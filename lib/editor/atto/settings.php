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
 * Atto admin settings
 *
 * @package    editor_atto
 * @copyright  2013 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$ADMIN->add('editorsettings', new admin_category('editoratto', $editor->displayname, $editor->is_enabled() === false));

$settings = new admin_settingpage('editorsettingsatto', new lang_string('settings', 'editor_atto'));
if ($ADMIN->fulltree) {
    require_once(__DIR__ . '/adminlib.php');
    $settings->add(new editor_atto_subplugins_setting());
    $name = new lang_string('toolbarconfig', 'editor_atto');
    $desc = new lang_string('toolbarconfig_desc', 'editor_atto');
    $default = 'collapse = collapse
style1 = title, bold, italic
list = unorderedlist, orderedlist, indent
links = link
files = emojipicker, image, media, recordrtc, managefiles, h5p
accessibility = accessibilitychecker, accessibilityhelper
style2 = underline, strike, subscript, superscript
align = align
insert = equation, charmap, table, clear
undo = undo
other = html';
    $setting = new editor_atto_toolbar_setting('editor_atto/toolbar', $name, $desc, $default);

    $settings->add($setting);
}

$name = new lang_string('autosavefrequency', 'editor_atto');
$desc = new lang_string('autosavefrequency_desc', 'editor_atto');
$default = 60;
$setting = new admin_setting_configduration('editor_atto/autosavefrequency', $name, $desc, $default);
$settings->add($setting);

$ADMIN->add('editoratto', $settings);

foreach (core_plugin_manager::instance()->get_plugins_of_type('atto') as $plugin) {
    /** @var \editor_atto\plugininfo\atto $plugin */
    $plugin->load_settings($ADMIN, 'editoratto', $hassiteconfig);
}

// Required or the editor plugininfo will add this section twice.
unset($settings);
$settings = null;

