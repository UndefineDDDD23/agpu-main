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
 * The mod_choice answer created event.
 *
 * @package    mod_choice
 * @copyright  2016 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_choice\event;

defined('agpu_INTERNAL') || die();

/**
 * The mod_choice answer created event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int choiceid: id of choice.
 *      - int optionid: id of the option.
 * }
 *
 * @package    mod_choice
 * @since      agpu 3.2
 * @copyright  2016 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class answer_created extends \core\event\base {

    /**
     * Creates an instance of the event from the records
     *
     * @param stdClass $choiceanswer record from 'choice_answers' table
     * @param stdClass $choice record from 'choice' table
     * @param stdClass $cm record from 'course_modules' table
     * @param stdClass $course
     * @return self
     */
    public static function create_from_object($choiceanswer, $choice, $cm, $course) {
        global $USER;
        $eventdata = array();
        $eventdata['objectid'] = $choiceanswer->id;
        $eventdata['context'] = \context_module::instance($cm->id);
        $eventdata['userid'] = $USER->id;
        $eventdata['courseid'] = $course->id;
        $eventdata['relateduserid'] = $choiceanswer->userid;
        $eventdata['other'] = array();
        $eventdata['other']['choiceid'] = $choice->id;
        $eventdata['other']['optionid'] = $choiceanswer->optionid;
        $event = self::create($eventdata);
        $event->add_record_snapshot('course', $course);
        $event->add_record_snapshot('course_modules', $cm);
        $event->add_record_snapshot('choice', $choice);
        $event->add_record_snapshot('choice_answers', $choiceanswer);
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has added the option with id '" . $this->other['optionid'] . "' for the
            user with id '$this->relateduserid' from the choice activity with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventanswercreated', 'mod_choice');
    }

    /**
     * Get URL related to the action
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/choice/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'choice_answers';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['choiceid'])) {
            throw new \coding_exception('The \'choiceid\' value must be set in other.');
        }

        if (!isset($this->other['optionid'])) {
            throw new \coding_exception('The \'optionid\' value must be set in other.');
        }
    }

    /**
     * This is used when restoring course logs where it is required that we
     * map the objectid to it's new value in the new course.
     *
     * @return string the name of the restore mapping the objectid links to
     */
    public static function get_objectid_mapping() {
        return array('db' => 'choice_answers', 'restore' => 'answer');
    }

    /**
     * This is used when restoring course logs where it is required that we
     * map the information in 'other' to it's new value in the new course.
     *
     * @return array an array of other values and their corresponding mapping
     */
    public static function get_other_mapping() {
        $othermapped = array();
        $othermapped['choiceid'] = array('db' => 'choice', 'restore' => 'choice');
        $othermapped['optionid'] = array('db' => 'choice_options', 'restore' => 'choice_option');

        return $othermapped;
    }
}
