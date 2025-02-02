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

use mod_quiz\form\preflight_check_form;
use mod_quiz\local\access_rule_base;
use mod_quiz\quiz_settings;

/**
 * A rule representing the time limit.
 *
 * It does not actually restrict access, but we use this
 * class to encapsulate some of the relevant code.
 *
 * @package   quizaccess_timelimit
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quizaccess_timelimit extends access_rule_base {

    public static function make(quiz_settings $quizobj, $timenow, $canignoretimelimits) {

        if (empty($quizobj->get_quiz()->timelimit) || $canignoretimelimits) {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    public function description() {
        return get_string('quiztimelimit', 'quizaccess_timelimit',
                format_time($this->quiz->timelimit));
    }

    public function end_time($attempt) {
        $timedue = $attempt->timestart + $this->quiz->timelimit;
        if ($this->quiz->timeclose) {
            $timedue = min($timedue, $this->quiz->timeclose);
        }
        return $timedue;
    }

    public function time_left_display($attempt, $timenow) {
        // If this is a teacher preview after the time limit expires, don't show the time_left
        $endtime = $this->end_time($attempt);
        if ($attempt->preview && $timenow > $endtime) {
            return false;
        }
        return $endtime - $timenow;
    }

    public function is_preflight_check_required($attemptid) {
        // Warning only required if the attempt is not already started.
        return $attemptid === null;
    }

    public function add_preflight_check_form_fields(preflight_check_form $quizform,
            agpuQuickForm $mform, $attemptid) {
        $mform->addElement('header', 'honestycheckheader',
                get_string('confirmstartheader', 'quizaccess_timelimit'));
        $mform->addElement('static', 'honestycheckmessage', '',
                get_string('confirmstart', 'quizaccess_timelimit', format_time($this->quiz->timelimit)));
    }
}
