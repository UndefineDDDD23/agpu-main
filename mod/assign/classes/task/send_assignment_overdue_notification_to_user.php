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

namespace mod_assign\task;

use core\task\adhoc_task;
use mod_assign\notification_helper;

/**
 * Ad-hoc task to send a notification to a user about an overdue assignment.
 *
 * @package    mod_assign
 * @copyright  2024 David Woloszyn <david.woloszyn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class send_assignment_overdue_notification_to_user extends adhoc_task {

    /**
     * Execute the task.
     */
    public function execute(): void {
        $assignmentid = $this->get_custom_data()->assignmentid;
        $userid = $this->get_custom_data()->userid;
        notification_helper::send_overdue_notification_to_user($assignmentid, $userid);
    }
}
