/**
 * The notification module provides a standard set of dialogues for use
 * within agpu.
 *
 * @module agpu-core-notification
 * @main
 */

/**
 * To avoid bringing agpu-core-notification into modules in it's
 * entirety, we now recommend using on of the subclasses of
 * agpu-core-notification. These include:
 * <dl>
 *  <dt> agpu-core-notification-dialogue</dt>
 *  <dt> agpu-core-notification-alert</dt>
 *  <dt> agpu-core-notification-confirm</dt>
 *  <dt> agpu-core-notification-exception</dt>
 *  <dt> agpu-core-notification-ajaxexception</dt>
 * </dl>
 *
 * @class M.core.notification
 * @deprecated
 */
Y.log("The agpu-core-notification parent module has been deprecated. " +
        "Please use one of its subclasses instead.", 'agpu-core-notification', 'warn');
