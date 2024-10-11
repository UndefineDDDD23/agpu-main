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
 * Duplicates a given course module
 *
 * The script backups and restores a single activity as if it was imported
 * from the same course, using the default import settings. The newly created
 * copy of the activity is then moved right below the original one.
 *
 * @package    core
 * @subpackage course
 * @deprecated agpu 2.8 MDL-46428 - Now redirects to mod.php.
 * @copyright  2011 David Mudrak <david@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../config.php');

$cmid           = required_param('cmid', PARAM_INT);
$courseid       = required_param('course', PARAM_INT);
$sectionreturn  = optional_param('sr', null, PARAM_INT);

require_sesskey();

debugging('Please use agpu_url(\'/course/mod.php\', array(\'duplicate\' => $cmid
    , \'id\' => $courseid, \'sesskey\' => sesskey(), \'sr\' => $sectionreturn)))
    instead of new agpu_url(\'/course/modduplicate.php\', array(\'cmid\' => $cmid
    , \'course\' => $courseid, \'sr\' => $sectionreturn))', DEBUG_DEVELOPER);

redirect(new agpu_url('/course/mod.php', array('duplicate' => $cmid, 'id' => $courseid,
                                                 'sesskey' => sesskey(), 'sr' => $sectionreturn)));
