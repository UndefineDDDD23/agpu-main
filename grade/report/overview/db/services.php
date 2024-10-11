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
 * Overview grade report external functions and service definitions.
 *
 * @package    gradereport_overview
 * @copyright  2016 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$functions = array(

    'gradereport_overview_get_course_grades' => array(
        'classname' => 'gradereport_overview_external',
        'methodname' => 'get_course_grades',
        'description' => 'Get the given user courses final grades',
        'type' => 'read',
        'services' => array(agpu_OFFICIAL_MOBILE_SERVICE),
    ),
    'gradereport_overview_view_grade_report' => array(
        'classname' => 'gradereport_overview_external',
        'methodname' => 'view_grade_report',
        'description' => 'Trigger the report view event',
        'type' => 'write',
        'capabilities' => 'gradereport/overview:view',
        'services' => array(agpu_OFFICIAL_MOBILE_SERVICE),
    )
);
