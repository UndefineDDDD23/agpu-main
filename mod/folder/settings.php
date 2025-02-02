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
 * Folder module admin settings and defaults
 *
 * @package   mod_folder
 * @copyright 2009 Petr Skoda  {@link http://skodak.org}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

if ($ADMIN->fulltree) {
    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_configcheckbox('folder/showexpanded',
        get_string('showexpanded', 'folder'),
        get_string('showexpanded_help', 'folder'), 1));

    $settings->add(new admin_setting_configtext('folder/maxsizetodownload',
        get_string('maxsizetodownload', 'folder'),
        get_string('maxsizetodownload_help', 'folder'), '', PARAM_INT));
}
