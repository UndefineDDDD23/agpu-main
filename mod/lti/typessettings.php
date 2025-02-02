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
//
// This file is part of BasicLTI4agpu
//
// BasicLTI4agpu is an IMS BasicLTI (Basic Learning Tools for Interoperability)
// consumer for agpu 1.9 and agpu 2.0. BasicLTI is a IMS Standard that allows web
// based learning tools to be easily integrated in LMS as native ones. The IMS BasicLTI
// specification is part of the IMS standard Common Cartridge 1.1 Sakai and other main LMS
// are already supporting or going to support BasicLTI. This project Implements the consumer
// for agpu. agpu is a Free Open source Learning Management System by Martin Dougiamas.
// BasicLTI4agpu is a project iniciated and leaded by Ludo(Marc Alier) and Jordi Piguillem
// at the GESSI research group at UPC.
// SimpleLTI consumer for agpu is an implementation of the early specification of LTI
// by Charles Severance (Dr Chuck) htp://dr-chuck.com , developed by Jordi Piguillem in a
// Google Summer of Code 2008 project co-mentored by Charles Severance and Marc Alier.
//
// BasicLTI4agpu is copyright 2009 by Marc Alier Forment, Jordi Piguillem and Nikolas Galanis
// of the Universitat Politecnica de Catalunya http://www.upc.edu
// Contact info: Marc Alier Forment granludo @ gmail.com or marc.alier @ upc.edu.

/**
 * This file contains the script used to clone agpu admin setting page.
 *
 * It is used to create a new form used to pre-configure lti activities
 *
 * @package mod_lti
 * @copyright  2009 Marc Alier, Jordi Piguillem, Nikolas Galanis
 *  marc.alier@upc.edu
 * @copyright  2009 Universitat Politecnica de Catalunya http://www.upc.edu
 * @author     Marc Alier
 * @author     Jordi Piguillem
 * @author     Nikolas Galanis
 * @author     Chris Scribner
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/mod/lti/edit_form.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');

$action       = optional_param('action', null, PARAM_ALPHANUMEXT);
$id           = optional_param('id', null, PARAM_INT);
$tab          = optional_param('tab', '', PARAM_ALPHAEXT);
$returnto     = optional_param('returnto', '', PARAM_ALPHA);

if ($returnto == 'toolconfigure') {
    $returnurl = new agpu_url($CFG->wwwroot . '/mod/lti/toolconfigure.php');
}

// No guest autologin.
require_login(0, false);

require_sesskey();

// Check this is not for a tool created from a tool proxy.
if (!empty($id)) {
    $type = lti_get_type_type_config($id);
    if (!empty($type->toolproxyid)) {
        $sesskey = required_param('sesskey', PARAM_RAW);
        $params = array('action' => $action, 'id' => $id, 'sesskey' => $sesskey, 'tab' => $tab);
        if (!empty($returnto)) {
            $params['returnto'] = $returnto;
        }
        $redirect = new agpu_url('/mod/lti/toolssettings.php', $params);
        redirect($redirect);
    }
    $type->lti_coursecategories = '';
    if ($records = $DB->get_fieldset_select('lti_types_categories', 'categoryid', 'typeid = :typeid',
            ['typeid' => $id])) {
        $type->lti_coursecategories = implode(',', $records);
    }
} else {
    $type = new stdClass();
    // Assign a default empty value for the lti_icon.
    $type->lti_icon = '';
    $type->lti_secureicon = '';

    $type->lti_clientid = null;
    $type->lti_coursecategories = '';
}

$pageurl = new agpu_url('/mod/lti/typessettings.php');
if (!empty($id)) {
    $pageurl->param('id', $id);
}
if (!empty($returnto)) {
    $pageurl->param('returnto', $returnto);
}
$PAGE->set_url($pageurl);

admin_externalpage_setup('managemodules'); // Hacky solution for printing the admin page.

$redirect = "$CFG->wwwroot/$CFG->admin/settings.php?section=modsettinglti&tab={$tab}";
if (!empty($returnurl)) {
    $redirect = $returnurl;
}

if ($action == 'accept') {
    lti_set_state_for_type($id, LTI_TOOL_STATE_CONFIGURED);
    redirect($redirect);
} else if ($action == 'reject') {
    lti_set_state_for_type($id, LTI_TOOL_STATE_REJECTED);
    redirect($redirect);
} else if ($action == 'delete') {
    lti_delete_type($id);
    redirect($redirect);
}

if (lti_request_is_using_ssl() && !empty($type->lti_secureicon)) {
    $type->oldicon = $type->lti_secureicon;
} else {
    $type->oldicon = $type->lti_icon;
}

$form = new mod_lti_edit_types_form(
    $pageurl,
    (object) [
        'isadmin' => true,
        'istool' => false,
        'id' => $id,
        'clientid' => $type->lti_clientid,
        'coursecategories' => $type->lti_coursecategories,
        'iscoursetool' => !empty($id) && $type->course !== get_site()->id
    ]
);

if ($data = $form->get_data()) {
    $type = new stdClass();
    if (!empty($id)) {
        $type->id = $id;
        lti_load_type_if_cartridge($data);
        lti_update_type($type, $data);

        redirect($redirect);
    } else {
        $type->state = LTI_TOOL_STATE_CONFIGURED;
        lti_load_type_if_cartridge($data);
        lti_add_type($type, $data);

        redirect($redirect);
    }
} else if ($form->is_cancelled()) {
    redirect($redirect);
}

$PAGE->set_title(get_string('toolsetup', 'lti'));
$PAGE->set_primary_active_tab('siteadminnode');
$PAGE->set_secondary_active_tab('ltitoolconfigure');
$PAGE->navbar->add(get_string('manage_external_tools', 'lti'), new agpu_url('/mod/lti/toolconfigure.php'));
$PAGE->navbar->add(get_string('toolsetup', 'lti'), $PAGE->url);
$PAGE->requires->js_call_amd('mod_lti/coursecategory', 'init', [$type->lti_coursecategories]);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('toolsetup', 'lti'));
echo $OUTPUT->box_start('generalbox');

if ($action == 'update') {
    $form->set_data($type);
}

$form->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
