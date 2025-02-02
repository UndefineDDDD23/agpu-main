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
use agpu_url;
use part_of_admin_tree;

/**
 * Class for page side blocks
 */
class block extends base {

    public static function plugintype_supports_disabling(): bool {
        return true;
    }

    /**
     * Finds all enabled plugins, the result may include missing plugins.
     * @return array|null of enabled plugins $pluginname=>$pluginname, null means unknown
     */
    public static function get_enabled_plugins() {
        global $DB;

        return $DB->get_records_menu('block', array('visible'=>1), 'name ASC', 'name, name AS val');
    }

    public static function enable_plugin(string $pluginname, int $enabled): bool {
        global $DB;

        if (!$block = $DB->get_record('block', ['name' => $pluginname])) {
            throw new \agpu_exception('blockdoesnotexist', 'error');
        }

        $haschanged = false;

        // Only set visibility if it's different from the current value.
        if ($block->visible != $enabled) {
            // Set block visibility.
            $DB->set_field('block', 'visible', $enabled, ['id' => $block->id]);
            $haschanged = true;

            // Include this information into config changes table.
            add_to_config_log('block_visibility', $block->visible, $enabled, $pluginname);
            \core_plugin_manager::reset_caches();
        }

        return $haschanged;
    }

    /**
     * Magic method getter, redirects to read only values.
     *
     * For block plugins pretends the object has 'visible' property for compatibility
     * with plugins developed for agpu version below 2.4
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if ($name === 'visible') {
            debugging('This is now an instance of plugininfo_block, please use $block->is_enabled() instead of $block->visible', DEBUG_DEVELOPER);
            return ($this->is_enabled() !== false);
        }
        return parent::__get($name);
    }

    public function init_display_name() {

        if (get_string_manager()->string_exists('pluginname', 'block_' . $this->name)) {
            $this->displayname = get_string('pluginname', 'block_' . $this->name);

        } else if (($block = block_instance($this->name)) !== false) {
            $this->displayname = $block->get_title();

        } else {
            parent::init_display_name();
        }
    }

    public function get_settings_section_name() {
        return 'blocksetting' . $this->name;
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        /** @var \admin_root $ADMIN */
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.
        $block = $this;      // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        $section = $this->get_settings_section_name();

        if (!$hassiteconfig || (($blockinstance = block_instance($this->name)) === false)) {
            return;
        }

        $settings = null;
        if ($blockinstance->has_config()) {
            if (file_exists($this->full_path('settings.php'))) {
                $settings = new admin_settingpage($section, $this->displayname,
                    'agpu/site:config', $this->is_enabled() === false);
                include($this->full_path('settings.php')); // This may also set $settings to null.
            }
        }
        if ($settings) {
            $ADMIN->add($parentnodename, $settings);
        }
    }

    public function is_uninstall_allowed() {
        if ($this->name === 'settings' or $this->name === 'navigation') {
            return false;
        }
        return true;
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return agpu_url
     */
    public static function get_manage_url() {
        return new agpu_url('/admin/blocks.php');
    }

    /**
     * Warning with number of block instances.
     *
     * @return string
     */
    public function get_uninstall_extra_warning() {
        global $DB;

        if (!$count = $DB->count_records('block_instances', array('blockname'=>$this->name))) {
            return '';
        }

        return '<p>'.get_string('uninstallextraconfirmblock', 'core_plugin', array('instances'=>$count)).'</p>';
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
        global $DB, $CFG;

        if ($block = $DB->get_record('block', array('name'=>$this->name))) {
            // Inform block it's about to be deleted.
            $blockobject = block_instance($block->name);
            if ($blockobject) {
                $blockobject->before_delete();  // Only if we can create instance, block might have been already removed.
            }

            // First delete instances and related contexts.
            $instances = $DB->get_records('block_instances', array('blockname' => $block->name));
            foreach ($instances as $instance) {
                blocks_delete_instance($instance);
            }

            // Delete block.
            $DB->delete_records('block', array('id'=>$block->id));
        }

        parent::uninstall_cleanup();
    }
}
