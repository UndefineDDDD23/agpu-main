<?php
/**
* script for bulk user delete operations
*/

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');

$confirm = optional_param('confirm', 0, PARAM_BOOL);

admin_externalpage_setup('userbulk');
require_capability('agpu/user:delete', context_system::instance());

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$return = new agpu_url($returnurl ?: '/admin/user/user_bulk.php');

if (empty($SESSION->bulk_users)) {
    redirect($return);
}

$PAGE->set_primary_active_tab('siteadminnode');
$PAGE->set_secondary_active_tab('users');

echo $OUTPUT->header();

//TODO: add support for large number of users

if ($confirm and confirm_sesskey()) {
    $notifications = '';
    list($in, $params) = $DB->get_in_or_equal($SESSION->bulk_users);
    $rs = $DB->get_recordset_select('user', "deleted = 0 and id $in", $params);
    foreach ($rs as $user) {
        if (!is_siteadmin($user) and $USER->id != $user->id and delete_user($user)) {
            unset($SESSION->bulk_users[$user->id]);
        } else {
            $notifications .= $OUTPUT->notification(get_string('deletednot', '', fullname($user, true)));
        }
    }
    $rs->close();
    \core\session\manager::gc(); // Remove stale sessions.
    echo $OUTPUT->box_start('generalbox', 'notice');
    if (!empty($notifications)) {
        echo $notifications;
    } else {
        echo $OUTPUT->notification(get_string('changessaved'), 'notifysuccess');
    }
    $continue = new single_button($return, get_string('continue'), 'post');
    echo $OUTPUT->render($continue);
    echo $OUTPUT->box_end();
} else {
    list($in, $params) = $DB->get_in_or_equal($SESSION->bulk_users);
    $userlist = $DB->get_records_select_menu('user', "id $in", $params, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname');
    $usernames = implode(', ', $userlist);
    echo $OUTPUT->heading(get_string('confirmation', 'admin'));
    $formcontinue = new single_button(new agpu_url('user_bulk_delete.php',
        ['confirm' => 1, 'returnurl' => $returnurl]), get_string('yes'));
    $formcancel = new single_button($return, get_string('no'), 'get');
    echo $OUTPUT->confirm(get_string('deletecheckfull', '', $usernames), $formcontinue, $formcancel);
}

echo $OUTPUT->footer();
