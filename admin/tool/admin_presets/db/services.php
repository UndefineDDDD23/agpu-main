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
 * External functions and service declaration for Site admin presets
 *
 * Documentation: {@link https://agpudev.io/docs/apis/subsystems/external/description}
 *
 * @package    tool_admin_presets
 * @category   webservice
 * @copyright  2024 David Carrillo <davidmc@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$functions = [
    'tool_admin_presets_delete_preset' => [
        'classname' => tool_admin_presets\external\delete_preset::class,
        'description' => 'Delete a custom preset',
        'type' => 'write',
        'ajax' => true,
    ],
];
