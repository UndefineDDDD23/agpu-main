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
 * Define all of the selectors we will be using on the grading interface.
 *
 * @module     gradereport_singleview/selectors
 * @copyright  2022 Ilya Tregubov <ilya@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * A small helper function to build queryable data selectors.
 * @method getDataSelector
 * @param {String} name
 * @param {String} value
 * @return {string}
 */
const getDataSelector = (name, value) => {
    return `[data-${name}="${value}"]`;
};

export default {
    actions: {
        bulkaction: getDataSelector('role', 'bulkaction'),
    },
    elements: {
        override: 'input[type=checkbox][name^=override]',
        exclude: 'input[type=checkbox][name^=exclude]',
        modalsave: '[data-action="save"]',
        warningcheckbox: 'input[type="checkbox"]',
        modalformdata: '.formdata',
        modalradio: 'input[type="radio"]',
        modalinput: 'input[type="text"]',
        modalradiochecked: 'input[type="radio"]:checked',
        enablebulkinsert: 'input[type="checkbox"][name^=bulk]',
        formradio: 'select[name^=bulk]',
        modalgrade: '.form-control',
        formgrade: 'input[type="text"][name^=bulk]',
        formsave: 'input[type="submit"]',
    },
};
