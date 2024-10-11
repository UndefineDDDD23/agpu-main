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
 * Tool agpu.Net webservice definitions.
 *
 * @package    tool_agpunet
 * @copyright  2020 Mathew May {@link https://mathew.solutions}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$functions = [
    'tool_agpunet_verify_webfinger' => [
        'classname'   => 'tool_agpunet\external',
        'methodname'  => 'verify_webfinger',
        'description' => 'Verify if the passed information resolves into a WebFinger profile URL',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [agpu_OFFICIAL_MOBILE_SERVICE]
    ],
    'tool_agpunet_search_courses' => [
        'classname'   => 'tool_agpunet\external',
        'methodname'  => 'search_courses',
        'description' => 'For some given input search for a course that matches',
        'type'        => 'read',
        'ajax'        => true,
        'services'    => [agpu_OFFICIAL_MOBILE_SERVICE]
    ],
];
