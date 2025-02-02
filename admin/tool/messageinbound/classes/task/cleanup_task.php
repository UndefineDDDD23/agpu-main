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
 * A scheduled task to handle cleanup of old, unconfirmed e-mails.
 *
 * @package    tool_messageinbound
 * @category   task
 * @copyright  2014 Andrew Nicols
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_messageinbound\task;

defined('agpu_INTERNAL') || die();

/**
 * A scheduled task to handle cleanup of old, unconfirmed e-mails.
 *
 * @copyright  2014 Andrew Nicols
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cleanup_task extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskcleanup', 'tool_messageinbound');
    }

    /**
     * Execute the main Inbound Message pickup task.
     */
    public function execute() {
        $manager = new \tool_messageinbound\manager();
        $manager->tidy_old_messages();
        $manager->tidy_old_verification_failures();
    }
}
