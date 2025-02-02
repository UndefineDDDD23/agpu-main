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
 * This class contains a list of webservice functions related to session.
 *
 * @package    core
 * @copyright  2019 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\session;

use core_external\external_api;
use core_external\external_description;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;

/**
 * This class contains a list of webservice functions related to session.
 *
 * @copyright  2019 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      2.9
 */
class external extends external_api {

    /**
     * Returns description of touch_session() parameters.
     *
     * @return external_function_parameters
     */
    public static function touch_session_parameters() {
        return new external_function_parameters([]);
    }

    /**
     * Extend the current session.
     *
     * @return array the mapping
     */
    public static function touch_session() {
        \core\session\manager::touch_session(session_id());
        return true;
    }

    /**
     * Returns description of touch_session() result value.
     *
     * @return external_description
     */
    public static function touch_session_returns() {
        return new external_value(PARAM_BOOL, 'result');
    }

    /**
     * Returns description of time_remaining() parameters.
     *
     * @return external_function_parameters
     */
    public static function time_remaining_parameters() {
        return new external_function_parameters([]);
    }

    /**
     * Extend the current session.
     *
     * @return array the mapping
     */
    public static function time_remaining() {
        return \core\session\manager::time_remaining(session_id());
    }

    /**
     * Returns description of touch_session() result value.
     *
     * @return external_description
     */
    public static function time_remaining_returns() {
        return new external_single_structure([
            'userid' => new external_value(PARAM_INT, 'The current user id.'),
            'timeremaining' => new external_value(PARAM_INT, 'The number of seconds remaining in this session.'),
        ]);
    }
}
