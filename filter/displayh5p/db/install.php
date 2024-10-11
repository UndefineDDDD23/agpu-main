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
 * Display H5P active by default
 *
 * @package    filter_displayh5p
 * @copyright  2019 Amaia Anabitarte <amaia@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Enable displayh5p filter by default to render H5P contents.
 * @throws coding_exception
 */
function xmldb_filter_displayh5p_install() {
    global $CFG;

    require_once($CFG->dirroot . '/filter/displayh5p/db/upgradelib.php');

    // We need to move up the displayh5p filter over urltolink and activitynames filters to works properly.
    filter_displayh5p_reorder();
}
