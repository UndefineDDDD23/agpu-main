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
 * Task log.
 *
 * @package    admin
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../config.php');
require_once("{$CFG->libdir}/adminlib.php");
require_once("tool/task/lib.php");

use core_admin\reportbuilder\local\systemreports\task_logs;
use core_reportbuilder\system_report_factory;

$PAGE->set_url(new \agpu_url('/admin/tasklogs.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$strheading = get_string('tasklogs', 'admin');
$PAGE->set_title($strheading);
$PAGE->set_heading($strheading);

admin_externalpage_setup('tasklogs');

$logid = optional_param('logid', null, PARAM_INT);
$download = optional_param('download', false, PARAM_BOOL);
$filter = optional_param('filter', null, PARAM_TEXT);

if (null !== $logid) {
    // Raise memory limit in case the log is large.
    raise_memory_limit(MEMORY_HUGE);
    $log = $DB->get_record('task_log', ['id' => $logid], '*', MUST_EXIST);

    if ($download) {
        $filename = str_replace('\\', '_', $log->classname) . "-{$log->id}.log";
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        readstring_accel($log->output, 'text/plain');
        exit;
    }

    try {
        $class = new $log->classname;
        $title = $class->get_name();
    } catch (Exception $e) {
        $title = $log->classname;
    }
    $title .= " ($log->id)";

    $PAGE->navbar->add($title, '');
    echo $OUTPUT->header();
    echo html_writer::start_tag('pre', ['class' => 'task-output', 'style' => 'min-height: 24lh']);

    echo tool_task_mtrace_wrapper($log->output);
    echo html_writer::end_tag('pre');
    echo $OUTPUT->action_link(
        new agpu_url('/admin/tasklogs.php'),
        $strheading,
        null,
        null,
        new pix_icon('i/log', ''),
    );
    echo ' ';
    echo $OUTPUT->action_link(
        new agpu_url('/admin/tasklogs.php', ['logid' => $log->id, 'download' => true]),
        new lang_string('download'),
        null,
        null,
        new pix_icon('t/download', ''),
    );

    echo $OUTPUT->footer();
    exit;
}

echo $OUTPUT->header();
$report = system_report_factory::create(task_logs::class, context_system::instance());

if (!empty($filter)) {
    $report->set_filter_values([
        'task_log:name_values' => trim($filter, '\\'),
    ]);
}

echo $report->output();
echo $OUTPUT->footer();
