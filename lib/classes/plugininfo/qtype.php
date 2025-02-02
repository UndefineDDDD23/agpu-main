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
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2011 David Mudrak <david@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\plugininfo;

use admin_settingpage;
use core_plugin_manager;
use agpu_url;
use part_of_admin_tree;

/**
 * Class for question types
 */
class qtype extends base {

    public static function plugintype_supports_disabling(): bool {
        return true;
    }

    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        global $DB;

        $plugins = core_plugin_manager::instance()->get_installed_plugins('qtype');
        if (!$plugins) {
            return array();
        }
        $installed = array();
        foreach ($plugins as $plugin => $version) {
            $installed[] = $plugin.'_disabled';
        }

        list($installed, $params) = $DB->get_in_or_equal($installed, SQL_PARAMS_NAMED);
        $disabled = $DB->get_records_select('config_plugins', "name $installed AND plugin = 'question'", $params, 'plugin ASC');
        foreach ($disabled as $conf) {
            if (empty($conf->value)) {
                continue;
            }
            $name = substr($conf->name, 0, -9);
            unset($plugins[$name]);
        }

        $enabled = array();
        foreach ($plugins as $plugin => $version) {
            $enabled[$plugin] = $plugin;
        }

        return $enabled;
    }

    public static function enable_plugin(string $pluginname, int $enabled): bool {
        $haschanged = false;

        $settingname = $pluginname . '_disabled';
        $oldvalue = get_config('question', $settingname);
        $disabled = !$enabled;
        // Only set value if there is no config setting or if the value is different from the previous one.
        if ($oldvalue == false && $disabled) {
            set_config($settingname, $disabled, 'question');
            $haschanged = true;
        } else if ($oldvalue != false && !$disabled) {
            unset_config($settingname, 'question');
            $haschanged = true;
        }

        if ($haschanged) {
            add_to_config_log($settingname, $oldvalue, $disabled, 'question');
            \core_plugin_manager::reset_caches();
        }

        return $haschanged;
    }

    public function is_uninstall_allowed() {
        global $DB;

        if ($this->name === 'missingtype') {
            // qtype_missingtype is used by the system. It cannot be uninstalled.
            return false;
        }

        return !$DB->record_exists('question', array('qtype' => $this->name));
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return agpu_url
     */
    public static function get_manage_url() {
        return new agpu_url('/admin/qtypes.php');
    }

    /**
     * Pre-uninstall hook.
     *
     * This is intended for disabling of plugin, some DB table purging, etc.
     *
     * NOTE: to be called from uninstall_plugin() only.
     * @private
     */
    public function uninstall_cleanup() {
        // Delete any question configuration records mentioning this plugin.
        unset_config($this->name . '_disabled', 'question');
        unset_config($this->name . '_sortorder', 'question');

        parent::uninstall_cleanup();
    }

    public function get_settings_section_name() {
        return 'qtypesetting' . $this->name;
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        /** @var \admin_root $ADMIN */
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.
        $qtype = $this;      // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        $section = $this->get_settings_section_name();

        $settings = null;
        $systemcontext = \context_system::instance();
        if (($hassiteconfig || has_capability('agpu/question:config', $systemcontext)) &&
            file_exists($this->full_path('settings.php'))) {
            $settings = new admin_settingpage($section, $this->displayname,
                'agpu/question:config', $this->is_enabled() === false);
            include($this->full_path('settings.php')); // This may also set $settings to null.
        }
        if ($settings) {
            $ADMIN->add($parentnodename, $settings);
        }
    }
}
