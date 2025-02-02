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
 * A module to handle the OAuth2 callback for agpuNet.
 *
 * @module     core/agpunet/oauth2callback
 * @copyright  2023 Huong Nguyen <huongnv13@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      4.2
 */

import Prefetch from "core/prefetch";
import {alert} from 'core/notification';
import {getString} from 'core/str';

/**
 * Handle the OAuth2 callback for agpuNet.
 *
 * @param {String} error Error
 * @param {String} errorDescription Error description
 */
const handleCallback = (error, errorDescription) => {
    if (window.opener) {
        // Call the agpuNet Authorization again in the opener window.
        window.opener.agpuNetAuthorize(error, errorDescription);
        // Close the authorization popup.
        // We need to use setTimeout here because the Behat 'I press "x" and switch to main window' step expects the popup to still
        // be visible after clicking the button. Otherwise, it will throw a webdriver error.
        setTimeout(() => {
            // Close the authorization popup.
            window.close();
        }, 300);
    } else {
        alert(getString('error', 'agpu'), getString('agpunet:sharefailtitle', 'agpu'));
    }
};

/**
 * Initialize.
 *
 * @param {String} error Error
 * @param {String} errorDescription Error description
 */
export const init = (error, errorDescription) => {
    Prefetch.prefetchStrings('agpu', ['agpunet:sharefailtitle', 'error']);
    handleCallback(error, errorDescription);
};
