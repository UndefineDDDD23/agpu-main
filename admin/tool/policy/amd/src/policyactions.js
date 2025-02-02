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
 * Policy actions.
 *
 * @module     tool_policy/policyactions
 * @copyright  2018 Sara Arjona (sara@agpu.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([
    'jquery',
    'core/ajax',
    'core/notification',
    'core/modal',
], function($, Ajax, Notification, Modal) {

    /**
     * PolicyActions class.
     *
     * @param {jQuery} root
     */
    var PolicyActions = function(root) {
        this.registerEvents(root);
    };

    /**
     * Register event listeners.
     *
     * @param {jQuery} root
     */
    PolicyActions.prototype.registerEvents = function(root) {
        root.on("click", function(e) {
            e.preventDefault();

            var versionid = $(this).data('versionid');
            var behalfid = $(this).data('behalfid');

            var params = {
                'versionid': versionid,
                'behalfid': behalfid
            };

            var request = {
                methodname: 'tool_policy_get_policy_version',
                args: params
            };

            var modalTitle = $.Deferred();
            var modalBody = $.Deferred();

            var modal = Modal.create({
                title: modalTitle,
                body: modalBody,
                large: true,
                removeOnClose: true,
                show: true,
            })
            .catch(Notification.exception);

            // Make the request now that the modal is configured.
            var promises = Ajax.call([request]);
            $.when(promises[0]).then(function(data) {
                if (data.result.policy) {
                    modalTitle.resolve(data.result.policy.name);
                    modalBody.resolve(data.result.policy.content);

                    return data;
                } else {
                    throw new Error(data.warnings[0].message);
                }
            }).catch(function(message) {
                modal.then(function(modal) {
                    modal.hide();

                    return modal;
                })
                .catch(Notification.exception);

                return Notification.addNotification({
                    message: message,
                    type: 'error'
                });
            });
        });

    };

    return /** @alias module:tool_policy/policyactions */ {
        // Public variables and functions.

        /**
         * Initialise the actions helper.
         *
         * @method init
         * @param {object} root
         * @return {PolicyActions}
         */
        'init': function(root) {
            root = $(root);
            return new PolicyActions(root);
        }
    };
});
