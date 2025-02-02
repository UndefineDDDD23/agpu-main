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
 * This page is the entry page into the quiz UI. Displays information about the
 * quiz to students and teachers, and lets students see their previous attempts.
 *
 * @package   mod_quiz
 * @category  grade
 * @copyright 1999 onwards Martin Dougiamas  {@link http://agpu.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_quiz\quiz_attempt;
use mod_quiz\quiz_settings;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/mod/quiz/report/reportlib.php');


$id = required_param('id', PARAM_INT);
$userid = optional_param('userid', 0, PARAM_INT);

$quizobj = quiz_settings::create_for_cmid($id);
$quiz = $quizobj->get_quiz();
$cm = $quizobj->get_cm();
$course = $quizobj->get_course();
require_login($course, false, $cm);

$reportlist = quiz_report_list($quizobj->get_context());
if (empty($reportlist) || $userid == $USER->id) {
    // If the user cannot see reports, or can see reports but is looking
    // at their own grades, redirect them to the view.php page.
    // (The looking at their own grades case is unlikely, since users who
    // appear in the gradebook are unlikely to be able to see quiz reports,
    // but it is possible.)
    redirect(new agpu_url('/mod/quiz/view.php', ['id' => $cm->id]));
}

// Now we know the user is interested in reports. If they are interested in a
// specific other user, try to send them to the most appropriate attempt review page.
if ($userid) {

    // Work out which attempt is most significant from a grading point of view.
    $attempts = quiz_get_user_attempts($quiz->id, $userid, 'finished');
    $attempt = null;
    switch ($quiz->grademethod) {
        case QUIZ_ATTEMPTFIRST:
            $attempt = reset($attempts);
            break;

        case QUIZ_ATTEMPTLAST:
        case QUIZ_GRADEAVERAGE:
            $attempt = end($attempts);
            break;

        case QUIZ_GRADEHIGHEST:
            $maxmark = 0;
            foreach ($attempts as $at) {
                // Operator >=, since we want to most recent relevant attempt.
                if ((float) $at->sumgrades >= $maxmark) {
                    $maxmark = $at->sumgrades;
                    $attempt = $at;
                }
            }
            break;
    }

    // If the user can review the relevant attempt, redirect to it.
    if ($attempt) {
        $attemptobj = new quiz_attempt($attempt, $quiz, $cm, $course, false);
        if ($attemptobj->is_review_allowed()) {
            $attemptobj->load_questions();
            redirect($attemptobj->review_url());
        }
    }

    // Otherwise, fall thorugh to the generic case.
}

// Send the user to the first report they can see.
redirect(new agpu_url('/mod/quiz/report.php', [
        'id' => $cm->id, 'mode' => reset($reportlist)]));
