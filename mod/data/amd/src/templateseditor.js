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
 * Javascript module to control the template editor.
 *
 * @module      mod_data/templateseditor
 * @copyright   2021 Mihail Geshoski <mihail@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {getString} from 'core/str';
import {prefetchStrings} from 'core/prefetch';
import {relativeUrl} from 'core/url';
import {saveCancel, deleteCancel} from 'core/notification';
import Templates from 'core/templates';

prefetchStrings('admin', ['confirmation']);
prefetchStrings('mod_data', [
    'resettemplateconfirmtitle',
    'enabletemplateeditorcheck',
    'editorenable'
]);
prefetchStrings('core', [
    'reset',
]);

/**
 * Template editor constants.
 */
const selectors = {
    toggleTemplateEditor: 'input[name="useeditor"]',
    resetTemplateAction: '[data-action="resettemplate"]',
    resetTemplate: 'input[name="defaultform"]',
    resetAllTemplates: 'input[name="resetall"]',
    resetAllCheck: 'input[name="resetallcheck"]',
    editForm: '#edittemplateform',
};

/**
 * Register event listeners for the module.
 *
 * @param {Number} instanceId The database ID
 * @param {string} mode The template mode
 */
const registerEventListeners = (instanceId, mode) => {
    registerResetButton(mode);
    registerEditorToggler(instanceId, mode);
};

const registerResetButton = (mode) => {
    const editForm = document.querySelector(selectors.editForm);
    const resetTemplate = document.querySelector(selectors.resetTemplate);
    const resetAllTemplates = document.querySelector(selectors.resetAllTemplates);
    const resetTemplateAction = document.querySelector(selectors.resetTemplateAction);

    if (!resetTemplateAction || !resetTemplate || !editForm) {
        return;
    }
    prefetchStrings('mod_data', [
        mode
    ]);
    resetTemplateAction.addEventListener('click', async(event) => {
        event.preventDefault();
        const params = {
            resetallname: "resetallcheck",
            templatename: await getString(mode, 'mod_data'),
        };
        deleteCancel(
            getString('resettemplateconfirmtitle', 'mod_data'),
            Templates.render('mod_data/template_editor_resetmodal', params),
            getString('reset', 'core'),
            () => {
                resetTemplate.value = "true";
                editForm.submit();
            },
            null,
            {triggerElement: event.target}
        );
    });

    // The reset all checkbox is inside a modal so we need to capture at document level.
    if (!resetAllTemplates) {
        return;
    }
    document.addEventListener('change', (event) => {
        if (event.target.matches(selectors.resetAllCheck)) {
            resetAllTemplates.value = (event.target.checked) ? "true" : "";
        }
    });
};

const registerEditorToggler = (instanceId, mode) => {
    const toggleTemplateEditor = document.querySelector(selectors.toggleTemplateEditor);

    if (!toggleTemplateEditor) {
        return;
    }

    toggleTemplateEditor.addEventListener('click', async(event) => {
        event.preventDefault();
        // Whether the event action attempts to enable or disable the template editor.
        const enableTemplateEditor = event.target.checked;

        if (enableTemplateEditor) {
            // Display a confirmation dialog before enabling the template editor.
            saveCancel(
                getString('confirmation', 'admin'),
                getString('enabletemplateeditorcheck', 'mod_data'),
                getString('editorenable', 'mod_data'),
                () => {
                    window.location = relativeUrl('/mod/data/templates.php', {d: instanceId, mode: mode, useeditor: true});
                },
                null,
                {triggerElement: event.target}
            );
        } else {
            window.location = relativeUrl('/mod/data/templates.php', {d: instanceId, mode: mode, useeditor: false});
        }
    });
};

/**
 * Initialize the module.
 *
 * @param {int} instanceId The database ID
 * @param {string} mode The template mode
 */
export const init = (instanceId, mode) => {
    registerEventListeners(instanceId, mode);
};
