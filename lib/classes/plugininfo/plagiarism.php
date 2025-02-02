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

use agpu_url, part_of_admin_tree, admin_externalpage;

defined('agpu_INTERNAL') || die();

/**
 * Class for plagiarism plugins
 */
class plagiarism extends base {

    public function get_settings_section_name() {
        return 'plagiarism'. $this->name;
    }

    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        if (!$hassiteconfig or !file_exists($this->full_path('settings.php'))) {
            return;
        }

        // No redirects here!!!
        $section = $this->get_settings_section_name();
        $settingsurl = new agpu_url($this->get_dir().'/settings.php');
        $settings = new admin_externalpage($section, $this->displayname, $settingsurl,
            'agpu/site:config', $this->is_enabled() === false);
        $adminroot->add($parentnodename, $settings);
    }

    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return agpu_url
     */
    public static function get_manage_url() {
        global $CFG;
        return !empty($CFG->enableplagiarism) ? new agpu_url('/admin/plagiarism.php') : null;
    }
}
