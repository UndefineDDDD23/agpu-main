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
 * This file contains the version information for the comments feedback plugin
 *
 * @package assignfeedback_editpdf
 * @copyright  2012 Davo Smith
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/assign/locallib.php');

/**
 * Serves assignment feedback and other files.
 *
 * @param mixed $course course or id of the course
 * @param mixed $cm course module or id of the course module
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options - List of options affecting file serving.
 * @return bool false if file not found, does not return if found - just send the file
 */
function assignfeedback_editpdf_pluginfile(
    $course,
    $cm,
    context $context,
    $filearea,
    $args,
    $forcedownload,
    array $options = array()
) {
    global $DB;
    if ($filearea === 'systemstamps') {

        if ($context->contextlevel !== CONTEXT_SYSTEM) {
            return false;
        }

        $filename = array_pop($args);
        $filepath = '/' . implode('/', $args) . '/';

        $fs = get_file_storage();
        $file = $fs->get_file($context->id, 'assignfeedback_editpdf', $filearea, 0, $filepath, $filename);
        if (!$file) {
            return false;
        }

        $options['cacheability'] = 'public';
        $options['immutable'] = true;

        send_stored_file($file, null, 0, false, $options);
    }

    if ($context->contextlevel == CONTEXT_MODULE) {

        require_login($course, false, $cm);
        $itemid = (int)array_shift($args);

        $assign = new assign($context, $cm, $course);

        $record = $DB->get_record('assign_grades', array('id' => $itemid), 'userid,assignment', MUST_EXIST);
        $userid = $record->userid;
        if ($assign->get_instance()->id != $record->assignment) {
            return false;
        }

        // Rely on mod_assign checking permissions.
        if (!$assign->can_view_submission($userid)) {
            return false;
        }

        $relativepath = implode('/', $args);

        $fullpath = "/{$context->id}/assignfeedback_editpdf/$filearea/$itemid/$relativepath";

        $fs = get_file_storage();
        if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
            return false;
        }
        // Download MUST be forced - security!
        send_stored_file($file, 0, 0, true, $options);// Check if we want to retrieve the stamps.
    }

}

/**
 * Files API hook to remove stale conversion records.
 *
 * When a file is update, its contenthash will change, but its ID
 * remains the same. The document converter API records source file
 * IDs and destination file IDs. When a file is updated, the document
 * converter API has no way of knowing that the content of the file
 * has changed, so it just serves the previously stored destination
 * file.
 *
 * In this hook we check if the contenthash has changed, and if it has
 * we delete the existing conversion so that a new one will be created.
 *
 * @param stdClass $file The updated file record.
 * @param stdClass $filepreupdate The file record pre-update.
 */
function assignfeedback_editpdf_after_file_updated(stdClass $file, stdClass $filepreupdate) {
    $contenthashchanged = $file->contenthash !== $filepreupdate->contenthash;
    if ($contenthashchanged && $file->component == 'assignsubmission_file' && $file->filearea == 'submission_files') {
        $fs = get_file_storage();
        $file = $fs->get_file_by_id($file->id);
        $conversions = \core_files\conversion::get_conversions_for_file($file, 'pdf');

        foreach ($conversions as $conversion) {
            if ($conversion->get('id')) {
                $conversion->delete();
            }
        }
    }
}
