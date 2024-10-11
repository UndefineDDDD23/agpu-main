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
 * A module to handle Share operations of the agpuNet.
 *
 * @module     core/agpunet/send_resource
 * @copyright  2023 Huong Nguyen <huongnv13@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      4.2
 */

import Config from 'core/config';
import {addNotification, exception as displayException} from 'core/notification';
import {getString} from 'core/str';
import Prefetch from "core/prefetch";
import * as Templates from 'core/templates';
import {publish} from 'core/pubsub';
import * as agpuNetService from 'core/agpunet/service';
import SendActivityModal from 'core/agpunet/send_activity_modal';
import * as agpuNetAuthorize from 'core/agpunet/authorize';
import agpuNetEvents from 'core/agpunet/events';

const TYPE_ACTIVITY = "activity";
const TYPE_COURSE = "course";
const TYPE_PARTIAL_COURSE = "partial";

let listenersRegistered = false;
let currentModal;
let siteSupportUrl;
let issuerId;
let courseId;
let resourceId;
let shareFormat;
let type;
let selectedCmIds;

/**
 * Handle send to agpuNet.
 *
 * @param {int} issuerId The OAuth 2 issuer ID.
 * @param {int} resourceId The resource ID, it can be a course or an activity.
 * @param {int} shareFormat The share format.
 */
export const sendToagpuNet = (issuerId, resourceId, shareFormat) => {
    const $modal = currentModal.getModal();
    const modal = $modal[0];
    modal.querySelector('.modal-header').classList.remove('no-border');
    modal.querySelector('.modal-header').classList.add('no-header-text');

    currentModal.setBody(Templates.render('core/agpunet/send_activity_modal_packaging', {}));
    currentModal.hideFooter();

    let infoPromise;
    if (type === TYPE_ACTIVITY) {
        infoPromise = agpuNetService.sendActivity(issuerId, resourceId, shareFormat);
    } else if (type === TYPE_COURSE) {
        infoPromise = agpuNetService.sendCourse(issuerId, resourceId, shareFormat);
    } else if (type === TYPE_PARTIAL_COURSE) {
        if (selectedCmIds.length > 1) {
            infoPromise = agpuNetService.sendPartialCourse(issuerId, resourceId, selectedCmIds, shareFormat);
        } else {
            infoPromise = agpuNetService.sendActivity(issuerId, selectedCmIds[0], shareFormat);
        }
    }
    infoPromise.then(async(data) => {
        const status = data.status;
        const resourceUrl = data.resourceurl;
        return responseFromagpuNet(status, resourceUrl);
    }).catch(displayException);
};

/**
 * Handle response from agpuNet.
 *
 * @param {boolean} status Response status. True if successful.
 * @param {String} resourceUrl Resource URL.
 */
const responseFromagpuNet = (status, resourceUrl = '') => {
    const $modal = currentModal.getModal();
    const modal = $modal[0];
    modal.querySelector('.modal-header').classList.add('no-border');
    currentModal.setBody(Templates.render('core/agpunet/send_activity_modal_done', {
        success: status,
        sitesupporturl: siteSupportUrl,
    }));

    if (status) {
        currentModal.setFooter(Templates.render('core/agpunet/send_activity_modal_footer_view', {
            resourceurl: resourceUrl,
        }));
        currentModal.showFooter();
    }
};

/**
 * Render the modal to send resource to agpuNet.
 *
 * @param {object} data The data of the resource to be shared.
 * @param {array} selectedActivities Selected activities.
 */
const renderModal = async(data, selectedActivities) => {
    if (data.status) {
        siteSupportUrl = data.supportpageurl;
        issuerId = data.issuerid;
        let modalConfig = {
            templateContext: {
                'activitytype': data.type,
                'activityname': data.name,
                'server': data.server,
            }
        };
        if (selectedActivities.length > 0) {
            selectedCmIds = selectedActivities;
        }
        if (selectedActivities.length > 1) {
            modalConfig.templateContext.fullsharing = false;
            modalConfig.templateContext.selectedactivitiesnotice = await getString('agpunet:sharenoticepartialactivitynumber',
                'agpu', selectedActivities.length);
            modalConfig.templateContext.sharenotice = await getString('agpunet:sharenoticepartial', 'agpu');
        } else {
            modalConfig.templateContext.fullsharing = true;
            if (type === TYPE_ACTIVITY || (type === TYPE_PARTIAL_COURSE && selectedActivities.length == 1)) {
                modalConfig.templateContext.sharenotice = await getString('agpunet:sharenoticeactivity', 'agpu');
            } else {
                modalConfig.templateContext.sharenotice = await getString('agpunet:sharenoticecourse', 'agpu');
            }
        }

        return SendActivityModal.create(modalConfig);
    } else {
        return addNotification({
            message: data.warnings[0].message,
            type: 'error'
        });
    }
};

/**
 * Handle modal.
 * @param {string} shareActionType Share action type.
 * @param {array} selectedActivities Selected activities.
 */
export const handleModal = (shareActionType, selectedActivities = []) => {
    const resourceId = Config.contextInstanceId;
    type = shareActionType;

    Promise.resolve(type)
        .then((type) => {
            if (type === TYPE_ACTIVITY) {
                return agpuNetService.getActivityInformation(resourceId);
            } else if (type === TYPE_COURSE) {
                return agpuNetService.getCourseInformation(resourceId);
            } else if (type === TYPE_PARTIAL_COURSE) {
                if (selectedActivities.length > 1) {
                    // Selected more than one activity.
                    return agpuNetService.getCourseInformation(resourceId);
                } else {
                    // Select only one activity. Switch to activity mode.
                    return agpuNetService.getActivityInformation(selectedActivities[0]);
                }
            }
            throw new Error(`Unknown type ${type}`);
        })
        .then((data) => {
            return renderModal(data, selectedActivities);
        })
        .then((modal) => {
            currentModal = modal;
            return currentModal;
        })
        .catch(displayException);
};

/**
 * Register events.
 */
const registerEventListeners = () => {
    document.addEventListener('click', (e) => {
        const shareAction = e.target.closest('[data-action="sendtoagpunet"]');
        const sendAction = e.target.closest('.agpunet-action-buttons [data-action="share"]');
        if (shareAction) {
            e.preventDefault();
            type = shareAction.getAttribute('data-type');
            handleModal(shareAction.getAttribute('data-type'));
        }

        if (sendAction) {
            e.preventDefault();
            publish(agpuNetEvents.agpuNET_SHARE_STARTED, {});
            courseId = Config.courseId;
            resourceId = Config.contextInstanceId;
            shareFormat = 0;
            agpuNetAuthorize.handleAuthorization(issuerId, courseId, resourceId, shareFormat);
        }
    });
};


/**
 * Initialize.
 */
export const init = () => {
    if (!listenersRegistered) {
        Prefetch.prefetchTemplates([
            'core/agpunet/send_activity_modal_base',
            'core/agpunet/send_activity_modal_packaging',
            'core/agpunet/send_activity_modal_done',
            'core/agpunet/send_activity_modal_footer_view',
            'core/agpunet/send_activity_modal_footer_share',
        ]);
        registerEventListeners();
        listenersRegistered = true;
    }
};
