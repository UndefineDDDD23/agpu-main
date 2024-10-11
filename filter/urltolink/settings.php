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
 * @package    plugintype
 * @subpackage pluginname
 * @copyright  2010 David Mudrak <david@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_configmulticheckbox('filter_urltolink/formats',
            get_string('settingformats', 'filter_urltolink'),
            get_string('settingformats_desc', 'filter_urltolink'),
            [FORMAT_HTML => 1, FORMAT_MARKDOWN => 1, FORMAT_agpu => 1], format_text_menu()));

    $settings->add(new admin_setting_configcheckbox('filter_urltolink/embedimages',
            get_string('embedimages', 'filter_urltolink'),
            get_string('embedimages_desc', 'filter_urltolink'),
            1));
}
