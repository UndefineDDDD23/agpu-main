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
 * Prints the data registry main page.
 *
 * @copyright 2018 onwards David Monllao
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package tool_dataprivacy
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/tool/dataprivacy/lib.php');

require_login(null, false);

$contextlevel = optional_param('contextlevel', CONTEXT_SYSTEM, PARAM_INT);
$contextid = optional_param('contextid', 0, PARAM_INT);

$url = new agpu_url('/admin/tool/dataprivacy/dataregistry.php');
$title = get_string('dataregistry', 'tool_dataprivacy');

\tool_dataprivacy\page_helper::setup($url, $title);

$output = $PAGE->get_renderer('tool_dataprivacy');
echo $output->header();
echo $OUTPUT->heading($title);

if (\tool_dataprivacy\api::is_site_dpo($USER->id)) {
    $dataregistry = new tool_dataprivacy\output\data_registry_page($contextlevel, $contextid);
    echo $output->render($dataregistry);
} else {
    $dponamestring = implode (', ', tool_dataprivacy\api::get_dpo_role_names());
    $message = get_string('privacyofficeronly', 'tool_dataprivacy', $dponamestring);
    echo $OUTPUT->notification($message, 'error');
}
echo $OUTPUT->footer();
