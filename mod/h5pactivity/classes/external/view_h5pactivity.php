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

namespace mod_h5pactivity\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use core_external\external_warnings;
use context_module;
use mod_h5pactivity\local\manager;

/**
 * This is the external method for triggering the course module viewed event.
 *
 * @package    mod_h5pactivity
 * @since      agpu 3.9
 * @copyright  2020 Carlos Escobedo <carlos@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class view_h5pactivity extends external_api {
    /**
     * Parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'h5pactivityid' => new external_value(PARAM_INT, 'H5P activity instance id')
            ]
        );
    }

    /**
     * Trigger the course module viewed event and update the module completion status.
     *
     * @param  int $h5pactivityid The h5p activity id.
     * @return array of warnings and the access information
     * @since agpu 3.9
     * @throws  agpu_exception
     */
    public static function execute(int $h5pactivityid): array {

        $params = external_api::validate_parameters(self::execute_parameters(), [
            'h5pactivityid' => $h5pactivityid
        ]);
        $warnings = [];

        // Request and permission validation.
        list($course, $cm) = get_course_and_cm_from_instance($params['h5pactivityid'], 'h5pactivity');

        $context = context_module::instance($cm->id);
        self::validate_context($context);

        $manager = manager::create_from_coursemodule($cm);
        $manager->set_module_viewed($course);

        $result = array(
            'status' => true,
            'warnings' => $warnings,
        );
        return $result;
    }

    /**
     * Describes the view_h5pactivity return value.
     *
     * @return external_single_structure
     * @since agpu 3.9
     */
    public static function execute_returns() {
        return new external_single_structure(
            [
                'status' => new external_value(PARAM_BOOL, 'status: true if success'),
                'warnings' => new external_warnings()
            ]
        );
    }
}
