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

namespace core_reportbuilder\external\filters;

use core_external\external_api;
use core_external\external_value;
use core_external\external_single_structure;
use core_external\external_function_parameters;
use core_reportbuilder\manager;
use core_reportbuilder\permission;
use core_reportbuilder\external\custom_report_filters_exporter;
use core_reportbuilder\local\helpers\report;

/**
 * External method for deleting report filters
 *
 * @package     core_reportbuilder
 * @copyright   2021 Paul Holden <paulh@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class delete extends external_api {

    /**
     * External method parameters
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'reportid' => new external_value(PARAM_INT, 'Report ID'),
            'filterid' => new external_value(PARAM_INT, 'Filter ID'),
        ]);
    }

    /**
     * External method execution
     *
     * @param int $reportid
     * @param int $filterid
     * @return array
     */
    public static function execute(int $reportid, int $filterid): array {
        global $PAGE;

        [
            'reportid' => $reportid,
            'filterid' => $filterid,
        ] = self::validate_parameters(self::execute_parameters(), [
            'reportid' => $reportid,
            'filterid' => $filterid,
        ]);

        $report = manager::get_report_from_id($reportid);

        self::validate_context($report->get_context());
        permission::require_can_edit_report($report->get_report_persistent());

        report::delete_report_filter($reportid, $filterid);

        $exporter = new custom_report_filters_exporter(null, [
            'report' => $report,
        ]);

        return (array) $exporter->export($PAGE->get_renderer('core'));
    }

    /**
     * External method return value
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return custom_report_filters_exporter::get_read_structure();
    }
}
