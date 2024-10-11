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
 * List of deprecated mod_survey functions.
 *
 * @package   mod_survey
 * @copyright 2021 Shamim Rezaie <shamim@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * @deprecated since agpu 3.11
 */
function survey_get_completion_state() {
    $completionclass = \mod_survey\completion\custom_completion::class;
    throw new coding_exception(__FUNCTION__ . "() has been removed, please use the '{$completionclass}' class instead");
}
