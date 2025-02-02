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
 * Allow the user to search for learners within the singleview report.
 *
 * @module    gradereport_singleview/user
 * @copyright 2023 Mathew May <mathew.solutions>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import UserSearch from 'core_user/comboboxsearch/user';
import {renderForPromise, replaceNodeContents} from 'core/templates';
import * as Repository from 'core_grades/searchwidget/repository';

export default class User extends UserSearch {

    /**
     * Construct the class.
     *
     * @param {string} baseUrl The base URL for the page.
     */
    constructor(baseUrl) {
        super();
        this.baseUrl = baseUrl;
    }

    static init(baseUrl) {
        return new User(baseUrl);
    }

    /**
     * Build the content then replace the node.
     */
    async renderDropdown() {
        const {html, js} = await renderForPromise('core_user/comboboxsearch/resultset', {
            instance: this.instance,
            users: this.getMatchedResults().slice(0, 5),
            hasresults: this.getMatchedResults().length > 0,
            searchterm: this.getSearchTerm(),
        });
        replaceNodeContents(this.getHTMLElements().searchDropdown, html, js);
        // Remove aria-activedescendant when the available options change.
        this.searchInput.removeAttribute('aria-activedescendant');
    }

    /**
     * Stub out default required function unused here.
     * @returns {null}
     */
    selectAllResultsLink() {
        return null;
    }

    /**
     * Build up the view all link that is dedicated to a particular result.
     *
     * @param {Number} userID The ID of the user selected.
     * @returns {string|*}
     */
    selectOneLink(userID) {
        const url = new URL(this.baseUrl);
        url.searchParams.set('searchvalue', this.getSearchTerm());
        url.searchParams.set('item', 'user');
        url.searchParams.set('userid', userID);
        return url.toString();
    }

    /**
     * Get the data we will be searching against in this component.
     *
     * @returns {Promise<*>}
     */
    fetchDataset() {
        // Small typing checks as sometimes groups don't exist therefore the element returns a empty string.
        const gts = typeof (this.groupID) === "string" && this.groupID === '' ? 0 : this.groupID;
        return Repository.userFetch(this.courseID, gts).then((r) => r.users);
    }
}
