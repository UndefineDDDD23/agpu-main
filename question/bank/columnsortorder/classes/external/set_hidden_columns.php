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

namespace qbank_columnsortorder\external;

use context_system;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_value;
use qbank_columnsortorder\column_manager;

/**
 * External function for saving the list of hidden columns.
 *
 * @package   qbank_columnsortorder
 * @copyright 2023 onwards Catalyst IT EU {@link https://catalyst-eu.net}
 * @author    Mark Johnson <mark.johnson@catalyst-eu.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class set_hidden_columns extends external_api {
    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'columns' => new external_multiple_structure(
                new external_value(PARAM_TEXT, 'Plugin name for the hidden column', VALUE_REQUIRED),
                'List of hidden columns',
                VALUE_DEFAULT,
                null,
                NULL_ALLOWED,
            ),
            'global' => new external_value(
                PARAM_BOOL,
                'Set global config setting, rather than user preference',
                VALUE_DEFAULT,
                false
            ),
        ]);
    }

    /**
     * Returns description of method result value.
     *
     */
    public static function execute_returns(): void {
    }

    /**
     * Set hidden columns
     * Save against user preference if specified
     *
     * @param ?array $columns List of hidden columns. Null value clears the setting.
     * @param bool $global Set global config setting, rather than user preference
     */
    public static function execute(?array $columns, bool $global = false): void {
        [
            'columns' => $columns,
            'global' => $global,
        ] = self::validate_parameters(
            self::execute_parameters(),
            [
                'columns' => $columns,
                'global' => $global,
            ]
        );

        $context = context_system::instance();
        self::validate_context($context);
        if ($global) {
            require_capability('agpu/site:config', $context);
        }

        column_manager::set_hidden_columns($columns, $global);
    }
}
