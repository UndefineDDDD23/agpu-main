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

namespace core_xapi\external;

use core_xapi\local\state;
use core_xapi\local\statement\item_activity;
use core_xapi\handler;
use core_xapi\xapi_exception;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;
use core_xapi\iri;

/**
 * This is the external API for generic xAPI state get.
 *
 * @package    core_xapi
 * @since      agpu 4.2
 * @copyright  2023 Ferran Recio
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_state extends external_api {

    use \core_xapi\local\helper\state_trait;

    /**
     * Parameters for execute
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'component' => new external_value(PARAM_COMPONENT, 'Component name'),
            'activityId' => new external_value(PARAM_URL, 'xAPI activity ID IRI'),
            'agent' => new external_value(PARAM_RAW, 'The xAPI agent json'),
            'stateId' => new external_value(PARAM_ALPHAEXT, 'The xAPI state ID'),
            'registration' => new external_value(PARAM_ALPHANUMEXT, 'The xAPI registration UUID', VALUE_DEFAULT, null),
        ]);
    }

    /**
     * Process a get state request.
     *
     * @param string $component The component name in frankenstyle.
     * @param string $activityiri The activity IRI.
     * @param string $agent The agent JSON.
     * @param string $stateid The xAPI state id.
     * @param string|null $registration The xAPI registration UUID.
     * @return string|null
     */
    public static function execute(
        string $component,
        string $activityiri,
        string $agent,
        string $stateid,
        ?string $registration = null
    ): ?string {

        $params = self::validate_parameters(self::execute_parameters(), [
            'component' => $component,
            'activityId' => $activityiri,
            'agent' => $agent,
            'stateId' => $stateid,
            'registration' => $registration,
        ]);
        [
            'component' => $component,
            'activityId' => $activityiri,
            'agent' => $agent,
            'stateId' => $stateid,
            'registration' => $registration,
        ] = $params;

        static::validate_component($component);

        $handler = handler::create($component);
        $activityid = iri::extract($activityiri, 'activity');

        $state = new state(
            self::get_agent_from_json($agent),
            item_activity::create_from_id($activityid),
            $stateid,
            null,
            $registration
        );

        if (!self::check_state_user($state)) {
            throw new xapi_exception('State agent is not the current user');
        }

        $result = $handler->load_state($state);
        if ($result !== null) {
            return json_encode($result);
        }

        return $result;
    }

    /**
     * Return for execute.
     */
    public static function execute_returns(): external_value {
        return new external_value(PARAM_RAW, 'The state data json');
    }
}
