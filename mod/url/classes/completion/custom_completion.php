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

declare(strict_types=1);

namespace mod_url\completion;

use core_completion\activity_custom_completion;

/**
 * Activity custom completion subclass for the url resource.
 *
 * Class for defining mod_url's custom completion rules and fetching the completion statuses
 * of the custom completion rules for a given url instance and a user.
 *
 * @package    mod_url
 * @copyright  2021 Huong Nguyen <huongn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class custom_completion extends activity_custom_completion {

    /**
     * Fetches the completion state for a given completion rule.
     *
     * @param string $rule The completion rule.
     * @return int The completion state.
     */
    public function get_state(string $rule): int {
        return COMPLETION_UNKNOWN;
    }

    /**
     * Fetch the list of custom completion rules that this module defines.
     *
     * @return array
     */
    public static function get_defined_custom_rules(): array {
        // This activity/resource do not have any custom rules.
        return [];
    }

    /**
     * Returns an associative array of the descriptions of custom completion rules.
     *
     * @return array
     */
    public function get_custom_rule_descriptions(): array {
        // This activity/resource do not have any custom rule descriptions.
        return [];
    }

    /**
     * Show the manual completion or not regardless of the course's showcompletionconditions setting.
     *
     * @return bool
     */
    public function manual_completion_always_shown(): bool {
        global $CFG;
        require_once($CFG->libdir.'/resourcelib.php');

        $display = $this->cm->customdata['display'] ?? null;

        $displaytypes = [
                RESOURCELIB_DISPLAY_NEW,
                RESOURCELIB_DISPLAY_OPEN,
                RESOURCELIB_DISPLAY_POPUP
        ];

        return in_array($display, $displaytypes);
    }

    /**
     * Returns an array of all completion rules, in the order they should be displayed to users.
     *
     * @return array
     */
    public function get_sort_order(): array {
        // This module only supports manual completion.
        return [];
    }
}
