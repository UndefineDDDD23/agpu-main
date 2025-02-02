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
 * This file defines an adhoc task to send notifications.
 *
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_monitor;

defined('agpu_INTERNAL') || die();

/**
 * Adhock class, used to send notifications to users.
 *
 * @since      agpu 2.8
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class notification_task extends \core\task\adhoc_task {

    /**
     * Send out messages.
     */
    public function execute() {
        foreach ($this->get_custom_data() as $data) {
            $eventobj = $data->event;
            $subscriptionids = $data->subscriptionids;
            foreach ($subscriptionids as $id) {
                if ($message = $this->generate_message($id, $eventobj)) {
                    mtrace("Sending message to the user with id " . $message->userto->id . " for the subscription with id $id...");
                    message_send($message);
                    mtrace("Sent.");
                }
            }
        }
    }

    /**
     * Generates the message object for a give subscription and event.
     *
     * @param int $subscriptionid Subscription instance
     * @param \stdClass $eventobj Event data
     *
     * @return false|\stdClass message object
     */
    protected function generate_message($subscriptionid, \stdClass $eventobj) {

        try {
            $subscription = subscription_manager::get_subscription($subscriptionid);
        } catch (\dml_exception $e) {
            // Race condition, someone deleted the subscription.
            return false;
        }
        $user = \core_user::get_user($subscription->userid);
        if (empty($user)) {
            // User doesn't exist. Should never happen, nothing to do return.
            return false;
        }
        $context = \context_user::instance($user->id, IGNORE_MISSING);
        if ($context === false) {
            // User context doesn't exist. Should never happen, nothing to do return.
            return false;
        }

        $template = $subscription->template;
        $template = $this->replace_placeholders($template, $subscription, $eventobj, $context);
        $htmlmessage = format_text($template, $subscription->templateformat, array('context' => $context));
        $msgdata = new \core\message\message();
        $msgdata->courseid          = empty($subscription->courseid) ? SITEID : $subscription->courseid;
        $msgdata->component         = 'tool_monitor'; // Your component name.
        $msgdata->name              = 'notification'; // This is the message name from messages.php.
        $msgdata->userfrom          = \core_user::get_noreply_user();
        $msgdata->userto            = $user;
        $msgdata->subject           = $subscription->get_name($context);
        $msgdata->fullmessage       = html_to_text($htmlmessage);
        $msgdata->fullmessageformat = FORMAT_PLAIN;
        $msgdata->fullmessagehtml   = $htmlmessage;
        $msgdata->smallmessage      = '';
        $msgdata->notification      = 1; // This is only set to 0 for personal messages between users.

        return $msgdata;
    }

    /**
     * Replace place holders in the template with respective content.
     *
     * @param string $template Message template.
     * @param subscription $subscription subscription instance
     * @param \stdclass $eventobj Event data
     * @param \context $context context object
     *
     * @return mixed final template string.
     */
    protected function replace_placeholders($template, subscription $subscription, $eventobj, $context) {
        $replacements = [
            '{link}' => $eventobj->link,
            '{rulename}' => $subscription->get_name($context),
            '{description}' => $subscription->get_description($context),
            '{eventname}' => $subscription->get_event_name(),
        ];

        if ($eventobj->contextlevel >= CONTEXT_COURSE && !empty($eventobj->courseid)) {
            $iscoursetemplate = str_contains($template, '{course');
            $ismodtemplate = str_contains($template, '{module');
            if ($iscoursetemplate || $ismodtemplate) {
                $modinfo = get_fast_modinfo($eventobj->courseid);
                $course = $modinfo->get_course();
                $replacements['{coursefullname}'] = $course->fullname;
                $replacements['{courseshortname}'] = $course->shortname;

                if ($eventobj->contextlevel == CONTEXT_MODULE && !empty($eventobj->contextinstanceid) && $ismodtemplate) {
                    $cm = $modinfo->get_cm($eventobj->contextinstanceid);
                    $replacements['{modulelink}'] = $cm->url;
                    $replacements['{modulename}'] = $cm->get_name();
                }
            }
        }
        return str_replace(
            search: array_keys($replacements),
            replace: array_values($replacements),
            subject: $template,
        );
    }
}
