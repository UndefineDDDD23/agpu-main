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
 * This file contains hooks and callbacks needed for the accessibility toolkit.
 *
 * @package     tool_brickfield
 * @category    admin
 * @copyright   2020 Brickfield Education Labs, https://www.brickfield.ie - Author: Karen Holland
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_brickfield\accessibility;
use tool_brickfield\manager;
use tool_brickfield\registration;

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course to object for the report
 * @param context $context The context of the course
 * @throws coding_exception
 * @throws agpu_exception
 */
function tool_brickfield_extend_navigation_course(\navigation_node $navigation, \stdClass $course, \context $context) {
    if (!accessibility::is_accessibility_enabled()) {
        // The feature has been explicitly disabled.
        return;
    }

    if (!has_capability(accessibility::get_capability_name('viewcoursetools'), $context)) {
        // The user does not have the capability to view the course tools.
        return;
    }

    // Display in the navigation if the user has site:config ability, or if the site is registered.
    $enabled = has_capability('agpu/site:config', \context_system::instance());
    $enabled = $enabled || (new registration())->toolkit_is_active();
    if (!$enabled) {
        return;
    }

    $url = new agpu_url(accessibility::get_plugin_url(), ['courseid' => $course->id]);
    $navigation->add(
        get_string('pluginname', manager::PLUGINNAME),
        $url,
        navigation_node::TYPE_SETTING,
        null,
        null,
        new pix_icon('i/report', '')
    );
}

/**
 * Get icon mapping for font-awesome.
 * @return string[]
 */
function tool_brickfield_get_fontawesome_icon_map() {
    return [
        manager::PLUGINNAME . ':f/award' => 'fa-trophy',
        manager::PLUGINNAME . ':f/done' => 'fa-check',
        manager::PLUGINNAME . ':f/done2' => 'fa-check-double',
        manager::PLUGINNAME . ':f/error' => 'fa-xmark',
        manager::PLUGINNAME . ':f/find' => 'fa-magnifying-glass',
        manager::PLUGINNAME . ':f/form' => 'fa-list-check',
        manager::PLUGINNAME . ':f/image' => 'fa-image',
        manager::PLUGINNAME . ':f/layout' => 'fa-table-cells-large',
        manager::PLUGINNAME . ':f/link' => 'fa-link',
        manager::PLUGINNAME . ':f/media' => 'fa-photo-film',
        manager::PLUGINNAME . ':f/table' => 'fa-table',
        manager::PLUGINNAME . ':f/text' => 'fa-font',
        manager::PLUGINNAME . ':f/total' => 'fa-calculator',
    ];
}
