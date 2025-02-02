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
 * Tiny Media plugin for agpu.
 *
 * @module      editor_tiny/uploader
 * @copyright   2022 Andrew Lyons <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import {
    notifyUploadStarted,
    notifyUploadCompleted,
} from 'core_form/events';
import {getFilePicker} from 'editor_tiny/options';

// This image uploader is based on advice given at:
// https://www.tiny.cloud/docs/tinymce/6/upload-images/
export default (editor, filePickerType, blob, fileName, progress) => new Promise((resolve, reject) => {
    notifyUploadStarted(editor.targetElm.id);

    const xhr = new XMLHttpRequest();

    // Add the progress handler.
    xhr.upload.addEventListener('progress', (e) => {
        progress(e.loaded / e.total * 100);
    });

    xhr.addEventListener('load', () => {
        if (xhr.status === 403) {
            reject({
                message: `HTTP error: ${xhr.status}`,
                remove: true,
            });
            return;
        }

        if (xhr.status < 200 || xhr.status >= 300) {
            reject(`HTTP Error: ${xhr.status}`);
            return;
        }

        const response = JSON.parse(xhr.responseText);

        if (!response) {
            reject(`Invalid JSON: ${xhr.responseText}`);
            return;
        }

        notifyUploadCompleted(editor.targetElm.id);

        let location;
        if (response.url) {
            location = response.url;
        } else if (response.event && response.event === 'fileexists' && response.newfile) {
            // A file with this name is already in use here - rename to avoid conflict.
            // Chances are, it's a different image (stored in a different folder on the user's computer).
            // If the user wants to reuse an existing image, they can copy/paste it within the editor.
            location = response.newfile.url;
        }

        if (location && typeof location === 'string') {
            resolve(location);
            return;
        }

        // Try to parse the error response into a JSON object.
        const errorString = xhr.responseText;
        let output = '';
        try {
            output = JSON.parse(errorString);
        } catch (error) {
            // If the JSON parsing process returns an error, then it returns the original.
            output = errorString;
        }

        reject(output);
    });

    xhr.addEventListener('error', () => {
        reject({
            message: `Upload failed due to an XHR transport error. Code: ${xhr.status}`,
            remove: true,
        });
    });

    const formData = new FormData();
    const options = getFilePicker(editor, filePickerType);

    formData.append('repo_upload_file', blob, fileName);
    formData.append('itemid', options.itemid);
    Object.values(options.repositories).some((repository) => {
        if (repository.type === 'upload') {
            formData.append('repo_id', repository.id);
            return true;
        }
        return false;
    });

    formData.append('env', options.env);
    formData.append('sesskey', M.cfg.sesskey);
    formData.append('client_id', options.client_id);
    formData.append('savepath', options.savepath ?? '/');
    formData.append('ctx_id', options.context.id);

    // Accepted types can be either a string or an array, but an array is
    // expected in the processing script, so make sure we are sending an array.
    const acceptedTypes = options.accepted_types;
    if (Array.isArray(acceptedTypes)) {
        acceptedTypes.forEach(function(type) {
              formData.append('accepted_types[]', type);
        });
    } else {
        formData.append('accepted_types[]', acceptedTypes);
    }

    xhr.open('POST', `${M.cfg.wwwroot}/repository/repository_ajax.php?action=upload`, true);
    xhr.send(formData);
});
