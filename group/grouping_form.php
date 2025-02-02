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
 * A form for creating and editing groupings.
 *
 * @copyright 2006 The Open University, N.D.Freear AT open.ac.uk, J.White AT open.ac.uk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   core_group
 */

if (!defined('agpu_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a agpu page
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Grouping form class
 *
 * @copyright 2006 The Open University, N.D.Freear AT open.ac.uk, J.White AT open.ac.uk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   core_group
 */
class grouping_form extends agpuform {

    /**
     * Form definition
     */
    function definition() {
        global $USER, $CFG, $COURSE;
        $coursecontext = context_course::instance($COURSE->id);

        $mform =& $this->_form;
        $editoroptions = $this->_customdata['editoroptions'];
        $grouping = $this->_customdata['grouping'];

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text','name', get_string('groupingname', 'group'),'maxlength="254" size="50"');
        $mform->addRule('name', get_string('required'), 'required', null, 'server');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('text','idnumber', get_string('idnumbergrouping'), 'maxlength="100" size="10"');
        $mform->addHelpButton('idnumber', 'idnumbergrouping');
        $mform->setType('idnumber', PARAM_RAW);
        if (!has_capability('agpu/course:changeidnumber', $coursecontext)) {
            $mform->hardFreeze('idnumber');
        }

        $mform->addElement('editor', 'description_editor', get_string('groupingdescription', 'group'), null, $editoroptions);
        $mform->setType('description_editor', PARAM_RAW);

        $handler = \core_group\customfield\grouping_handler::create();
        $handler->instance_form_definition($mform, empty($grouping->id) ? 0 : $grouping->id);
        $handler->instance_form_before_set_data($grouping);

        $mform->addElement('hidden','id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons();
    }

    /**
     * Form validation
     *
     * @param array $data
     * @param array $files
     * @return array $errors An array of validataion errors for the form.
     */
    function validation($data, $files) {
        global $COURSE, $DB;

        $errors = parent::validation($data, $files);

        $name = trim($data['name']);
        if (isset($data['idnumber'])) {
            $idnumber = trim($data['idnumber']);
        } else {
            $idnumber = '';
        }
        if ($data['id'] and $grouping = $DB->get_record('groupings', array('id'=>$data['id']))) {
            if (core_text::strtolower($grouping->name) != core_text::strtolower($name)) {
                if (groups_get_grouping_by_name($COURSE->id,  $name)) {
                    $errors['name'] = get_string('groupingnameexists', 'group', $name);
                }
            }
            if (!empty($idnumber) && $grouping->idnumber != $idnumber) {
                if (groups_get_grouping_by_idnumber($COURSE->id, $idnumber)) {
                    $errors['idnumber']= get_string('idnumbertaken');
                }
            }

        } else if (groups_get_grouping_by_name($COURSE->id, $name)) {
            $errors['name'] = get_string('groupingnameexists', 'group', $name);
        } else if (!empty($idnumber) && groups_get_grouping_by_idnumber($COURSE->id, $idnumber)) {
            $errors['idnumber']= get_string('idnumbertaken');
        }

        $handler = \core_group\customfield\grouping_handler::create();
        $errors = array_merge($errors, $handler->instance_form_validation($data, $files));

        return $errors;
    }

    /**
     *  Apply a logic after data is set.
     */
    public function definition_after_data() {
        $groupid = $this->_form->getElementValue('id');
        $handler = \core_group\customfield\grouping_handler::create();
        $handler->instance_form_definition_after_data($this->_form, empty($groupid) ? 0 : $groupid);
    }
}
