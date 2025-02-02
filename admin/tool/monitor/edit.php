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
 * This file gives an overview of the monitors present in site.
 *
 * @package    tool_monitor
 * @copyright  2014 onwards Simey Lameze <simey@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

$ruleid = optional_param('ruleid', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);

// Validate course id.
if (empty($courseid)) {
    require_login(null, false);
    $context = context_system::instance();
    $coursename = format_string($SITE->fullname, true, array('context' => $context));
    $PAGE->set_context($context);
    $PAGE->set_primary_active_tab('siteadminnode');
    $PAGE->set_secondary_active_tab('reports');
} else {
    $course = get_course($courseid);
    require_login($course);
    $context = context_course::instance($course->id);
    $coursename = format_string($course->fullname, true, array('context' => $context));
}

// Check for caps.
require_capability('tool/monitor:managerules', $context);

// Set up the page.
$url = new agpu_url("/admin/tool/monitor/edit.php", array('courseid' => $courseid, 'ruleid' => $ruleid));
$manageurl = new agpu_url("/admin/tool/monitor/managerules.php", array('courseid' => $courseid));
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title($coursename);
$PAGE->set_heading($coursename);

// Get data ready for mform.
$eventlist = tool_monitor\eventlist::get_all_eventlist(true);
$pluginlist = tool_monitor\eventlist::get_plugin_list();

// Site level report.
if (empty($courseid)) {
    admin_externalpage_setup('toolmonitorrules', '', null, '', array('pagelayout' => 'report'));
} else {
    // Course level report.
    $PAGE->navigation->override_active_url($manageurl);
}

// Mform setup.
if (!empty($ruleid)) {
    $PAGE->navbar->add(get_string('editrule', 'tool_monitor'), $PAGE->url);
    $rule = \tool_monitor\rule_manager::get_rule($ruleid)->get_mform_set_data();
    $rule->minutes = $rule->timewindow / MINSECS;
    $subscriptioncount = \tool_monitor\subscription_manager::count_rule_subscriptions($ruleid);

    // Filter out events which cannot be triggered for some reason.
    $eventlist = array_filter($eventlist, function($classname) use ($rule) {
        // Filter out all deprecated events, except for the current one.
        return $classname === $rule->eventname || !$classname::is_deprecated();
    }, ARRAY_FILTER_USE_KEY);
} else {
    $PAGE->navbar->add(get_string('addrule', 'tool_monitor'), $PAGE->url);
    $rule = new stdClass();
    $subscriptioncount = 0;

    // Filter out events which cannot be triggered for some reason.
    $eventlist = array_filter($eventlist, function($classname) {
        return !$classname::is_deprecated();
    }, ARRAY_FILTER_USE_KEY);
}

// Modify the lists to add the choosers.
$eventlist = array_merge(array('' => get_string('choosedots')), $eventlist);
$pluginlist = array_merge(['' => [0 => get_string('choosedots')]], $pluginlist);
$mform = new tool_monitor\rule_form(null, array('eventlist' => $eventlist, 'pluginlist' => $pluginlist, 'rule' => $rule,
        'courseid' => $courseid, 'subscriptioncount' => $subscriptioncount));

if ($mform->is_cancelled()) {
    redirect(new agpu_url('/admin/tool/monitor/managerules.php', array('courseid' => $courseid)));
    exit();
}

if ($mformdata = $mform->get_data()) {
    $rule = \tool_monitor\rule_manager::clean_ruledata_form($mformdata);

    if (empty($rule->id)) {
        \tool_monitor\rule_manager::add_rule($rule);
    } else {
        \tool_monitor\rule_manager::update_rule($rule);
    }

    redirect($manageurl);
} else {
    echo $OUTPUT->header();
    $mform->set_data($rule);
    // If there's any subscription for this rule, display an information message.
    if ($subscriptioncount > 0) {
        echo $OUTPUT->notification(get_string('disablefieldswarning', 'tool_monitor'), 'notifyproblem');
    }
    $mform->display();
    echo $OUTPUT->footer();
    exit;
}

echo $OUTPUT->header();
if (!empty($ruleid)) {
    echo $OUTPUT->heading(get_string('editrule', 'tool_monitor'));
} else {
    echo $OUTPUT->heading(get_string('addrule', 'tool_monitor'));
}
$mform->set_data($rule);
$mform->display();
echo $OUTPUT->footer();
