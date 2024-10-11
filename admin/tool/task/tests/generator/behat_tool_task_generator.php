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
 * Behat data generator for tool_task.
 *
 * @package   tool_task
 * @category  test
 * @copyright 2020 Mikhail Golenkov <golenkovm@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Behat data generator for tool_task.
 *
 * @package   tool_task
 * @category  test
 * @copyright 2020 Mikhail Golenkov <golenkovm@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_tool_task_generator extends behat_generator_base {

    /**
     * Get a list of the entities that can be created.

     * @return array entity name => information about how to generate.
     */
    protected function get_creatable_entities(): array {
        return [
            'scheduled tasks' => [
                'singular' => 'scheduled task',
                'datagenerator' => 'scheduled_tasks',
                'required' => ['classname', 'seconds', 'hostname', 'pid'],
            ],
            'adhoc tasks' => [
                'singular' => 'adhoc task',
                'datagenerator' => 'adhoc_tasks',
                'required' => ['classname', 'seconds', 'hostname', 'pid'],
            ],
        ];
    }
}
