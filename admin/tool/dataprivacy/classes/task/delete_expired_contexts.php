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
 * Scheduled task to delete expired context instances once they are approved for deletion.
 *
 * @package    tool_dataprivacy
 * @copyright  2018 David Monllao
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_dataprivacy\task;

use coding_exception;
use core\task\scheduled_task;
use tool_dataprivacy\api;

defined('agpu_INTERNAL') || die();

require_once($CFG->dirroot . '/' . $CFG->admin . '/tool/dataprivacy/lib.php');

/**
 * Scheduled task to delete expired context instances once they are approved for deletion.
 *
 * @package     tool_dataprivacy
 * @copyright   2018 David Monllao
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class delete_expired_contexts extends scheduled_task {

    /**
     * Returns the task name.
     *
     * @return string
     */
    public function get_name() {
        return get_string('deleteexpiredcontextstask', 'tool_dataprivacy');
    }

    /**
     * Run the task to delete context instances based on their retention periods.
     */
    public function execute() {
        $manager = new \tool_dataprivacy\expired_contexts_manager(new \text_progress_trace());
        list($courses, $users) = $manager->process_approved_deletions();
        mtrace("Processed deletions for {$courses} course contexts, and {$users} user contexts as expired");
    }
}
