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
 * The mod_quiz user override deleted event.
 *
 * @package    mod_quiz
 * @copyright  2014 Mark Nelson <markn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_quiz\event;

defined('agpu_INTERNAL') || die();

/**
 * The mod_quiz user override deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int quizid: the id of the quiz.
 * }
 *
 * @package    mod_quiz
 * @since      agpu 2.7
 * @copyright  2014 Mark Nelson <markn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class user_override_deleted extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'quiz_overrides';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventoverridedeleted', 'mod_quiz');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the override with id '$this->objectid' for the quiz with " .
            "course module id '$this->contextinstanceid' for the user with id '{$this->relateduserid}'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/quiz/overrides.php', ['cmid' => $this->contextinstanceid]);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['quizid'])) {
            throw new \coding_exception('The \'quizid\' value must be set in other.');
        }
    }

    public static function get_objectid_mapping() {
        return ['db' => 'quiz_overrides', 'restore' => 'quiz_override'];
    }

    public static function get_other_mapping() {
        $othermapped = [];
        $othermapped['quizid'] = ['db' => 'quiz', 'restore' => 'quiz'];

        return $othermapped;
    }
}
