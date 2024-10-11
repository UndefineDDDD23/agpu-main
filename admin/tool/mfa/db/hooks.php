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
 * Hook callbacks for Multi-factor authentication
 *
 * @package    tool_mfa
 * @copyright  2024 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$callbacks = [
    [
        'hook' => core_user\hook\extend_bulk_user_actions::class,
        'callback' => [\tool_mfa\local\hooks\extend_bulk_user_actions::class, 'callback'],
        'priority' => 0,
    ],
    [
        'hook' => \core\hook\after_config::class,
        'callback' => [\tool_mfa\hook_callbacks::class, 'after_config'],
    ],
];