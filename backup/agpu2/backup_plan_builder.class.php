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
 * Defines backup_plan_builder class
 *
 * @package     core_backup
 * @subpackage  agpu2
 * @category    backup
 * @copyright   2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

require_once($CFG->dirroot . '/backup/agpu2/backup_root_task.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_activity_task.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_section_task.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_course_task.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_final_task.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_block_task.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_default_block_task.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_xml_transformer.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_qbank_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_qtype_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_qtype_extrafields_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_gradingform_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_format_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_local_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_theme_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_report_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_coursereport_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_plagiarism_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_enrol_plugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_subplugin.class.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_settingslib.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_stepslib.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_custom_fields.php');

// Load all the activity tasks for agpu2 format
$mods = core_component::get_plugin_list('mod');
foreach ($mods as $mod => $moddir) {
    $taskpath = $moddir . '/backup/agpu2/backup_' . $mod . '_activity_task.class.php';
    if (plugin_supports('mod', $mod, FEATURE_BACKUP_agpu2)) {
        if (file_exists($taskpath)) {
            require_once($taskpath);
        }
    }
}

// Load all the block tasks for agpu2 format
$blocks = core_component::get_plugin_list('block');
foreach ($blocks as $block => $blockdir) {
    $taskpath = $blockdir . '/backup/agpu2/backup_' . $block . '_block_task.class.php';
    if (file_exists($taskpath)) {
        require_once($taskpath);
    }
}

/**
 * Abstract class defining the static method in charge of building the whole
 * backup plan, based in @backup_controller preferences.
 *
 * TODO: Finish phpdocs
 */
abstract class backup_plan_builder {

    /**
     * Dispatches, based on type to specialised builders
     */
    public static function build_plan($controller) {

        $plan = $controller->get_plan();

        // Add the root task, responsible for storing global settings
        // and some init tasks
        $plan->add_task(new backup_root_task('root_task'));

        switch ($controller->get_type()) {
            case backup::TYPE_1ACTIVITY:
                self::build_activity_plan($controller, $controller->get_id());
                break;
            case backup::TYPE_1SECTION:
                self::build_section_plan($controller, $controller->get_id());
                break;
            case backup::TYPE_1COURSE:
                self::build_course_plan($controller, $controller->get_id());
                break;
        }

        // Add the final task, responsible for outputting
        // all the global xml files (groups, users,
        // gradebook, questions, roles, files...) and
        // the main agpu_backup.xml file
        // and perform other various final actions.
        $plan->add_task(new backup_final_task('final_task'));
    }


    /**
     * Return one array of supported backup types
     */
    public static function supported_backup_types() {
        return array(backup::TYPE_1COURSE, backup::TYPE_1SECTION, backup::TYPE_1ACTIVITY);
    }

// Protected API starts here

    /**
     * Build one 1-activity backup
     */
    protected static function build_activity_plan($controller, $id) {

        $plan = $controller->get_plan();

        // Add the activity task, responsible for outputting
        // all the module related information
        try {
            $plan->add_task(backup_factory::get_backup_activity_task($controller->get_format(), $id));

            // Some activities may have delegated section integrations.
            self::build_delegated_section_plan($controller, $id);

            // For the given activity, add as many block tasks as necessary
            $blockids = backup_plan_dbops::get_blockids_from_moduleid($id);
            foreach ($blockids as $blockid) {
                try {
                    $plan->add_task(backup_factory::get_backup_block_task($controller->get_format(), $blockid, $id));
                } catch (backup_task_exception $e) {
                    $a = stdClass();
                    $a->mid = $id;
                    $a->bid = $blockid;
                    $controller->log(get_string('error_block_for_module_not_found', 'backup', $a), backup::LOG_WARNING);
                }
            }
        } catch (backup_task_exception $e) {
            $controller->log(get_string('error_course_module_not_found', 'backup', $id), backup::LOG_WARNING);
        }
    }

    /**
     * Build a course module delegated section backup plan.
     * @param backup_controller $controller
     * @param int $cmid the parent course module id.
     */
    protected static function build_delegated_section_plan($controller, $cmid) {
        global $CFG, $DB;

        // Check moduleid exists.
        if (!$coursemodule = get_coursemodule_from_id(false, $cmid)) {
            $controller->log(get_string('error_course_module_not_found', 'backup', $cmid), backup::LOG_WARNING);
        }
        $classname = 'mod_' . $coursemodule->modname . '\courseformat\sectiondelegate';
        if (!class_exists($classname)) {
            return;
        }
        $sectionid = null;
        try {
            $sectionid = $classname::delegated_section_id($coursemodule);
        } catch (dml_exception $error) {
            $controller->log(get_string('error_delegate_section_not_found', 'backup', $cmid), backup::LOG_WARNING);
            return;
        }

        $plan = $controller->get_plan();
        $sectiontask = backup_factory::get_backup_section_task($controller->get_format(), $sectionid);
        $sectiontask->set_delegated_cm($cmid);
        $plan->add_task($sectiontask);

        // For the given section, add as many activity tasks as necessary.
        $coursemodules = backup_plan_dbops::get_modules_from_sectionid($sectionid);
        foreach ($coursemodules as $coursemodule) {
            if (plugin_supports('mod', $coursemodule->modname, FEATURE_BACKUP_agpu2)) {
                self::build_activity_plan($controller, $coursemodule->id);
            }
        }
    }

    /**
     * Build one 1-section backup
     */
    protected static function build_section_plan($controller, $id) {

        $plan = $controller->get_plan();

        // Add the section task, responsible for outputting
        // all the section related information
        $plan->add_task(backup_factory::get_backup_section_task($controller->get_format(), $id));

        // For the given section, add as many activity tasks as necessary
        $coursemodules = backup_plan_dbops::get_modules_from_sectionid($id);
        foreach ($coursemodules as $coursemodule) {
            if (plugin_supports('mod', $coursemodule->modname, FEATURE_BACKUP_agpu2)) { // Check we support the format
                self::build_activity_plan($controller, $coursemodule->id);
            } else {
                // TODO: Debug information about module not supported
            }
        }
    }

    /**
     * Build one 1-course backup
     */
    protected static function build_course_plan($controller, $id) {

        $plan = $controller->get_plan();

        // Add the course task, responsible for outputting
        // all the course related information
        $plan->add_task(backup_factory::get_backup_course_task($controller->get_format(), $id));

        // For the given course, add as many section tasks as necessary
        $sections = backup_plan_dbops::get_sections_from_courseid($id);
        foreach ($sections as $sectionid) {
            // Delegated sections are not course responsability.
            $sectiondata = backup_plan_dbops::get_section_from_id($sectionid);
            if (!empty($sectiondata->component)) {
                continue;
            }
            self::build_section_plan($controller, $sectionid);
        }

        // For the given course, add as many block tasks as necessary
        $blockids = backup_plan_dbops::get_blockids_from_courseid($id);
        foreach ($blockids as $blockid) {
            $plan->add_task(backup_factory::get_backup_block_task($controller->get_format(), $blockid));
        }
    }
}
