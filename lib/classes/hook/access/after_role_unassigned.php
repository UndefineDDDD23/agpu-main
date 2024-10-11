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

namespace core\hook\access;

use context;

/**
 * Hook after a role is unassigned.
 *
 * @package    core
 * @copyright  2024 Safat Shahin <safat.shahin@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\core\attribute\label('Allows plugins or features to perform actions after a role is unassigned for a user.')]
#[\core\attribute\tags('role', 'user')]
class after_role_unassigned {
    /**
     * Constructor for the hook.
     *
     * @param context $context The context of the role assignment.
     * @param int $userid The user id of the user.
     *
     */
    public function __construct(
        /** @var context The context of the role assignment */
        public readonly context $context,
        /** @var int The user id of the user */
        public readonly int $userid,
    ) {
    }
}
