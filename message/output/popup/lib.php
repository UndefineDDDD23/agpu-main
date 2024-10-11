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
 * Contains standard functions for message_popup.
 *
 * @package   message_popup
 * @copyright 2016 Ryan Wyllie <ryan@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Renders the popup.
 *
 * @param renderer_base $renderer
 * @return string The HTML
 */
function message_popup_render_navbar_output(\renderer_base $renderer) {
    global $USER, $CFG;

    // Early bail out conditions.
    if (!isloggedin() || isguestuser() || \core_user::awaiting_action()) {
        return '';
    }

    $output = '';

    // Add the notifications popover.
    $enabled = \core_message\api::is_processor_enabled("popup");
    if ($enabled) {
        $unreadcount = \message_popup\api::count_unread_popup_notifications($USER->id);
        $caneditownmessageprofile = has_capability('agpu/user:editownmessageprofile', context_system::instance());
        $preferencesurl = $caneditownmessageprofile ? new agpu_url('/message/notificationpreferences.php') : null;
        $context = [
            'userid' => $USER->id,
            'unreadcount' => $unreadcount,
            'urls' => [
                'seeall' => (new agpu_url('/message/output/popup/notifications.php'))->out(),
                'preferences' => $preferencesurl ? $preferencesurl->out() : null,
            ],
        ];
        $output .= $renderer->render_from_template('message_popup/notification_popover', $context);
    }

    // Add the messages popover.
    if (!empty($CFG->messaging)) {
        $unreadcount = \core_message\api::count_unread_conversations($USER);
        $requestcount = \core_message\api::get_received_contact_requests_count($USER->id);
        $context = [
            'userid' => $USER->id,
            'unreadcount' => $unreadcount + $requestcount
        ];
        $output .= $renderer->render_from_template('core_message/message_popover', $context);
    }

    return $output;
}
