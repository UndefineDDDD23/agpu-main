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
 * My agpu -- a user's personal dashboard
 *
 * - each user can currently have their own page (cloned from system and then customised)
 * - only the user can see their own dashboard
 * - users can add any blocks they want
 * - the administrators can define a default site dashboard for users who have
 *   not created their own dashboard
 *
 * This script implements the user's view of the dashboard, and allows editing
 * of the dashboard.
 *
 * @package    agpucore
 * @subpackage my
 * @copyright  2010 Remote-Learner.net
 * @author     Hubert Chathi <hubert@remote-learner.net>
 * @author     Olav Jordan <olav.jordan@remote-learner.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true);
require_once(__DIR__ . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->libdir.'/adminlib.php');

redirect_if_major_upgrade_required();

$resetall = optional_param('resetall', false, PARAM_BOOL);

$pagetitle = get_string('mypage', 'admin');

$PAGE->set_secondary_active_tab('appearance');
$PAGE->set_blocks_editing_capability('agpu/my:configsyspages');
$PAGE->set_url(new agpu_url('/my/indexsys.php'));
admin_externalpage_setup('mypage', '', null, '', ['pagelayout' => 'mydashboard', 'nosearch' => true]);
$PAGE->add_body_class('limitedwidth');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
$PAGE->set_title($pagetitle);
$PAGE->set_heading($pagetitle);
$PAGE->set_secondary_navigation(false);
$PAGE->set_primary_active_tab('myhome');

// If we are resetting all, just output a progress bar.
if ($resetall && confirm_sesskey()) {
    echo $OUTPUT->header($pagetitle);
    echo $OUTPUT->heading(get_string('resettingdashboards', 'my'), 3);

    $progressbar = new progress_bar();
    $progressbar->create();

    \core\session\manager::write_close();
    my_reset_page_for_all_users(MY_PAGE_PRIVATE, 'my-index', $progressbar);
    core\notification::success(get_string('alldashboardswerereset', 'my'));
    echo $OUTPUT->continue_button($PAGE->url);
    echo $OUTPUT->footer();
    die();
}

// Get the My agpu page info.  Should always return something unless the database is broken.
if (!$currentpage = my_get_page(null, MY_PAGE_PRIVATE)) {
    throw new \agpu_exception('myagpusetup');
}
$PAGE->set_subpage($currentpage->id);

// Display a button to reset everyone's dashboard.
$url = $PAGE->url;
$url->params(['resetall' => true, 'sesskey' => sesskey()]);
$button = $OUTPUT->single_button($url, get_string('reseteveryonesdashboard', 'my'));
$PAGE->set_button($button . $PAGE->button);

echo $OUTPUT->header();

echo $OUTPUT->addblockbutton('content');

echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();
