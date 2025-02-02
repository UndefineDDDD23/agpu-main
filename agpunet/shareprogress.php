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
 * View the progress of agpuNet shares.
 *
 * @package   core
 * @copyright 2023 David Woloszyn <david.woloszyn@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\agpunet\utilities;

require_once('../config.php');

require_login();
if (isguestuser()) {
    throw new \agpu_exception('noguest');
}

// Capability was not found.
if (utilities::does_user_have_capability_in_any_course($USER->id) === 'no') {
    throw new \agpu_exception('nocapabilitytousethisservice');
}

$pageurl = $CFG->wwwroot . '/agpunet/shareprogress.php';
$PAGE->set_url($pageurl);
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('agpunet:shareprogress'));
$PAGE->set_heading(get_string('agpunet:shareprogress'));
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

// Intro paragraph.
echo html_writer::div(get_string('agpunet:shareprogressinfo'), 'mb-4');

// Build table.
$table = new core\agpunet\share_progress_table('agpunet-share-progress', $pageurl, $USER->id);
$perpage = $table->get_default_per_page();
$table->out($perpage, true);

echo $OUTPUT->footer();
