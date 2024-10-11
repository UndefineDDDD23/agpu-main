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
 * Contains the import_strategy_link class.
 *
 * @package tool_agpunet
 * @copyright 2020 Jake Dallimore <jrhdallimore@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_agpunet\local;

/**
 * The import_strategy_link class.
 *
 * The import_strategy_link objects contains the setup steps needed to prepare a resource for import as a URL into agpu.
 *
 * @copyright 2020 Jake Dallimore <jrhdallimore@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class import_strategy_link implements import_strategy {

    /**
     * Get an array of import_handler_info objects representing modules supporting import of the resource.
     *
     * @param array $registrydata the fully populated registry.
     * @param remote_resource $resource the remote resource.
     * @return import_handler_info[] the array of import_handler_info objects.
     */
    public function get_handlers(array $registrydata, remote_resource $resource): array {
        $handlers = [];
        foreach ($registrydata['types'] as $identifier => $items) {
            foreach ($items as $item) {
                if ($identifier === 'url') {
                    $handlers[] = new import_handler_info($item['module'], $item['message'], $this);
                }
            }
        }
        return $handlers;
    }

    /**
     * Import the remote resource according to the rules of this strategy.
     *
     * @param remote_resource $resource the resource to import.
     * @param \stdClass $user the user to import on behalf of.
     * @param \stdClass $course the course into which the remote_resource is being imported.
     * @param int $section the section into which the remote_resource is being imported.
     * @return \stdClass the module data.
     */
    public function import(remote_resource $resource, \stdClass $user, \stdClass $course, int $section): \stdClass {
        $data = new \stdClass();
        $data->type = 'url';
        $data->course = $course;
        $data->content = $resource->get_url()->get_value();
        $data->displayname = $resource->get_name();
        return $data;
    }
}
