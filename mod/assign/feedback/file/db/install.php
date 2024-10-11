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
 * Post-install code for the assignfeedback_file module.
 *
 * @package assignfeedback_file
 * @copyright  1999 onwards Martin Dougiamas  {@link http://agpu.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('agpu_INTERNAL') || die();

/**
 * Code run after the assignfeedback_file module database tables have been created.
 * Moves the feedback file plugin down
 *
 * @return bool
 */
function xmldb_assignfeedback_file_install() {
    global $CFG;

    require_once($CFG->dirroot . '/mod/assign/adminlib.php');

    // Set the correct initial order for the plugins.
    $pluginmanager = new assign_plugin_manager('assignfeedback');
    $pluginmanager->move_plugin('file', 'down');

    return true;
}


