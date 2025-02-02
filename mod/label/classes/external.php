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
 * Label external API
 *
 * @package    mod_label
 * @category   external
 * @copyright  2017 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      agpu 3.3
 */

use core_course\external\helper_for_get_mods_by_courses;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use core_external\external_warnings;
use core_external\util;

/**
 * Label external functions
 *
 * @package    mod_label
 * @category   external
 * @copyright  2017 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      agpu 3.3
 */
class mod_label_external extends external_api {

    /**
     * Describes the parameters for get_labels_by_courses.
     *
     * @return external_function_parameters
     * @since agpu 3.3
     */
    public static function get_labels_by_courses_parameters() {
        return new external_function_parameters (
            array(
                'courseids' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'Course id'), 'Array of course ids', VALUE_DEFAULT, array()
                ),
            )
        );
    }

    /**
     * Returns a list of labels in a provided list of courses.
     * If no list is provided all labels that the user can view will be returned.
     *
     * @param array $courseids course ids
     * @return array of warnings and labels
     * @since agpu 3.3
     */
    public static function get_labels_by_courses($courseids = array()) {

        $warnings = array();
        $returnedlabels = array();

        $params = array(
            'courseids' => $courseids,
        );
        $params = self::validate_parameters(self::get_labels_by_courses_parameters(), $params);

        $mycourses = array();
        if (empty($params['courseids'])) {
            $mycourses = enrol_get_my_courses();
            $params['courseids'] = array_keys($mycourses);
        }

        // Ensure there are courseids to loop through.
        if (!empty($params['courseids'])) {

            list($courses, $warnings) = util::validate_courses($params['courseids'], $mycourses);

            // Get the labels in this course, this function checks users visibility permissions.
            // We can avoid then additional validate_context calls.
            $labels = get_all_instances_in_courses("label", $courses);
            foreach ($labels as $label) {
                helper_for_get_mods_by_courses::format_name_and_intro($label, 'mod_label');
                $returnedlabels[] = $label;
            }
        }

        $result = array(
            'labels' => $returnedlabels,
            'warnings' => $warnings
        );
        return $result;
    }

    /**
     * Describes the get_labels_by_courses return value.
     *
     * @return external_single_structure
     * @since agpu 3.3
     */
    public static function get_labels_by_courses_returns() {
        return new external_single_structure(
            array(
                'labels' => new external_multiple_structure(
                    new external_single_structure(array_merge(
                        helper_for_get_mods_by_courses::standard_coursemodule_elements_returns(),
                        [
                            'timemodified' => new external_value(PARAM_INT, 'Last time the label was modified'),
                        ]
                    ))
                ),
                'warnings' => new external_warnings(),
            )
        );
    }
}
