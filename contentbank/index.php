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
 * List content in content bank.
 *
 * @package    core_contentbank
 * @copyright  2020 Amaia Anabitarte <amaia@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');

require_login();

$contextid    = optional_param('contextid', \context_system::instance()->id, PARAM_INT);
$search = optional_param('search', '', PARAM_CLEAN);
$context = context::instance_by_id($contextid, MUST_EXIST);

$cb = new \core_contentbank\contentbank();
if (!$cb->is_context_allowed($context)) {
    throw new \agpu_exception('contextnotallowed', 'core_contentbank');
}

require_capability('agpu/contentbank:access', $context);

// If notifications had been sent we don't pay attention to message parameter.
if (empty($SESSION->notifications)) {
    $statusmsg = optional_param('statusmsg', '', PARAM_ALPHANUMEXT);
    $errormsg = optional_param('errormsg', '', PARAM_ALPHANUMEXT);
}

$title = get_string('contentbank');
\core_contentbank\helper::get_page_ready($context, $title);
if ($PAGE->course) {
    require_login($PAGE->course->id);
}
$PAGE->set_url('/contentbank/index.php', ['contextid' => $contextid]);
if ($contextid == \context_system::instance()->id) {
    $PAGE->set_context(context_course::instance($contextid));
} else {
    $PAGE->set_context($context);
}

if ($context->contextlevel == CONTEXT_COURSECAT) {
    $PAGE->set_primary_active_tab('home');
}

$PAGE->set_title($title);
$PAGE->add_body_class('limitedwidth');
$PAGE->set_pagetype('contentbank');
$PAGE->set_secondary_active_tab('contentbank');

// Get all contents managed by active plugins where the user has permission to render them.
$contenttypes = [];
$enabledcontenttypes = $cb->get_enabled_content_types();
foreach ($enabledcontenttypes as $contenttypename) {
    $contenttypeclass = "\\contenttype_$contenttypename\\contenttype";
    $contenttype = new $contenttypeclass($context);
    if ($contenttype->can_access()) {
        $contenttypes[] = $contenttypename;
    }
}

// Get the toolbar ready.
$toolbar = array ();

if (has_capability('agpu/contentbank:viewunlistedcontent', $context)) {
    $display = get_user_preferences('core_contentbank_displayunlisted', 1);
    $toolbar[] = [
        'name' => 'displayunlisted',
        'id' => 'displayunlisted',
        'checkbox' => true,
        'checked' => !empty($display),
        'label' => get_string('displayunlisted', 'contentbank'),
        'class' => 'displayunlisted m-2',
        'action' => 'displayunlisted',
    ];
    $PAGE->requires->js_call_amd(
        'core_contentbank/displayunlisted',
        'init',
        ['[data-action=displayunlisted]']
    );
}

// Place the Add button in the toolbar.
if (has_capability('agpu/contentbank:useeditor', $context)) {
    // Get the content types for which the user can use an editor.
    $editabletypes = $cb->get_contenttypes_with_capability_feature(\core_contentbank\contenttype::CAN_EDIT, $context);
    if (!empty($editabletypes)) {
        // Editor base URL.
        $editbaseurl = new agpu_url('/contentbank/edit.php', ['contextid' => $contextid]);
        $toolbar[] = [
            'name' => get_string('add'),
            'link' => $editbaseurl, 'dropdown' => true,
            'contenttypes' => $editabletypes,
            'action' => 'add'
        ];
    }
}

// Place the Upload button in the toolbar.
if (has_capability('agpu/contentbank:upload', $context)) {
    // Don' show upload button if there's no plugin to support any file extension.
    $accepted = $cb->get_supported_extensions_as_string($context);
    if (!empty($accepted)) {
        $importurl = new agpu_url('/contentbank/index.php', ['contextid' => $contextid]);
        $toolbar[] = [
            'name' => get_string('upload', 'contentbank'),
            'link' => $importurl->out(false),
            'icon' => 'i/upload',
            'action' => 'upload'
        ];
        $PAGE->requires->js_call_amd(
            'core_contentbank/upload',
            'initModal',
            ['[data-action=upload]', \core_contentbank\form\upload_files::class, $contextid]
        );
    }
}

echo $OUTPUT->header();
echo $OUTPUT->heading($title, 2);
echo $OUTPUT->box_start('generalbox');

// If needed, display notifications.
if (!empty($errormsg) && get_string_manager()->string_exists($errormsg, 'core_contentbank')) {
    $errormsg = get_string($errormsg, 'core_contentbank');
    echo $OUTPUT->notification($errormsg);
} else if (!empty($statusmsg) && get_string_manager()->string_exists($statusmsg, 'core_contentbank')) {
    $statusmsg = get_string($statusmsg, 'core_contentbank');
    echo $OUTPUT->notification($statusmsg, 'notifysuccess');
}

$foldercontents = $cb->search_contents($search, $contextid, $contenttypes);

// Render the contentbank contents.
$folder = new \core_contentbank\output\bankcontent($foldercontents, $toolbar, $context, $cb);
echo $OUTPUT->render($folder);

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
