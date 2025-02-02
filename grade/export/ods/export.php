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

require_once '../../../config.php';
require_once $CFG->dirroot.'/grade/export/lib.php';
require_once 'grade_export_ods.php';

$id                = required_param('id', PARAM_INT); // course id
$PAGE->set_url('/grade/export/ods/export.php', array('id'=>$id));

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    throw new \agpu_exception('invalidcourseid');
}

require_login($course);
$context = context_course::instance($id);
$groupid = groups_get_course_group($course, true);

require_capability('agpu/grade:export', $context);
require_capability('gradeexport/ods:view', $context);

// We need to call this method here before any output otherwise the menu won't display.
// If you use this method without this check, will break the direct grade exporting (without publishing).
$key = optional_param('key', '', PARAM_RAW);
if (!empty($CFG->gradepublishing) && !empty($key)) {
    $actionbar = new \core_grades\output\export_publish_action_bar($context, 'ods');
    print_grade_page_head($COURSE->id, 'export', 'ods',
        get_string('exportto', 'grades') . ' ' . get_string('pluginname', 'gradeexport_ods'),
        false, false, true, null, null, null, $actionbar);
}

if (groups_get_course_groupmode($COURSE) == SEPARATEGROUPS and !has_capability('agpu/site:accessallgroups', $context)) {
    if (!groups_is_member($groupid, $USER->id)) {
        throw new \agpu_exception('cannotaccessgroup', 'grades');
    }
}
$mform = new grade_export_form(null, array('publishing' => true, 'simpleui' => true, 'multipledisplaytypes' => true));
$data = $mform->get_data();
$export = new grade_export_ods($course, $groupid, $data);

// If the gradepublishing is enabled and user key is selected print the grade publishing link.
if (!empty($CFG->gradepublishing) && !empty($key)) {
    groups_print_course_menu($course, 'index.php?id='.$id);
    echo $export->get_grade_publishing_url();
    echo $OUTPUT->footer();
} else {
    $event = \gradeexport_ods\event\grade_exported::create(array('context' => $context));
    $event->trigger();
    $export->print_grades();
}
