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
 * AMD module to handle overriding activity completion status.
 *
 * @module     report_progress/completion_override
 * @copyright  2016 onwards Eiz Eddin Al Katrib <eiz@barasoft.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      3.1
 */
define(['jquery', 'core/ajax', 'core/str', 'core/modal_save_cancel', 'core/modal_events', 'core/notification',
        'core/custom_interaction_events', 'core/templates', 'core/pending'],
    function($, Ajax, Str, ModalSaveCancel, ModalEvents, Notification, CustomEvents, Templates, Pending) {

        /**
         * @var {String} the full name of the current user.
         * @private
         */
        var userFullName;

        /**
         * @var {JQuery} JQuery object containing the element (completion link) that was most recently activated.
         * @private
         */
        var triggerElement;

        /**
         * Helper function to get the pix icon key based on the completion state.
         * @method getIconDescriptorFromState
         * @param {number} state The current completion state.
         * @param {string} tracking The completion tracking type, either 'manual' or 'auto'.
         * @return {string} the key for the respective icon.
         * @private
         */
        var getIconKeyFromState = function(state, tracking) {
            return state > 0 ? 'i/completion-' + tracking + '-y-override' : 'i/completion-' + tracking + '-n-override';
        };

        /**
         * Handles the confirmation of an override change, calling the web service to update it.
         * @method setOverride
         * @param {Object} override the override data
         * @private
         */
        var setOverride = function(override) {
            const pendingPromise = new Pending('report_progress/compeletion_override/setOverride');
            // Generate a loading spinner while we're working.
            Templates.render('core/loading', {}).then(function(html) {
                // Append the loading spinner to the trigger element.
                triggerElement.append(html);

                // Update the completion status override.
                return Ajax.call([{
                    methodname: 'core_completion_override_activity_completion_status',
                    args: override
                }])[0];
            }).then(function(results) {
                var completionState = (results.state > 0) ? 1 : 0;

                // Now, build the new title string, get the new icon, and update the DOM.
                var tooltipKey = completionState ? 'completion-y-override' : 'completion-n-override';
                Str.get_string(tooltipKey, 'completion', userFullName).then(function(stateString) {
                    var params = {
                        state: stateString,
                        date: '',
                        user: triggerElement.attr('data-userfullname'),
                        activity: triggerElement.attr('data-activityname')
                    };
                    return Str.get_string('progress-title', 'completion', params);
                }).then(function(titleString) {
                    var completionTracking = triggerElement.attr('data-completiontracking');
                    return Templates.renderPix(getIconKeyFromState(completionState, completionTracking), 'core', titleString);
                }).then(function(html) {
                    var oppositeState = completionState > 0 ? 0 : 1;
                    triggerElement.find('.loading-icon').remove();
                    triggerElement.data('changecompl', override.userid + '-' + override.cmid + '-' + oppositeState);
                    triggerElement.attr('data-changecompl', override.userid + '-' + override.cmid + '-' + oppositeState);
                    triggerElement.children("img").replaceWith(html);
                    return;
                }).catch(Notification.exception);

                return;
            })
            .then(() => {
                pendingPromise.resolve();
                return;
            }).catch(Notification.exception);
        };

        /**
         * Handler for activation of a completion status button element.
         * @method userConfirm
         * @param {Event} e the CustomEvents event (CustomEvents.events.activate in this case)
         * @param {Object} data an object containing the original event (click, keydown, etc.).
         * @private
         */
        var userConfirm = function(e, data) {
            data.originalEvent.preventDefault();
            data.originalEvent.stopPropagation();
            e.preventDefault();
            e.stopPropagation();

            triggerElement = $(e.currentTarget);
            var elemData = triggerElement.data('changecompl').split('-');
            var override = {
                userid: elemData[0],
                cmid: elemData[1],
                newstate: elemData[2]
            };
            var newStateStr = (override.newstate == 1) ? 'completion-y' : 'completion-n';

            Str.get_strings([
                {key: newStateStr, component: 'completion'}
            ]).then(function(strings) {
                return Str.get_strings([
                    {key: 'confirm', component: 'agpu'},
                    {key: 'areyousureoverridecompletion', component: 'completion', param: strings[0]}
                ]);
            }).then(function(strings) {
                // Create a save/cancel modal.
                return ModalSaveCancel.create({
                    title: strings[0],
                    body: strings[1],
                    show: true,
                    removeOnClose: true,
                });
            }).then(function(modal) {
                // Now set up the handlers for the confirmation or cancellation of the modal, and show it.

                // Confirmation only.
                modal.getRoot().on(ModalEvents.save, function() {
                    setOverride(override);
                });

                return modal;
            }).catch(Notification.exception);
        };

        /**
         * Init this module which allows activity completion state to be changed via ajax.
         * @method init
         * @param {string} fullName The current user's full name.
         * @private
         */
        var init = function(fullName) {
            userFullName = fullName;

            // Register the click, space and enter events as activators for the trigger element.
            $('#completion-progress a.changecompl').each(function(index, element) {
                CustomEvents.define(element, [CustomEvents.events.activate]);
            });

            // Set the handler on the parent element (the table), but filter so the callback is only called for <a> type children
            // having the '.changecompl' class. The <a> element can then be accessed in the callback via e.currentTarget.
            $('#completion-progress').on(CustomEvents.events.activate, "a.changecompl", function(e, data) {
                userConfirm(e, data);
            });
        };

        return /** @alias module:report_progress/completion_override */ {
            init: init
        };
    });
