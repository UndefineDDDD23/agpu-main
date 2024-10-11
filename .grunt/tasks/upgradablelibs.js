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
 * @copyright  2023 Sara Arjona <sara@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

module.exports = grunt => {
    /**
     * Generate upgradable third-party libraries (utilising thirdpartylibs.xml data)
     */
    grunt.registerTask('upgradablelibs', 'Generate upgradable third-party libraries', async function() {
        const done = this.async();

        const path = require('path');
        const ComponentList = require(path.join(process.cwd(), '.grunt', 'components.js'));

        // An array of third party libraries that have a newer version in their repositories.
        const thirdPartyLibs = await ComponentList.getThirdPartyLibsUpgradable({progress: true});
        for (let library of thirdPartyLibs) {
            grunt.log.ok(JSON.stringify(Object.assign({}, library), null, 4));
        }

        done();
    });

};
