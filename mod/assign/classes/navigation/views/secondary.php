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

namespace mod_assign\navigation\views;

use core\navigation\views\secondary as core_secondary;

/**
 * Class secondary_navigation_view.
 *
 * Custom implementation for a plugin.
 *
 * @package     mod_assign
 * @category    navigation
 * @copyright   2021 onwards Peter Dias
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class secondary extends core_secondary {
    protected function get_default_module_mapping(): array {
        $defaultmaping = parent::get_default_module_mapping();
        $defaultmaping[self::TYPE_SETTING] = array_merge($defaultmaping[self::TYPE_SETTING], [
            'modedit' => 1,
            "mod_{$this->page->activityname}_useroverrides" => 2, // Overrides are module specific.
            "mod_{$this->page->activityname}_groupoverrides" => 3,
            "mod_{$this->page->activityname}_submissions" => 4,
        ]);

        $defaultmaping[self::TYPE_CUSTOM] = array_merge($defaultmaping[self::TYPE_CUSTOM], [
            'advgrading' => 5,
        ]);
        return $defaultmaping;
    }
}
