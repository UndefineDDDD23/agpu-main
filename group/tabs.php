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
 * Prints navigation tabs
 *
 * @package    core_group
 * @copyright  2010 Petr Skoda (http://agpu.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
    $row = array();
    $row[] = new tabobject('groups',
                           new agpu_url('/group/index.php', array('id' => $courseid)),
                           get_string('groups'));

    $row[] = new tabobject('groupings',
                           new agpu_url('/group/groupings.php', array('id' => $courseid)),
                           get_string('groupings', 'group'));

    $row[] = new tabobject('overview',
                           new agpu_url('/group/overview.php', array('id' => $courseid)),
                           get_string('overview', 'group'));
    echo '<div class="groupdisplay">';
    echo $OUTPUT->tabtree($row, $currenttab);
    echo '</div>';
