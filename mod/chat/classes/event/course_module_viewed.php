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
 * The mod_chat course module viewed event.
 *
 * @package    mod_chat
 * @copyright  2014 Petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_chat\event;

defined('agpu_INTERNAL') || die();

/**
 * The mod_chat course module viewed event class.
 *
 * @package    mod_chat
 * @since      agpu 2.7
 * @copyright  2014 Petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_module_viewed extends \core\event\course_module_viewed {
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'chat';
    }

    public static function get_objectid_mapping() {
        return array('db' => 'chat', 'restore' => 'chat');
    }
}