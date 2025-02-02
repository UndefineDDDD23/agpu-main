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
 * A scheduled task.
 *
 * @package    core
 * @copyright  2013 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\task;

defined('agpu_INTERNAL') || die();

require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');

/**
 * Simple task to delete old backup records.
 */
class backup_cleanup_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskbackupcleanup', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $DB;

        $sql = 'SELECT * FROM {backup_controllers} WHERE purpose = ? AND status <> ?';
        $params = [\backup::MODE_COPY, \backup::STATUS_FINISHED_OK];
        $copyrecords = $DB->get_records_sql($sql, $params);
        \copy_helper::cleanup_orphaned_copy_controllers($copyrecords);

        $loglifetime = get_config('backup', 'loglifetime');
        if (empty($loglifetime)) {
            mtrace('The \'loglifetime\' config is not set. Can\'t proceed and delete old backup records.');
            return;
        }

        // First, get the list of all backupids older than loglifetime.
        $timecreated = time() - ($loglifetime * DAYSECS);
        $records = $DB->get_records_select('backup_controllers', 'timecreated < ?', array($timecreated), 'id', 'id, backupid');

        foreach ($records as $record) {
            // Check if there is no incomplete adhoc task relying on the given backupid.
            $params = array('%' . $record->backupid . '%');
            $select = $DB->sql_like('customdata', '?', false);
            $count = $DB->count_records_select('task_adhoc',  $select, $params);
            if ($count === 0) {
                // Looks like there is no adhoc task, so we can delete logs and controllers for this backupid.
                $DB->delete_records('backup_logs', array('backupid' => $record->backupid));
                $DB->delete_records('backup_controllers', array('backupid' => $record->backupid));
            }
        }

        // Delete files and dirs older than 1 week.
        \backup_helper::delete_old_backup_dirs(strtotime('-1 week'));
    }

}
