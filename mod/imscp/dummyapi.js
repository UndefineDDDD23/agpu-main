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
 * IMS Content Package module including dummy SCORM API.
 *
 * @package    mod
 * @subpackage imscp
 * @copyright  2009 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/** Dummy SCORM API adapter */
var API = new function () {
    this.LMSCommit         = function (parameter) {return "true";};
    this.LMSFinish         = function (parameter) {return "true";};
    this.LMSGetDiagnostic  = function (errorCode) {return "n/a";};
    this.LMSGetErrorString = function (errorCode) {return "n/a";};
    this.LMSGetLastError   = function () {return "0";};
    this.LMSGetValue       = function (element) {return "";};
    this.LMSInitialize     = function (parameter) {return "true";};
    this.LMSSetValue       = function (element, value) {return "true";};
};