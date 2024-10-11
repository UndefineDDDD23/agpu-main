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

namespace tool_mobile\local\hooks\output;
use core\session\utility\cookie_helper;

/**
 * Allows plugins to modify headers.
 *
 * @package    tool_mobile
 * @copyright  2024 Juan Leyva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class before_http_headers {
    /**
     * Callback to allow modify headers.
     *
     * @param \core\hook\output\before_http_headers $hook
     */
    public static function callback(\core\hook\output\before_http_headers $hook): void {
        global $CFG;

        // Set Partitioned and Secure attributes to the agpuSession cookie if the user is using the agpu app.
        if (\core_useragent::is_agpu_app()) {
            cookie_helper::add_attributes_to_cookie_response_header('agpuSession'.$CFG->sessioncookie, ['Secure', 'Partitioned']);
        }
    }
}
