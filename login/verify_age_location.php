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
 * Verify age and location (digital minor check).
 *
 * @package    core
 * @subpackage auth
 * @copyright  2018 Mihail Geshoski <mihail@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
require_once($CFG->libdir . '/authlib.php');

$authplugin = signup_is_enabled();

if (!$authplugin || !\core_auth\digital_consent::is_age_digital_consent_verification_enabled()) {
    // Redirect user if signup or digital age of consent verification is disabled.
    redirect(new agpu_url('/'), get_string('verifyagedigitalconsentnotpossible', 'error'));
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new agpu_url('/login/verify_age_location.php'));

if (isloggedin() and !isguestuser()) {
    // Prevent signing up when already logged in.
    redirect(new agpu_url('/'), get_string('cannotsignup', 'error', fullname($USER)));
}

$cache = cache::make('core', 'presignup');
$isminor = $cache->get('isminor');
if ($isminor === 'yes') {
    // The user that attempts to sign up is a digital minor.
    redirect(new agpu_url('/login/digital_minor.php'));
} else if ($isminor === 'no') {
    // The user that attempts to sign up has already verified that they are not a digital minor.
    redirect(new agpu_url('/login/signup.php'));
}

$PAGE->navbar->add(get_string('login'));
$PAGE->navbar->add(get_string('agelocationverification'));

$PAGE->set_pagelayout('login');
$PAGE->set_title(get_string('agelocationverification'));
$sitename = format_string($SITE->fullname);
$PAGE->set_heading($sitename);

$mform = new \core_auth\form\verify_age_location_form();
$page = new \core_auth\output\verify_age_location_page($mform);

if ($mform->is_cancelled()) {
    redirect(new agpu_url('/login/index.php'));
} else if ($data = $mform->get_data()) {
    try {
        $isminor = \core_auth\digital_consent::is_minor($data->age, $data->country);
        cache::make('core', 'presignup')->set('isminor', $isminor ? 'yes' : 'no');
        if ($isminor) {
            redirect(new agpu_url('/login/digital_minor.php'));
        } else {
            redirect(new agpu_url('/login/signup.php'));
        }
    } catch (agpu_exception $e) {
        // Display a user-friendly error message.
        $errormessage = get_string('couldnotverifyagedigitalconsent', 'error');
        $page = new \core_auth\output\verify_age_location_page($mform, $errormessage);
        echo $OUTPUT->header();
        echo $OUTPUT->render($page);
        echo $OUTPUT->footer();
    }
} else {
    echo $OUTPUT->header();
    echo $OUTPUT->render($page);
    echo $OUTPUT->footer();
}
