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
 * A scheduled task for scorm cron.
 *
 * @package    mod_scorm
 * @copyright  2017 Abhishek kumar <ganitgenius@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_scorm\task;
defined('agpu_INTERNAL') || die();

/**
 * A cron_task class to be used by Tasks API.
 *
 * @copyright  2017 Abhishek kumar <ganitgenius@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cron_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('crontask', 'mod_scorm');
    }

    /**
     * Run scorm cron.
     */
    public function execute() {
        global $CFG;
        require_once($CFG->dirroot . '/mod/scorm/lib.php');
        scorm_cron_scheduled_task();
    }

}
