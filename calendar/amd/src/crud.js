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
 * A module to handle CRUD operations within the UI.
 *
 * @module     core_calendar/crud
 * @copyright  2017 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([
    'jquery',
    'core/str',
    'core/notification',
    'core/modal_events',
    'core_calendar/modal_event_form',
    'core_calendar/repository',
    'core_calendar/events',
    'core_calendar/modal_delete',
    'core_calendar/selectors',
    'core/pending',
    'core/modal_save_cancel',
    'core/config',
],
function(
    $,
    Str,
    Notification,
    ModalEvents,
    ModalEventForm,
    CalendarRepository,
    CalendarEvents,
    CalendarModalDelete,
    CalendarSelectors,
    Pending,
    ModalSaveCancel,
    Config,
) {

    /**
     * Prepares the action for the summary modal's delete action.
     *
     * @param {Number} eventId The ID of the event.
     * @param {string} eventTitle The event title.
     * @param {Number} eventCount The number of events in the series.
     * @return {Promise}
     */
    function confirmDeletion(eventId, eventTitle, eventCount) {
        var pendingPromise = new Pending('core_calendar/crud:confirmDeletion');
        var deleteStrings = [
            {
                key: 'deleteevent',
                component: 'calendar'
            },
        ];

        eventCount = parseInt(eventCount, 10);
        var deletePromise;
        var isRepeatedEvent = eventCount > 1;
        if (isRepeatedEvent) {
            deleteStrings.push({
                key: 'confirmeventseriesdelete',
                component: 'calendar',
                param: {
                    name: eventTitle,
                    count: eventCount,
                },
            });

            deletePromise = CalendarModalDelete.create();
        } else {
            deleteStrings.push({
                key: 'confirmeventdelete',
                component: 'calendar',
                param: eventTitle
            });


            deletePromise = ModalSaveCancel.create();
        }

        var stringsPromise = Str.get_strings(deleteStrings);

        var finalPromise = $.when(stringsPromise, deletePromise)
        .then(function(strings, deleteModal) {
            deleteModal.setRemoveOnClose(true);
            deleteModal.setTitle(strings[0]);
            deleteModal.setBody(strings[1]);
            if (!isRepeatedEvent) {
                deleteModal.setSaveButtonText(strings[0]);
            }

            deleteModal.show();

            deleteModal.getRoot().on(ModalEvents.save, function() {
                var pendingPromise = new Pending('calendar/crud:initModal:deletedevent');
                CalendarRepository.deleteEvent(eventId, false)
                    .then(function() {
                        $('body').trigger(CalendarEvents.deleted, [eventId, false]);
                        return;
                    })
                    .then(pendingPromise.resolve)
                    .catch(Notification.exception);
            });

            deleteModal.getRoot().on(CalendarEvents.deleteAll, function() {
                var pendingPromise = new Pending('calendar/crud:initModal:deletedallevent');
                CalendarRepository.deleteEvent(eventId, true)
                    .then(function() {
                        $('body').trigger(CalendarEvents.deleted, [eventId, true]);
                        return;
                    })
                    .then(pendingPromise.resolve)
                    .catch(Notification.exception);
            });

            return deleteModal;
        })
        .then(function(modal) {
            pendingPromise.resolve();

            return modal;
        })
        .catch(Notification.exception);

        return finalPromise;
    }

    /**
     * Create the event form modal for creating new events and
     * editing existing events.
     *
     * @method registerEventFormModal
     * @param {object} root The calendar root element
     * @return {object} The create modal promise
     */
    var registerEventFormModal = function(root) {
        var eventFormPromise = ModalEventForm.create();

        // Bind click event on the new event button.
        root.on('click', CalendarSelectors.actions.create, function(e) {
            eventFormPromise.then(function(modal) {
                var wrapper = root.find(CalendarSelectors.wrapper);

                var categoryId = wrapper.data('categoryid');
                const courseId = wrapper.data('courseid');
                if (typeof categoryId !== 'undefined' && courseId != Config.siteId) {
                    modal.setCategoryId(categoryId);
                }

                // Attempt to find the cell for today.
                // If it can't be found, then use the start time of the first day on the calendar.
                var today = root.find(CalendarSelectors.today);
                var firstDay = root.find(CalendarSelectors.day);
                if (!today.length && firstDay.length) {
                    modal.setStartTime(firstDay.data('newEventTimestamp'));
                }

                modal.setContextId(wrapper.data('contextId'));
                modal.setCourseId(wrapper.data('courseid'));
                modal.show();
                return;
            })
            .catch(Notification.exception);

            e.preventDefault();
        });

        root.on('click', CalendarSelectors.actions.edit, function(e) {
            e.preventDefault();
            var target = $(e.currentTarget),
                calendarWrapper = target.closest(CalendarSelectors.wrapper),
                eventWrapper = target.closest(CalendarSelectors.eventItem);

            eventFormPromise.then(function(modal) {
                // When something within the calendar tells us the user wants
                // to edit an event then show the event form modal.
                modal.setEventId(eventWrapper.data('eventId'));

                modal.setContextId(calendarWrapper.data('contextId'));
                modal.setCourseId(eventWrapper.data('courseId'));
                modal.show();

                e.stopImmediatePropagation();
                return;
            }).catch(Notification.exception);
        });


        return eventFormPromise;
    };
    /**
     * Register the listeners required to remove the event.
     *
     * @param   {jQuery} root
     */
    function registerRemove(root) {
        root.on('click', CalendarSelectors.actions.remove, function(e) {
            // Fetch the event title, count, and pass them into the new dialogue.
            var eventSource = $(this).closest(CalendarSelectors.eventItem);
            var eventId = eventSource.data('eventId'),
                eventTitle = eventSource.data('eventTitle'),
                eventCount = eventSource.data('eventCount');
            confirmDeletion(eventId, eventTitle, eventCount);

            e.preventDefault();
        });
    }

    /**
     * Register the listeners required to edit the event.
     *
     * @param   {jQuery} root
     * @param   {Promise} eventFormModalPromise
     * @returns {Promise}
     */
    function registerEditListeners(root, eventFormModalPromise) {
        var pendingPromise = new Pending('core_calendar/crud:registerEditListeners');

        return eventFormModalPromise
        .then(function(modal) {
            // When something within the calendar tells us the user wants
            // to edit an event then show the event form modal.
            $('body').on(CalendarEvents.editEvent, function(e, eventId) {
                var target = root.find(`[data-event-id=${eventId}]`),
                    calendarWrapper = root.find(CalendarSelectors.wrapper);

                modal.setEventId(eventId);
                modal.setContextId(calendarWrapper.data('contextId'));
                modal.setReturnElement(target);
                modal.show();

                e.stopImmediatePropagation();
            });
            return modal;
        })
        .then(function(modal) {
            pendingPromise.resolve();

            return modal;
        })
        .catch(Notification.exception);
    }

    return {
        registerRemove: registerRemove,
        registerEditListeners: registerEditListeners,
        registerEventFormModal: registerEventFormModal
    };
});
