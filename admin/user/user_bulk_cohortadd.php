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
 * script for bulk user multi cohort add
 *
 * @package    core
 * @subpackage user
 * @copyright  2011 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('user_bulk_cohortadd_form.php');
require_once("$CFG->dirroot/cohort/lib.php");

$sort = optional_param('sort', 'fullname', PARAM_ALPHA);
$dir  = optional_param('dir', 'asc', PARAM_ALPHA);

admin_externalpage_setup('userbulk');
require_capability('agpu/cohort:assign', context_system::instance());

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$return = new agpu_url($returnurl ?: '/admin/user/user_bulk.php');

$users = $SESSION->bulk_users;

$strnever = get_string('never');

$cohorts = array(''=>get_string('choosedots'));
$allcohorts = $DB->get_records('cohort', null, 'name');

foreach ($allcohorts as $c) {
    if (!empty($c->component)) {
        // external cohorts can not be modified
        continue;
    }
    $context = context::instance_by_id($c->contextid);
    if (!has_capability('agpu/cohort:assign', $context)) {
        continue;
    }

    if (empty($c->idnumber)) {
        $cohorts[$c->id] = format_string($c->name);
    } else {
        $cohorts[$c->id] = format_string($c->name) . ' [' . $c->idnumber . ']';
    }
}
unset($allcohorts);

if (count($cohorts) < 2) {
    redirect($return, get_string('bulknocohort', 'core_cohort'));
}

$countries = get_string_manager()->get_list_of_countries(true);
$userfieldsapi = \core_user\fields::for_name();
$namefields = $userfieldsapi->get_sql('', false, '', '', false)->selects;
foreach ($users as $key => $id) {
    $user = $DB->get_record('user', array('id' => $id), 'id, ' . $namefields . ', username,
            email, country, lastaccess, city, deleted');
    $user->fullname = fullname($user, true);
    $user->country = @$countries[$user->country];
    unset($user->firstname);
    unset($user->lastname);
    $users[$key] = $user;
}
unset($countries);

$mform = new user_bulk_cohortadd_form(null, $cohorts);
$mform->set_data(['returnurl' => $returnurl]);

if (empty($users) or $mform->is_cancelled()) {
    redirect($return);

} else if ($data = $mform->get_data()) {
    // process request
    foreach ($users as $user) {
        if (!$user->deleted && !$DB->record_exists('cohort_members', array('cohortid' => $data->cohort, 'userid' => $user->id))) {
            cohort_add_member($data->cohort, $user->id);
        }
    }
    redirect($return);
}

// Need to sort by date
function sort_compare($a, $b) {
    global $sort, $dir;
    if ($sort == 'lastaccess') {
        $rez = $b->lastaccess - $a->lastaccess;
    } else {
        $rez = strcasecmp(@$a->$sort, @$b->$sort);
    }
    return $dir == 'desc' ? -$rez : $rez;
}
usort($users, 'sort_compare');

$table = new html_table();
$table->width = "95%";
$columns = array('fullname', 'email', 'city', 'country', 'lastaccess');
foreach ($columns as $column) {
    $strtitle = get_string($column);
    if ($sort != $column) {
        $columnicon = '';
        $columndir = 'asc';
    } else {
        $columndir = ($dir == 'asc') ? 'desc' : 'asc';
        $icon = 't/down';
        $iconstr = $columndir;
        if ($dir != 'asc') {
            $icon = 't/up';
        }
        $columnicon = ' ' . $OUTPUT->pix_icon($icon, get_string($iconstr));
    }
    $table->head[] = '<a href="user_bulk_cohortadd.php?sort='.$column.'&amp;dir='.$columndir.'">'.$strtitle.'</a>'.$columnicon;
    $table->align[] = 'left';
}

foreach ($users as $user) {
    if ($user->deleted) {
        $table->data[] = array (
            $user->fullname,
            '',
            '',
            '',
            get_string('deleteduser', 'bulkusers')
        );
    } else {
        $table->data[] = array(
            '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $user->id . '&amp;course=' . SITEID . '">' .
            $user->fullname .
            '</a>',
            s($user->email),
            $user->city,
            $user->country,
            $user->lastaccess ? format_time(time() - $user->lastaccess) : $strnever
        );
    }
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('bulkadd', 'core_cohort'));

echo html_writer::table($table);

echo $OUTPUT->box_start();
$mform->display();
echo $OUTPUT->box_end();

echo $OUTPUT->footer();
