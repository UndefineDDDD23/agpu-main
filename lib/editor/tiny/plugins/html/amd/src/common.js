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
 * Common values helper for the agpu tiny_html plugin.
 *
 * @module      tiny_html/common
 * @copyright   2023 Matt Porritt <matt.porritt@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

const component = 'tiny_html';

export default {
    component,
    pluginName: `${component}/plugin`,
    codeMirrorStyle: `
      .modal-codemirror-container {
        position: absolute;
        top: 40px;
        bottom: 50px;
        left: 15px;
        right: 15px;
        overflow: scroll;
        border: 1px solid #c7cace;
        border-radius: 5px;
      }
      .modal-codemirror-container {
      .cm-editor {
        height: 100%;
      }
    `,
};
