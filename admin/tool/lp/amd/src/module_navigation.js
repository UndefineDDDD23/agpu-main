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
 * Module to navigation between users in a course.
 *
 * @module     tool_lp/module_navigation
 * @copyright  2019 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {

    /**
     * ModuleNavigation
     *
     * @class tool_lp/module_navigation
     * @param {String} moduleSelector The selector of the module element.
     * @param {String} baseUrl The base url for the page (no params).
     * @param {Number} courseId The course id
     * @param {Number} moduleId The activity module (filter)
     */
    var ModuleNavigation = function(moduleSelector, baseUrl, courseId, moduleId) {
        this._baseUrl = baseUrl;
        this._moduleId = moduleId;
        this._courseId = courseId;

        $(moduleSelector).on('change', this._moduleChanged.bind(this));
    };

    /**
     * The module was changed in the select list.
     *
     * @method _moduleChanged
     * @param {Event} e the event
     */
    ModuleNavigation.prototype._moduleChanged = function(e) {
        var newModuleId = $(e.target).val();
        var queryStr = '?mod=' + newModuleId + '&courseid=' + this._courseId;
        document.location = this._baseUrl + queryStr;
    };

    /** @property {Number} The id of the course. */
    ModuleNavigation.prototype._courseId = null;
    /** @property {Number} The id of the module. */
    ModuleNavigation.prototype._moduleId = null;
    /** @property {String} Plugin base url. */
    ModuleNavigation.prototype._baseUrl = null;

    return ModuleNavigation;
});
