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

namespace core_reportbuilder\external\conditions;

use core_external\external_api;
use core_external\external_value;
use core_external\external_single_structure;
use core_external\external_function_parameters;
use core_reportbuilder\manager;
use core_reportbuilder\permission;
use core_reportbuilder\external\custom_report_conditions_exporter;
use core_reportbuilder\local\helpers\report;

/**
 * External method for adding report conditions
 *
 * @package     core_reportbuilder
 * @copyright   2021 Paul Holden <paulh@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class add extends external_api {

    /**
     * External method parameters
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'reportid' => new external_value(PARAM_INT, 'Report ID'),
            'uniqueidentifier' => new external_value(PARAM_RAW, 'Unique identifier of the condition'),
        ]);
    }

    /**
     * External method execution
     *
     * @param int $reportid
     * @param string $uniqueidentifier
     * @return array
     */
    public static function execute(int $reportid, string $uniqueidentifier): array {
        global $PAGE, $OUTPUT;

        [
            'reportid' => $reportid,
            'uniqueidentifier' => $uniqueidentifier,
        ] = self::validate_parameters(self::execute_parameters(), [
            'reportid' => $reportid,
            'uniqueidentifier' => $uniqueidentifier,
        ]);

        $report = manager::get_report_from_id($reportid);

        self::validate_context($report->get_context());
        permission::require_can_edit_report($report->get_report_persistent());

        report::add_report_condition($reportid, $uniqueidentifier);

        // Set current URL and force bootstrap_renderer to initiate agpu page.
        $PAGE->set_url('/');
        $OUTPUT->header();
        $PAGE->start_collecting_javascript_requirements();

        $exporter = new custom_report_conditions_exporter(null, ['report' => $report]);

        $export = $exporter->export($PAGE->get_renderer('core'));
        $export->javascript = $PAGE->requires->get_end_code();

        return (array) $export;
    }

    /**
     * External method return value
     *
     * @return external_value
     */
    public static function execute_returns(): external_single_structure {
        return custom_report_conditions_exporter::get_read_structure();
    }
}
