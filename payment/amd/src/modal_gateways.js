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
 * Contain the logic for the gateways modal: A modal with proceed and cancel buttons.
 *
 * @module     core_payment/modal_gateways
 * @copyright  2020 Shamim Rezaie <shamim@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import $ from 'jquery';
import CustomEvents from 'core/custom_interaction_events';
import Modal from 'core/modal';
import ModalEvents from 'core/modal_events';
import PaymentEvents from 'core_payment/events';

const SELECTORS = {
    PROCEED_BUTTON: '[data-action="proceed"]',
    CANCEL_BUTTON: '[data-action="cancel"]',
};

export default class ModalGateways extends Modal {
    static TYPE = 'core_payment-modal_gateways';
    static TEMPLATE = 'core_payment/modal_gateways';

    /**
     * Constructor for the Modal.
     *
     * @param {object} root The root jQuery element for the modal
     */
    constructor(root) {
        super(root);
    }

    /**
     * Set up all of the event handling for the modal.
     *
     * @method registerEventListeners
     */
    registerEventListeners() {
        // Apply parent event listeners.
        super.registerEventListeners();

        this.getModal().on(CustomEvents.events.activate, SELECTORS.PROCEED_BUTTON, (e, data) => {
            var proceedEvent = $.Event(PaymentEvents.proceed);
            this.getRoot().trigger(proceedEvent, this);

            if (!proceedEvent.isDefaultPrevented()) {
                this.hide();
                data.originalEvent.preventDefault();
            }
        });

        this.getModal().on(CustomEvents.events.activate, SELECTORS.CANCEL_BUTTON, (e, data) => {
            var cancelEvent = $.Event(ModalEvents.cancel);
            this.getRoot().trigger(cancelEvent, this);

            if (!cancelEvent.isDefaultPrevented()) {
                this.hide();
                data.originalEvent.preventDefault();
            }
        });
    }
}

ModalGateways.registerModalType();
