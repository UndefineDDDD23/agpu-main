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
 * Event vault interface
 *
 * @package    core_calendar
 * @copyright  2017 Ryan Wyllie <ryan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_calendar\local\event\data_access;

defined('agpu_INTERNAL') || die();

use core_calendar\local\event\entities\event_interface;

/**
 * Interface for an event vault class
 *
 * @copyright  2017 Ryan Wyllie <ryan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
interface event_vault_interface {
    /**
     * Retrieve an event for the given id.
     *
     * @param int $id The event id
     * @return event_interface|false
     */
    public function get_event_by_id($id);

    /**
     * Get all events restricted by various parameters, taking in to account user and group overrides.
     *
     * @param int|null              $timestartfrom         Events with timestart from this value (inclusive).
     * @param int|null              $timestartto           Events with timestart until this value (inclusive).
     * @param int|null              $timesortfrom          Events with timesort from this value (inclusive).
     * @param int|null              $timesortto            Events with timesort until this value (inclusive).
     * @param event_interface|null  $timestartafterevent   Restrict the events in the timestart range to ones after this one.
     * @param event_interface|null  $timesortafterevent    Restrict the events in the timesort range to ones after this one.
     * @param int                   $limitnum              Return at most this number of events.
     * @param int|null              $type                  Return only events of this type.
     * @param array|null            $usersfilter           Return only events for these users.
     * @param array|null            $groupsfilter          Return only events for these groups.
     * @param array|null            $coursesfilter         Return only events for these courses.
     * @param bool                  $withduration          If true return only events starting within specified
     *                                                     timestart otherwise return in progress events as well.
     * @param bool                  $ignorehidden          If true don't return hidden events.
     * @param callable|null         $filter                Additional logic to filter out unwanted events.
     *                                                     Must return true to keep the event, false to discard it.
     * @param string|null           $searchvalue          The value a user wishes to search against
     * @return event_interface[] Array of event_interfaces.
     */
    public function get_events(
        $timestartfrom = null,
        $timestartto = null,
        $timesortfrom = null,
        $timesortto = null,
        ?event_interface $timestartafterevent = null,
        ?event_interface $timesortafterevent = null,
        $limitnum = 20,
        $type = null,
        ?array $usersfilter = null,
        ?array $groupsfilter = null,
        ?array $coursesfilter = null,
        ?array $categoriesfilter = null,
        $withduration = true,
        $ignorehidden = true,
        ?callable $filter = null,
        ?string $searchvalue = null
    );

    /**
     * Retrieve an array of events for the given user and time constraints.
     *
     * If using this function for pagination then you can provide the last event that you've seen
     * ($afterevent) and it will be used to appropriately offset the result set so that you don't
     * receive the same events again.
     * @param \stdClass       $user         The user for whom the events belong
     * @param int             $timesortfrom Events with timesort from this value (inclusive)
     * @param int             $timesortto   Events with timesort until this value (inclusive)
     * @param event_interface $afterevent   Only return events after this one
     * @param int             $limitnum     Return at most this number of events
     * @param bool            $lmittononsuspendedevents Limit course events to courses the user is active in (not suspended).
     * @param string|null     $searchvalue  The value a user wishes to search against
     * @return event_interface
     */
    public function get_action_events_by_timesort(
        \stdClass $user,
        $timesortfrom,
        $timesortto,
        event_interface $afterevent,
        $limitnum,
        $limittononsuspendedevents,
        ?string $searchvalue = null
    );

    /**
     * Retrieve an array of events for the given user filtered by the course and time constraints.
     *
     * If using this function for pagination then you can provide the last event that you've seen
     * ($afterevent) and it will be used to appropriately offset the result set so that you don't
     * receive the same events again.
     *
     * @param \stdClass       $user         The user for whom the events belong
     * @param \stdClass       $course       The course to filter by
     * @param int             $timesortfrom Events with timesort from this value (inclusive)
     * @param int             $timesortto   Events with timesort until this value (inclusive)
     * @param event_interface $afterevent   Only return events after this one
     * @param int             $limitnum     Return at most this number of events
     * @param string|null     $searchvalue  The value a user wishes to search against
     * @return action_event_interface
     */
    public function get_action_events_by_course(
        \stdClass $user,
        \stdClass $course,
        $timesortfrom,
        $timesortto,
        event_interface $afterevent,
        $limitnum,
        ?string $searchvalue = null
    );
}
