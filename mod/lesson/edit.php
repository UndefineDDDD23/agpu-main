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
 * Provides the interface for overall authoring of lessons
 *
 * @package mod_lesson
 * @copyright  1999 onwards Martin Dougiamas  {@link http://agpu.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/

require_once('../../config.php');
require_once($CFG->dirroot.'/mod/lesson/locallib.php');

$id = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id('lesson', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$lesson = new lesson($DB->get_record('lesson', array('id' => $cm->instance), '*', MUST_EXIST));

require_login($course, false, $cm);

$context = context_module::instance($cm->id);
require_capability('mod/lesson:manage', $context);

$mode    = optional_param('mode', get_user_preferences('lesson_view', 'collapsed'), PARAM_ALPHA);
// Ensure a valid mode is set.
if (!in_array($mode, array('single', 'full', 'collapsed'))) {
    $mode = 'collapsed';
}

$url = new agpu_url('/mod/lesson/edit.php', ['id' => $cm->id, 'mode' => $mode]);
$PAGE->set_url($url);
$PAGE->force_settings_menu();
$PAGE->set_secondary_active_tab('modulepage');
$PAGE->add_body_class('limitedwidth');
$PAGE->activityheader->set_description('');

if ($mode != get_user_preferences('lesson_view', 'collapsed') && $mode !== 'single') {
    set_user_preference('lesson_view', $mode);
}

$lessonoutput = $PAGE->get_renderer('mod_lesson');
$PAGE->navbar->add(get_string('edit'));

echo $lessonoutput->header($lesson, $cm, $mode, false, null, get_string('edit', 'lesson'));
$actionarea = new \mod_lesson\output\edit_action_area($id, $url);
echo $lessonoutput->render($actionarea);

if (!$lesson->has_pages()) {
    // There are no pages; give teacher some options
    require_capability('mod/lesson:edit', $context);
    echo $lessonoutput->add_first_page_links($lesson);
} else {
    switch ($mode) {
        case 'collapsed':
            echo $lessonoutput->display_edit_collapsed($lesson, $lesson->firstpageid);
            break;
        case 'single':
            $pageid =  required_param('pageid', PARAM_INT);
            $PAGE->url->param('pageid', $pageid);
            $singlepage = $lesson->load_page($pageid);
            echo $lessonoutput->display_edit_full($lesson, $singlepage->id, $singlepage->prevpageid, true);
            break;
        case 'full':
            echo $lessonoutput->display_edit_full($lesson, $lesson->firstpageid, 0);
            break;
    }
}

echo $lessonoutput->footer();
