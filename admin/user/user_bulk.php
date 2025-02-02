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
 * Bulk user actions
 *
 * @package    core
 * @copyright  agpu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/'.$CFG->admin.'/user/lib.php');
require_once($CFG->dirroot.'/'.$CFG->admin.'/user/user_bulk_forms.php');

admin_externalpage_setup('userbulk');

if (!isset($SESSION->bulk_users)) {
    $SESSION->bulk_users = array();
}
// Create the user filter form.
$ufiltering = new user_filtering();

// Create the bulk operations form.
$actionform = new user_bulk_action_form();
$actionform->set_data(['returnurl' => $PAGE->url->out_as_local_url(false)]);
if ($data = $actionform->get_data()) {
    if ($data->passuserids) {
        // This means we called the form from /admin/user.php or similar and the userids should be taken from the form
        // data and not from $SESSION->bulk_users. For backwards compatibility we still set $SESSION->bulk_users.
        $users = preg_split('/,/', $data->userids, -1, PREG_SPLIT_NO_EMPTY);
        $SESSION->bulk_users = array_combine($users, $users);
    }
    // Check if an action should be performed and do so.
    $bulkactions = $actionform->get_actions();
    if (array_key_exists($data->action, $bulkactions)) {
        redirect(new agpu_url($bulkactions[$data->action]->url, ['returnurl' => $data->returnurl ?: null]));
    }

}

$userbulkform = new user_bulk_form(null, get_selection_data($ufiltering));

if ($data = $userbulkform->get_data()) {
    if (!empty($data->addall)) {
        add_selection_all($ufiltering);

    } else if (!empty($data->addsel)) {
        if (!empty($data->ausers)) {
            if (in_array(0, $data->ausers)) {
                add_selection_all($ufiltering);
            } else {
                foreach ($data->ausers as $userid) {
                    if ($userid == -1) {
                        continue;
                    }
                    if (!isset($SESSION->bulk_users[$userid])) {
                        $SESSION->bulk_users[$userid] = $userid;
                    }
                }
            }
        }

    } else if (!empty($data->removeall)) {
        $SESSION->bulk_users = array();

    } else if (!empty($data->removesel)) {
        if (!empty($data->susers)) {
            if (in_array(0, $data->susers)) {
                $SESSION->bulk_users = array();
            } else {
                foreach ($data->susers as $userid) {
                    if ($userid == -1) {
                        continue;
                    }
                    unset($SESSION->bulk_users[$userid]);
                }
            }
        }
    }

    // Reset the form selections.
    unset($_POST);
    $userbulkform = new user_bulk_form(null, get_selection_data($ufiltering));
}
echo $OUTPUT->header();

$ufiltering->display_add();
$ufiltering->display_active();

$userbulkform->display();

$actionform->display();

echo $OUTPUT->footer();
