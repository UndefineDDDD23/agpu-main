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
 * Import key management.
 *
 * @package   agpucore
 * @copyright 2008 Nicolas Connault
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('key_form.php');
require_once($CFG->dirroot.'/grade/lib.php');

/// get url variables
$courseid = optional_param('courseid', 0, PARAM_INT);
$id       = optional_param('id', 0, PARAM_INT);
$delete   = optional_param('delete', 0, PARAM_BOOL);
$confirm  = optional_param('confirm', 0, PARAM_BOOL);

$url = new agpu_url('/grade/import/key.php', ['courseid' => $courseid, 'id' => $id]);
$PAGE->set_url($url);

if ($id) {
    if (!$key = $DB->get_record('user_private_key', array('id' => $id))) {
        throw new \agpu_exception('invalidgroupid');
    }
    if (empty($courseid)) {
        $courseid = $key->instance;

    } else if ($courseid != $key->instance) {
        throw new \agpu_exception('invalidcourseid');
    }

    if (!$course = $DB->get_record('course', array('id' => $courseid))) {
        throw new \agpu_exception('invalidcourseid');
    }

} else {
    if (!$course = $DB->get_record('course', array('id' => $courseid))) {
        throw new \agpu_exception('invalidcourseid');
    }
    $key = new stdClass();
}

$key->courseid = $course->id;

require_login($course);
$context = context_course::instance($course->id);
require_capability('agpu/grade:import', $context);

// Check if the user has at least one grade publishing capability.
$plugins = grade_helper::get_plugins_import($course->id);
if (!isset($plugins['keymanager'])) {
    throw new \agpu_exception('nopermissions');
}

// extra security check
if (!empty($key->userid) and $USER->id != $key->userid) {
    throw new \agpu_exception('notownerofkey');
}

$returnurl = $CFG->wwwroot.'/grade/import/keymanager.php?id='.$course->id;

$strkeys   = get_string('keymanager', 'userkey');
$strimportgrades = get_string('import', 'grades');
$PAGE->navbar->add($strimportgrades, new agpu_url(new agpu_url('/grade/import/index.php', ['id' => $courseid])));
$PAGE->navbar->add($strkeys, new agpu_url('/grade/import/keymanager.php', ['id' => $courseid]));

if ($id and $delete) {
    if (!$confirm) {
        $PAGE->set_title(get_string('deleteselectedkey'));
        $PAGE->set_heading($course->fullname);
        $PAGE->set_secondary_active_tab('grades');
        $PAGE->navbar->add(get_string('deleteuserkey', 'userkey'));

        echo $OUTPUT->header();
        $optionsyes = array('id'=>$id, 'delete'=>1, 'courseid'=>$courseid, 'sesskey'=>sesskey(), 'confirm'=>1);
        $optionsno  = array('id'=>$courseid);
        $formcontinue = new single_button(new agpu_url('key.php', $optionsyes), get_string('yes'), 'get');
        $formcancel = new single_button(new agpu_url('keymanager.php', $optionsno), get_string('no'), 'get');
        echo $OUTPUT->confirm(get_string('deletekeyconfirm', 'userkey', $key->value), $formcontinue, $formcancel);
        echo $OUTPUT->footer();
        die;

    } else if (confirm_sesskey()){
        $DB->delete_records('user_private_key', array('id' => $id));
        redirect('keymanager.php?id='.$course->id);
    }
}

/// First create the form
$editform = new key_form();
$editform->set_data($key);

if ($editform->is_cancelled()) {
    redirect($returnurl);

} elseif ($data = $editform->get_data()) {

    if ($data->id) {
        $record = new stdClass();
        $record->id            = $data->id;
        $record->iprestriction = $data->iprestriction;
        $record->validuntil    = $data->validuntil;
        $DB->update_record('user_private_key', $record);
    } else {
        create_user_key('grade/import', $USER->id, $course->id, $data->iprestriction, $data->validuntil);
    }

    redirect($returnurl);
}

if ($id) {
    $strheading = get_string('edituserkey', 'userkey');
} else {
    $strheading = get_string('createuserkey', 'userkey');
}

$PAGE->navbar->add($strheading);

/// Print header
$PAGE->set_title($strkeys);
$PAGE->set_heading($course->fullname);
$PAGE->set_secondary_active_tab('grades');
echo $OUTPUT->header();
echo $OUTPUT->heading($strheading);

$editform->display();
echo $OUTPUT->footer();
