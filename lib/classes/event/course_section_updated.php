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
 * Course section updated event.
 *
 * @package    core
 * @copyright  2013 Rajesh Taneja <rajesh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

defined('agpu_INTERNAL') || die();

/**
 * Course section updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int sectionnum: section number.
 * }
 *
 * @package    core
 * @since      agpu 2.6
 * @copyright  2013 Rajesh Taneja <rajesh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_section_updated extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'course_sections';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursesectionupdated');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated section number '{$this->other['sectionnum']}' for the " .
            "course with id '$this->courseid'";
    }

    /**
     * Get URL related to the action.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/course/editsection.php', array('id' => $this->objectid));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['sectionnum'])) {
            throw new \coding_exception('The \'sectionnum\' value must be set in other.');
        }
    }

    public static function get_objectid_mapping() {
        return array('db' => 'course_sections', 'restore' => 'course_section');
    }

    public static function get_other_mapping() {
        // Nothing to map.
        return false;
    }
}
