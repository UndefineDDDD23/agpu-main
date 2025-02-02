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
 * Settings for format_singleactivity
 *
 * @package    format_singleactivity
 * @copyright  2012 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;
require_once($CFG->dirroot. '/course/format/singleactivity/settingslib.php');

if ($ADMIN->fulltree) {
    $settings->add(new format_singleactivity_admin_setting_activitytype('format_singleactivity/activitytype',
            new lang_string('defactivitytype', 'format_singleactivity'),
            new lang_string('defactivitytypedesc', 'format_singleactivity'),
            'forum', null));
}
