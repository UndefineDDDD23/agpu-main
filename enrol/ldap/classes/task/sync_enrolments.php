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
 * Sync enrolments task
 * @package enrol_ldap
 * @author    Guy Thomas <gthomas@agpurooms.com>
 * @copyright Copyright (c) 2017 Blackboard Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_ldap\task;

defined('agpu_INTERNAL') || die();

/**
 * Class sync_enrolments
 * @package enrol_ldap
 * @author    Guy Thomas <gthomas@agpurooms.com>
 * @copyright Copyright (c) 2017 Blackboard Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class sync_enrolments extends \core\task\scheduled_task {

    /**
     * Name for this task.
     *
     * @return string
     */
    public function get_name() {
        return get_string('syncenrolmentstask', 'enrol_ldap');
    }

    /**
     * Run task for synchronising users.
     */
    public function execute() {

        if (!enrol_is_enabled('ldap')) {
            mtrace(get_string('pluginnotenabled', 'enrol_ldap'));
            exit(0); // Note, exit with success code, this is not an error - it's just disabled.
        }

        /** @var \enrol_ldap_plugin $enrol */
        $enrol = enrol_get_plugin('ldap');

        $trace = new \text_progress_trace();

        // Update enrolments -- these handlers should autocreate courses if required.
        $enrol->sync_enrolments($trace);
    }

}
