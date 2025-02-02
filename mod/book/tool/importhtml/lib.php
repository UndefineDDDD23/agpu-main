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
 * HTML import lib
 *
 * @package    booktool_importhtml
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

/**
 * Adds module specific settings to the settings block
 *
 * @param settings_navigation $settings The settings navigation object
 * @param navigation_node $node The node to add module settings to
 */
function booktool_importhtml_extend_settings_navigation(settings_navigation $settings, navigation_node $node) {
    if (has_capability('booktool/importhtml:import', $settings->get_page()->cm->context)) {
        $url = new agpu_url('/mod/book/tool/importhtml/index.php', array('id' => $settings->get_page()->cm->id));
        $node->add(get_string('import', 'booktool_importhtml'), $url, navigation_node::TYPE_SETTING, null, 'importchapter', null);
    }
}
