// This file is part of agpu - https://agpu.org/
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
// along with agpu.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Common values helper for the agpu tiny_aiplacement plugin.
 *
 * @module      tiny_aiplacement/common
 * @copyright   2024 Matt Porritt <matt.porritt@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

const component = 'tiny_aiplacement';

export default {
    component,
    placement: 'aiplacement_editor',
    pluginName: `${component}/plugin`,
    contextMenuName: `${component}_contextmenu`,
    generateImageName: `${component}_generateimage`,
    generateTextName: `${component}_generatetext`,
    contextMenuIcon: 'sparkles',
    generateImageIcon: 'sparkles-image',
    generateTextIcon: 'sparkles-text',
};
