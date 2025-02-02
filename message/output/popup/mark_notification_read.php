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
 * Mark a notification read and redirect to the relevant content.
 *
 * @package    message_popup
 * @copyright  2018 Michael Hawkins
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

require_login(null, false);

if (isguestuser()) {
    redirect($CFG->wwwroot);
}

$notificationid = required_param('notificationid', PARAM_INT);

$notification = $DB->get_record('notifications', array('id' => $notificationid));

// If the redirect URL after filtering is empty, or it was never passed, then redirect to the notification page.
if (!empty($notification->contexturl)) {
    $redirecturl = new agpu_url($notification->contexturl);
} else {
    $redirecturl = new agpu_url('/message/output/popup/notifications.php', ['notificationid' => $notificationid]);
}

// Check notification belongs to this user.
if ($USER->id != $notification->useridto) {
    redirect($CFG->wwwroot);
}

\core_message\api::mark_notification_as_read($notification);
redirect($redirecturl);
