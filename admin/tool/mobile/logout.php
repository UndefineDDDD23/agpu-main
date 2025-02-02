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
 * Log out a user from his external mobile devices (phones, tables, agpu Desktop app, etc..)
 *
 * @package tool_mobile
 * @copyright 2020 Juan Leyva <juan@agpu.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/admin/tool/mobile/lib.php');
require_once($CFG->dirroot . '/webservice/lib.php');

if (!$CFG->enablemobilewebservice) {
    throw new \agpu_exception('enablewsdescription', 'webservice');
}

require_login(null, false);

// Require an active user: not guest, not suspended.
core_user::require_active_user($USER);

$redirecturl = new \agpu_url('/user/profile.php');

if (optional_param('confirm', 0, PARAM_INT) && data_submitted()) {
    require_sesskey();

    // Get the mobile service token to be deleted.
    $token = tool_mobile_get_token($USER->id);

    if ($token) {
        $webservicemanager = new webservice();
        $webservicemanager->delete_user_ws_token($token->id);
    }
    redirect($redirecturl);
}

// Page settings.
$title = get_string('logout');
$context = context_system::instance();
$PAGE->set_url(new \agpu_url('/'.$CFG->admin.'/tool/mobile/logout.php'));
$PAGE->navbar->add($title);
$PAGE->set_context($context);
$PAGE->set_title($title);

// Display the page.
echo $OUTPUT->header();

$message = get_string('logoutconfirmation', 'tool_mobile');
$confirmurl = new \agpu_url('logout.php', ['confirm' => 1]);
$yesbutton = new single_button($confirmurl, get_string('yes'), 'post');
$nobutton = new single_button($redirecturl, get_string('no'));
echo $OUTPUT->confirm($message, $yesbutton, $nobutton);

echo $OUTPUT->footer();
