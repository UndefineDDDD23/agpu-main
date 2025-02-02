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
 * Detects if an element is fullscreen.
 *
 * @module     core/fullscreen
 * @copyright  2020 University of Nottingham
 * @author     Neill Magill <neill.magill@nottingham.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Gets the element that is fullscreen or null if no element is fullscreen.
 *
 * @method
 * @returns {HTMLElement}
 */
export const getElement = () => {
    let element = null;
    if (document.fullscreenElement) {
        element = document.fullscreenElement;
    } else if (document.mozFullscreenElement) {
        // Fallback for older Firefox.
        element = document.mozFullscreenElement;
    } else if (document.msFullscreenElement) {
        // Fallback for Edge and IE.
        element = document.msFullscreenElement;
    } else if (document.webkitFullscreenElement) {
        // Fallback for Chrome, Edge and Safari.
        element = document.webkitFullscreenElement;
    }

    return element;
};
