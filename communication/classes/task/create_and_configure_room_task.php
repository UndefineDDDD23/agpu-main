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

namespace core_communication\task;

use core\task\adhoc_task;
use core_communication\processor;

/**
 * Class create_and_configure_room_task to add a task to create a room and execute the task to action the creation.
 *
 * this task will be queued by the communication api and will use the communication handler api to action the creation.
 *
 * @package    core_communication
 * @copyright  2023 Safat Shahin <safat.shahin@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class create_and_configure_room_task extends adhoc_task {
    public function execute() {
        $data = $this->get_custom_data();

        // Call the communication api to action the operation.
        $communication = processor::load_by_id($data->id);

        if ($communication === null) {
            mtrace("Skipping room creation because the instance does not exist");
            return;
        }

        if (!$communication->is_instance_active()) {
            mtrace("Skipping room creation because the instance is not active");
            return;
        }

        // If the room is created successfully, add members to the room if supported by the provider.
        if ($communication->get_room_provider()->create_chat_room() && $communication->supports_user_features()) {
            add_members_to_room_task::queue(
                $communication
            );
        }
    }

    /**
     * Queue the task for the next run.
     *
     * @param processor $communication The communication processor to perform the action on
     */
    public static function queue(
        processor $communication,
    ): void {

        // Add ad-hoc task to update the provider room.
        $task = new self();
        $task->set_custom_data([
            'id' => $communication->get_id(),
        ]);

        // Queue the task for the next run.
        \core\task\manager::queue_adhoc_task($task);
    }
}
