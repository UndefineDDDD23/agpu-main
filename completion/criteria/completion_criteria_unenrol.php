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
 * Course completion critieria - completion on unenrolment
 *
 * @package core_completion
 * @category completion
 * @copyright 2009 Catalyst IT Ltd
 * @author Aaron Barnes <aaronb@catalyst.net.nz>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Course completion critieria - completion on unenrolment
 *
 * @package core_completion
 * @category completion
 * @copyright 2009 Catalyst IT Ltd
 * @author Aaron Barnes <aaronb@catalyst.net.nz>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class completion_criteria_unenrol extends completion_criteria {

    /* @var int Criteria type constant [COMPLETION_CRITERIA_TYPE_UNENROL] */
    public $criteriatype = COMPLETION_CRITERIA_TYPE_UNENROL;

    /**
     * Finds and returns a data_object instance based on params.
     *
     * @param array $params associative arrays varname=>value
     * @return data_object data_object instance or false if none found.
     */
    public static function fetch($params) {
        $params['criteriatype'] = COMPLETION_CRITERIA_TYPE_UNENROL;
        return self::fetch_helper('course_completion_criteria', __CLASS__, $params);
    }

    /**
     * Add appropriate form elements to the critieria form
     *
     * @param agpuform $mform agpu forms object
     * @param stdClass $data Form data
     */
    public function config_form_display(&$mform, $data = null) {
        $mform->addElement('checkbox', 'criteria_unenrol', get_string('enable'));

        if ($this->id) {
            $mform->setDefault('criteria_unenrol', 1);
        }
    }

    /**
     * Update the criteria information stored in the database
     *
     * @param stdClass $data Form data
     */
    public function update_config(&$data) {
        if (!empty($data->criteria_unenrol)) {
            $this->course = $data->id;
            $this->insert();
        }
    }

    /**
     * Review this criteria and decide if the user has completed
     *
     * @param completion_completion $completion The user's completion record
     * @param bool $mark Optionally set false to not save changes to database
     * @return bool
     */
    public function review($completion, $mark = true) {
        // Check enrolment
        return false;
    }

    /**
     * Return criteria title for display in reports
     *
     * @return string
     */
    public function get_title() {
        return get_string('unenrol', 'enrol');
    }

    /**
     * Return a more detailed criteria title for display in reports
     *
     * @return string
     */
    public function get_title_detailed() {
        return $this->get_title();
    }

    /**
     * Return criteria type title for display in reports
     *
     * @return string
     */
    public function get_type_title() {
        return get_string('unenrol', 'enrol');
    }

    /**
     * Return criteria progress details for display in reports
     *
     * @param completion_completion $completion The user's completion record
     * @return array An array with the following keys:
     *     type, criteria, requirement, status
     */
    public function get_details($completion) {
        $details = array();
        $details['type'] = get_string('unenrolment', 'completion');
        $details['criteria'] = get_string('unenrolment', 'completion');
        $details['requirement'] = get_string('unenrolingfromcourse', 'completion');
        $details['status'] = '';
        return $details;
    }

    /**
     * Return pix_icon for display in reports.
     *
     * @param string $alt The alt text to use for the icon
     * @param array $attributes html attributes
     * @return pix_icon
     */
    public function get_icon($alt, ?array $attributes = null) {
        return new pix_icon('i/user', $alt, 'agpu', $attributes);
    }
}
