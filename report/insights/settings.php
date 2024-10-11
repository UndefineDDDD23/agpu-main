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
 * Links and settings
 *
 * Contains settings used by insights report.
 *
 * @package    report_insights
 * @copyright  2017 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

if (\core_analytics\manager::is_analytics_enabled()) {
    // Just a link to course report.
    $ADMIN->add('reports', new admin_externalpage('reportinsights', get_string('insights', 'report_insights'),
            $CFG->wwwroot . "/report/insights/insights.php?contextid=" . SYSCONTEXTID, 'agpu/analytics:listinsights'));

    // No report settings.
    $settings = null;
}
