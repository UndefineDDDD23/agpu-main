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
 * Customfield date plugin
 *
 * @package   customfield_date
 * @copyright 2018 Daniel Neis Araujo <daniel@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Get icon mapping for font-awesome.
 */
function customfield_date_get_fontawesome_icon_map() {
    return [
        'customfield_date:checked' => 'fa-regular fa-calendar-check',
        'customfield_date:notchecked' => 'fa-regular fa-calendar',
    ];
}
