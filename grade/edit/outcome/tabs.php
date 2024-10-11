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
 * Prints navigation tabs for viewing and editing grade outcomes
 *
 * @package   core_grades
 * @copyright 2009 Petr Skoda
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

    $row = $tabs = array();

    $context = context_course::instance($courseid);

    $row[] = new tabobject('courseoutcomes',
                           $CFG->wwwroot.'/grade/edit/outcome/course.php?id='.$courseid,
                           get_string('outcomescourse', 'grades'));

    if (has_capability('agpu/grade:manage', $context)) {
        $row[] = new tabobject('outcomes',
                               $CFG->wwwroot.'/grade/edit/outcome/index.php?id='.$courseid,
                               get_string('editoutcomes', 'grades'));
    }

    $tabs[] = $row;

    echo '<div class="outcomedisplay">';
    print_tabs($tabs, $currenttab);
    echo '</div>';


