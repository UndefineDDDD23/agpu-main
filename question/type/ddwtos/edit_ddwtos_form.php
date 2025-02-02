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
 * Defines the editing form for the drag-and-drop words into sentences question type.
 *
 * @package   qtype_ddwtos
 * @copyright 2009 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('agpu_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/gapselect/edit_form_base.php');


/**
 * Drag-and-drop words into sentences editing form definition.
 *
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_ddwtos_edit_form extends qtype_gapselect_edit_form_base {
    public function qtype() {
        return 'ddwtos';
    }

    protected function data_preprocessing_choice($question, $answer, $key) {
        $question = parent::data_preprocessing_choice($question, $answer, $key);
        $options = unserialize_object($answer->feedback);
        $question->choices[$key]['choicegroup'] = $options->draggroup ?? 1;
        $question->choices[$key]['infinite'] = !empty($options->infinite);
        return $question;
    }

    protected function choice_group($mform) {
        $grouparray = parent::choice_group($mform);
        $grouparray[] = $mform->createElement('checkbox', 'infinite', get_string('infinite', 'qtype_ddwtos'), '', null,
                array('size' => 1, 'class' => 'tweakcss'));
        return $grouparray;
    }

    protected function extra_slot_validation(array $slots, array $choices): ?string {
        foreach ($slots as $slot) {
            if (count(array_filter($slots, fn($value) => $value == $slot)) > 1) {
                $choice = $choices[$slot - 1];
                if (!isset($choice['infinite']) || $choice['infinite'] != 1) {
                    return get_string('errorlimitedchoice', 'qtype_ddwtos',
                        html_writer::tag('b', $slot));
                }
            }
        }
        return null;
    }

    protected function definition_inner($mform): void {
        parent::definition_inner($mform);
        $mform->insertElementBefore($mform->createElement('static', 'previewarea', '',
            get_string('choicesacceptedtext', 'qtype_ddwtos')), 'shuffleanswers');
    }
}
