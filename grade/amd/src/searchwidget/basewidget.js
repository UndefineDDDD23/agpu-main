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
 * A widget to search users or grade items within the gradebook.
 *
 * @module    core_grades/searchwidget/basewidget
 * @copyright 2022 Mathew May <mathew.solutions>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import {debounce} from 'core/utils';
import * as Templates from 'core/templates';
import * as Selectors from 'core_grades/searchwidget/selectors';
import Notification from 'core/notification';
import Log from 'core/log';

/**
 * Build the base searching widget.
 *
 * @method init
 * @param {HTMLElement} widgetContentContainer The selector for the widget container element.
 * @param {Promise} bodyPromise The promise from the callee of the contents to place in the widget container.
 * @param {Array} data An array of all the data generated by the callee.
 * @param {Function} searchFunc Partially applied function we need to manage search the passed dataset.
 * @param {string|null} unsearchableContent The content rendered in a non-searchable area.
 * @param {Function|null} afterSelect Callback executed after an item is selected.
 */
export const init = async(
    widgetContentContainer,
    bodyPromise,
    data,
    searchFunc,
    unsearchableContent = null,
    afterSelect = null,
) => {
    Log.debug('The core_grades/searchwidget/basewidget component is deprecated. Please refer to core/search_combobox() instead.');
    bodyPromise.then(async(bodyContent) => {
        // Render the body content.
        widgetContentContainer.innerHTML = bodyContent;

        // Render the unsearchable content if defined.
        if (unsearchableContent) {
            const unsearchableContentContainer = widgetContentContainer.querySelector(Selectors.regions.unsearchableContent);
            unsearchableContentContainer.innerHTML += unsearchableContent;
        }

        const searchResultsContainer = widgetContentContainer.querySelector(Selectors.regions.searchResults);
        // Display a loader until the search results are rendered.
        await showLoader(searchResultsContainer);
        // Render the search results.
        await renderSearchResults(searchResultsContainer, data);

        registerListenerEvents(widgetContentContainer, data, searchFunc, afterSelect);

    }).catch(Notification.exception);
};

/**
 * Register the event listeners for the search widget.
 *
 * @method registerListenerEvents
 * @param {HTMLElement} widgetContentContainer The selector for the widget container element.
 * @param {Array} data An array of all the data generated by the callee.
 * @param {Function} searchFunc Partially applied function we need to manage search the passed dataset.
 * @param {Function|null} afterSelect Callback executed after an item is selected.
 */
export const registerListenerEvents = (widgetContentContainer, data, searchFunc, afterSelect = null) => {
    const searchResultsContainer = widgetContentContainer.querySelector(Selectors.regions.searchResults);
    const searchInput = widgetContentContainer.querySelector(Selectors.actions.search);

    if (!searchInput) {
        // Too late. The widget is already closed and its content is empty.
        return;
    }

    // We want to focus on the first known user interable element within the dropdown.
    searchInput.focus();
    const clearSearchButton = widgetContentContainer.querySelector(Selectors.actions.clearSearch);

    // The search input is triggered.
    searchInput.addEventListener('input', debounce(async() => {
        // If search query is present display the 'clear search' button, otherwise hide it.
        if (searchInput.value.length > 0) {
            clearSearchButton.classList.remove('d-none');
        } else {
            clearSearchButton.classList.add('d-none');
        }
        // Remove aria-activedescendant when the available options change.
        searchInput.removeAttribute('aria-activedescendant');
        // Display the search results.
        await renderSearchResults(
            searchResultsContainer,
            debounceCallee(
                searchInput.value,
                data,
                searchFunc()
            )
        );
    }, 300));

    // Clear search is triggered.
    clearSearchButton.addEventListener('click', async(e) => {
        e.stopPropagation();
        // Clear the entered search query in the search bar.
        searchInput.value = "";
        searchInput.focus();
        clearSearchButton.classList.add('d-none');

        // Remove aria-activedescendant when the available options change.
        searchInput.removeAttribute('aria-activedescendant');

        // Display all results.
        await renderSearchResults(
            searchResultsContainer,
            debounceCallee(
                searchInput.value,
                data,
                searchFunc()
            )
        );
    });

    const inputElement = document.getElementById(searchInput.dataset.inputElement);
    if (inputElement && afterSelect) {
        inputElement.addEventListener('change', e => {
            const selectedOption = widgetContentContainer.querySelector(
                Selectors.elements.getSearchWidgetSelectOption(searchInput),
            );

            if (selectedOption) {
                afterSelect(e.target.value);
            }
        });
    }

    // Backward compatibility. Handle the click event for the following cases:
    // - When we have <li> tags without an afterSelect callback function being provided (old js).
    // - When we have <a> tags without href (old template).
    widgetContentContainer.addEventListener('click', e => {
        const deprecatedOption = e.target.closest(
            'a.dropdown-item[role="menuitem"]:not([href]), .dropdown-item[role="option"]:not([href])'
        );
        if (deprecatedOption) {
            // We are in one of these situations:
            // - We have <li> tags without an afterSelect callback function being provided.
            // - We have <a> tags without href.
            if (inputElement && afterSelect) {
                afterSelect(deprecatedOption.dataset.value);
            } else {
                const url = (data.find(object => object.id == deprecatedOption.dataset.value) || {url: ''}).url;
                location.href = url;
            }
        }
    });

    // Backward compatibility. Handle the keydown event for the following cases:
    // - When we have <li> tags without an afterSelect callback function being provided (old js).
    // - When we have <a> tags without href (old template).
    widgetContentContainer.addEventListener('keydown', e => {
        const deprecatedOption = e.target.closest(
            'a.dropdown-item[role="menuitem"]:not([href]), .dropdown-item[role="option"]:not([href])'
        );
        if (deprecatedOption && (e.key === ' ' || e.key === 'Enter')) {
            // We are in one of these situations:
            // - We have <li> tags without an afterSelect callback function being provided.
            // - We have <a> tags without href.
            e.preventDefault();
            if (inputElement && afterSelect) {
                afterSelect(deprecatedOption.dataset.value);
            } else {
                const url = (data.find(object => object.id == deprecatedOption.dataset.value) || {url: ''}).url;
                location.href = url;
            }
        }
    });
};

/**
 * Renders the loading placeholder for the search widget.
 *
 * @method showLoader
 * @param {HTMLElement} container The DOM node where we'll render the loading placeholder.
 */
export const showLoader = async(container) => {
    container.innerHTML = '';
    const {html, js} = await Templates.renderForPromise('core_grades/searchwidget/loading', {});
    Templates.replaceNodeContents(container, html, js);
};

/**
 * We have a small helper that'll call the curried search function allowing callers to filter
 * the data set however we want rather than defining how data must be filtered.
 *
 * @method debounceCallee
 * @param {String} searchValue The input from the user that we'll search against.
 * @param {Array} data An array of all the data generated by the callee.
 * @param {Function} searchFunction Partially applied function we need to manage search the passed dataset.
 * @return {Array} The filtered subset of the provided data that we'll then render into the results.
 */
const debounceCallee = (searchValue, data, searchFunction) => {
    if (searchValue.length > 0) { // Search query is present.
        return searchFunction(data, searchValue);
    }
    return data;
};

/**
 * Given the output of the callers' search function, render out the results into the search results container.
 *
 * @method renderSearchResults
 * @param {HTMLElement} searchResultsContainer The DOM node of the widget where we'll render the provided results.
 * @param {Array} searchResultsData The filtered subset of the provided data that we'll then render into the results.
 */
const renderSearchResults = async(searchResultsContainer, searchResultsData) => {
    const templateData = {
        'searchresults': searchResultsData,
    };
    // Build up the html & js ready to place into the help section.
    const {html, js} = await Templates.renderForPromise('core_grades/searchwidget/searchresults', templateData);
    await Templates.replaceNodeContents(searchResultsContainer, html, js);

    // Backward compatibility.
    if (searchResultsContainer.getAttribute('role') !== 'listbox') {
        const deprecatedOptions = searchResultsContainer.querySelectorAll(
            'a.dropdown-item[role="menuitem"][href=""], .dropdown-item[role="option"]:not([href])'
        );
        for (const option of deprecatedOptions) {
            option.tabIndex = 0;
            option.removeAttribute('href');
        }
    }
};

/**
 * We want to create the basic promises and hooks that the caller will implement, so we can build the search widget
 * ahead of time and allow the caller to resolve their promises once complete.
 *
 * @method promisesAndResolvers
 * @returns {{bodyPromise: Promise, bodyPromiseResolver}}
 */
export const promisesAndResolvers = () => {
    // We want to show the widget instantly but loading whilst waiting for our data.
    let bodyPromiseResolver;
    const bodyPromise = new Promise(resolve => {
        bodyPromiseResolver = resolve;
    });

    return {bodyPromiseResolver, bodyPromise};
};
