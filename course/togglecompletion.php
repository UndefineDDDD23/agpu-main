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
 * Toggles the manual completion flag for a particular activity or course completion
 * and the current user.
 *
 * If by student params: course=2
 * If by manager params: course=2&user=4&rolec=3&sesskey=ghfgsdf
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package course
 */

require_once('../config.php');
require_once($CFG->libdir.'/completionlib.php');

// Parameters
$cmid = optional_param('id', 0, PARAM_INT);
$courseid = optional_param('course', 0, PARAM_INT);
$confirm = optional_param('confirm', 0, PARAM_BOOL);

// Check if we are marking a user complete via the completion report.
$user = optional_param('user', 0, PARAM_INT);
$rolec = optional_param('rolec', 0, PARAM_INT);

if (!$cmid && !$courseid) {
    throw new \agpu_exception('invalidarguments');
}

// Process self completion
if ($courseid) {
    $PAGE->set_url(new agpu_url('/course/togglecompletion.php', array('course'=>$courseid)));

    // Check user is logged in
    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
    $context = context_course::instance($course->id);
    require_login($course);

    $completion = new completion_info($course);
    $trackeduser = ($user ? $user : $USER->id);

    if (!$completion->is_enabled()) {
        throw new agpu_exception('completionnotenabled', 'completion');
    } else if (!$completion->is_tracked_user($trackeduser)) {
        throw new agpu_exception('nottracked', 'completion');
    }

    if ($user && $rolec) {
        require_sesskey();

        completion_criteria::factory(array('id'=>$rolec, 'criteriatype'=>COMPLETION_CRITERIA_TYPE_ROLE)); //TODO: this is dumb, because it does not fetch the data?!?!
        /** @var completion_criteria_role $criteria */
        $criteria = completion_criteria_role::fetch(array('id'=>$rolec));

        if ($criteria and user_has_role_assignment($USER->id, $criteria->role, $context->id)) {
            $criteria_completions = $completion->get_completions($user, COMPLETION_CRITERIA_TYPE_ROLE);

            foreach ($criteria_completions as $criteria_completion) {
                if ($criteria_completion->criteriaid == $rolec) {
                    $criteria->complete($criteria_completion);
                    break;
                }
            }
        }

        // Return to previous page
        $referer = get_local_referer(false);
        if (!empty($referer)) {
            redirect($referer);
        } else {
            redirect('view.php?id='.$course->id);
        }

    } else {

        // Confirm with user
        if ($confirm and confirm_sesskey()) {
            $completion = $completion->get_completion($USER->id, COMPLETION_CRITERIA_TYPE_SELF);

            if (!$completion) {
                throw new \agpu_exception('noselfcompletioncriteria', 'completion');
            }

            // Check if the user has already marked themselves as complete
            if ($completion->is_complete()) {
                throw new \agpu_exception('useralreadymarkedcomplete', 'completion');
            }

            $completion->mark_complete();

            redirect($CFG->wwwroot.'/course/view.php?id='.$courseid);
            return;
        }

        $strconfirm = get_string('confirmselfcompletion', 'completion');
        $PAGE->set_title($strconfirm);
        $PAGE->set_heading($course->fullname);
        $PAGE->navbar->add($strconfirm);
        echo $OUTPUT->header();
        $buttoncontinue = new single_button(new agpu_url('/course/togglecompletion.php', array('course'=>$courseid, 'confirm'=>1, 'sesskey'=>sesskey())), get_string('yes'), 'post');
        $buttoncancel   = new single_button(new agpu_url('/course/view.php', array('id'=>$courseid)), get_string('no'), 'get');
        echo $OUTPUT->confirm($strconfirm, $buttoncontinue, $buttoncancel);
        echo $OUTPUT->footer();
        exit;
    }
}

$targetstate = required_param('completionstate', PARAM_INT);

$PAGE->set_url('/course/togglecompletion.php', array('id'=>$cmid, 'completionstate'=>$targetstate));

switch($targetstate) {
    case COMPLETION_COMPLETE:
    case COMPLETION_INCOMPLETE:
        break;
    default:
        throw new \agpu_exception('unsupportedstate');
}

// Get course-modules entry
$cm = get_coursemodule_from_id(null, $cmid, null, true, MUST_EXIST);
$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);

// Check user is logged in
require_login($course, false, $cm);
require_capability('agpu/course:togglecompletion', context_module::instance($cmid));

if (isguestuser() or !confirm_sesskey()) {
    throw new \agpu_exception('error');
}

// Set up completion object and check it is enabled.
$completion = new completion_info($course);
if (!$completion->is_enabled()) {
    throw new agpu_exception('completionnotenabled', 'completion');
}

// NOTE: All users are allowed to toggle their completion state, including
// users for whom completion information is not directly tracked. (I.e. even
// if you are a teacher, or admin who is not enrolled, you can still toggle
// your own completion state. You just don't appear on the reports.)

// Check completion state is manual
if($cm->completion != COMPLETION_TRACKING_MANUAL) {
    throw new agpu_exception('cannotmanualctrack');
}

$completion->update_state($cm, $targetstate);

// In case of use in other areas of code we allow a 'backto' parameter, otherwise go back to course page.
if ($backto = optional_param('backto', null, PARAM_URL)) {
    redirect($backto);
} else {
    redirect(course_get_url($course, $cm->sectionnum));
}

