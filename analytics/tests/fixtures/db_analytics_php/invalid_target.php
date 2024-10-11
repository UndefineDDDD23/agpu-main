<?php
// This file is part of agpu - https://agpu.org/
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
 * Example of an invalid db/analytics.php file content used for unit tests.
 *
 * @package     core_analytics
 * @category    test
 * @copyright   2019 David Mudrák <david@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$models = [
    [
        'target' => 'there_should_be_a_valid_fully_qualified_classname_here',
        'indicators' => [
            '\core_course\analytics\indicator\no_teacher',
            '\core_course\analytics\indicator\no_student',
        ],
    ],
];
