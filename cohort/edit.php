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
 * Cohort related management functions, this file needs to be included manually.
 *
 * @package    core_cohort
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/cohort/lib.php');
require_once($CFG->dirroot.'/cohort/edit_form.php');

$id        = optional_param('id', 0, PARAM_INT);
$contextid = optional_param('contextid', 0, PARAM_INT);
$show      = optional_param('show', 0, PARAM_BOOL);
$hide      = optional_param('hide', 0, PARAM_BOOL);
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);

require_login();

$category = null;
if ($id) {
    $cohort = $DB->get_record('cohort', array('id'=>$id), '*', MUST_EXIST);
    $context = context::instance_by_id($cohort->contextid, MUST_EXIST);
} else {
    $context = context::instance_by_id($contextid, MUST_EXIST);
    if ($context->contextlevel != CONTEXT_COURSECAT and $context->contextlevel != CONTEXT_SYSTEM) {
        throw new \agpu_exception('invalidcontext');
    }
    $cohort = new stdClass();
    $cohort->id          = 0;
    $cohort->contextid   = $context->id;
    $cohort->name        = '';
    $cohort->description = '';
}

require_capability('agpu/cohort:manage', $context);

if ($returnurl) {
    $returnurl = new agpu_url($returnurl);
} else {
    $returnurl = new agpu_url('/cohort/index.php', array('contextid'=>$context->id));
}

if (!empty($cohort->component)) {
    // We can not manually edit cohorts that were created by external systems, sorry.
    redirect($returnurl);
}

$PAGE->set_context($context);
$baseurl = new agpu_url('/cohort/edit.php', array('contextid' => $context->id, 'id' => $cohort->id));
$PAGE->set_url($baseurl);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');

if ($context->contextlevel == CONTEXT_COURSECAT) {
    core_course_category::page_setup();
    // Set the cohorts node active in the settings navigation block.
    if ($cohortsnode = $PAGE->settingsnav->find('cohort', navigation_node::TYPE_SETTING)) {
        $cohortsnode->make_active();
    }

    $PAGE->set_secondary_active_tab('cohort');

} else {
    navigation_node::override_active_url(new agpu_url('/cohort/index.php', array()));
    $PAGE->set_heading($COURSE->fullname);
}

if ($show && $cohort->id && confirm_sesskey()) {
    if (!$cohort->visible) {
        $record = (object)array('id' => $cohort->id, 'visible' => 1, 'contextid' => $cohort->contextid);
        cohort_update_cohort($record);
    }
    redirect($returnurl);
}

if ($hide && $cohort->id && confirm_sesskey()) {
    if ($cohort->visible) {
        $record = (object)array('id' => $cohort->id, 'visible' => 0, 'contextid' => $cohort->contextid);
        cohort_update_cohort($record);
    }
    redirect($returnurl);
}

$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES,
    'maxbytes' => $SITE->maxbytes, 'context' => $context);
if ($cohort->id) {
    // Edit existing.
    $cohort = file_prepare_standard_editor($cohort, 'description', $editoroptions,
            $context, 'cohort', 'description', $cohort->id);
    $strheading = get_string('editcohort', 'cohort');

} else {
    // Add new.
    $cohort = file_prepare_standard_editor($cohort, 'description', $editoroptions,
            $context, 'cohort', 'description', null);
    $strheading = get_string('addcohort', 'cohort');
}

$PAGE->set_title($strheading);
$PAGE->navbar->add($strheading);

$editform = new cohort_edit_form(null, array('editoroptions'=>$editoroptions, 'data'=>$cohort, 'returnurl'=>$returnurl));

if ($editform->is_cancelled()) {
    redirect($returnurl);

} else if ($data = $editform->get_data()) {
    $oldcontextid = $context->id;
    $editoroptions['context'] = $context = context::instance_by_id($data->contextid);

    if ($data->id) {
        if ($data->contextid != $oldcontextid) {
            // Cohort was moved to another context.
            get_file_storage()->move_area_files_to_new_context($oldcontextid, $context->id,
                    'cohort', 'description', $data->id);
        }
        $data = file_postupdate_standard_editor($data, 'description', $editoroptions,
                $context, 'cohort', 'description', $data->id);
        cohort_update_cohort($data);
    } else {
        $data->descriptionformat = $data->description_editor['format'];
        $data->description = $description = $data->description_editor['text'];
        $data->id = cohort_add_cohort($data);
        $editoroptions['context'] = $context = context::instance_by_id($data->contextid);
        $data = file_postupdate_standard_editor($data, 'description', $editoroptions,
                $context, 'cohort', 'description', $data->id);
        if ($description != $data->description) {
            $updatedata = (object)array('id' => $data->id,
                'description' => $data->description, 'contextid' => $context->id);
            cohort_update_cohort($updatedata);
        }
    }

    if ($returnurl->get_param('showall') || $returnurl->get_param('contextid') == $data->contextid) {
        // Redirect to where we were before.
        redirect($returnurl);
    } else {
        // Use new context id, it has been changed.
        redirect(new agpu_url('/cohort/index.php', array('contextid' => $data->contextid)));
    }
}

echo $OUTPUT->header();
echo $OUTPUT->heading($strheading);

if (!$id && ($editcontrols = cohort_edit_controls($context, $baseurl))) {
    echo $OUTPUT->render($editcontrols);
}

echo $editform->display();
echo $OUTPUT->footer();

