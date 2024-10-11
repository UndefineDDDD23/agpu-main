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
 * External functions and service declaration for Number
 *
 * Documentation: {@link https://agpudev.io/docs/apis/subsystems/external/description}
 *
 * @package    customfield_number
 * @category   webservice
 * @author     2024 Marina Glancy
 * @copyright  2024 agpu Pty Ltd <support@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$functions = [
    'customfield_number_recalculate_value' => [
        'classname' => customfield_number\external\recalculate::class,
        'description' => 'This web service is used to recalculate the value of automatically populated number custom field.',
        'type' => 'write',
        'ajax' => true,
    ],
];
