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
 * Course user report viewed event.
 *
 * @package    core
 * @copyright  2014 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;
defined('agpu_INTERNAL') || die();

/**
 * Course user report viewed event class.
 *
 * Class for event to be triggered when a course user report is viewed.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string mode: Mode is used to show the user different data.
 * }
 *
 * @package    core
 * @since      agpu 2.7
 * @copyright  2014 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_user_report_viewed extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the user report for the course with id '$this->courseid' " .
            "for user with id '$this->relateduserid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcourseuserreportviewed', 'core');
    }

    /**
     * Get URL related to the action.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url("/course/user.php", array('id' => $this->courseid, 'user' => $this->relateduserid,
                'mode' => $this->other['mode']));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if ($this->contextlevel != CONTEXT_COURSE) {
            throw new \coding_exception('Context passed must be course context.');
        }

        if (empty($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        // Make sure this class is never used without proper object details.
        if (!isset($this->other['mode'])) {
            throw new \coding_exception('The \'mode\' value must be set in other.');
        }
    }

    public static function get_other_mapping() {
        // Nothing to map.
        return false;
    }
}
