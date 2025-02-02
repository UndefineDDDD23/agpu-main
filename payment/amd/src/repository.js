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
 * Repository for payment subsystem.
 *
 * @module     core_payment/repository
 * @copyright  2020 Shamim Rezaie <shamim@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Ajax from 'core/ajax';

/**
 * @typedef {Object} PaymentGateway A Payment Gateway
 * @property {string} shortname
 * @property {string} name
 * @property {string} description
 */

/**
 * Returns the list of gateways that can process payments in the given currency.
 *
 * @method getAvailableGateways
 * @param {string} component
 * @param {string} paymentArea
 * @param {number} itemId
 * @returns {Promise<PaymentGateway[]>}
 */
export const getAvailableGateways = (component, paymentArea, itemId) => {
    const request = {
        methodname: 'core_payment_get_available_gateways',
        args: {
            component,
            paymentarea: paymentArea,
            itemid: itemId,
        }
    };
    return Ajax.call([request])[0];
};
