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

use mod_quiz\local\access_rule_base;
use mod_quiz\quiz_settings;

/**
 * A rule enforcing open and close dates.
 *
 * @package   quizaccess_openclosedate
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quizaccess_openclosedate extends access_rule_base {

    public static function make(quiz_settings $quizobj, $timenow, $canignoretimelimits) {
        // This rule is always used, even if the quiz has no open or close date.
        return new self($quizobj, $timenow);
    }

    public function prevent_access() {
        $message = get_string('notavailable', 'quizaccess_openclosedate');

        if ($this->timenow < $this->quiz->timeopen) {
            return $message;
        }

        if (!$this->quiz->timeclose) {
            return false;
        }

        if ($this->timenow <= $this->quiz->timeclose) {
            return false;
        }

        if ($this->quiz->overduehandling != 'graceperiod') {
            return $message;
        }

        if ($this->timenow <= $this->quiz->timeclose + $this->quiz->graceperiod) {
            return false;
        }

        return $message;
    }

    public function is_finished($numprevattempts, $lastattempt) {
        return $this->quiz->timeclose && $this->timenow > $this->quiz->timeclose;
    }

    public function end_time($attempt) {
        if ($this->quiz->timeclose) {
            return $this->quiz->timeclose;
        }
        return false;
    }

    public function time_left_display($attempt, $timenow) {
        // If this is a teacher preview after the close date, do not show
        // the time.
        if ($attempt->preview && $timenow > $this->quiz->timeclose) {
            return false;
        }
        // Otherwise, return to the time left until the close date, providing that is
        // less than QUIZ_SHOW_TIME_BEFORE_DEADLINE.
        $endtime = $this->end_time($attempt);
        if ($endtime !== false && $timenow > $endtime - QUIZ_SHOW_TIME_BEFORE_DEADLINE) {
            return $endtime - $timenow;
        }
        return false;
    }
}
