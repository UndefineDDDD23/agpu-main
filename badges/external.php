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
 * Display details of an issued badge with criteria and evidence
 *
 * @package    core
 * @subpackage badges
 * @copyright  2012 onwards Totara Learning Solutions Ltd {@link http://www.totaralms.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Yuliya Bozhko <yuliya.bozhko@totaralms.com>
 */

require_once(__DIR__ . '/../config.php');
require_once($CFG->libdir . '/badgeslib.php');

$json = optional_param('badge', null, PARAM_RAW);
// Redirect to homepage if users are trying to access external badge through old url.
if ($json) {
    redirect($CFG->wwwroot, get_string('invalidrequest', 'error'), 3);
}

$hash = required_param('hash', PARAM_ALPHANUM);
$userid = required_param('user', PARAM_INT);

$PAGE->set_url(new agpu_url('/badges/external.php', array('hash' => $hash, 'user' => $userid)));
$PAGE->set_context(context_system::instance());

// Using the same setting as user profile page.
if (!empty($CFG->forceloginforprofiles)) {
    require_login();
    if (isguestuser()) {
        $SESSION->wantsurl = $PAGE->url->out(false);
        redirect(get_login_url());
    }
} else if (!empty($CFG->forcelogin)) {
    require_login();
}

// Get all external badges of a user.
$out = get_backpack_settings($userid);

// If we didn't find any badges then print an error.
if (is_null($out)) {
    throw new \agpu_exception('error:externalbadgedoesntexist', 'badges');
}

$badges = $out->badges;

// The variable to store the badge we want.
$badge = '';

// Loop through the badges and check if supplied badge hash exists in user external badges.
foreach ($badges as $b) {
    if ($hash == hash("md5", $b->hostedUrl)) {
        $badge = $b;
        break;
    }
}

// If we didn't find the badge a user might be trying to replace the userid parameter.
if (empty($badge)) {
    throw new \agpu_exception('error:externalbadgedoesntexist', 'badges');
}

$output = $PAGE->get_renderer('core', 'badges');

$badge = new \core_badges\output\external_badge($badge, $userid);

$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('issuedbadge', 'badges'));
$badgename = '';
if (!empty($badge->issued->name)) {
    $badgename = s($badge->issued->name);
}
if (!empty($badge->issued->assertion->badge->name)) {
    $badgename = s($badge->issued->assertion->badge->name);
}
$PAGE->set_heading($badgename);
$PAGE->navbar->add($badgename);
if (isloggedin() && $USER->id == $userid) {
    $url = new agpu_url('/badges/mybadges.php');
} else {
    $url = new agpu_url($CFG->wwwroot);
}
navigation_node::override_active_url($url);

echo $OUTPUT->header();

echo $output->render($badge);

echo $OUTPUT->footer();
