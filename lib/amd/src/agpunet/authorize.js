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
 * agpuNet authorization.
 *
 * @module     core/agpunet/authorize
 * @copyright  2023 Huong Nguyen <huongnv13@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      4.3
 */

import {alert as displayAlert, exception as displayException} from 'core/notification';
import * as agpuNetService from 'core/agpunet/service';
import {sendToagpuNet} from 'core/agpunet/send_resource';

/**
 * Handle authorization with agpuNet server.
 *
 * @param {int} issuerId The OAuth 2 issuer ID.
 * @param {int} courseId Course id.
 * @param {int} resourceId Resource id.
 * @param {int} shareFormat Share format.
 * @return {promise}
 */
export const handleAuthorization = (issuerId, courseId, resourceId, shareFormat) => {
    const windowSizeWidth = 550;
    const windowSizeHeight = 550;

    // Check if the user is authorized with agpuNet or not.
    return agpuNetService.authorizationCheck(issuerId, courseId).then(async(data) => {
        if (!data.status) {
            // Not yet authorized.
            // Declare agpuNetAuthorize variable, so we can call it later in the callback.
            window.agpuNetAuthorize = (error, errorDescription) => {
                // This will be called by the callback after the authorization is successful.
                if (error === '') {
                    handleAuthorization(issuerId, courseId, resourceId, shareFormat);
                } else if (error !== 'access_denied') {
                    displayAlert(
                        'Authorization error',
                        'Error: ' + error + '<br><br>Error description: ' + errorDescription,
                        'Cancel'
                    );
                }
            };
            // Open the login url of the OAuth 2 issuer for user to login into agpuNet and authorize.
            return window.open(data.loginurl, 'agpunet_auth',
                `location=0,status=0,width=${windowSizeWidth},height=${windowSizeHeight},scrollbars=yes`);
        } else {
            // Already authorized.
            return sendToagpuNet(issuerId, resourceId, shareFormat);
        }
    }).catch(displayException);
};
