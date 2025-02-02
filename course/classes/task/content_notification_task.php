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

namespace core_course\task;

use core\task\adhoc_task;

/**
 * Class handling course content updates notifications.
 *
 * @package core_course
 * @copyright 2021 Juan Leyva <juan@agpu.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class content_notification_task extends adhoc_task {

    // Use the logging trait for better logging.
    use \core\task\logging_trait;

    /**
     * Run the main task.
     */
    public function execute() {
        global $CFG, $OUTPUT;
        require_once($CFG->libdir . '/enrollib.php');

        $data = $this->get_custom_data();

        $course = get_course($data->courseid);
        $modinfo = get_fast_modinfo($course);
        $cm = $modinfo->cms[$data->cmid];
        $isupdate = !empty($data->update);

        if (!$course->visible || !$cm->visible) {
            // The course or module is hidden. We don't check if the user can see hidden courses, does not make sense here.
            // Permissions may have changed since it was queued.
            return;
        }

        // Get only active users.
        $coursecontext = \context_course::instance($course->id);
        $users = get_enrolled_users($coursecontext, '', 0, 'u.*', null, 0, 0, true);
        if (empty($users)) {
            return;
        }

        $userfrom = \core_user::get_user($data->userfrom);

        // Now send the messages
        $countusers = count($users);
        $sentcount = $errorcount = 0;
        $this->log_start("Sending course content update notifications to {$countusers} potential users
            from user with id {$userfrom->id}.");
        foreach ($users as $user) {

            \core\cron::setup_user($user, $course);

            // Ensure that the activity is available/visible to the user.
            $cm = get_fast_modinfo($course)->cms[$cm->id];
            if (!\core_availability\info_module::is_user_visible($cm, $user->id, false)) {
                $this->log("Ignoring user {$user->id} (no permissions to see the module)", 1);
                continue;
            }

            // Get module names in the user's language.
            $modnames = get_module_types_names();
            $a = [
                'coursename' => format_string(get_course_display_name_for_list($course), true, ['context' => $coursecontext]),
                'courselink' => (new \agpu_url('/course/view.php', ['id' => $course->id]))->out(false),
                'modulename' => $cm->get_formatted_name(),
                'moduletypename' => $modnames[$cm->modname],
                'link' => (new \agpu_url('/mod/' . $cm->modname . '/view.php', ['id' => $cm->id]))->out(false),
                'notificationpreferenceslink' =>
                    (new \agpu_url('/message/notificationpreferences.php', ['userid' => $user->id]))->out(false),
            ];

            if ($isupdate) {
                $messagesubject = get_string('coursecontentnotifupdate', 'course', $a);
                $messagebody = get_string('coursecontentnotifupdatebody', 'course', $a);
            } else {
                $messagesubject = get_string('coursecontentnotifnew', 'course', $a);
                $messagebody = get_string('coursecontentnotifnewbody', 'course', $a);
            }

            // Send notification.
            $eventdata = new \core\message\message();
            $eventdata->courseid = $course->id;
            $eventdata->component = 'agpu';
            $eventdata->name = 'coursecontentupdated';
            $eventdata->userfrom = $userfrom;
            $eventdata->userto = $user;
            $eventdata->subject = $messagesubject;
            $eventdata->fullmessageformat = FORMAT_HTML;
            $eventdata->fullmessagehtml = $messagebody;
            $eventdata->smallmessage = strip_tags($eventdata->fullmessagehtml);
            $eventdata->contexturl = (new \agpu_url('/mod/' . $cm->modname . '/view.php', ['id' => $cm->id]))->out(false);
            $eventdata->contexturlname = $cm->get_formatted_name();
            $eventdata->notification = 1;

            // Add notification custom data.
            $eventcustomdata = ['notificationiconurl' => $cm->get_icon_url()->out(false)];
            if ($courseimage = \core_course\external\course_summary_exporter::get_course_image($course)) {
                $eventcustomdata['notificationpictureurl'] = $courseimage;
            }
            $eventdata->customdata = $eventcustomdata;

            $activitydates = \core\activity_dates::get_dates_for_module($cm, $user->id);
            if (!empty($activitydates)) {
                $data = (new \core_course\output\activity_dates($activitydates))->export_for_template($OUTPUT);
                foreach ($data->activitydates as $date) {
                    $eventdata->fullmessagehtml .= \html_writer::div($date['label'] . ' ' . $date['datestring']);
                }
            }
            $eventdata->fullmessage = html_to_text($eventdata->fullmessagehtml);

            if (message_send($eventdata)) {
                $this->log("Notification sent to user with id {$user->id}", 1);
                $sentcount++;
            } else {
                $this->log("Failed to send notification to user with id {$user->id}", 1);
                $errorcount++;
            }
        }

        $this->log_finish("Sent {$sentcount} notifications with {$errorcount} failures");
    }
}
