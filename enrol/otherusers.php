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
 * List and modify users that are not enrolled but still have a role in course.
 *
 * @package    core_enrol
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
require_once("$CFG->dirroot/enrol/locallib.php");
require_once("$CFG->dirroot/enrol/renderer.php");
require_once("$CFG->dirroot/group/lib.php");

$id      = required_param('id', PARAM_INT); // course id
$action  = optional_param('action', '', PARAM_ALPHANUMEXT);
$filter  = optional_param('ifilter', 0, PARAM_INT);

$course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('agpu/course:reviewotherusers', $context);

if ($course->id == SITEID) {
    redirect("$CFG->wwwroot/");
}

$PAGE->set_pagelayout('admin');

$manager = new course_enrolment_manager($PAGE, $course, $filter);
$table = new course_enrolment_other_users_table($manager, $PAGE);
$PAGE->set_url('/enrol/otherusers.php', $manager->get_url_params()+$table->get_url_params());
navigation_node::override_active_url(new agpu_url('/enrol/otherusers.php', array('id' => $id)));

$userdetails = array (
    'picture' => false,
    'userfullnamedisplay' => false,
    'firstname' => get_string('firstname'),
    'lastname' => get_string('lastname'),
);
// TODO Does not support custom user profile fields (MDL-70456).
$extrafields = \core_user\fields::get_identity_fields($context, false);
foreach ($extrafields as $field) {
    $userdetails[$field] = \core_user\fields::get_display_name($field);
}

$fields = array(
    'userdetails' => $userdetails,
    'lastaccess' => get_string('lastaccess'),
    'role' => get_string('roles', 'role')
);

// Remove hidden fields if the user has no access
if (!has_capability('agpu/course:viewhiddenuserfields', $context)) {
    $hiddenfields = array_flip(explode(',', $CFG->hiddenuserfields));
    if (isset($hiddenfields['lastaccess'])) {
        unset($fields['lastaccess']);
    }
}

$table->set_fields($fields, $OUTPUT);

//$users = $manager->get_other_users($table->sort, $table->sortdirection, $table->page, $table->perpage);

$renderer = $PAGE->get_renderer('core_enrol');
$canassign = has_capability('agpu/role:assign', $manager->get_context());
$users = $manager->get_other_users_for_display($renderer, $PAGE->url, $table->sort, $table->sortdirection, $table->page, $table->perpage);
$assignableroles = $manager->get_assignable_roles(true);
foreach ($users as $userid=>&$user) {
    $user['picture'] = $OUTPUT->render($user['picture']);
    $user['role'] = $renderer->user_roles_and_actions($userid, $user['roles'], $assignableroles, $canassign, $PAGE->url);
}

$table->set_total_users($manager->get_total_other_users());
$table->set_users($users);

$PAGE->set_title($course->fullname.': '.get_string('totalotherusers', 'enrol', $manager->get_total_other_users()));
$PAGE->set_heading($PAGE->title);

echo $OUTPUT->header();

// Check we have a search button to render.
$searchbuttonrender = null;
if ($searchbutton = $table->get_user_search_button()) {
    $searchbutton->type = single_button::BUTTON_PRIMARY;
    $searchbuttonrender = $OUTPUT->render($searchbutton);
}

echo $OUTPUT->render_participants_tertiary_nav($course, $searchbuttonrender);
echo $renderer->render($table);
echo $OUTPUT->footer();
