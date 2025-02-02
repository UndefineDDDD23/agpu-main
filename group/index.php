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
 * The main group management user interface.
 *
 * @copyright 2006 The Open University, N.D.Freear AT open.ac.uk, J.White AT open.ac.uk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   core_group
 */
require_once('../config.php');
require_once('lib.php');

$courseid = required_param('id', PARAM_INT);
$groupid  = optional_param('group', false, PARAM_INT);
$userid   = optional_param('user', false, PARAM_INT);
$action = optional_param('action', false, PARAM_TEXT);

// Support either single group= parameter, or array groups[].
if ($groupid) {
    $groupids = array($groupid);
} else {
    $groupids = optional_param_array('groups', array(), PARAM_INT);
}
$singlegroup = (count($groupids) == 1);

$returnurl = $CFG->wwwroot.'/group/index.php?id='.$courseid;

// Get the course information so we can print the header and
// check the course id is valid.
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$url = new agpu_url('/group/index.php', array('id' => $courseid));
navigation_node::override_active_url($url);
if ($userid) {
    $url->param('user', $userid);
}
if ($groupid) {
    $url->param('group', $groupid);
}
$PAGE->set_url($url);

// Make sure that the user has permissions to manage groups.
require_login($course);

$context = context_course::instance($course->id);
require_capability('agpu/course:managegroups', $context);

$PAGE->requires->js('/group/clientlib.js', true);
$PAGE->requires->js('/group/module.js', true);

// Check for multiple/no group errors.
if (!$singlegroup) {
    switch($action) {
        case 'ajax_getmembersingroup':
        case 'showgroupsettingsform':
        case 'showaddmembersform':
        case 'updatemembers':
            throw new \agpu_exception('errorselectone', 'group', $returnurl);
    }
}

switch ($action) {
    case false: // OK, display form.
        break;

    case 'ajax_getmembersingroup':
        $roles = array();

        $userfieldsapi = \core_user\fields::for_identity($context)->with_userpic();
        [
            'selects' => $userfieldsselects,
            'joins' => $userfieldsjoin,
            'params' => $userfieldsparams
        ] = (array)$userfieldsapi->get_sql('u', true, '', '', false);
        $extrafields = $userfieldsapi->get_required_fields([\core_user\fields::PURPOSE_IDENTITY]);
        if ($groupmemberroles = groups_get_members_by_role($groupids[0], $courseid,
                'u.id, ' . $userfieldsselects, null, '', $userfieldsparams, $userfieldsjoin)) {

            $viewfullnames = has_capability('agpu/site:viewfullnames', $context);

            foreach ($groupmemberroles as $roleid => $roledata) {
                $shortroledata = new stdClass();
                $shortroledata->name = html_entity_decode($roledata->name, ENT_QUOTES, 'UTF-8');
                $shortroledata->users = array();
                foreach ($roledata->users as $member) {
                    $shortmember = new stdClass();
                    $shortmember->id = $member->id;
                    $shortmember->name = fullname($member, $viewfullnames);
                    if ($extrafields) {
                        $extrafieldsdisplay = [];
                        foreach ($extrafields as $field) {
                            // No escaping here, handled client side in response to AJAX request.
                            $extrafieldsdisplay[] = $member->{$field};
                        }
                        $shortmember->name .= ' (' . implode(', ', $extrafieldsdisplay) . ')';
                    }

                    $shortroledata->users[] = $shortmember;
                }
                $roles[] = $shortroledata;
            }
        }
        echo json_encode($roles);
        die;  // Client side JavaScript takes it from here.

    case 'deletegroup':
        if (count($groupids) == 0) {
            throw new \agpu_exception('errorselectsome', 'group', $returnurl);
        }
        $groupidlist = implode(',', $groupids);
        redirect(new agpu_url('/group/delete.php', array('courseid' => $courseid, 'groups' => $groupidlist)));
        break;

    case 'showcreateorphangroupform':
        redirect(new agpu_url('/group/group.php', array('courseid' => $courseid)));
        break;

    case 'showautocreategroupsform':
        redirect(new agpu_url('/group/autogroup.php', array('courseid' => $courseid)));
        break;

    case 'showimportgroups':
        redirect(new agpu_url('/group/import.php', array('id' => $courseid)));
        break;

    case 'showgroupsettingsform':
        redirect(new agpu_url('/group/group.php', array('courseid' => $courseid, 'id' => $groupids[0])));
        break;

    case 'updategroups': // Currently reloading.
        break;

    case 'removemembers':
        break;

    case 'showaddmembersform':
        redirect(new agpu_url('/group/members.php', array('group' => $groupids[0])));
        break;

    case 'updatemembers': // Currently reloading.
        break;

    case 'enablemessaging':
        set_groups_messaging($groupids, true);
        redirect($returnurl, get_string('messagingenabled', 'group', count($groupids)), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    case 'disablemessaging':
        set_groups_messaging($groupids, false);
        redirect($returnurl, get_string('messagingdisabled', 'group', count($groupids)), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    default: // ERROR.
        throw new \agpu_exception('unknowaction', '', $returnurl);
        break;
}

// Print the page and form.
$strgroups = get_string('groups');
$strparticipants = get_string('participants');

// Print header.
$PAGE->set_title($strgroups);
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');
echo $OUTPUT->header();

echo $OUTPUT->render_participants_tertiary_nav($course);

$groups = groups_get_all_groups($courseid);
$selectedname = null;
$preventgroupremoval = array();

// Get list of groups to render.
$groupoptions = array();
if ($groups) {
    foreach ($groups as $group) {
        $selected = false;
        $usercount = $DB->count_records('groups_members', array('groupid' => $group->id));
        $groupname = format_string($group->name, true, ['context' => $context, 'escape' => false]) . ' (' . $usercount . ')';
        if (in_array($group->id, $groupids)) {
            $selected = true;
            if ($singlegroup) {
                // Only keep selected name if there is one group selected.
                $selectedname = $groupname;
            }
        }
        if (!empty($group->idnumber) && !has_capability('agpu/course:changeidnumber', $context)) {
            $preventgroupremoval[$group->id] = true;
        }

        $groupoptions[] = (object) [
            'value' => $group->id,
            'selected' => $selected,
            'text' => s($groupname)
        ];
    }
}

// Get list of group members to render if there is a single selected group.
$members = array();
if ($singlegroup) {
    $userfieldsapi = \core_user\fields::for_identity($context)->with_userpic();
    [
        'selects' => $userfieldsselects,
        'joins' => $userfieldsjoin,
        'params' => $userfieldsparams
    ] = (array)$userfieldsapi->get_sql('u', true, '', '', false);
    $extrafields = $userfieldsapi->get_required_fields([\core_user\fields::PURPOSE_IDENTITY]);
    if ($groupmemberroles = groups_get_members_by_role(reset($groupids), $courseid,
            'u.id, ' . $userfieldsselects, null, '', $userfieldsparams, $userfieldsjoin)) {

        $viewfullnames = has_capability('agpu/site:viewfullnames', $context);

        foreach ($groupmemberroles as $roleid => $roledata) {
            $users = array();
            foreach ($roledata->users as $member) {
                $shortmember = new stdClass();
                $shortmember->value = $member->id;
                $shortmember->text = fullname($member, $viewfullnames);
                if ($extrafields) {
                    $extrafieldsdisplay = [];
                    foreach ($extrafields as $field) {
                        $extrafieldsdisplay[] = s($member->{$field});
                    }
                    $shortmember->text .= ' (' . implode(', ', $extrafieldsdisplay) . ')';
                }

                $users[] = $shortmember;
            }

            $members[] = (object)[
                'role' => html_entity_decode($roledata->name, ENT_QUOTES, 'UTF-8'),
                'rolemembers' => $users
            ];
        }
    }
}

$disableaddedit = !$singlegroup;
$disabledelete = !empty($groupids);
$caneditmessaging = \core_message\api::can_create_group_conversation($USER->id, $context);

$renderable = new \core_group\output\index_page($courseid, $groupoptions, $selectedname, $members, $disableaddedit, $disabledelete,
        $preventgroupremoval, $caneditmessaging);
$output = $PAGE->get_renderer('core_group');
echo $output->render($renderable);

echo $OUTPUT->footer();
