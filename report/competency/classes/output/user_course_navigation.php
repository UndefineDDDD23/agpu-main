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
 * User navigation class.
 *
 * @package    report_competency
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace report_competency\output;

use renderable;
use renderer_base;
use templatable;
use context_course;
use core_user\external\user_summary_exporter;
use core_course\external\course_module_summary_exporter;
use stdClass;

/**
 * User course navigation class.
 *
 * @package    report_competency
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class user_course_navigation implements renderable, templatable {

    /** @var userid */
    protected $userid;

    /** @var courseid */
    protected $courseid;

    /** @var moduleid */
    protected $moduleid;

    /** @var baseurl */
    protected $baseurl;

    /**
     * Construct.
     *
     * @param int $userid
     * @param int $courseid
     * @param int $moduleid
     * @param string $baseurl
     */
    public function __construct($userid, $courseid, $baseurl, $moduleid) {
        $this->userid = $userid;
        $this->courseid = $courseid;
        $this->moduleid = $moduleid;
        $this->baseurl = $baseurl;
    }

    /**
     * Export the data.
     *
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        global $CFG, $DB, $SESSION, $PAGE;

        $context = context_course::instance($this->courseid);

        $data = new stdClass();
        $data->userid = $this->userid;
        $data->courseid = $this->courseid;
        $data->moduleid = $this->moduleid;
        if (empty($data->moduleid)) {
            // Moduleid is optional.
            $data->moduleid = 0;
        }
        $data->baseurl = $this->baseurl;
        $data->groupselector = '';

        if (has_any_capability(array('agpu/competency:usercompetencyview', 'agpu/competency:coursecompetencymanage'),
                $context)) {
            $course = $DB->get_record('course', array('id' => $this->courseid));
            $currentgroup = groups_get_course_group($course, true);
            if ($currentgroup !== false) {
                $select = groups_allgroups_course_menu($course, $PAGE->url, true, $currentgroup);
                $data->groupselector = $select;
            }
            // Fetch showactive.
            $defaultgradeshowactiveenrol = !empty($CFG->grade_report_showonlyactiveenrol);
            $showonlyactiveenrol = get_user_preferences('grade_report_showonlyactiveenrol', $defaultgradeshowactiveenrol);
            $showonlyactiveenrol = $showonlyactiveenrol || !has_capability('agpu/course:viewsuspendedusers', $context);

            // Fetch current active group.
            $groupmode = groups_get_course_groupmode($course);

            $users = get_enrolled_users($context, 'agpu/competency:coursecompetencygradable', $currentgroup,
                                        'u.*', null, 0, 0, $showonlyactiveenrol);

            $data->users = array();
            foreach ($users as $user) {
                $data->users[] = (object)[
                    'id' => $user->id,
                    'fullname' => fullname($user, has_capability('agpu/site:viewfullnames', $context)),
                    'selected' => $user->id == $this->userid
                ];
            }
            $data->hasusers = true;

            $data->hasmodules = true;
            $data->modules = array();
            $empty = (object)['id' => 0, 'name' => get_string('nofiltersapplied')];
            $data->modules[] = $empty;

            $modinfo = get_fast_modinfo($this->courseid);
            foreach ($modinfo->get_cms() as $cm) {
                if ($cm->uservisible) {
                    $exporter = new course_module_summary_exporter(null, ['cm' => $cm]);
                    $module = $exporter->export($output);
                    if ($module->id == $this->moduleid) {
                        $module->selected = true;
                    }
                    $data->modules[] = $module;
                    $data->hasmodules = true;
                }
            }

        } else {
            $data->users = array();
            $data->hasusers = false;
        }

        return $data;
    }
}
