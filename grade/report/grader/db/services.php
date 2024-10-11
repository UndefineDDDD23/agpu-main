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
 * Grader grade report external functions and service definitions.
 *
 * @package    gradereport_grader
 * @copyright  2022 Mathew May <Mathew.solutions>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

$functions = [
    'gradereport_grader_get_users_in_report' => [
        'classname' => 'gradereport_grader\\external\\get_users_in_report',
        'methodname' => 'execute',
        'description' => 'Returns the dataset of users within the report',
        'type' => 'read',
        'ajax' => true,
        'capabilities' => 'gradereport/grader:view',
        'services' => [agpu_OFFICIAL_MOBILE_SERVICE],
    ],
];
