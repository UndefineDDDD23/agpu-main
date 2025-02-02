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
 * List of Web Services for the tool_usertours plugin.
 *
 * @package    tool_usertours
 * @copyright  2016 Andrew Nicols
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$functions = [
    'tool_usertours_fetch_and_start_tour' => [
        'classname'       => 'tool_usertours\external\tour',
        'methodname'      => 'fetch_and_start_tour',
        'description'     => 'Fetch the specified tour',
        'type'            => 'read',
        'capabilities'    => '',
        'ajax'            => true,
    ],

    'tool_usertours_step_shown' => [
        'classname'       => 'tool_usertours\external\tour',
        'methodname'      => 'step_shown',
        'description'     => 'Mark the specified step as completed for the current user',
        'type'            => 'write',
        'capabilities'    => '',
        'ajax'            => true,
    ],

    'tool_usertours_complete_tour' => [
        'classname'       => 'tool_usertours\external\tour',
        'methodname'      => 'complete_tour',
        'description'     => 'Mark the specified tour as completed for the current user',
        'type'            => 'write',
        'capabilities'    => '',
        'ajax'            => true,
    ],

    'tool_usertours_reset_tour' => [
        'classname'       => 'tool_usertours\external\tour',
        'methodname'      => 'reset_tour',
        'description'     => 'Remove the specified tour',
        'type'            => 'write',
        'capabilities'    => '',
        'ajax'            => true,
    ],
];
