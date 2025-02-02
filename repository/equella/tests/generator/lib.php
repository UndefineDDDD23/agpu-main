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
 * Equella repository data generator
 *
 * @package    repository_equella
 * @category   test
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Equella repository data generator class
 *
 * @package    repository_equella
 * @category   test
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class repository_equella_generator extends testing_repository_generator {

    /**
     * Fill in record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_record(array $record) {
        $record = parent::prepare_record($record);
        if (!isset($record['equella_url'])) {
            $record['equella_url'] = 'http://dummy.url.com';
        }
        if (!isset($record['equella_userfield'])) {
            $record['equella_userfield'] = 'default';
        }
        if (!isset($record['equella_select_restriction'])) {
            $record['equella_select_restriction'] = 'none';
        }
        if (!isset($record['equella_options'])) {
            $record['equella_options'] = '';
        }
        if (!isset($record['equella_shareid'])) {
            $record['equella_shareid'] = 'id';
        }
        if (!isset($record['equella_sharedsecret'])) {
            $record['equella_sharedsecret'] = 'secret';
        }
        // Set defaults for all generated options for each role with editing capabilities.
        $editingroles = get_roles_with_capability('agpu/course:manageactivities', CAP_ALLOW);
        foreach ($editingroles as $role) {
            if (!isset($record["equella_{$role->shortname}_shareid"])) {
                $record["equella_{$role->shortname}_shareid"] = '';
            }
            if (!isset($record["equella_{$role->shortname}_sharedsecret"])) {
                $record["equella_{$role->shortname}_sharedsecret"] = '';
            }
        }
        return $record;
    }

}
