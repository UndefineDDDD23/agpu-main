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
 * The mod_forum course searched event.
 *
 * @package    mod_forum
 * @copyright  2014 Dan Poltawski <dan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\event;

defined('agpu_INTERNAL') || die();

/**
 * The mod_forum course searched event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string searchterm: The searchterm used on forum search.
 * }
 *
 * @package    mod_forum
 * @since      agpu 2.7
 * @copyright  2014 Dan Poltawski <dan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_searched extends \core\event\base {

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
        $searchterm = s($this->other['searchterm']);
        return "The user with id '$this->userid' has searched the course with id '$this->courseid' for forum posts " .
            "containing \"{$searchterm}\".";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursesearched', 'mod_forum');
    }

    /**
     * Get URL related to the action
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/forum/search.php',
            array('id' => $this->courseid, 'search' => $this->other['searchterm']));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['searchterm'])) {
            throw new \coding_exception('The \'searchterm\' value must be set in other.');
        }

        if ($this->contextlevel != CONTEXT_COURSE) {
            throw new \coding_exception('Context level must be CONTEXT_COURSE.');
        }
    }

    public static function get_other_mapping() {
        return false;
    }
}

