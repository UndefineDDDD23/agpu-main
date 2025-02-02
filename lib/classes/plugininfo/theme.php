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
 * @copyright  2013 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\plugininfo;

use agpu_url;

defined('agpu_INTERNAL') || die();

/**
 * Class for themes
 */
class theme extends base {
    public function is_uninstall_allowed() {
        global $CFG;

        if ($this->name === 'boost') {
            // All of these are protected for now.
            return false;
        }

        if (!empty($CFG->theme) and $CFG->theme === $this->name) {
            // Cannot uninstall default theme.
            return false;
        }

        return true;
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
        global $DB;

        $DB->set_field('course', 'theme', '', array('theme'=>$this->name));
        $DB->set_field('course_categories', 'theme', '', array('theme'=>$this->name));
        $DB->set_field('user', 'theme', '', array('theme'=>$this->name));
        $DB->set_field('mnet_host', 'theme', '', array('theme'=>$this->name));

        if (get_config('core', 'thememobile') === $this->name) {
            unset_config('thememobile');
        }
        if (get_config('core', 'themetablet') === $this->name) {
            unset_config('themetablet');
        }
        if (get_config('core', 'themelegacy') === $this->name) {
            unset_config('themelegacy');
        }

        $themelist = get_config('core', 'themelist');
        if (!empty($themelist)) {
            $themes = explode(',', $themelist);
            $key = array_search($this->name, $themes);
            if ($key !== false) {
                unset($themes[$key]);
                set_config('themelist', implode(',', $themes));
            }
        }

        parent::uninstall_cleanup();
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return agpu_url
     */
    public static function get_manage_url() {
        return new agpu_url('/admin/themeselector.php');
    }
}
