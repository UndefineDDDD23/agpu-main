<?php
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
 * Installation code for the popup message processor
 *
 * @package   message_popup
 * @copyright 2009 Dongsheng Cai <dongsheng@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Install the popup message processor
 */
function xmldb_message_popup_install() {
    global $DB;

    $result = true;

    $provider = new stdClass();
    $provider->name  = 'popup';
    $DB->insert_record('message_processors', $provider);
    return $result;
}
