
// This file is part of agpu - http://agpu.org/ //
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
 * SMS gateway selection handler.
 *
 * @module     core_sms/smsgatewaychooser
 * @copyright  2024 Safat Shahin <safat.shahin@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

const Selectors = {
    fields: {
        selector: '[data-smsgatewaychooser-field="selector"]',
        updateButton: '[data-smsgatewaychooser-field="updateButton"]',
    },
};

/**
 * Initialise the sms gateway chooser.
 */
export const init = () => {
    document.querySelector(Selectors.fields.selector)?.addEventListener('change', e => {
        const form = e.target.closest('form');
        const updateButton = form.querySelector(Selectors.fields.updateButton);
        const url = new URL(form.action);

        form.action = url.toString();
        updateButton.click();
    });
};
