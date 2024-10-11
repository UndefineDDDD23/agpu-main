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
/* jshint node: true, browser: false */
/* eslint-env node */

/**
 * @copyright  2021 Andrew Nicols
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

module.exports = grunt => {
    /**
     * Generate ignore files (utilising thirdpartylibs.xml data)
     */
    const handler = function() {
        const path = require('path');

        // Are we in a YUI directory?
        if (path.basename(path.resolve(grunt.agpuEnv.cwd, '../../')) == 'yui') {
            grunt.task.run('yui');
        // Are we in an AMD directory?
        } else if (grunt.agpuEnv.inAMD) {
            grunt.task.run('amd');
        } else {
            // Run all of the requested startup tasks.
            grunt.agpuEnv.startupTasks.forEach(taskName => grunt.task.run(taskName));
        }
    };

    // Register the startup task.
    grunt.registerTask('startup', 'Run the correct tasks for the current directory', handler);

    return handler;
};
