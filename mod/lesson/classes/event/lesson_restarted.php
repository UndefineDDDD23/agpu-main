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
 * The mod_lesson lesson restarted event class.
 *
 * @package    mod_lesson
 * @copyright  2015 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

namespace mod_lesson\event;

defined('agpu_INTERNAL') || die();

/**
 * The mod_lesson lesson restarted event class
 *
 * @package    mod_lesson
 * @since      agpu 2.9
 * @copyright  2015 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */
class lesson_restarted extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'lesson';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventlessonrestarted', 'mod_lesson');
    }

    /**
     * Get URL related to the action.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/lesson/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' abandoned their previous incomplete attempt ".
               "and started a new attempt on the lesson with course module id '$this->contextinstanceid'.";
    }

    public static function get_objectid_mapping() {
        return array('db' => 'lesson', 'restore' => 'lesson');
    }
}
