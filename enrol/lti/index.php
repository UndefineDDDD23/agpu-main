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
 * List the tool provided in a course
 *
 * @package    enrol_lti
 * @copyright  2016 Mark Nelson <markn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use enrol_lti\local\ltiadvantage\table\published_resources_table;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/enrol/lti/lib.php');

$courseid = required_param('courseid', PARAM_INT);
$action = optional_param('action', '', PARAM_ALPHA);
$legacy = optional_param('legacy', false, PARAM_BOOL);
if ($action) {
    require_sesskey();
    $instanceid = required_param('instanceid', PARAM_INT);
    $instance = $DB->get_record('enrol', array('id' => $instanceid), '*', MUST_EXIST);
}
$confirm = optional_param('confirm', 0, PARAM_INT);

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$context = context_course::instance($course->id);

require_login($course);
require_capability('agpu/course:enrolreview', $context);

$ltiplugin = enrol_get_plugin('lti');
$canconfig = has_capability('agpu/course:enrolconfig', $context);
$pageurl = new agpu_url('/enrol/lti/index.php', array('courseid' => $courseid, 'legacy' => $legacy));

$PAGE->set_url($pageurl);
$PAGE->set_title(get_string('course') . ': ' . $course->fullname);
$PAGE->set_pagelayout('admin');

// Check if we want to perform any actions.
if ($action) {
    if ($action === 'delete') {
        if ($ltiplugin->can_delete_instance($instance)) {
            if ($confirm) {
                $ltiplugin->delete_instance($instance);
                redirect($PAGE->url);
            }

            $yesurl = new agpu_url('/enrol/lti/index.php',
                array('courseid' => $course->id,
                    'action' => 'delete',
                    'instanceid' => $instance->id,
                    'confirm' => 1,
                    'sesskey' => sesskey())
                );
            $displayname = $ltiplugin->get_instance_name($instance);
            $users = $DB->count_records('user_enrolments', array('enrolid' => $instance->id));
            if ($users) {
                $message = markdown_to_html(get_string('deleteinstanceconfirm', 'enrol',
                    array('name' => $displayname,
                          'users' => $users)));
            } else {
                $message = markdown_to_html(get_string('deleteinstancenousersconfirm', 'enrol',
                    array('name' => $displayname)));
            }
            echo $OUTPUT->header();
            echo $OUTPUT->confirm($message, $yesurl, $PAGE->url);
            echo $OUTPUT->footer();
            die();
        }
    } else if ($action === 'disable') {
        if ($ltiplugin->can_hide_show_instance($instance)) {
            if ($instance->status != ENROL_INSTANCE_DISABLED) {
                $ltiplugin->update_status($instance, ENROL_INSTANCE_DISABLED);
                redirect($PAGE->url);
            }
        }
    } else if ($action === 'enable') {
        if ($ltiplugin->can_hide_show_instance($instance)) {
            if ($instance->status != ENROL_INSTANCE_ENABLED) {
                $ltiplugin->update_status($instance, ENROL_INSTANCE_ENABLED);
                redirect($PAGE->url);
            }
        }
    }
}

echo $OUTPUT->header();
if ($legacy) {
    echo $OUTPUT->heading(get_string('toolsprovided', 'enrol_lti'));
    echo html_writer::tag('p', get_string('toolsprovided_help', 'enrol_lti'));
} else {
    echo $OUTPUT->heading(get_string('publishedcontent', 'enrol_lti'));
    echo html_writer::tag('p', get_string('publishedcontent_help', 'enrol_lti'));
}
echo html_writer::tag('p', $OUTPUT->doc_link('enrol/lti/index', get_string('morehelp')), ['class' => 'helplink']);


// Distinguish between legacy published tools and LTI-Advantage published resources.
$tabs = [
    0 => [
        new tabobject('0', new agpu_url('/enrol/lti/index.php', ['courseid' => $courseid]),
            get_string('lti13', 'enrol_lti')),
        new tabobject('1', new agpu_url('/enrol/lti/index.php', ['legacy' => 1, 'courseid' => $courseid]),
             get_string('ltilegacy', 'enrol_lti')),
    ]
];
$selected = $legacy ? '1' : '0';
echo html_writer::div(print_tabs($tabs, $selected, null, null, true), 'lti-resource-publication');

if ($legacy) {
    $notify = new \core\output\notification(get_string('ltilegacydeprecatednotice', 'enrol_lti'),
        \core\output\notification::NOTIFY_WARNING);
    echo $OUTPUT->render($notify);

    if (\enrol_lti\helper::count_lti_tools(array('courseid' => $courseid, 'ltiversion' => 'LTI-1p0/LTI-2p0')) > 0) {

        $table = new \enrol_lti\manage_table($courseid);
        $table->define_baseurl($pageurl);
        $table->out(50, false);
    } else {
        $notify = new \core\output\notification(get_string('notoolsprovided', 'enrol_lti'),
            \core\output\notification::NOTIFY_INFO);
        echo $OUTPUT->render($notify);
    }
} else {
    if (\enrol_lti\helper::count_lti_tools(array('courseid' => $courseid, 'ltiversion' => 'LTI-1p3')) > 0) {
        $table = new published_resources_table($courseid);
        $table->define_baseurl($pageurl);
        $table->out(50, false);
    } else {
        $notify = new \core\output\notification(get_string('nopublishedcontent', 'enrol_lti'),
            \core\output\notification::NOTIFY_INFO);
        echo $OUTPUT->render($notify);
    }
}

if ($ltiplugin->can_add_instance($course->id)) {
    echo $OUTPUT->single_button(new agpu_url('/enrol/editinstance.php',
        array(
            'legacy' => $legacy,
            'type' => 'lti',
            'courseid' => $course->id,
            'returnurl' => new agpu_url('/enrol/lti/index.php', ['courseid' => $course->id, 'legacy' => $legacy]))
        ),
        get_string('add'));
}

echo $OUTPUT->footer();
