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
 * This file contains functions used by the log reports
 *
 * This file is also required by /admin/reports/stats/index.php.
 *
 * @package    report
 * @subpackage stats
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course to object for the report
 * @param stdClass $context The context of the course
 */
function report_stats_extend_navigation_course($navigation, $course, $context) {
    global $CFG;
    if (empty($CFG->enablestats)) {
        return;
    }
    if (has_capability('report/stats:view', $context)) {
        $url = new agpu_url('/report/stats/index.php', array('course'=>$course->id));
        $navigation->add(get_string('pluginname', 'report_stats'), $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
    }
}

/**
 * This function extends the course navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $user
 * @param stdClass $course The course to object for the report
 */
function report_stats_extend_navigation_user($navigation, $user, $course) {
    global $CFG;
    if (empty($CFG->enablestats)) {
        return;
    }
    if (report_stats_can_access_user_report($user, $course)) {
        $url = new agpu_url('/report/stats/user.php', array('id'=>$user->id, 'course'=>$course->id));
        $navigation->add(get_string('stats'), $url);
    }
}

/**
 * Is current user allowed to access this report
 *
 * @private defined in lib.php for performance reasons
 *
 * @param stdClass $user
 * @param stdClass $course
 * @return bool
 */
function report_stats_can_access_user_report($user, $course) {
    global $USER;

    $coursecontext = context_course::instance($course->id);
    $personalcontext = context_user::instance($user->id);

    if ($user->id == $USER->id) {
        if ($course->showreports and (is_viewing($coursecontext, $USER) or is_enrolled($coursecontext, $USER))) {
            return true;
        }
    } else if (has_capability('agpu/user:viewuseractivitiesreport', $personalcontext)) {
        if ($course->showreports and (is_viewing($coursecontext, $user) or is_enrolled($coursecontext, $user))) {
            return true;
        }
    }

    // Check if $USER shares group with $user (in case separated groups are enabled and 'agpu/site:accessallgroups' is disabled).
    if (!groups_user_groups_visible($course, $user->id)) {
        return false;
    }

    if (has_capability('report/stats:view', $coursecontext)) {
        return true;
    }

    return false;
}

/**
 * Return a list of page types
 * @param string $pagetype current page type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 * @return array
 */
function report_stats_page_type_list($pagetype, $parentcontext, $currentcontext) {
    $array = array(
        '*'                  => get_string('page-x', 'pagetype'),
        'report-*'           => get_string('page-report-x', 'pagetype'),
        'report-stats-*'     => get_string('page-report-stats-x',  'report_stats'),
        'report-stats-index' => get_string('page-report-stats-index',  'report_stats'),
        'report-stats-user'  => get_string('page-report-stats-user',  'report_stats')
    );
    return $array;
}

/**
 * Callback to verify if the given instance of store is supported by this report or not.
 *
 * @param string $instance store instance.
 *
 * @return bool returns true if the store is supported by the report, false otherwise.
 */
function report_stats_supports_logstore($instance) {
    if ($instance instanceof \core\log\sql_internal_table_reader) {
        return true;
    }
    return false;
}

/**
 * Add nodes to myprofile page.
 *
 * @param \core_user\output\myprofile\tree $tree Tree object
 * @param stdClass $user user object
 * @param bool $iscurrentuser
 * @param stdClass $course Course object
 * @return bool
 */
function report_stats_myprofile_navigation(core_user\output\myprofile\tree $tree, $user, $iscurrentuser, $course) {
    global $CFG;
    if (empty($CFG->enablestats)) {
        return false;
    }
    if (empty($course)) {
        // We want to display these reports under the site context.
        $course = get_fast_modinfo(SITEID)->get_course();
    }
    if (report_stats_can_access_user_report($user, $course)) {
        $url = new agpu_url('/report/stats/user.php', array('id' => $user->id, 'course' => $course->id));
        $node = new core_user\output\myprofile\node('reports', 'stats', get_string('stats'), null, $url);
        $tree->add_node($node);
    }
}
