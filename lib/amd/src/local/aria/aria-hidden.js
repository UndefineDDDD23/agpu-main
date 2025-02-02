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
 * ARIA helpers related to the aria-hidden attribute.
 *
 * @module     core/local/aria/aria-hidden.
 * @copyright  2020 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import {getList} from 'core/normalise';
import Selectors from './selectors';

// The map of MutationObserver objects for an object.
const childObserverMap = new Map();
const siblingObserverMap = new Map();

/**
 * Determine whether the browser supports the MutationObserver system.
 *
 * @method
 * @returns {Bool}
 */
const supportsMutationObservers = () => (MutationObserver && typeof MutationObserver === 'function');

/**
 * Disable element focusability, disabling the tabindex for child elements which are normally focusable.
 *
 * @method
 * @param {HTMLElement} target
 */
const disableElementFocusability = target => {
    if (!(target instanceof HTMLElement)) {
        // This element is not an HTMLElement.
        // This can happen for Text Nodes.
        return;
    }

    if (target.matches(Selectors.elements.focusable)) {
        disableAndStoreTabIndex(target);
    }

    target.querySelectorAll(Selectors.elements.focusable).forEach(disableAndStoreTabIndex);
};

/**
 * Remove the current tab-index and store it for later restoration.
 *
 * @method
 * @param {HTMLElement} element
 */
const disableAndStoreTabIndex = element => {
    if (typeof element.dataset.ariaHiddenTabIndex !== 'undefined') {
        // This child already has a hidden attribute.
        // Do not modify it as the original value will be lost.
        return;
    }

    // Store the old tabindex in a data attribute.
    if (element.getAttribute('tabindex')) {
        element.dataset.ariaHiddenTabIndex = element.getAttribute('tabindex');
    } else {
        element.dataset.ariaHiddenTabIndex = '';
    }
    element.setAttribute('tabindex', -1);
};

/**
 * Re-enable element focusability, restoring any tabindex.
 *
 * @method
 * @param {HTMLElement} target
 */
const enableElementFocusability = target => {
    if (!(target instanceof HTMLElement)) {
        // This element is not an HTMLElement.
        // This can happen for Text Nodes.
        return;
    }

    if (target.matches(Selectors.elements.focusableToUnhide)) {
        restoreTabIndex(target);
    }

    target.querySelectorAll(Selectors.elements.focusableToUnhide).forEach(restoreTabIndex);
};

/**
 * Restore the tab-index of the supplied element.
 *
 * When disabling focusability the current tab-index is stored in the ariaHiddenTabIndex data attribute.
 * This is used to restore the tab-index, but only whilst the parent nodes remain unhidden.
 *
 * @method
 * @param {HTMLElement} element
 */
const restoreTabIndex = element => {
    if (element.closest(Selectors.aria.hidden)) {
        // This item still has a hidden parent, or is hidden itself. Do not unhide it.
        return;
    }

    const oldTabIndex = element.dataset.ariaHiddenTabIndex;
    if (oldTabIndex === '') {
        element.removeAttribute('tabindex');
    } else {
        element.setAttribute('tabindex', oldTabIndex);
    }

    delete element.dataset.ariaHiddenTabIndex;
};

/**
 * Update the supplied DOM Module to be hidden.
 *
 * @method
 * @param {HTMLElement} target
 * @returns {Array}
 */
export const hide = target => getList(target).forEach(_hide);

const _hide = target => {
    if (!(target instanceof HTMLElement)) {
        // This element is not an HTMLElement.
        // This can happen for Text Nodes.
        return;
    }

    if (target.closest(Selectors.aria.hidden)) {
        // This Element, or a parent Element, is already hidden.
        // Stop processing.
        return;
    }

    // Set the aria-hidden attribute to true.
    target.setAttribute('aria-hidden', true);

    // Based on advice from https://dequeuniversity.com/rules/axe/3.3/aria-hidden-focus, upon setting the aria-hidden
    // attribute, all focusable elements underneath that element should be modified such that they are not focusable.
    disableElementFocusability(target);

    if (supportsMutationObservers()) {
        // Add a MutationObserver to check for new children to the tree.
        const mutationObserver = new MutationObserver(mutationList => {
            mutationList.forEach(mutation => {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(disableElementFocusability);
                } else if (mutation.type === 'attributes') {
                    // The tabindex has been updated on a hidden attribute.
                    // Ensure that it is stored, ad set to -1 to prevent breakage.
                    const element = mutation.target;
                    const proposedTabIndex = element.getAttribute('tabindex');

                    if (proposedTabIndex !== "-1") {
                        element.dataset.ariaHiddenTabIndex = proposedTabIndex;
                        element.setAttribute('tabindex', -1);
                    }
                }
            });
        });

        mutationObserver.observe(target, {
            // Watch for changes to the entire subtree.
            subtree: true,

            // Watch for new nodes.
            childList: true,

            // Watch for attribute changes to the tabindex.
            attributes: true,
            attributeFilter: ['tabindex'],
        });
        childObserverMap.set(target, mutationObserver);
    }
};

/**
 * Reverse the effect of the hide action.
 *
 * @method
 * @param {HTMLElement} target
 * @returns {Array}
 */
export const unhide = target => getList(target).forEach(_unhide);

const _unhide = target => {
    if (!(target instanceof HTMLElement)) {
        return;
    }

    // Note: The aria-hidden attribute should be removed, and not set to false.
    // The presence of the attribute is sufficient for some browsers to treat it as being true, regardless of its value.
    target.removeAttribute('aria-hidden');

    // Restore the tabindex across all child nodes of the target.
    enableElementFocusability(target);

    // Remove the focusability MutationObserver watching this tree.
    if (childObserverMap.has(target)) {
        childObserverMap.get(target).disconnect();
        childObserverMap.delete(target);
    }
};

/**
 * Correctly mark all siblings of the supplied target Element as hidden.
 *
 * @method
 * @param {HTMLElement} target
 * @returns {Array}
 */
export const hideSiblings = target => getList(target).forEach(_hideSiblings);

const _hideSiblings = target => {
    if (!(target instanceof HTMLElement)) {
        return;
    }

    if (!target.parentElement) {
        return;
    }

    target.parentElement.childNodes.forEach(node => {
        if (node === target) {
            // Skip self;
            return;
        }

        hide(node);
    });

    if (supportsMutationObservers()) {
        // Add a MutationObserver to check for new children to the tree.
        const newNodeObserver = new MutationObserver(mutationList => {
            mutationList.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (target.contains(node)) {
                        // Skip self, and children of self.
                        return;
                    }

                    hide(node);
                });
            });
        });

        newNodeObserver.observe(target.parentElement, {childList: true, subtree: true});
        siblingObserverMap.set(target.parentElement, newNodeObserver);
    }
};

/**
 * Correctly reverse the hide action of all children of the supplied target Element.
 *
 * @method
 * @param {HTMLElement} target
 * @returns {Array}
 */
export const unhideSiblings = target => getList(target).forEach(_unhideSiblings);

const _unhideSiblings = target => {
    if (!(target instanceof HTMLElement)) {
        return;
    }

    if (!target.parentElement) {
        return;
    }

    target.parentElement.childNodes.forEach(node => {
        if (node === target) {
            // Skip self;
            return;
        }

        unhide(node);
    });

    // Remove the sibling MutationObserver watching this tree.
    if (siblingObserverMap.has(target.parentElement)) {
        siblingObserverMap.get(target.parentElement).disconnect();
        siblingObserverMap.delete(target.parentElement);
    }
};
