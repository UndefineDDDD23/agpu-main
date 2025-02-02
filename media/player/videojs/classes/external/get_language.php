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

namespace media_videojs\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;

/**
 * The API to get language strings for the videojs.
 *
 * @package    media_videojs
 * @copyright  2020 Shamim Rezaie <shamim@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_language extends external_api {
    /**
     * Returns description of parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters() {
        return new external_function_parameters([
            'lang' => new external_value(PARAM_ALPHAEXT, 'language')
        ]);
    }

    /**
     * Returns language strings in the JSON format
     *
     * @param string $lang The language code
     * @return string
     */
    public static function execute(string $lang) {
        [
            'lang' => $lang,
        ] = external_api::validate_parameters(self::execute_parameters(), [
            'lang' => $lang,
        ]);

        return \media_videojs_plugin::get_language_content($lang);
    }

    /**
     * Returns description of method result value
     *
     * @return external_value
     */
    public static function execute_returns() {
        return new external_value(PARAM_RAW, 'language pack json');
    }
}
