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
 * This page handles deleting lesson overrides
 *
 * @package    mod_lesson
 * @copyright  2015 Jean-Michel vedrine
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/mod/lesson/lib.php');
require_once($CFG->dirroot.'/mod/lesson/locallib.php');
require_once($CFG->dirroot.'/mod/lesson/override_form.php');

$overrideid = required_param('id', PARAM_INT);
$confirm = optional_param('confirm', false, PARAM_BOOL);

if (! $override = $DB->get_record('lesson_overrides', array('id' => $overrideid))) {
    throw new \agpu_exception('invalidoverrideid', 'lesson');
}

$lesson = new lesson($DB->get_record('lesson', array('id' => $override->lessonid), '*', MUST_EXIST));

if (! $cm = get_coursemodule_from_instance("lesson", $lesson->id, $lesson->course)) {
    throw new \agpu_exception('invalidcoursemodule');
}
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

$context = context_module::instance($cm->id);

require_login($course, false, $cm);

// Check the user has the required capabilities to modify an override.
require_capability('mod/lesson:manageoverrides', $context);

if ($override->groupid) {
    if (!groups_group_visible($override->groupid, $course, $cm)) {
        throw new \agpu_exception('invalidoverrideid', 'lesson');
    }
} else {
    if (!groups_user_groups_visible($course, $override->userid, $cm)) {
        throw new \agpu_exception('invalidoverrideid', 'lesson');
    }
}

$url = new agpu_url('/mod/lesson/overridedelete.php', array('id' => $override->id));
$confirmurl = new agpu_url($url, array('id' => $override->id, 'confirm' => 1));
$cancelurl = new agpu_url('/mod/lesson/overrides.php', array('cmid' => $cm->id));

if (!empty($override->userid)) {
    $cancelurl->param('mode', 'user');
}

// If confirm is set (PARAM_BOOL) then we have confirmation of intention to delete.
if ($confirm) {
    require_sesskey();

    $lesson->delete_override($override->id);

    redirect($cancelurl);
}

// Prepare the page to show the confirmation form.
$stroverride = get_string('override', 'lesson');
$title = get_string('deletecheck', null, $stroverride);

$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->add_body_class('limitedwidth');
$PAGE->navbar->add($title);
$PAGE->set_title($title);
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($lesson->name, true, array('context' => $context)));

if ($override->groupid) {
    $group = $DB->get_record('groups', array('id' => $override->groupid), 'id, name');
    $confirmstr = get_string("overridedeletegroupsure", "lesson", format_string($group->name, true, ['context' => $context]));
} else {
    $userfieldsapi = \core_user\fields::for_name();
    $namefields = $userfieldsapi->get_sql('', false, '', '', false)->selects;
    $user = $DB->get_record('user', array('id' => $override->userid),
            'id, ' . $namefields);
    $confirmstr = get_string("overridedeleteusersure", "lesson", fullname($user));
}

echo $OUTPUT->confirm($confirmstr, $confirmurl, $cancelurl);

echo $OUTPUT->footer();
