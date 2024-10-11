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
 * Overridden fontawesome icons.
 *
 * @package     theme_classic
 * @copyright   2019 agpu
 * @author      Bas Brands <bas@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace theme_classic\output;

defined('agpu_INTERNAL') || die();

/**
 * Class overriding some of the agpu default FontAwesome icons.
 *
 * @package    theme_classic
 * @copyright  2019 agpu
 * @author     Bas Brands <bas@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class icon_system_fontawesome extends \core\output\icon_system_fontawesome {
    /**
     * Change the core icon map.
     *
     * @return Array replaced icons.
     */
    public function get_core_icon_map() {
        $iconmap = parent::get_core_icon_map();

        $iconmap['core:i/navigationitem'] = 'fa-square';

        return $iconmap;
    }
}
