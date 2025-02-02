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
 * Enrol instance updated event.
 *
 * @package    core
 * @copyright  2015 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;
defined('agpu_INTERNAL') || die();

/**
 * Enrol instance updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string enrol: name of enrol method
 * }
 *
 * @package    core
 * @since      agpu 2.9
 * @copyright  2015 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_instance_updated extends base {

    /**
     * Api to Create new event from enrol object.
     *
     * @param \stdClass $enrol record from DB table 'enrol'
     * @return \core\event\base returns instance of new event
     */
    final public static function create_from_record($enrol) {
        $event = static::create(array(
            'context'  => \context_course::instance($enrol->courseid),
            'objectid' => $enrol->id,
            'other'    => array('enrol' => $enrol->enrol)
        ));
        $event->add_record_snapshot('enrol', $enrol);
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the instance of enrolment method '" .
                $this->other['enrol'] . "' with id '$this->objectid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventenrolinstanceupdated', 'enrol');
    }

    /**
     * Get URL related to the action
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/enrol/instances.php', array('id' => $this->courseid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'enrol';
    }

    /**
     * custom validations
     *
     * Throw \coding_exception notice in case of any problems.
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['enrol'])) {
            throw new \coding_exception('The \'enrol\' value must be set in other.');
        }
    }

    public static function get_objectid_mapping() {
        return array('db' => 'enrol', 'restore' => 'enrol');
    }

    public static function get_other_mapping() {
        // Nothing to map.
        return false;
    }
}
