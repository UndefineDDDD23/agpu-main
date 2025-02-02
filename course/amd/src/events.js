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
 * Contain the events the course component can trigger.
 *
 * @module     core_course/events
 * @copyright  2018 Simey Lameze <simey@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
export default {
    favourited: 'core_course:favourited',
    unfavorited: 'core_course:unfavorited',
    manualCompletionToggled: 'core_course:manualcompletiontoggled',
    stateChanged: 'core_course:stateChanged',
    sectionRefreshed: 'core_course:sectionRefreshed',
};
