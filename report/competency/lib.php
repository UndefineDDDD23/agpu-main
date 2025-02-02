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
 * Public API of the competency report.
 *
 * Defines the APIs used by competency reports
 *
 * @package    report_competency
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course to object for the report
 * @param stdClass $context The context of the course
 */
function report_competency_extend_navigation_course($navigation, $course, $context) {
    if (!get_config('core_competency', 'enabled')) {
        return;
    }

    if (has_capability('agpu/competency:coursecompetencyview', $context)) {
        $url = new agpu_url('/report/competency/index.php', array('id' => $course->id));
        $name = get_string('pluginname', 'report_competency');
        $navigation->add($name, $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
    }
}

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param cminfo $cm The course module.
 */
function report_competency_extend_navigation_module($navigation, $cm) {
    if (!get_config('core_competency', 'enabled')) {
        return;
    }

    if (has_any_capability(array('agpu/competency:usercompetencyview', 'agpu/competency:coursecompetencymanage'),
            context_course::instance($cm->course))) {
        $url = new agpu_url('/report/competency/index.php', array('id' => $cm->course, 'mod' => $cm->id));
        $name = get_string('pluginname', 'report_competency');
        $navigation->add($name, $url, navigation_node::TYPE_SETTING, null, 'competencybreakdown',
            new pix_icon('i/competencies', ''))->set_show_in_secondary_navigation(false);
    }
}
