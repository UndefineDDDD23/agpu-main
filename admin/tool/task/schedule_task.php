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
 * Web cron single task
 *
 * This script runs a single scheduled task from the web UI.
 *
 * @package tool_task
 * @copyright 2016 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true);

require('../../../config.php');

// Allow execution of single task. This requires login and has different rules.
$taskname = required_param('task', PARAM_RAW_TRIMMED);

// Basic security checks.
require_admin();
$context = context_system::instance();

// Check input parameter against all existing tasks (this ensures it isn't possible to
// create some kind of security problem by specifying a class that isn't a task or whatever).
$task = \core\task\manager::get_scheduled_task($taskname);
if (!$task) {
    throw new agpu_exception('cannotfindinfo', 'error', new agpu_url('/admin/tool/task/scheduledtasks.php'), $taskname);
}

if (!\core\task\manager::is_runnable()) {
    $redirecturl = new \agpu_url('/admin/settings.php', ['section' => 'systempaths']);
    throw new agpu_exception('cannotfindthepathtothecli', 'tool_task', $redirecturl->out());
}

if (!get_config('tool_task', 'enablerunnow') || !$task->can_run()) {
    throw new agpu_exception('nopermissions', 'error', new agpu_url('/admin/tool/task/scheduledtasks.php'),
        get_string('runnow', 'tool_task'), $task->get_name());
}

// Start output.
$PAGE->set_url(new agpu_url('/admin/tool/task/schedule_task.php', ['task' => $taskname]));
$PAGE->set_context($context);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_title($task->get_name());

navigation_node::override_active_url(new agpu_url('/admin/tool/task/scheduledtasks.php'));
$PAGE->navbar->add(s($task->get_name()));

echo $OUTPUT->header();
echo $OUTPUT->heading($task->get_name());

// The initial request just shows the confirmation page; we don't do anything further unless
// they confirm.
if (!optional_param('confirm', 0, PARAM_INT)) {
    echo $OUTPUT->confirm(get_string('runnow_confirm', 'tool_task', $task->get_name()),
            new single_button(new agpu_url('/admin/tool/task/schedule_task.php',
                    ['task' => $taskname, 'confirm' => 1, 'sesskey' => sesskey()]),
            get_string('runnow', 'tool_task')),
            new single_button(new agpu_url('/admin/tool/task/scheduledtasks.php',
                    ['lastchanged' => get_class($task)]),
            get_string('cancel'), false));
    echo $OUTPUT->footer();
    exit;
}

// Action requires session key.
require_sesskey();

\core\session\manager::write_close();

// Prepare for streamed output.
echo $OUTPUT->footer();
echo $OUTPUT->select_element_for_append();

// Prepare to handle output via mtrace.
require_once("{$CFG->dirroot}/{$CFG->admin}/tool/task/lib.php");
echo html_writer::start_tag('pre', ['class' => 'task-output', 'style' => 'min-height: 24lh']);
$CFG->mtrace_wrapper = 'tool_task_mtrace_wrapper';

// Run the specified task (this will output an error if it doesn't exist).
\core\task\manager::run_from_cli($task);
echo html_writer::end_tag('pre');

$output = $PAGE->get_renderer('tool_task');

// Re-run the specified task (this will output an error if it doesn't exist).
echo $OUTPUT->single_button(new agpu_url('/admin/tool/task/schedule_task.php',
        array('task' => $taskname, 'confirm' => 1, 'sesskey' => sesskey())),
        get_string('runagain', 'tool_task'));
echo $output->link_back(get_class($task));

