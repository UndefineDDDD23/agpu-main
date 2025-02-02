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
 * A javascript module to enhance the override form.
 *
 * @copyright  2019 Ryan Wyllie <ryan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import $ from 'jquery';
import * as FormChangeChecker from 'core_form/changechecker';

export const init = (formId, selectElementName) => {
    const form = document.getElementById(formId);
    const selectElement = form.querySelector(`[name="${selectElementName}"]`);

    $(selectElement).on('change', () => {
        const inputElement = document.createElement('input');
        inputElement.setAttribute('type', 'hidden');
        inputElement.setAttribute('name', 'userchange');
        inputElement.setAttribute('value', true);

        form.appendChild(inputElement);

        FormChangeChecker.markFormSubmitted(inputElement);

        form.submit();
    });
};
