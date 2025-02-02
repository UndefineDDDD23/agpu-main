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

/**
 * Simple task to run the plagiarism cron.
 */
class plagiarism_cron_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskplagiarismcron', 'admin');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $CFG;

        if (!empty($CFG->enableplagiarism)) {
            require_once($CFG->libdir.'/plagiarismlib.php');
            $plagiarismplugins = plagiarism_load_available_plugins();
            foreach ($plagiarismplugins as $plugin => $dir) {
                require_once($dir . '/lib.php');
                $plagiarismclass = "plagiarism_plugin_$plugin";
                $plagiarismplugin = new $plagiarismclass;
                if (method_exists($plagiarismplugin, 'cron')) {
                    mtrace('Processing cron function for plagiarism_plugin_' . $plugin . '...', '');
                    \core\cron::trace_time_and_memory();
                    mtrace('It has been detected the class ' . $plagiarismclass . ' has a legacy cron method
                            implemented. Plagiarism plugins should implement their own schedule tasks.', '');
                    $plagiarismplugin->cron();
                }
            }
        }
    }

}
