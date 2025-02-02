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

namespace mod_quiz\form;

use agpuform;

defined('agpu_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

/**
 * A form that limits student's access to attempt a quiz.
 *
 * @package   mod_quiz
 * @copyright  2011 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class preflight_check_form extends agpuform {

    protected function definition() {
        $mform = $this->_form;
        $this->_form->updateAttributes(['id' => 'mod_quiz_preflight_form']);

        foreach ($this->_customdata['hidden'] as $name => $value) {
            if ($name === 'sesskey') {
                continue;
            }
            $mform->addElement('hidden', $name, $value);
            $mform->setType($name, PARAM_INT);
        }

        foreach ($this->_customdata['rules'] as $rule) {
            if ($rule->is_preflight_check_required($this->_customdata['attemptid'])) {
                $rule->add_preflight_check_form_fields($this, $mform,
                        $this->_customdata['attemptid']);
            }
        }

        $this->add_action_buttons(true, get_string('startattempt', 'quiz'));
        $this->set_display_vertical();
        $mform->setDisableShortforms();
    }

    public function validation($data, $files): array {
        $errors = parent::validation($data, $files);
        $accessmanager = $this->_customdata['quizobj']->get_access_manager(time());
        return array_merge($errors, $accessmanager->validate_preflight_check(
                $data, $files, $this->_customdata['attemptid']));
    }
}
