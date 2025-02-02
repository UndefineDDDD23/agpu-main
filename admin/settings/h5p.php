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
 * H5P settings link.
 *
 * @package    core_h5p
 * @copyright  2019 Amaia Anabitarte <amaia@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

// H5P overview.
$ADMIN->add('h5p', new admin_externalpage('h5poverview', get_string('h5poverview', 'core_h5p'),
    new agpu_url('/h5p/overview.php'), ['agpu/site:config']));

// Manage H5P libraries page.
$ADMIN->add('h5p', new admin_externalpage('h5pmanagelibraries', get_string('h5pmanage', 'core_h5p'),
    new agpu_url('/h5p/libraries.php'), ['agpu/site:config', 'agpu/h5p:updatelibraries']));

// H5P settings.
$defaulth5plib = \core_h5p\local\library\autoloader::get_default_handler_library();
if (!empty($defaulth5plib)) {
    // As for now this page only has this setting, it will be hidden if there isn't any H5P libraries handler defined.
    $settings = new admin_settingpage('h5psettings', new lang_string('h5psettings', 'core_h5p'));
    $ADMIN->add('h5p', $settings);

    $settings->add(new admin_settings_h5plib_handler_select('h5plibraryhandler', new lang_string('h5plibraryhandler', 'core_h5p'),
        new lang_string('h5plibraryhandler_help', 'core_h5p'), $defaulth5plib));

    $setting = new admin_setting_configtextarea(
        'core_h5p/h5pcustomcss',
        new lang_string('h5pcustomcss', 'core_h5p'),
        new lang_string('h5pcustomcss_help', 'core_h5p'),
        '',
        PARAM_NOTAGS
    );
    $setting->set_updatedcallback(function () {
        // Enables use of file_storage constants.
        \core_h5p\local\library\autoloader::register();
        \core_h5p\file_storage::generate_custom_styles();
    });
    $settings->add($setting);
}
