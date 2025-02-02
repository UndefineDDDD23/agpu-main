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

use mod_quiz\local\reports\attempts_report;
use mod_quiz\local\reports\attempts_report_options;

/**
 * Class to store the options for a {@link quiz_overview_report}.
 *
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quiz_overview_options extends attempts_report_options {

    /** @var bool whether to show only attempt that need regrading. */
    public $onlyregraded = false;

    /** @var bool whether to show marks for each question (slot). */
    public $slotmarks = true;

    protected function get_url_params() {
        $params = parent::get_url_params();
        $params['onlyregraded'] = $this->onlyregraded;
        $params['slotmarks']    = $this->slotmarks;
        return $params;
    }

    public function get_initial_form_data() {
        $toform = parent::get_initial_form_data();
        $toform->onlyregraded = $this->onlyregraded;
        $toform->slotmarks    = $this->slotmarks;

        return $toform;
    }

    public function setup_from_form_data($fromform) {
        parent::setup_from_form_data($fromform);

        $this->onlyregraded = !empty($fromform->onlyregraded);
        $this->slotmarks    = $fromform->slotmarks;
    }

    public function setup_from_params() {
        parent::setup_from_params();

        $this->onlyregraded = optional_param('onlyregraded', $this->onlyregraded, PARAM_BOOL);
        $this->slotmarks    = optional_param('slotmarks', $this->slotmarks, PARAM_BOOL);
    }

    public function setup_from_user_preferences() {
        parent::setup_from_user_preferences();

        $this->slotmarks = get_user_preferences('quiz_overview_slotmarks', $this->slotmarks);
    }

    public function update_user_preferences() {
        parent::update_user_preferences();

        if (quiz_has_grades($this->quiz)) {
            set_user_preference('quiz_overview_slotmarks', $this->slotmarks);
        }
    }

    public function resolve_dependencies() {
        parent::resolve_dependencies();

        if ($this->attempts == attempts_report::ENROLLED_WITHOUT) {
            $this->onlyregraded = false;
        }

        if (!$this->usercanseegrades) {
            $this->slotmarks = false;
        }

        // We only want to show the checkbox to delete attempts
        // if the user has permissions and if the report mode is showing attempts.
        $this->checkboxcolumn = has_any_capability(
                ['mod/quiz:regrade', 'mod/quiz:deleteattempts'], context_module::instance($this->cm->id))
                && ($this->attempts != attempts_report::ENROLLED_WITHOUT);
    }
}
