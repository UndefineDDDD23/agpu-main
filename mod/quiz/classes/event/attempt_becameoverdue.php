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
 * The mod_quiz attempt became overdue event.
 *
 * @package    mod_quiz
 * @copyright  2013 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_quiz\event;
defined('agpu_INTERNAL') || die();

/**
 * The mod_quiz attempt became overdue event class.
 *
 * Please note that the name of this event is not following the event naming convention.
 * Its name should not be used as a reference for other events to be created.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int submitterid: id of submitter (null when trigged by CLI script).
 *      - int quizid: (optional) the id of the quiz.
 * }
 *
 * @package    mod_quiz
 * @since      agpu 2.6
 * @copyright  2013 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class attempt_becameoverdue extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'quiz_attempts';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The quiz attempt with id '$this->objectid' belonging to the quiz with course module id '$this->contextinstanceid' " .
            "for the user with id '$this->relateduserid' became overdue.";
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventquizattempttimelimitexceeded', 'mod_quiz');
    }

    /**
     * Returns relevant URL.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/quiz/review.php', ['attempt' => $this->objectid]);
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

        if (!array_key_exists('submitterid', $this->other)) {
            throw new \coding_exception('The \'submitterid\' value must be set in other.');
        }
    }

    public static function get_objectid_mapping() {
        return ['db' => 'quiz_attempts', 'restore' => 'quiz_attempt'];
    }

    public static function get_other_mapping() {
        $othermapped = [];
        $othermapped['submitterid'] = ['db' => 'user', 'restore' => 'user'];
        $othermapped['quizid'] = ['db' => 'quiz', 'restore' => 'quiz'];

        return $othermapped;
    }
}
