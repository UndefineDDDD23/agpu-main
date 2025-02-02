<?php
// This file is part of agpu - http://agpu.org/
//
// agpu is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// agpu is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains a class definition for the LineItem container resource
 *
 * @package    ltiservice_gradebookservices
 * @copyright  2017 Cengage Learning http://www.cengage.com
 * @author     Dirk Singels, Diego del Blanco, Claude Vervoort
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace ltiservice_gradebookservices\local\resources;

use ltiservice_gradebookservices\local\service\gradebookservices;
use mod_lti\local\ltiservice\resource_base;

defined('agpu_INTERNAL') || die();

/**
 * A resource implementing LineItem container.
 *
 * @package    ltiservice_gradebookservices
 * @copyright  2017 Cengage Learning http://www.cengage.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lineitems extends resource_base {

    /**
     * Class constructor.
     *
     * @param \ltiservice_gradebookservices\local\service\gradebookservices $service Service instance
     */
    public function __construct($service) {

        parent::__construct($service);
        $this->id = 'LineItem.collection';
        $this->template = '/{context_id}/lineitems';
        $this->variables[] = 'LineItems.url';
        $this->formats[] = 'application/vnd.ims.lis.v2.lineitemcontainer+json';
        $this->formats[] = 'application/vnd.ims.lis.v2.lineitem+json';
        $this->methods[] = self::HTTP_GET;
        $this->methods[] = self::HTTP_POST;

    }

    /**
     * Execute the request for this resource.
     *
     * @param \mod_lti\local\ltiservice\response $response  Response object for this request.
     */
    public function execute($response) {
        global $DB;

        $params = $this->parse_template();
        $contextid = $params['context_id'];
        $isget = $response->get_request_method() === self::HTTP_GET;
        if ($isget) {
            $contenttype = $response->get_accept();
        } else {
            $contenttype = $response->get_content_type();
        }
        $container = empty($contenttype) || ($contenttype === $this->formats[0]);
        // We will receive typeid when working with LTI 1.x, if not then we are in LTI 2.
        $typeid = optional_param('type_id', null, PARAM_INT);

        $scopes = array(gradebookservices::SCOPE_GRADEBOOKSERVICES_LINEITEM);
        if ($response->get_request_method() === self::HTTP_GET) {
            $scopes[] = gradebookservices::SCOPE_GRADEBOOKSERVICES_LINEITEM_READ;
        }

        try {
            if (!$this->check_tool($typeid, $response->get_request_data(), $scopes)) {
                throw new \Exception(null, 401);
            }
            $typeid = $this->get_service()->get_type()->id;
            if (empty($contextid) || !($container ^ ($response->get_request_method() === self::HTTP_POST)) ||
                    (!empty($contenttype) && !in_array($contenttype, $this->formats))) {
                throw new \Exception('No context or unsupported content type', 400);
            }
            if (!($course = $DB->get_record('course', array('id' => $contextid), 'id', IGNORE_MISSING))) {
                throw new \Exception("Not Found: Course {$contextid} doesn't exist", 404);
            }
            if (!$this->get_service()->is_allowed_in_context($typeid, $course->id)) {
                throw new \Exception('Not allowed in context', 403);
            }
            if ($response->get_request_method() !== self::HTTP_POST) {
                $resourceid = optional_param('resource_id', null, PARAM_TEXT);
                $ltilinkid = optional_param('resource_link_id', null, PARAM_TEXT);
                if (is_null($ltilinkid)) {
                    $ltilinkid = optional_param('lti_link_id', null, PARAM_TEXT);
                }
                $tag = optional_param('tag', null, PARAM_TEXT);
                $limitnum = optional_param('limit', 0, PARAM_INT);
                $limitfrom = optional_param('from', 0, PARAM_INT);
                $itemsandcount = $this->get_service()->get_lineitems($contextid, $resourceid, $ltilinkid, $tag, $limitfrom,
                        $limitnum, $typeid);
                $items = $itemsandcount[1];
                $totalcount = $itemsandcount[0];
                $json = $this->get_json_for_get_request($items, $resourceid, $ltilinkid, $tag, $limitfrom,
                        $limitnum, $totalcount, $typeid, $response);
                $response->set_content_type($this->formats[0]);
            } else {
                $json = $this->get_json_for_post_request($response->get_request_data(), $contextid, $typeid);
                $response->set_code(201);
                $response->set_content_type($this->formats[1]);
            }
            $response->set_body($json);

        } catch (\Exception $e) {
            $response->set_code($e->getCode());
            $response->set_reason($e->getMessage());
        }

    }

    /**
     * Generate the JSON for a GET request.
     *
     * @param array $items Array of lineitems
     * @param string $resourceid Resource identifier used for filtering, may be null
     * @param string $ltilinkid Resource Link identifier used for filtering, may be null
     * @param string $tag Tag identifier used for filtering, may be null
     * @param int $limitfrom Offset of the first line item to return
     * @param int $limitnum Maximum number of line items to return, ignored if zero or less
     * @param int $totalcount Number of total lineitems before filtering for paging
     * @param int $typeid Maximum number of line items to return, ignored if zero or less
     * @param \mod_lti\local\ltiservice\response $response

     * @return string
     */
    private function get_json_for_get_request($items, $resourceid, $ltilinkid,
            $tag, $limitfrom, $limitnum, $totalcount, $typeid, $response) {

        $firstpage = null;
        $nextpage = null;
        $prevpage = null;
        $lastpage = null;
        if (isset($limitnum) && $limitnum > 0) {
            if ($limitfrom >= $totalcount || $limitfrom < 0) {
                $outofrange = true;
            } else {
                $outofrange = false;
            }
            $limitprev = $limitfrom - $limitnum >= 0 ? $limitfrom - $limitnum : 0;
            $limitcurrent = $limitfrom;
            $limitlast = $totalcount - $limitnum + 1 >= 0 ? $totalcount - $limitnum + 1 : 0;
            $limitfrom += $limitnum;

            $baseurl = new \agpu_url($this->get_endpoint());
            if (isset($resourceid)) {
                $baseurl->param('resource_id', $resourceid);
            }
            if (isset($ltilinkid)) {
                $baseurl->param('resource_link_id', $ltilinkid);
            }
            if (isset($tag)) {
                $baseurl->param('tag', $tag);
            }

            if (is_null($typeid)) {
                $baseurl->param('limit', $limitnum);
                if (($limitfrom <= $totalcount - 1) && (!$outofrange)) {
                    $nextpage = new \agpu_url($baseurl, ['from' => $limitfrom]);
                }
                $firstpage = new \agpu_url($baseurl, ['from' => 0]);
                $canonicalpage = new \agpu_url($baseurl, ['from' => $limitcurrent]);
                $lastpage = new \agpu_url($baseurl, ['from' > $limitlast]);
                if (($limitcurrent > 0) && (!$outofrange)) {
                    $prevpage = new \agpu_url($baseurl, ['from' => $limitprev]);
                }
            } else {
                $baseurl->params(['type_id' => $typeid, 'limit' => $limitnum]);
                if (($limitfrom <= $totalcount - 1) && (!$outofrange)) {
                    $nextpage = new \agpu_url($baseurl, ['from' => $limitfrom]);
                }
                $firstpage = new \agpu_url($baseurl, ['from' => 0]);
                $canonicalpage = new \agpu_url($baseurl, ['from' => $limitcurrent]);
                $lastpage = new \agpu_url($baseurl, ['from' => $limitlast]);
                if (($limitcurrent > 0) && (!$outofrange)) {
                    $prevpage = new \agpu_url($baseurl, ['from' => $limitprev]);
                }
            }
        }

        $jsonitems = [];
        $endpoint = parent::get_endpoint();
        foreach ($items as $item) {
            array_push($jsonitems, gradebookservices::item_for_json($item, $endpoint, $typeid));
        }

        if (isset($canonicalpage) && ($canonicalpage)) {
            $links = 'Link: <' . $firstpage->out() . '>; rel=“first”';
            if (!is_null($prevpage)) {
                $links .= ', <' . $prevpage->out() . '>; rel=“prev”';
            }
            $links .= ', <' . $canonicalpage->out(). '>; rel=“canonical”';
            if (!is_null($nextpage)) {
                $links .= ', <' . $nextpage->out() . '>; rel=“next”';
            }
            $links .= ', <' . $lastpage->out() . '>; rel=“last”';
            $response->add_additional_header($links);
        }
        return json_encode($jsonitems);
    }

    /**
     * Generate the JSON for a POST request.
     *
     * @param string $body POST body
     * @param string $contextid Course ID
     * @param string $typeid
     *
     * @return string
     * @throws \Exception
     */
    private function get_json_for_post_request($body, $contextid, $typeid) {
        global $CFG, $DB;

        $json = json_decode($body);
        if (empty($json) ||
                !isset($json->scoreMaximum) ||
                !isset($json->label)) {
            throw new \Exception('No label or Score Maximum', 400);
        }
        if (is_numeric($json->scoreMaximum)) {
            $max = $json->scoreMaximum;
        } else {
            throw new \Exception(null, 400);
        }
        require_once($CFG->libdir.'/gradelib.php');
        $resourceid = (isset($json->resourceId)) ? $json->resourceId : '';
        $ltilinkid = (isset($json->resourceLinkId)) ? $json->resourceLinkId : null;
        if ($ltilinkid == null) {
            $ltilinkid = (isset($json->ltiLinkId)) ? $json->ltiLinkId : null;
        }
        if ($ltilinkid != null) {
            if (is_null($typeid)) {
                if (!gradebookservices::check_lti_id($ltilinkid, $contextid, $this->get_service()->get_tool_proxy()->id)) {
                    throw new \Exception(null, 403);
                }
            } else {
                if (!gradebookservices::check_lti_1x_id($ltilinkid, $contextid, $typeid)) {
                    throw new \Exception(null, 403);
                }
            }
        }
        $tag = (isset($json->tag)) ? $json->tag : '';
        if (is_null($typeid)) {
            $toolproxyid = $this->get_service()->get_tool_proxy()->id;
            $baseurl = null;
        } else {
            $toolproxyid = null;
            $baseurl = lti_get_type_type_config($typeid)->lti_toolurl;
        }
        $gradebookservices = new gradebookservices();
        $id = $gradebookservices->add_standalone_lineitem($contextid, $json->label,
            $max, $baseurl, $ltilinkid, $resourceid, $tag, $typeid, $toolproxyid);
        if (is_null($typeid)) {
            $json->id = parent::get_endpoint() . "/{$id}/lineitem";
        } else {
            $json->id = parent::get_endpoint() . "/{$id}/lineitem?type_id={$typeid}";
        }
        return json_encode($json, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Parse a value for custom parameter substitution variables.
     *
     * @param string $value String to be parsed
     *
     * @return string
     */
    public function parse_value($value) {
        global $COURSE;

        if (strpos($value, '$LineItems.url') !== false) {
            $this->params['context_id'] = $COURSE->id;
            $query = '';
            if (($tool = $this->get_service()->get_type())) {
                $query = "?type_id={$tool->id}";
            }
            $value = str_replace('$LineItems.url', parent::get_endpoint() . $query, $value);
        }

        return $value;

    }
}
