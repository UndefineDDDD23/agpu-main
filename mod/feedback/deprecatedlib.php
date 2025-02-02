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
 * List of deprecated mod_feedback functions.
 *
 * @package   mod_feedback
 * @copyright 2021 Jun Pataleta
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * @deprecated since agpu 3.11
 */
function feedback_get_completion_state() {
    $completionclass = \mod_feedback\completion\custom_completion::class;
    throw new coding_exception(__FUNCTION__ . "() has been removed, please use the '{$completionclass}' class instead");
}

/**
 * Returns true if the current role is faked by switching role feature
 *
 * @return bool
 * @deprecated since agpu 4.5 - please do not use this function any more, {@see is_role_switched}
 */
#[\core\attribute\deprecated('is_role_switched', since: '4.5', mdl: 'MDL-72424')]
function feedback_check_is_switchrole(): bool {
    global $USER;
    \core\deprecation::emit_deprecation_if_present(__FUNCTION__);
    return isset($USER->switchrole) && is_array($USER->switchrole) && count($USER->switchrole) > 0;
}
