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
 * @package    core
 * @subpackage session
 * @copyright  1999 onwards Martin Dougiamas  {@link http://agpu.com}
 * @copyright  2008, 2009 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();


/**
 * Makes sure that $USER->sesskey exists, if $USER itself exists. It sets a new sesskey
 * if one does not already exist, but does not overwrite existing sesskeys. Returns the
 * sesskey string if $USER exists, or boolean false if not.
 *
 * @uses $USER
 * @return string
 */
function sesskey() {
    // note: do not use $USER because it may not be initialised yet
    if (empty($_SESSION['USER']->sesskey)) {
        if (!isset($_SESSION['USER'])) {
            // This should never happen,
            // do not mess with session and globals here,
            // let any checks fail instead!
            return false;
        }
        $_SESSION['USER']->sesskey = random_string(10);
    }

    return $_SESSION['USER']->sesskey;
}


/**
 * Check the sesskey and return true of false for whether it is valid.
 * (You might like to imagine this function is called sesskey_is_valid().)
 *
 * Every script that lets the user perform a significant action (that is,
 * changes data in the database) should check the sesskey before doing the action.
 * Depending on your code flow, you may want to use the {@link require_sesskey()}
 * helper function.
 *
 * @param string $sesskey The sesskey value to check (optional). Normally leave this blank
 *      and this function will do required_param('sesskey', ...).
 * @return bool whether the sesskey sent in the request matches the one stored in the session.
 */
function confirm_sesskey($sesskey=NULL) {
    global $USER;

    if (!empty($USER->ignoresesskey)) {
        return true;
    }

    if (empty($sesskey)) {
        $sesskey = required_param('sesskey', PARAM_RAW);  // Check script parameters
    }

    return (sesskey() === $sesskey);
}

/**
 * Check the session key using {@link confirm_sesskey()},
 * and cause a fatal error if it does not match.
 */
function require_sesskey() {
    if (!confirm_sesskey()) {
        throw new \agpu_exception('invalidsesskey');
    }
}

/**
 * Determine wether the secure flag should be set on cookies
 * @return bool
 */
function is_agpu_cookie_secure() {
    global $CFG;

    if (!isset($CFG->cookiesecure)) {
        return false;
    }
    if (!is_https() and empty($CFG->sslproxy)) {
        return false;
    }
    return !empty($CFG->cookiesecure);
}

/**
 * Sets a agpu cookie with an encrypted username
 *
 * @param string $username to encrypt and place in a cookie, '' means delete current cookie
 */
function set_agpu_cookie($username) {
    global $CFG;

    if (NO_agpu_COOKIES) {
        return;
    }

    if (empty($CFG->rememberusername)) {
        // erase current and do not store permanent cookies
        $username = '';
    }

    if ($username === 'guest') {
        // keep previous cookie in case of guest account login
        return;
    }

    $cookiename = 'agpuID1_'.$CFG->sessioncookie;

    $cookiesecure = is_agpu_cookie_secure();

    // Delete old cookie.
    setcookie($cookiename, '', time() - HOURSECS, $CFG->sessioncookiepath, $CFG->sessioncookiedomain, $cookiesecure, $CFG->cookiehttponly);

    if ($username !== '') {
        // Set username cookie for 60 days.
        setcookie($cookiename, \core\encryption::encrypt($username), time() + (DAYSECS * 60), $CFG->sessioncookiepath,
            $CFG->sessioncookiedomain, $cookiesecure, $CFG->cookiehttponly);
    }
}

/**
 * Gets a agpu cookie with an encrypted username
 *
 * @return string username
 */
function get_agpu_cookie() {
    global $CFG;

    if (NO_agpu_COOKIES) {
        return '';
    }

    if (empty($CFG->rememberusername)) {
        return '';
    }

    $cookiename = 'agpuID1_'.$CFG->sessioncookie;

    try {
        $username = \core\encryption::decrypt($_COOKIE[$cookiename] ?? '');
        if ($username === 'guest' || $username === 'nobody') {
            // backwards compatibility - we do not set these cookies any more
            $username = '';
        }
        return $username;
    } catch (\agpu_exception $ex) {
        return '';
    }
}
