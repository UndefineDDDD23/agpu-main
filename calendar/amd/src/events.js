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
 * Contain the events the calendar component can fire.
 *
 * @module     core_calendar/events
 * @copyright  2017 Simey Lameze <simey@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
export default {
    created: 'calendar-events:created',
    deleted: 'calendar-events:deleted',
    deleteAll: 'calendar-events:delete_all',
    updated: 'calendar-events:updated',
    editEvent: 'calendar-events:edit_event',
    editActionEvent: 'calendar-events:edit_action_event',
    eventMoved: 'calendar-events:event_moved',
    dayChanged: 'calendar-events:day_changed',
    monthChanged: 'calendar-events:month_changed',
    moveEvent: 'calendar-events:move_event',
    filterChanged: 'calendar-events:filter_changed',
    courseChanged: 'calendar-events:course_changed',
    viewUpdated: 'calendar-events:view_updated',
};
