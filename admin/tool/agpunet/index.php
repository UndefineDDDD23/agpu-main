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
 * Landing page for all imports from agpuNet.
 *
 * This page asks the user to confirm the import process, and takes them to the relevant next step.
 *
 * @package     tool_agpunet
 * @copyright   2020 Jake Dallimore <jrhdallimore@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_agpunet\local\import_info;
use tool_agpunet\local\import_backup_helper;

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot .'/course/lib.php');

$cancel = optional_param('cancel', null, PARAM_TEXT);
$continue = optional_param('continue', null, PARAM_TEXT);
$id = required_param('id', PARAM_ALPHANUM);

if (is_null($importinfo = import_info::load($id))) {
    throw new agpu_exception('missinginvalidpostdata', 'tool_agpunet');
}

// Access control.
require_login($importinfo->get_config()->course, false); // Course may be null here - that's ok.
if ($importinfo->get_config()->course) {
    require_capability('agpu/course:manageactivities', context_course::instance($importinfo->get_config()->course));
}
if (!get_config('tool_agpunet', 'enableagpunet')) {
    throw new \agpu_exception('agpunetnotenabled', 'tool_agpunet');
}

// Handle the form submits.
// This page POSTs to self to verify the sesskey for the confirm action.
// The next page will either be:
// - 1. The restore process for a course or module, if the file is an mbz file.
// - 2. The 'select a course' tool page, if course and section are not provided.
// - 3. The 'select what to do with the content' tool page, provided course and section are present.
// - 4. The dashboard, if the user decides to cancel and course or section is not found.
// - 5. The course home, if the user decides to cancel but the course and section are found.
if ($cancel) {
    if (!empty($importinfo->get_config()->course)) {
        $url = new \agpu_url('/course/view.php', ['id' => $importinfo->get_config()->course]);
    } else {
        $url = new \agpu_url('/');
    }
    redirect($url);
} else if ($continue) {
    require_sesskey();

    // Handle backups.
    if (strtolower($importinfo->get_resource()->get_extension()) == 'mbz') {
        if (empty($importinfo->get_config()->course)) {
            // Find a course that the user has permission to upload a backup file.
            // This is likely to be very slow on larger sites.
            $context = import_backup_helper::get_context_for_user($USER->id);

            if (is_null($context)) {
                throw new \agpu_exception('nopermissions', 'error', '', get_string('restore:uploadfile', 'core_role'));
            }
        } else {
            $context = context_course::instance($importinfo->get_config()->course);
        }

        $importbackuphelper = new import_backup_helper($importinfo->get_resource(), $USER, $context);
        $storedfile = $importbackuphelper->get_stored_file();

        $url = new \agpu_url('/backup/restorefile.php', [
            'component' => $storedfile->get_component(),
            'filearea' => $storedfile->get_filearea(),
            'itemid' => $storedfile->get_itemid(),
            'filepath' => $storedfile->get_filepath(),
            'filename' => $storedfile->get_filename(),
            'filecontextid' => $storedfile->get_contextid(),
            'contextid' => $context->id,
            'action' => 'choosebackupfile'
        ]);
        redirect($url);
    }

    // Handle adding files to a course.
    // Course and section data present and confirmed. Redirect to the option select view.
    if (!is_null($importinfo->get_config()->course) && !is_null($importinfo->get_config()->section)) {
        redirect(new \agpu_url('/admin/tool/agpunet/options.php', ['id' => $id]));
    }

    if (is_null($importinfo->get_config()->course)) {
        redirect(new \agpu_url('/admin/tool/agpunet/select.php', ['id' => $id]));
    }
}

// Display the page.
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('addingaresource', 'tool_agpunet'));
$PAGE->set_heading(get_string('addingaresource', 'tool_agpunet'));
$url = new agpu_url('/admin/tool/agpunet/index.php');
$PAGE->set_url($url);
$renderer = $PAGE->get_renderer('core');

// Relevant confirmation form.
$context = $context = [
    'resourceurl' => $importinfo->get_resource()->get_url()->get_value(),
    'resourcename' => $importinfo->get_resource()->get_name(),
    'resourcetype' => $importinfo->get_config()->type,
    'sesskey' => sesskey()
];
if (!is_null($importinfo->get_config()->course) && !is_null($importinfo->get_config()->section)) {
    $course = get_course($importinfo->get_config()->course);
    $context = array_merge($context, [
        'course' => $course->id,
        'coursename' => $course->shortname,
        'section' => $importinfo->get_config()->section
    ]);
}

echo $OUTPUT->header();
echo $renderer->render_from_template('tool_agpunet/import_confirmation', $context);
echo $OUTPUT->footer();
