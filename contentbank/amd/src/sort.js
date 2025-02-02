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
 * Content bank UI actions.
 *
 * @module     core_contentbank/sort
 * @copyright  2020 Bas Brands <bas@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import selectors from './selectors';
import {getString} from 'core/str';
import Prefetch from 'core/prefetch';
import Notification from 'core/notification';
import {setUserPreference} from 'core_user/repository';

/**
 * Set up the contentbank views.
 *
 * @method init
 */
export const init = () => {
    const contentBank = document.querySelector(selectors.regions.contentbank);
    Prefetch.prefetchStrings('contentbank', ['contentname', 'uses', 'lastmodified', 'size', 'type', 'author']);
    Prefetch.prefetchStrings('agpu', ['sortbyx', 'sortbyxreverse']);
    registerListenerEvents(contentBank);
};

/**
 * Register contentbank related event listeners.
 *
 * @method registerListenerEvents
 * @param {HTMLElement} contentBank The DOM node of the content bank
 */
const registerListenerEvents = (contentBank) => {

    contentBank.addEventListener('click', e => {
        const viewList = contentBank.querySelector(selectors.actions.viewlist);
        const viewGrid = contentBank.querySelector(selectors.actions.viewgrid);
        const fileArea = contentBank.querySelector(selectors.regions.filearea);
        const shownItems = fileArea.querySelectorAll(selectors.elements.listitem);

        // View as Grid button.
        if (e.target.closest(selectors.actions.viewgrid)) {
            contentBank.classList.remove('view-list');
            contentBank.classList.add('view-grid');
            if (fileArea && shownItems) {
                fileArea.setAttribute('role', 'list');
                shownItems.forEach(listItem => {
                    listItem.setAttribute('role', 'listitem');
                    listItem.querySelectorAll(selectors.elements.cell).forEach(cell => cell.removeAttribute('role'));
                });

                const heading = fileArea.querySelector(selectors.elements.heading);
                if (heading) {
                    heading.removeAttribute('role');
                    heading.querySelectorAll(selectors.elements.cell).forEach(cell => cell.removeAttribute('role'));
                }
            }
            viewGrid.classList.add('active');
            viewList.classList.remove('active');
            setViewListPreference(false);

            return;
        }

        // View as List button.
        if (e.target.closest(selectors.actions.viewlist)) {
            contentBank.classList.remove('view-grid');
            contentBank.classList.add('view-list');
            if (fileArea && shownItems) {
                fileArea.setAttribute('role', 'table');
                shownItems.forEach(listItem => {
                    listItem.setAttribute('role', 'row');
                    listItem.querySelectorAll(selectors.elements.cell).forEach(cell => cell.setAttribute('role', 'cell'));
                });

                const heading = fileArea.querySelector(selectors.elements.heading);
                if (heading) {
                    heading.setAttribute('role', 'row');
                    heading.querySelectorAll(selectors.elements.cell).forEach(cell => cell.setAttribute('role', 'columnheader'));
                }
            }
            viewList.classList.add('active');
            viewGrid.classList.remove('active');
            setViewListPreference(true);

            return;
        }

        if (fileArea && shownItems) {

            // Sort by file name alphabetical
            const sortByName = e.target.closest(selectors.actions.sortname);
            if (sortByName) {
                const ascending = updateSortButtons(contentBank, sortByName);
                updateSortOrder(fileArea, shownItems, 'data-file', ascending);
                return;
            }

            // Sort by uses.
            const sortByUses = e.target.closest(selectors.actions.sortuses);
            if (sortByUses) {
                const ascending = updateSortButtons(contentBank, sortByUses);
                updateSortOrder(fileArea, shownItems, 'data-uses', ascending);
                return;
            }

            // Sort by date.
            const sortByDate = e.target.closest(selectors.actions.sortdate);
            if (sortByDate) {
                const ascending = updateSortButtons(contentBank, sortByDate);
                updateSortOrder(fileArea, shownItems, 'data-timemodified', ascending);
                return;
            }

            // Sort by size.
            const sortBySize = e.target.closest(selectors.actions.sortsize);
            if (sortBySize) {
                const ascending = updateSortButtons(contentBank, sortBySize);
                updateSortOrder(fileArea, shownItems, 'data-bytes', ascending);
                return;
            }

            // Sort by type.
            const sortByType = e.target.closest(selectors.actions.sorttype);
            if (sortByType) {
                const ascending = updateSortButtons(contentBank, sortByType);
                updateSortOrder(fileArea, shownItems, 'data-type', ascending);
                return;
            }

            // Sort by author.
            const sortByAuthor = e.target.closest(selectors.actions.sortauthor);
            if (sortByAuthor) {
                const ascending = updateSortButtons(contentBank, sortByAuthor);
                updateSortOrder(fileArea, shownItems, 'data-author', ascending);
            }
            return;
        }
    });
};


/**
 * Set the contentbank user preference in list view
 *
 * @param  {Bool} viewList view ContentBank as list.
 * @return {Promise} Repository promise.
 */
const setViewListPreference = function(viewList) {

    // If the given status is not hidden, the preference has to be deleted with a null value.
    if (viewList === false) {
        viewList = null;
    }

    return setUserPreference('core_contentbank_view_list', viewList)
        .catch(Notification.exception);
};

/**
 * Update the sort button view.
 *
 * @method updateSortButtons
 * @param {HTMLElement} contentBank The DOM node of the contentbank button
 * @param {HTMLElement} sortButton The DOM node of the sort button
 * @return {Bool} sort ascending
 */
const updateSortButtons = (contentBank, sortButton) => {
    const sortButtons = contentBank.querySelectorAll(selectors.elements.sortbutton);

    sortButtons.forEach((button) => {
        if (button !== sortButton) {
            button.classList.remove('dir-asc');
            button.classList.remove('dir-desc');
            button.classList.add('dir-none');

            button.closest(selectors.elements.cell).setAttribute('aria-sort', 'none');

            updateButtonTitle(button, false);
        }
    });

    let ascending = true;

    if (sortButton.classList.contains('dir-none')) {
        sortButton.classList.remove('dir-none');
        sortButton.classList.add('dir-asc');
        sortButton.closest(selectors.elements.cell).setAttribute('aria-sort', 'ascending');
    } else if (sortButton.classList.contains('dir-asc')) {
        sortButton.classList.remove('dir-asc');
        sortButton.classList.add('dir-desc');
        sortButton.closest(selectors.elements.cell).setAttribute('aria-sort', 'descending');
        ascending = false;
    } else if (sortButton.classList.contains('dir-desc')) {
        sortButton.classList.remove('dir-desc');
        sortButton.classList.add('dir-asc');
        sortButton.closest(selectors.elements.cell).setAttribute('aria-sort', 'ascending');
    }

    updateButtonTitle(sortButton, ascending);

    return ascending;
};

/**
 * Update the button title.
 *
 * @method updateButtonTitle
 * @param {HTMLElement} button Button to update
 * @param {Bool} ascending Sort direction
 * @return {Promise} string promise
 */
const updateButtonTitle = (button, ascending) => {

    const sortString = (ascending ? 'sortbyxreverse' : 'sortbyx');

    return getString(button.dataset.string, 'contentbank')
    .then(columnName => {
        return getString(sortString, 'core', columnName);
    })
    .then(sortByString => {
        button.setAttribute('title', sortByString);
        return sortByString;
    })
    .catch();
};

/**
 * Update the sort order of the itemlist and update the DOM
 *
 * @method updateSortOrder
 * @param {HTMLElement} fileArea the Dom container for the itemlist
 * @param {Array} itemList Nodelist of Dom elements
 * @param {String} attribute the attribut to sort on
 * @param {Bool} ascending Sort Ascending
 */
const updateSortOrder = (fileArea, itemList, attribute, ascending) => {
    const sortList = [].slice.call(itemList).sort(function(a, b) {

        let aa = a.getAttribute(attribute);
        let bb = b.getAttribute(attribute);
        if (!isNaN(aa)) {
           aa = parseInt(aa);
           bb = parseInt(bb);
        }

        if (ascending) {
            return aa > bb ? 1 : -1;
        } else {
            return aa < bb ? 1 : -1;
        }
    });
    sortList.forEach(listItem => fileArea.appendChild(listItem));
};
