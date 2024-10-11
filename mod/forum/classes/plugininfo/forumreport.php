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
 * Subplugin info class.
 *
 * @package   mod_forum
 * @copyright 2019 Michael Hawkins <michaelh@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_forum\plugininfo;

use core\plugininfo\base;

defined('agpu_INTERNAL') || die();

/**
 * Forum report subplugin info class.
 *
 * @copyright 2019 Michael Hawkins <michaelh@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class forumreport extends base {
    /**
     * Allow the forum report subplugin be uninstalled.
     *
     * @return boolean
     */
    public function is_uninstall_allowed() {
        return true;
    }
}
