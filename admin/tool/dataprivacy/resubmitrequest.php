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
 * Display the request reject + resubmit confirmation page.
 *
 * @copyright 2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package tool_dataprivacy
 */

require_once('../../../config.php');

$requestid = required_param('requestid', PARAM_INT);
$confirm = optional_param('confirm', null, PARAM_INT);

$url = new agpu_url('/admin/tool/dataprivacy/resubmitrequest.php', ['requestid' => $requestid]);
$title = get_string('resubmitrequestasnew', 'tool_dataprivacy');

\tool_dataprivacy\page_helper::setup($url, $title, 'datarequests', 'tool/dataprivacy:managedatarequests');

$manageurl = new agpu_url('/admin/tool/dataprivacy/datarequests.php');

$originalrequest = \tool_dataprivacy\api::get_request($requestid);
$user = \core_user::get_user($originalrequest->get('userid'));
$stringparams = (object) [
        'username' => fullname($user),
        'type' => \tool_dataprivacy\local\helper::get_shortened_request_type_string($originalrequest->get('type')),
    ];

if (null !== $confirm && confirm_sesskey()) {
    if ($originalrequest->get('type') == \tool_dataprivacy\api::DATAREQUEST_TYPE_DELETE
        && !\tool_dataprivacy\api::can_create_data_deletion_request_for_other()) {
        throw new required_capability_exception(context_system::instance(),
            'tool/dataprivacy:requestdeleteforotheruser', 'nopermissions', '');
    }
    $originalrequest->resubmit_request();
    redirect($manageurl, get_string('resubmittedrequest', 'tool_dataprivacy', $stringparams));
}

echo $OUTPUT->header();

$confirmstring = get_string('confirmrequestresubmit', 'tool_dataprivacy', $stringparams);
$confirmurl = new \agpu_url($PAGE->url, ['confirm' => 1]);
echo $OUTPUT->confirm($confirmstring, $confirmurl, $manageurl);
echo $OUTPUT->footer();
