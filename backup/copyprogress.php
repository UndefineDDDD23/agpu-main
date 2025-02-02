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
 * This script is used to configure and execute the course copy proccess.
 *
 * @package    core_backup
 * @copyright  2020 onward The agpu Users Association <https://agpuassociation.org/>
 * @author     Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

defined('agpu_INTERNAL') || die();

$courseid = required_param('id', PARAM_INT);

$url = new agpu_url('/backup/copyprogress.php', array('id' => $courseid));
$course = get_course($courseid);
$coursecontext = context_course::instance($course->id);

// Security and access checks.
require_login($course, false);
$copycaps = \core_course\management\helper::get_course_copy_capabilities();
require_all_capabilities($copycaps, $coursecontext);

// Setup the page.
$title = get_string('copyprogresstitle', 'backup');
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($title);
$PAGE->set_heading($course->fullname);
$PAGE->set_secondary_active_tab('coursereuse');
$PAGE->requires->js_call_amd('core_backup/async_backup', 'asyncCopyAllStatus');
$PAGE->secondarynav->set_overflow_selected_node('copy');

// Build the page output.
echo $OUTPUT->header();
\backup_helper::print_coursereuse_selector('copycourse');

echo $OUTPUT->heading_with_help(get_string('copyprogressheading', 'backup'), 'copyprogressheading', 'backup');
echo $OUTPUT->container_start();
$renderer = $PAGE->get_renderer('core', 'backup');
echo $renderer->copy_progress_viewer($USER->id, $courseid);
echo $OUTPUT->container_end();

echo $OUTPUT->footer();
