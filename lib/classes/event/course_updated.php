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
 * Course updated event.
 *
 * @package    core
 * @copyright  2013 Mark Nelson <markn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

defined('agpu_INTERNAL') || die();

/**
 * Course updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string shortname: (optional) shortname of course.
 *      - string fullname: (optional) fullname of course.
 *      - string updatedfields: (optional) array of course table fields edited in this event, ['fieldname' => 'newvalue']
 * }
 *
 * @package    core
 * @since      agpu 2.6
 * @copyright  2013 Mark Nelson <markn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_updated extends base {

    /** @var array The legacy log data. */
    private $legacylogdata;

    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['objecttable'] = 'course';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcourseupdated');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the course with id '$this->courseid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/course/edit.php', array('id' => $this->objectid));
    }

    public static function get_objectid_mapping() {
        return array('db' => 'course', 'restore' => 'course');
    }

    public static function get_other_mapping() {
        // Nothing to map.
        return false;
    }
}
