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
 * Tiny Autosave plugin for agpu.
 *
 * @module      tiny_autosave/plugin
 * @copyright   2022 Andrew Lyons <andrew@nicols.co.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import {getTinyMCE} from 'editor_tiny/loader';
import {getPluginMetadata} from 'editor_tiny/utils';

import {component, pluginName} from './common';
import * as Options from './options';
import * as Autosaver from './autosaver';

// Setup the autosave Plugin.
// eslint-disable-next-line no-async-promise-executor
export default new Promise(async(resolve) => {
    const [tinyMCE, pluginMetadata] = await Promise.all([
        getTinyMCE(),
        getPluginMetadata(component, pluginName),
    ]);

    // Note: The PluginManager.add function does not accept a Promise.
    // Any asynchronous code must be run before this point.
    tinyMCE.PluginManager.add(pluginName, (editor) => {
        // Register options.
        Options.register(editor);

        // Register the Autosaver.
        Autosaver.register(editor);

        return pluginMetadata;
    });

    resolve(pluginName);
});
