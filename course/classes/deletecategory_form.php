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
 * Delete category form.
 *
 * @package core_course
 * @copyright 2002 onwards Martin Dougiamas (http://dougiamas.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->libdir . '/questionlib.php');

/**
 * Delete category agpuform.
 * @package core_course
 * @copyright 2002 onwards Martin Dougiamas (http://dougiamas.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_course_deletecategory_form extends agpuform {

    /**
     * The core_course_category object for that category being deleted.
     * @var core_course_category
     */
    protected $coursecat;

    /**
     * Defines the form.
     */
    public function definition() {
        $mform = $this->_form;
        $this->coursecat = $this->_customdata;

        $categorycontext = context_coursecat::instance($this->coursecat->id);
        $categoryname = $this->coursecat->get_formatted_name();

        // Check permissions, to see if it OK to give the option to delete
        // the contents, rather than move elsewhere.
        $candeletecontent = $this->coursecat->can_delete_full();

        // Get the list of categories we might be able to move to.
        $displaylist = $this->coursecat->move_content_targets_list();

        // Now build the options.
        $options = array();
        if ($displaylist) {
            $options[0] = get_string('movecontentstoanothercategory');
        }
        if ($candeletecontent) {
            $options[1] = get_string('deleteallcannotundo');
        }
        if (empty($options)) {
            throw new \agpu_exception('youcannotdeletecategory', 'error', 'index.php', $categoryname);
        }

        // Now build the form.
        $mform->addElement('header', 'general', get_string('categorycurrentcontents', '', $categoryname));

        // Describe the contents of this category.
        $contents = '';
        if ($this->coursecat->has_children()) {
            $contents .= html_writer::tag('li', get_string('subcategories'));
        }
        if ($this->coursecat->has_courses()) {
            $contents .= html_writer::tag('li', get_string('courses'));
        }
        if (question_context_has_any_questions($categorycontext)) {
            $contents .= html_writer::tag('li', get_string('questionsinthequestionbank'));
        }

        // Check if plugins can provide more info.
        $pluginfunctions = $this->coursecat->get_plugins_callback_function('get_course_category_contents');
        foreach ($pluginfunctions as $pluginfunction) {
            if ($plugincontents = $pluginfunction($this->coursecat)) {
                $contents .= html_writer::tag('li', $plugincontents);
            }
        }

        if (!empty($contents)) {
            $mform->addElement('static', 'emptymessage', get_string('thiscategorycontains'), html_writer::tag('ul', $contents));
        } else {
            $mform->addElement('static', 'emptymessage', '', get_string('deletecategoryempty'));
        }

        // Give the options for what to do.
        $mform->addElement('select', 'fulldelete', get_string('whattodo'), $options);

        if (count($options) == 1) {
            // Freeze selector if only one option available.
            $optionkeys = array_keys($options);
            $option = reset($optionkeys);
            $mform->hardFreeze('fulldelete');
            $mform->setConstant('fulldelete', $option);
        }

        if ($displaylist) {
            $mform->addElement('autocomplete', 'newparent', get_string('movecategorycontentto'), $displaylist);
            if (in_array($this->coursecat->parent, $displaylist)) {
                $mform->setDefault('newparent', $this->coursecat->parent);
            }
            $mform->hideIf('newparent', 'fulldelete', 'eq', '1');
        }

        $mform->addElement('hidden', 'categoryid', $this->coursecat->id);
        $mform->setType('categoryid', PARAM_ALPHANUM);
        $mform->addElement('hidden', 'action', 'deletecategory');
        $mform->setType('action', PARAM_ALPHANUM);

        $this->add_action_buttons(true, get_string('delete'));
    }

    /**
     * Perform some extra agpu validation.
     *
     * @param array $data
     * @param array $files
     * @return array An array of errors.
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if (empty($data['fulldelete']) && empty($data['newparent'])) {
            // When they have chosen the move option, they must specify a destination.
            $errors['newparent'] = get_string('required');
            return $errors;
        }

        if (!empty($data['newparent']) && !$this->coursecat->can_move_content_to($data['newparent'])) {
            $errors['newparent'] = get_string('movecatcontentstoselected', 'error');
        }

        return $errors;
    }
}