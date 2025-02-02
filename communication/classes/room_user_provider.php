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

namespace core_communication;

/**
 * Class communication_user_base to manage communication provider users.
 *
 * @package    core_communication
 * @copyright  2023 Safat Shahin <safat.shahin@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
interface room_user_provider {
    /**
     * Add members to communication room.
     *
     * @param array $userids The user ids to be added
     */
    public function add_members_to_room(array $userids): void;

    /**
     * Update room membership for the communication room.
     *
     * @param array $userids The user ids to be updated
     */
    public function update_room_membership(array $userids): void;

    /**
     * Remove members from room.
     *
     * @param array $userids The user ids to be removed
     */
    public function remove_members_from_room(array $userids): void;
}
