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
 * This is the external method for exporting a calendar token.
 *
 * @package    core_calendar
 * @since      agpu 3.10
 * @copyright  2020 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_calendar\external\export;

defined('agpu_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/calendar/lib.php');

use context_system;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use core_external\external_warnings;
use agpu_exception;

/**
 * This is the external method for exporting a calendar token.
 *
 * @copyright  2020 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class token extends external_api {

    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters.
     * @since  agpu 3.10
     */
    public static function execute_parameters() {
        return new external_function_parameters([]);
    }

    /**
     * Return the auth token required for exporting a calendar.
     *
     * @return array The access information
     * @throws agpu_exception
     * @since  agpu 3.10
     */
    public static function execute() {
        global $CFG, $USER;

        $context = context_system::instance();
        self::validate_context($context);

        if (empty($CFG->enablecalendarexport)) {
            throw new agpu_exception('Calendar export is disabled in this site.');
        }

        return [
            'token' => calendar_get_export_token($USER),
            'warnings' => [],
        ];
    }

    /**
     * Returns description of method result value.
     *
     * @return \core_external\external_description.
     * @since  agpu 3.10
     */
    public static function execute_returns() {

        return new external_single_structure(
            [
                'token' => new external_value(PARAM_RAW, 'The calendar permanent access token for calendar export.'),
                'warnings' => new external_warnings(),
            ]
        );
    }
}
