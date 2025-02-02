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
 * Scheduled task abstract class.
 *
 * @package    core
 * @copyright  2013 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\task;

/**
 * Simple task to delete user accounts for users who have not confirmed in time.
 */
class delete_unconfirmed_users_task extends scheduled_task {
    use stored_progress_task_trait;

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskdeleteunconfirmedusers', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG, $DB;

        $timenow = time();

        // Delete users who haven't confirmed within required period.
        if (!empty($CFG->deleteunconfirmed)) {
            $cuttime = $timenow - ($CFG->deleteunconfirmed * 3600);
            $select = "confirmed = 0 AND timecreated > 0 AND timecreated < ? AND deleted = 0";
            $params = [$cuttime];
            $count = $DB->count_records_select('user', $select, $params);

            // Exit early if there are no records to process.
            if (!$count) {
                return;
            }

            $this->start_stored_progress();
            $rs = $DB->get_recordset_select('user', $select, $params);
            $processed = 0;
            foreach ($rs as $user) {
                delete_user($user);
                $message = " Deleted unconfirmed user ".fullname($user, true)." ($user->id)";
                $processed++;
                $this->progress->update($processed, $count, $message);
            }
            $rs->close();
            $this->progress->update($processed, $count, "Deleted $processed out of $count unconfirmed users");
        }
    }

}
