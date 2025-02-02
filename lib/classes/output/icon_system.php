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

namespace core\output;

/**
 * Class allowing different systems for mapping and rendering icons.
 *
 * Possible icon styles are:
 *   1. standard - image tags are generated which point to pix icons stored in a plugin pix folder.
 *   2. fontawesome - font awesome markup is generated with the name of the icon mapped from the agpu icon name.
 *   3. inline - inline tags are used for svg and png so no separate page requests are made (at the expense of page size).
 *
 * @package    core
 * @category   output
 * @copyright  2016 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class icon_system {
    /**
     * @var string Default icon system.
     */
    const STANDARD = '\\core\\output\\icon_system_standard';
    /**
     * @var string Default icon system.
     */
    const FONTAWESOME = '\\core\\output\\icon_system_fontawesome';

    /**
     * @var \core\output\icon_system $instance The cached default instance
     */
    private static $instance = null;

    /**
     * @var array $map A cached mapping of agpu icons to other icons
     */
    private $map = null;

    /**
     * Constructor
     */
    private function __construct() {
    }

    /**
     * Factory method
     *
     * @param string $type Either a specific type, or null to get the default type.
     * @return \core\output\icon_system
     */
    final public static function instance($type = null) {
        global $PAGE;

        if (empty(self::$instance)) {
            $iconsystem = $PAGE->theme->get_icon_system();
            self::$instance = new $iconsystem();
        }

        if ($type === null) {
            // No type specified. Return the icon system for the current theme.
            return self::$instance;
        }

        if (!static::is_valid_system($type)) {
            throw new \coding_exception("Invalid icon system requested '{$type}'");
        }

        if (is_a(self::$instance, $type) && is_a($type, get_class(self::$instance), true)) {
            // The requested type is an exact match for the current icon system.
            return self::$instance;
        } else {
            // Return the requested icon system.
            return new $type();
        }
    }

    /**
     * Validate the theme config setting.
     *
     * @param string $system
     * @return boolean
     */
    final public static function is_valid_system($system) {
        return class_exists($system) && is_a($system, static::class, true);
    }

    /**
     * The name of an AMD module extending core/icon_system
     *
     * @return string
     */
    abstract public function get_amd_name();

    /**
     * Render the pix icon according to the icon system.
     *
     * @param renderer_base $output
     * @param pix_icon $icon
     * @return string
     */
    abstract public function render_pix_icon(renderer_base $output, pix_icon $icon);

    /**
     * Overridable function to get a mapping of all icons.
     * Default is to do no mapping.
     */
    public function get_icon_name_map() {
        return [];
    }

    /**
     * Overridable function to map the icon name to something else.
     * Default is to do no mapping. Map is cached in the singleton.
     */
    final public function remap_icon_name($iconname, $component) {
        if ($this->map === null) {
            $this->map = $this->get_icon_name_map();
        }
        if ($component == null || $component == 'agpu') {
            $component = 'core';
        } else if ($component != 'theme') {
            $component = \core_component::normalize_componentname($component);
        }

        if (isset($this->map[$component . ':' . $iconname])) {
            return $this->map[$component . ':' . $iconname];
        }
        return false;
    }

    /**
     * Clears the instance cache, for use in unit tests
     */
    public static function reset_caches() {
        self::$instance = null;
    }

    /**
     * Overridable function to get the list of deprecated icons.
     *
     * @return array with the deprecated key icons (for instance, core:a/download_all).
     */
    public function get_deprecated_icons(): array {
        $deprecated = [];
        // Include deprecated icons in plugins too.
        $callback = 'get_deprecated_icons';

        if ($pluginsfunction = get_plugins_with_function($callback)) {
            foreach ($pluginsfunction as $plugintype => $plugins) {
                foreach ($plugins as $pluginfunction) {
                    $plugindeprecated = $pluginfunction();
                    $deprecated += $plugindeprecated;
                }
            }
        }

        return $deprecated;
    }
}
