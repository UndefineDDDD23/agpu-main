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
 * Question behaviour for questions that can only be graded manually.
 *
 * @package    qbehaviour
 * @subpackage manualgraded
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('agpu_INTERNAL') || die();


/**
 * Question behaviour for questions that can only be graded manually.
 *
 * The student enters their response during the attempt, and it is saved. Later,
 * when the whole attempt is finished, the attempt goes into the NEEDS_GRADING
 * state, and the teacher must grade it manually.
 *
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qbehaviour_manualgraded extends question_behaviour_with_save {

    public function is_compatible_question(question_definition $question) {
        return $question instanceof question_with_responses;
    }

    public function adjust_display_options(question_display_options $options) {
        parent::adjust_display_options($options);

        if ($this->qa->get_state()->is_finished()) {
            // Hide all feedback except genfeedback and manualcomment.
            $save = clone($options);
            $options->hide_all_feedback();
            $options->generalfeedback = $save->generalfeedback;
            $options->manualcomment = $save->manualcomment;
        }
    }

    public function process_action(question_attempt_pending_step $pendingstep) {
        if ($pendingstep->has_behaviour_var('comment')) {
            return $this->process_comment($pendingstep);
        } else if ($pendingstep->has_behaviour_var('finish')) {
            return $this->process_finish($pendingstep);
        } else {
            return $this->process_save($pendingstep);
        }
    }

    /**
     * Like the parent method, except that when a response is gradable, but not
     * completely, we move it to the invalid state.
     * @param question_attempt_pending_step $pendingstep a partially initialised step
     *      containing all the information about the action that is being performed.
     * @return bool either {@link question_attempt::KEEP} or {@link question_attempt::DISCARD}
     */
    public function process_save(question_attempt_pending_step $pendingstep) {
        if ($this->qa->get_state()->is_finished()) {
            return question_attempt::DISCARD;
        } else if (!$this->qa->get_state()->is_active()) {
            throw new coding_exception('Question is not active, cannot process_actions.');
        }

        if ($this->is_same_response($pendingstep)) {
            return question_attempt::DISCARD;
        }

        if ($this->is_complete_response($pendingstep)) {
            $pendingstep->set_state(question_state::$complete);
        } else if ($this->question->is_gradable_response($pendingstep->get_qt_data())) {
            $pendingstep->set_state(question_state::$invalid);
        } else {
            $pendingstep->set_state(question_state::$todo);
        }
        return question_attempt::KEEP;
    }

    public function summarise_action(question_attempt_step $step) {
        if ($step->has_behaviour_var('comment')) {
            return $this->summarise_manual_comment($step);
        } else if ($step->has_behaviour_var('finish')) {
            return $this->summarise_finish($step);
        } else {
            return $this->summarise_save($step);
        }
    }

    public function process_finish(question_attempt_pending_step $pendingstep) {
        if ($this->qa->get_state()->is_finished()) {
            return question_attempt::DISCARD;
        }

        $response = $this->qa->get_last_step()->get_qt_data();
        if (!$this->question->is_gradable_response($response)) {
            $pendingstep->set_state(question_state::$gaveup);
        } else {
            $pendingstep->set_state(question_state::$needsgrading);
        }
        $pendingstep->set_new_response_summary($this->question->summarise_response($response));
        return question_attempt::KEEP;
    }
}
