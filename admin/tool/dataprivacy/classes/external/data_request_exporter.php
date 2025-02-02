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
 * Class for exporting user evidence with all competencies.
 *
 * @package    tool_dataprivacy
 * @copyright  2018 Jun Pataleta
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_dataprivacy\external;
defined('agpu_INTERNAL') || die();

use core\external\persistent_exporter;
use core_user;
use core_user\external\user_summary_exporter;
use renderer_base;
use tool_dataprivacy\api;
use tool_dataprivacy\data_request;
use tool_dataprivacy\local\helper;

/**
 * Class for exporting user evidence with all competencies.
 *
 * @copyright  2018 Jun Pataleta
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class data_request_exporter extends persistent_exporter {

    /**
     * Class definition.
     *
     * @return string
     */
    protected static function define_class() {
        return data_request::class;
    }

    /**
     * Related objects definition.
     *
     * @return array
     */
    protected static function define_related() {
        return [
            'context' => 'context',
        ];
    }

    /**
     * Other properties definition.
     *
     * @return array
     */
    protected static function define_other_properties() {
        return [
            'foruser' => [
                'type' => user_summary_exporter::read_properties_definition(),
            ],
            'requestedbyuser' => [
                'type' => user_summary_exporter::read_properties_definition(),
                'optional' => true
            ],
            'dpouser' => [
                'type' => user_summary_exporter::read_properties_definition(),
                'optional' => true
            ],
            'messagehtml' => [
                'type' => PARAM_RAW,
                'optional' => true
            ],
            'typename' => [
                'type' => PARAM_TEXT,
            ],
            'typenameshort' => [
                'type' => PARAM_TEXT,
            ],
            'statuslabel' => [
                'type' => PARAM_TEXT,
            ],
            'statuslabelclass' => [
                'type' => PARAM_TEXT,
            ],
            'canreview' => [
                'type' => PARAM_BOOL,
                'optional' => true,
                'default' => false
            ],
            'approvedeny' => [
                'type' => PARAM_BOOL,
                'optional' => true,
                'default' => false
            ],
            'allowfiltering' => [
                'type' => PARAM_BOOL,
                'optional' => true,
                'default' => false,
            ],
            'canmarkcomplete' => [
                'type' => PARAM_BOOL,
                'optional' => true,
                'default' => false
            ],
            'downloadlink' => [
                'type' => PARAM_URL,
                'optional' => true,
            ],
        ];
    }

    /**
     * Assign values to the defined other properties.
     *
     * @param renderer_base $output The output renderer object.
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     * @throws agpu_exception
     */
    protected function get_other_values(renderer_base $output) {
        $values = [];

        $foruserid = $this->persistent->get('userid');
        $user = core_user::get_user($foruserid, '*', MUST_EXIST);
        $userexporter = new user_summary_exporter($user);
        $values['foruser'] = $userexporter->export($output);

        $requestedbyid = $this->persistent->get('requestedby');
        if ($requestedbyid != $foruserid) {
            $user = core_user::get_user($requestedbyid, '*', MUST_EXIST);
            $userexporter = new user_summary_exporter($user);
            $values['requestedbyuser'] = $userexporter->export($output);
        } else {
            $values['requestedbyuser'] = $values['foruser'];
        }

        if (!empty($this->persistent->get('dpo'))) {
            $dpoid = $this->persistent->get('dpo');
            $user = core_user::get_user($dpoid, '*', MUST_EXIST);
            $userexporter = new user_summary_exporter($user);
            $values['dpouser'] = $userexporter->export($output);
        }

        $values['messagehtml'] = text_to_html($this->persistent->get('comments'));

        $requesttype = $this->persistent->get('type');
        $values['typename'] = helper::get_request_type_string($requesttype);
        $values['typenameshort'] = helper::get_shortened_request_type_string($requesttype);

        $values['canreview'] = false;
        $values['approvedeny'] = false;
        $values['allowfiltering'] = get_config('tool_dataprivacy', 'allowfiltering');
        $values['statuslabel'] = helper::get_request_status_string($this->persistent->get('status'));

        switch ($this->persistent->get('status')) {
            case api::DATAREQUEST_STATUS_PENDING:
            case api::DATAREQUEST_STATUS_PREPROCESSING:
                $values['statuslabelclass'] = 'bg-info text-white';
                // Request can be manually completed for general enquiry requests.
                $values['canmarkcomplete'] = $requesttype == api::DATAREQUEST_TYPE_OTHERS;
                break;
            case api::DATAREQUEST_STATUS_AWAITING_APPROVAL:
                $values['statuslabelclass'] = 'bg-info text-white';
                // DPO can review the request once it's ready.
                $values['canreview'] = true;
                // Whether the DPO can approve or deny the request.
                $values['approvedeny'] = in_array($requesttype, [api::DATAREQUEST_TYPE_EXPORT, api::DATAREQUEST_TYPE_DELETE]);
                // If the request's type is delete, check if user have permission to approve/deny it.
                if ($requesttype == api::DATAREQUEST_TYPE_DELETE) {
                    $values['approvedeny'] = api::can_create_data_deletion_request_for_other();
                }
                break;
            case api::DATAREQUEST_STATUS_APPROVED:
                $values['statuslabelclass'] = 'bg-info text-white';
                break;
            case api::DATAREQUEST_STATUS_PROCESSING:
                $values['statuslabelclass'] = 'bg-info text-white';
                break;
            case api::DATAREQUEST_STATUS_COMPLETE:
            case api::DATAREQUEST_STATUS_DOWNLOAD_READY:
            case api::DATAREQUEST_STATUS_DELETED:
                $values['statuslabelclass'] = 'bg-success text-white';
                break;
            case api::DATAREQUEST_STATUS_CANCELLED:
                $values['statuslabelclass'] = 'bg-warning text-dark';
                break;
            case api::DATAREQUEST_STATUS_REJECTED:
                $values['statuslabelclass'] = 'bg-danger text-white';
                break;
            case api::DATAREQUEST_STATUS_EXPIRED:
                $values['statuslabelclass'] = 'bg-secondary text-dark';
                break;
        }

        if ($this->persistent->get('status') == api::DATAREQUEST_STATUS_DOWNLOAD_READY) {
            $usercontext = \context_user::instance($foruserid, IGNORE_MISSING);
            // If user has permission to view download link, show relevant action item.
            if ($usercontext && api::can_download_data_request_for_user($foruserid, $requestedbyid)) {
                $downloadlink = api::get_download_link($usercontext, $this->persistent->get('id'))->url;
                $values['downloadlink'] = $downloadlink->out(false);
            }
        }

        return $values;
    }
}
