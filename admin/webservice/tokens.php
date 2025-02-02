<?php
// This file is part of agpu - https://agpu.org/
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
 * Web services / external tokens management UI.
 *
 * @package     core_webservice
 * @category    admin
 * @copyright   2009 Jerome Mouneyrac
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core_reportbuilder\system_report_factory;
use core_webservice\reportbuilder\local\systemreports\tokens;

require(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/webservice/lib.php');

$action = optional_param('action', '', PARAM_ALPHANUMEXT);
$tokenid = optional_param('tokenid', '', PARAM_SAFEDIR);
$confirm = optional_param('confirm', 0, PARAM_BOOL);
$fname = optional_param('fname', '', PARAM_ALPHANUM);
$fusers = optional_param_array('fusers', [], PARAM_INT);
$fservices = optional_param_array('fservices', [], PARAM_INT);

admin_externalpage_setup('webservicetokens');

$PAGE->set_primary_active_tab('siteadminnode');
$PAGE->navbar->add(get_string('managetokens', 'webservice'),
    new agpu_url('/admin/webservice/tokens.php'));

if ($action === 'create') {
    $PAGE->navbar->add(get_string('createtoken', 'webservice'), $PAGE->url);
    $webservicemanager = new webservice();
    $mform = new \core_webservice\token_form(null, ['action' => 'create']);
    $data = $mform->get_data();

    if ($mform->is_cancelled()) {
        redirect($PAGE->url);

    } else if ($data) {
        ignore_user_abort(true);

        // Check the user is allowed for the service.
        $selectedservice = $webservicemanager->get_external_service_by_id($data->service);

        if ($selectedservice->restrictedusers) {
            $restricteduser = $webservicemanager->get_ws_authorised_user($data->service, $data->user);

            if (empty($restricteduser)) {
                $errormsg = $OUTPUT->notification(get_string('usernotallowed', 'webservice', $selectedservice->name));
            }
        }

        $user = \core_user::get_user($data->user, '*', MUST_EXIST);
        \core_user::require_active_user($user);

        // Generate the token.
        if (empty($errormsg)) {
            \core_external\util::generate_token(
                EXTERNAL_TOKEN_PERMANENT,
                \core_external\util::get_service_by_id($data->service),
                $data->user,
                context_system::instance(),
                $data->validuntil,
                $data->iprestriction,
                $data->name
            );
            redirect($PAGE->url);
        }
    }

    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('createtoken', 'webservice'));
    if (!empty($errormsg)) {
        echo $errormsg;
    }
    $mform->display();
    echo $OUTPUT->footer();
    die();
}

if ($action === 'delete') {
    $PAGE->navbar->add(get_string('deletetoken', 'webservice'), $PAGE->url);
    $webservicemanager = new webservice();
    $token = $webservicemanager->get_token_by_id_with_details($tokenid);

    if ($token->creatorid != $USER->id) {
        require_capability('agpu/webservice:managealltokens', context_system::instance());
    }

    if ($confirm && confirm_sesskey()) {
        $webservicemanager->delete_user_ws_token($token->id);
        redirect($PAGE->url);
    }

    echo $OUTPUT->header();

    echo $OUTPUT->confirm(
        get_string('deletetokenconfirm', 'webservice', [
            'user' => $token->firstname . ' ' . $token->lastname,
            'service' => $token->name,
        ]),
        new single_button(new agpu_url('/admin/webservice/tokens.php', [
            'tokenid' => $token->id,
            'action' => 'delete',
            'confirm' => 1,
            'sesskey' => sesskey(),
        ]), get_string('delete')),
        $PAGE->url
    );

    echo $OUTPUT->footer();
    die();
}

echo $OUTPUT->header();
echo $OUTPUT->container_start('d-flex flex-wrap');
echo $OUTPUT->heading(get_string('managetokens', 'core_webservice'));
echo html_writer::div($OUTPUT->render(new single_button(new agpu_url($PAGE->url, ['action' => 'create']),
    get_string('createtoken', 'core_webservice'), 'get', single_button::BUTTON_PRIMARY)), 'ms-auto');
echo $OUTPUT->container_end();

if (!empty($SESSION->webservicenewlycreatedtoken)) {
    $webservicemanager = new webservice();
    $newtoken = $webservicemanager->get_created_by_user_ws_token(
        $USER->id,
        $SESSION->webservicenewlycreatedtoken
    );
    if ($newtoken) {
        // Unset the session variable.
        unset($SESSION->webservicenewlycreatedtoken);
        // Display the newly created token.
        echo $OUTPUT->render_from_template(
            'core_admin/webservice_token_new', ['token' => $newtoken->token, 'tokenname' => $newtoken->tokenname]
        );
    }
}

$report = system_report_factory::create(tokens::class, context_system::instance());
echo $report->output();

echo $OUTPUT->footer();
