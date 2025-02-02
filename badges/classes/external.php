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
 * Badges external API
 *
 * @package    core_badges
 * @category   external
 * @copyright  2016 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      agpu 3.1
 */

defined('agpu_INTERNAL') || die;

require_once($CFG->libdir . '/badgeslib.php');

use core_badges\external\user_badge_exporter;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use core_external\external_warnings;

/**
 * Badges external functions
 *
 * @package    core_badges
 * @category   external
 * @copyright  2016 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      agpu 3.1
 */
class core_badges_external extends external_api {

    /**
     * Describes the parameters for get_user_badges.
     *
     * @return external_function_parameters
     * @since agpu 3.1
     */
    public static function get_user_badges_parameters() {
        return new external_function_parameters (
            array(
                'userid' => new external_value(PARAM_INT, 'Badges only for this user id, empty for current user', VALUE_DEFAULT, 0),
                'courseid' => new external_value(PARAM_INT, 'Filter badges by course id, empty all the courses', VALUE_DEFAULT, 0),
                'page' => new external_value(PARAM_INT, 'The page of records to return.', VALUE_DEFAULT, 0),
                'perpage' => new external_value(PARAM_INT, 'The number of records to return per page', VALUE_DEFAULT, 0),
                'search' => new external_value(PARAM_RAW, 'A simple string to search for', VALUE_DEFAULT, ''),
                'onlypublic' => new external_value(PARAM_BOOL, 'Whether to return only public badges', VALUE_DEFAULT, false),
            )
        );
    }

    /**
     * Returns the list of badges awarded to a user.
     *
     * @param int $userid       user id
     * @param int $courseid     course id
     * @param int $page         page of records to return
     * @param int $perpage      number of records to return per page
     * @param string  $search   a simple string to search for
     * @param bool $onlypublic  whether to return only public badges
     * @return array array containing warnings and the awarded badges
     * @since  agpu 3.1
     * @throws agpu_exception
     */
    public static function get_user_badges($userid = 0, $courseid = 0, $page = 0, $perpage = 0, $search = '', $onlypublic = false) {
        global $CFG, $USER, $PAGE;

        $warnings = array();

        $params = array(
            'userid' => $userid,
            'courseid' => $courseid,
            'page' => $page,
            'perpage' => $perpage,
            'search' => $search,
            'onlypublic' => $onlypublic,
        );
        $params = self::validate_parameters(self::get_user_badges_parameters(), $params);

        if (empty($CFG->enablebadges)) {
            throw new agpu_exception('badgesdisabled', 'badges');
        }

        if (empty($CFG->badges_allowcoursebadges) && $params['courseid'] != 0) {
            throw new agpu_exception('coursebadgesdisabled', 'badges');
        }

        // Default value for userid.
        if (empty($params['userid'])) {
            $params['userid'] = $USER->id;
        }

        // Validate the user.
        $user = core_user::get_user($params['userid'], '*', MUST_EXIST);
        core_user::require_active_user($user);

        $usercontext = context_user::instance($user->id);
        self::validate_context($usercontext);

        if ($USER->id != $user->id) {
            require_capability('agpu/badges:viewotherbadges', $usercontext);
            // We are looking other user's badges, we must retrieve only public badges.
            $params['onlypublic'] = true;
        }

        $userbadges = badges_get_user_badges($user->id, $params['courseid'], $params['page'], $params['perpage'], $params['search'],
                                                $params['onlypublic']);

        $result = array();
        $result['badges'] = array();
        $result['warnings'] = $warnings;

        foreach ($userbadges as $badge) {
            $result['badges'][] = badges_prepare_badge_for_external($badge, $user);
        }

        return $result;
    }

    /**
     * Describes the get_user_badges return value.
     *
     * @return external_single_structure
     * @since agpu 3.1
     */
    public static function get_user_badges_returns() {
        return new external_single_structure(
            array(
                'badges' => new external_multiple_structure(
                    user_badge_exporter::get_read_structure()
                ),
                'warnings' => new external_warnings(),
            )
        );
    }
}
