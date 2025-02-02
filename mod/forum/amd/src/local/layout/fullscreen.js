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
 * Full screen window layout.
 *
 * @module mod_forum/local/layout/fullscreen
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {addIconToContainer} from 'core/loadingicon';
import {addToastRegion} from 'core/toast';
import * as FocusLockManager from 'core/local/aria/focuslock';

/**
 * Get the composed layout.
 *
 * @method
 * @param {string} templateName
 * @param {object} context
 * @returns {LayoutHelper}
 */

export const createLayout = ({
    fullscreen = true,
    showLoader = false,
    focusOnClose = null,
} = {}) => {
    const container = document.createElement('div');
    document.body.append(container);
    container.classList.add('layout');
    container.classList.add('fullscreen');
    container.setAttribute('role', 'application');
    addToastRegion(container);

    // Lock scrolling on the document body.
    lockBodyScroll();

    // Lock tab control.
    FocusLockManager.trapFocus(container);

    const helpers = getLayoutHelpers(container, FocusLockManager, focusOnClose);

    if (showLoader) {
        helpers.showLoadingIcon();
    }

    if (fullscreen) {
        helpers.requestFullscreen();
    }

    return helpers;
};

/**
 * LayoutHelper A helper object containing functions for managing the current fullscreen layout
 *
 * @typedef {object}
 * @property {Function} close A function to close the fullscreen layout
 * @property {Function} toggleFullscreen A function to toggle the fullscreen from active to disabled and back
 * @property {Function} requestFullscreen Make a request to the browser to make the window full screen.
 * Note: This must be called in response to a direct user action
 * @property {Function} exitFullscreen Exit the fullscreen mode
 * @property {Function} getContainer Get the container of the fullscreen layout
 * @property {Function} setContent Set the content of the fullscreen layout
 * @property {Function} showLoadingIcon Display the loading icon
 * @property {Function} hideLoadingIcon Hide the loading icon
 */

/**
 * Get the layout helpers.
 *
 * @method
 * @private
 * @param {HTMLElement} layoutNode
 * @param {FocusLockManager} FocusLockManager
 * @param {Boolean} focusOnClose
 * @returns {LayoutHelper}
 */
const getLayoutHelpers = (layoutNode, FocusLockManager, focusOnClose) => {
    const contentNode = document.createElement('div');
    layoutNode.append(contentNode);

    const loadingNode = document.createElement('div');
    layoutNode.append(loadingNode);

    /**
     * Close and destroy the window container.
     */
    const close = () => {
        exitFullscreen();
        unlockBodyScroll();
        FocusLockManager.untrapFocus();

        layoutNode.remove();

        if (focusOnClose) {
            try {
                focusOnClose.focus();
            } catch (e) {
                // eslint-disable-line
            }
        }
    };

    /**
     * Attempt to make the conatiner full screen.
     */
    const requestFullscreen = () => {
        if (layoutNode.requestFullscreen) {
            layoutNode.requestFullscreen();
        } else if (layoutNode.msRequestFullscreen) {
            layoutNode.msRequestFullscreen();
        } else if (layoutNode.mozRequestFullscreen) {
            layoutNode.mozRequestFullscreen();
        } else if (layoutNode.webkitRequestFullscreen) {
            layoutNode.webkitRequestFullscreen();
        } else {
            // Not supported.
            // Hack to make this act like full-screen as much as possible.
            layoutNode.setTop(0);
        }
    };

    /**
     * Exit full screen but do not close the container fully.
     */
    const exitFullscreen = () => {
        if (document.exitRequestFullScreen) {
            if (document.fullScreenElement !== layoutNode) {
                return;
            }
            document.exitRequestFullScreen();
        } else if (document.msExitFullscreen) {
            if (document.msFullscreenElement !== layoutNode) {
                return;
            }
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            if (document.mozFullScreenElement !== layoutNode) {
                return;
            }
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            if (document.webkitFullscreenElement !== layoutNode) {
                return;
            }
            document.webkitExitFullscreen();
        }
    };

    const toggleFullscreen = () => {
        if (document.exitRequestFullScreen) {
            if (document.fullScreenElement === layoutNode) {
                exitFullscreen();
            } else {
                requestFullscreen();
            }
        } else if (document.msExitFullscreen) {
            if (document.msFullscreenElement === layoutNode) {
                exitFullscreen();
            } else {
                requestFullscreen();
            }
        } else if (document.mozCancelFullScreen) {
            if (document.mozFullScreenElement === layoutNode) {
                exitFullscreen();
            } else {
                requestFullscreen();
            }
        } else if (document.webkitExitFullscreen) {
            if (document.webkitFullscreenElement === layoutNode) {
                exitFullscreen();
            } else {
                requestFullscreen();
            }
        }
    };

    /**
     * Get the Node which is fullscreen.
     *
     * @return {Element}
     */
    const getContainer = () => {
        return contentNode;
    };

    const setContent = (content) => {
        hideLoadingIcon();

        // Note: It would be better to use replaceWith, but this is not compatible with IE.
        let child = contentNode.lastElementChild;
        while (child) {
            contentNode.removeChild(child);
            child = contentNode.lastElementChild;
        }
        contentNode.append(content);
    };

    const showLoadingIcon = () => {
        addIconToContainer(loadingNode);
    };

    const hideLoadingIcon = () => {
        // Hide the loading container.
        let child = loadingNode.lastElementChild;
        while (child) {
            loadingNode.removeChild(child);
            child = loadingNode.lastElementChild;
        }
    };

    /**
     * @return {Object}
     */
    return {
        close,

        toggleFullscreen,
        requestFullscreen,
        exitFullscreen,

        getContainer,
        setContent,

        showLoadingIcon,
        hideLoadingIcon,
    };
};

const lockBodyScroll = () => {
    document.querySelector('body').classList.add('overflow-hidden');
};

const unlockBodyScroll = () => {
    document.querySelector('body').classList.remove('overflow-hidden');
};
