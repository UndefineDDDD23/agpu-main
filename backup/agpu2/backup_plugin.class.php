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
 * Defines backup_plugin class
 *
 * @package     core_backup
 * @subpackage  agpu2
 * @category    backup
 * @copyright   2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Class implementing the plugins support for agpu2 backups
 *
 * TODO: Finish phpdocs
 */
abstract class backup_plugin {

    /** @var string */
    protected $plugintype;
    /** @var string */
    protected $pluginname;
    /** @var string */
    protected $connectionpoint;
    /** @var backup_optigroup_element */
    protected $optigroup; // Optigroup, parent of all optigroup elements
    /** @var backup_structure_step */
    protected $step;
    /** @var backup_course_task|backup_activity_task */
    protected $task;

    /**
     * backup_plugin constructor.
     *
     * @param string $plugintype
     * @param string $pluginname
     * @param backup_optigroup_element $optigroup
     * @param backup_structure_step $step
     */
    public function __construct($plugintype, $pluginname, $optigroup, $step) {
        $this->plugintype = $plugintype;
        $this->pluginname = $pluginname;
        $this->optigroup  = $optigroup;
        $this->connectionpoint = '';
        $this->step       = $step;
        $this->task       = $step->get_task();
    }

    public function define_plugin_structure($connectionpoint) {

        $this->connectionpoint = $connectionpoint;

        $methodname = 'define_' . $connectionpoint . '_plugin_structure';

        if (method_exists($this, $methodname)) {
            $this->$methodname();
        }
    }

// Protected API starts here

// backup_step/structure_step/task wrappers

    /**
     * Returns the value of one (task/plan) setting
     */
    protected function get_setting_value($name) {
        if (is_null($this->task)) {
            throw new backup_step_exception('not_specified_backup_task');
        }
        return $this->task->get_setting_value($name);
    }

// end of backup_step/structure_step/task wrappers

    /**
     * Factory method that will return one backup_plugin_element (backup_optigroup_element)
     * with its name automatically calculated, based one the plugin being handled (type, name)
     */
    protected function get_plugin_element($final_elements = null, $conditionparam = null, $conditionvalue = null) {
        // Something exclusive for this backup_plugin_element (backup_optigroup_element)
        // because it hasn't XML representation
        $name = 'optigroup_' . $this->plugintype . '_' . $this->pluginname . '_' . $this->connectionpoint;
        $optigroup_element = new backup_plugin_element($name, $final_elements, $conditionparam, $conditionvalue);
        $this->optigroup->add_child($optigroup_element);  // Add optigroup_element to stay connected since beginning
        return $optigroup_element;
    }

    /**
     * Simple helper function that suggests one name for the main nested element in plugins
     * It's not mandatory to use it but recommended ;-)
     */
    protected function get_recommended_name() {
        return 'plugin_' . $this->plugintype . '_' . $this->pluginname . '_' . $this->connectionpoint;
    }

}
