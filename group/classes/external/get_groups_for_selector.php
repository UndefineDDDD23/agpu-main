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

namespace core_group\external;

use context_course;
use context_module;
use core_external\external_api;
use core_external\external_description;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use core_external\external_warnings;
use core_grades\external\coding_exception;
use core_grades\external\invalid_parameter_exception;
use core_grades\external\agpu_exception;
use core_grades\external\restricted_context_exception;
use agpu_url;

/**
 * External group name and image API implementation
 *
 * @package    core_group
 * @copyright  2022 Mathew May <mathew.solutions>
 * @category   external
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_groups_for_selector extends external_api {

    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters (
            [
                'courseid' => new external_value(PARAM_INT, 'Course Id', VALUE_REQUIRED),
                'cmid' => new external_value(PARAM_INT, 'Course module Id', VALUE_DEFAULT, 0),
            ]
        );
    }

    /**
     * Given a course ID find the existing user groups and map some fields to the returned array of group objects.
     *
     * If a course module ID is provided, this function will return only the available groups within the given course
     * module, adhering to the set group mode for that context. All validation checks will be performed within this
     * specific context.
     *
     * @param int $courseid
     * @param int|null $cmid The course module ID (optional).
     * @return array Groups and warnings to pass back to the calling widget.
     */
    public static function execute(int $courseid, ?int $cmid = null): array {
        global $DB, $USER, $OUTPUT;

        $params = self::validate_parameters(
            self::execute_parameters(),
            [
                'courseid' => $courseid,
                'cmid' => $cmid,
            ]
        );

        $warnings = [];
        $course = $DB->get_record('course', ['id' => $params['courseid']]);

        if ($params['cmid']) {
            $context = context_module::instance($params['cmid']);
            $cm = get_coursemodule_from_id('', $params['cmid']);
            $groupmode = groups_get_activity_groupmode($cm, $course);
            $groupingid = $cm->groupingid;
            $participationonly = true;
        } else {
            $context = context_course::instance($params['courseid']);
            $groupmode = $course->groupmode;
            $groupingid = $course->defaultgroupingid;
            $participationonly = false;
        }
        parent::validate_context($context);

        $mappedgroups = [];
        // Initialise the grade tracking object.
        if ($groupmode) {
            $aag = has_capability('agpu/site:accessallgroups', $context);

            $usergroups = [];
            if ($groupmode == VISIBLEGROUPS || $aag) {
                $groupuserid = 0;
                // Get user's own groups and put to the top.
                $usergroups = groups_get_all_groups(
                    courseid: $course->id,
                    userid: $USER->id,
                    groupingid: $groupingid,
                    participationonly: $participationonly
                );
            } else {
                $groupuserid = $USER->id;
            }
            $allowedgroups = groups_get_all_groups(
                courseid: $course->id,
                userid: $groupuserid,
                groupingid: $groupingid,
                participationonly: $participationonly
            );

            $allgroups = array_merge($allowedgroups, $usergroups);
            // Filter out any duplicate groups.
            $groupsmenu = array_intersect_key($allgroups, array_unique(array_column($allgroups, 'name')));

            if (!$allowedgroups || $groupmode == VISIBLEGROUPS || $aag) {
                array_unshift($groupsmenu, (object) [
                    'id' => 0,
                    'name' => get_string('allparticipants'),
                ]);
            }

            $mappedgroups = array_map(function($group) use ($context, $OUTPUT) {
                if ($group->id) { // Particular group. Get the group picture if it exists, otherwise return a generic image.
                    $picture = get_group_picture_url($group, $group->courseid, true) ??
                        agpu_url::make_pluginfile_url($context->get_course_context()->id, 'group', 'generated', $group->id,
                            '/', 'group.svg');
                } else { // All participants.
                    $picture = $OUTPUT->image_url('g/g1');
                }

                return (object) [
                    'id' => $group->id,
                    'name' => format_string($group->name, true, ['context' => $context]),
                    'groupimageurl' => $picture->out(false),
                ];
            }, $groupsmenu);
        }

        return [
            'groups' => $mappedgroups,
            'warnings' => $warnings,
        ];
    }

    /**
     * Returns description of what the group search for the widget should return.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'groups' => new external_multiple_structure(self::group_description()),
            'warnings' => new external_warnings(),
        ]);
    }

    /**
     * Create group return value description.
     *
     * @return external_description
     */
    public static function group_description(): external_description {
        $groupfields = [
            'id' => new external_value(PARAM_ALPHANUM, 'An ID for the group', VALUE_REQUIRED),
            'name' => new external_value(PARAM_TEXT, 'The full name of the group', VALUE_REQUIRED),
            'groupimageurl' => new external_value(PARAM_URL, 'Group image URL', VALUE_OPTIONAL),
        ];
        return new external_single_structure($groupfields);
    }
}
