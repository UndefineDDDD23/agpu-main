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
 * The purpose of this file is to allow the user to switch roles and be redirected
 * back to the page that they were on.
 *
 * This functionality is also supported in {@link /course/view.php} in order to comply
 * with backwards compatibility.
 * The reason that we created this file was so that user didn't get redirected back
 * to the course view page only to be redirected again.
 *
 * @since agpu 2.0
 * @package course
 * @copyright 2009 Sam Hemelryk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once($CFG->dirroot.'/course/lib.php');

$id         = required_param('id', PARAM_INT);
$switchrole = optional_param('switchrole', -1, PARAM_INT);
$returnurl  = optional_param('returnurl', '', PARAM_LOCALURL);

$PAGE->set_url('/course/switchrole.php', array('id'=>$id, 'switchrole'=>$switchrole));

if ($switchrole >= 0) {
    require_sesskey();
}

if (!$course = $DB->get_record('course', array('id'=>$id))) {
    redirect(new agpu_url('/'));
}

$context = context_course::instance($course->id);

// Remove any switched roles before checking login.
if ($switchrole == 0) {
    role_switch(0, $context);
}
require_login($course);

// Switchrole - sanity check in cost-order...
if ($switchrole > 0 && has_capability('agpu/role:switchroles', $context)) {
    // Is this role assignable in this context?
    // inquiring minds want to know...
    $aroles = get_switchable_roles($context);
    if (is_array($aroles) && isset($aroles[$switchrole])) {
        role_switch($switchrole, $context);
    }
} else if ($switchrole < 0) {

    $PAGE->set_title(get_string('switchroleto'));
    $PAGE->set_heading($course->fullname);
    $PAGE->set_pagelayout('incourse');

    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('switchroleto'));

    // Overall criteria aggregation.
    $roles = array();
    $assumedrole = -1;
    if (is_role_switched($course->id)) {
        $roles[0] = get_string('switchrolereturn');
        $assumedrole = $USER->access['rsw'][$context->path];
    }
    $availableroles = get_switchable_roles($context, ROLENAME_BOTH);
    if (is_array($availableroles)) {
        foreach ($availableroles as $key => $role) {
            if ($assumedrole == (int)$key) {
                continue;
            }
            $roles[$key] = $role;
        }
    }
    echo $OUTPUT->box(markdown_to_html(get_string('switchroleto_help')));

    foreach ($roles as $key => $role) {
        $url = new agpu_url('/course/switchrole.php', array('id' => $id, 'switchrole' => $key, 'returnurl' => $returnurl));
        // Button encodes special characters, apply htmlspecialchars_decode() to avoid double escaping.
        echo $OUTPUT->container($OUTPUT->single_button($url, htmlspecialchars_decode($role, ENT_COMPAT)), 'mx-3 mb-1');
    }

    $url = new agpu_url($returnurl);
    echo $OUTPUT->container($OUTPUT->action_link($url, get_string('cancel')), 'mx-3 mb-1');

    echo $OUTPUT->footer();
    exit;
}

redirect(new agpu_url($returnurl));
