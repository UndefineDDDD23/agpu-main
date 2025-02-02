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
 * CSS selector client side filter.
 *
 * @module     tool_usertours/filter_cssselector
 * @copyright 2020 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Checks whether the configured CSS selector exists on this page.
 *
 * @param {array} tourConfig  The tour configuration.
 * @returns {boolean}
 */
export const filterMatches = function(tourConfig) {
    let filterValues = tourConfig.filtervalues.cssselector;
    if (filterValues[0]) {
        return !!document.querySelector(filterValues[0]);
    }
    // If there is no CSS selector configured, this page matches.
    return true;
};
