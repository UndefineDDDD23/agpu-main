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
 * This file contains a class definition for the Link Memberships resource
 *
 * @package    ltiservice_memberships
 * @copyright  2015 Vital Source Technologies http://vitalsource.com
 * @author     Stephen Vickers
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace ltiservice_memberships\local\resources;

use mod_lti\local\ltiservice\resource_base;
use ltiservice_memberships\local\service\memberships;
use core_availability\info_module;

defined('agpu_INTERNAL') || die();

/**
 * A resource implementing Link Memberships.
 * The link membership is no longer defined in the published
 * version of the LTI specification. It is replaced by the
 * rlid parameter in the context membership URL.
 *
 * @package    ltiservice_memberships
 * @since      agpu 3.0
 * @copyright  2015 Vital Source Technologies http://vitalsource.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class linkmemberships extends resource_base {

    /**
     * Class constructor.
     *
     * @param \ltiservice_memberships\local\service\memberships $service Service instance
     */
    public function __construct($service) {

        parent::__construct($service);
        $this->id = 'LtiLinkMemberships';
        $this->template = '/links/{link_id}/memberships';
        $this->variables[] = 'LtiLink.memberships.url';
        $this->formats[] = 'application/vnd.ims.lis.v2.membershipcontainer+json';
        $this->methods[] = 'GET';

    }

    /**
     * Execute the request for this resource.
     *
     * @param \mod_lti\local\ltiservice\response $response  Response object for this request.
     */
    public function execute($response) {
        global $DB;

        $params = $this->parse_template();
        $linkid = $params['link_id'];
        $role = optional_param('role', '', PARAM_TEXT);
        $limitnum = optional_param('limit', 0, PARAM_INT);
        $limitfrom = optional_param('from', 0, PARAM_INT);

        if ($limitnum <= 0) {
            $limitfrom = 0;
        }

        if (empty($linkid)) {
            $response->set_code(404);
            return;
        }
        if (!($lti = $DB->get_record('lti', array('id' => $linkid), 'id,course,typeid,servicesalt', IGNORE_MISSING))) {
            $response->set_code(404);
            return;
        }
        if (!$this->check_tool($lti->typeid, $response->get_request_data(), array(memberships::SCOPE_MEMBERSHIPS_READ))) {
            $response->set_code(403);
            return;
        }
        if (!($course = $DB->get_record('course', array('id' => $lti->course), 'id', IGNORE_MISSING))) {
            $response->set_code(404);
            return;
        }
        if (!($context = \context_course::instance($lti->course))) {
            $response->set_code(404);
            return;
        }
        $modinfo = get_fast_modinfo($course);
        $cm = get_coursemodule_from_instance('lti', $linkid, $lti->course, false, MUST_EXIST);
        $cm = $modinfo->get_cm($cm->id);
        $info = new info_module($cm);
        if ($info->is_available_for_all()) {
            $info = null;
        }
        $json = $this->get_service()->get_members_json($this, $context, $course, $role,
                                                       $limitfrom, $limitnum, $lti, $info, $response);

        $response->set_content_type($this->formats[0]);
        $response->set_body($json);
    }

    /**
     * get permissions from the config of the tool for that resource
     *
     * @param string $typeid
     *
     * @return array with the permissions related to this resource by the $lti_type or null if none.
     */
    public function get_permissions($typeid) {
        $tool = lti_get_type_type_config($typeid);
        if ($tool->memberships == '1') {
            return array('ToolProxyBinding.memberships.url:get');
        } else {
            return array();
        }
    }

    /**
     * Parse a value for custom parameter substitution variables.
     *
     * @param string $value String to be parsed
     *
     * @return string
     */
    public function parse_value($value) {

        if (strpos($value, '$LtiLink.memberships.url') !== false) {
            $id = optional_param('id', 0, PARAM_INT); // Course Module ID.
            if (!empty($id)) {
                $cm = get_coursemodule_from_id('lti', $id, 0, false, MUST_EXIST);
                $this->params['link_id'] = $cm->instance;
            }
            $value = str_replace('$LtiLink.memberships.url', parent::get_endpoint(), $value);
        }
        return $value;

    }

}
