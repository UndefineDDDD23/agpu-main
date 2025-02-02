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
 * Mnet access control updated event.
 *
 * @package    core
 * @since      agpu 2.7
 * @copyright  2013 Mark Nelson <markn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

defined('agpu_INTERNAL') || die();

/**
 * Mnet access control updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string username: the username of the user.
 *      - string hostname: the name of the host the user came from.
 *      - string accessctrl: the access control value.
 * }
 *
 * @package    core
 * @since      agpu 2.7
 * @copyright  2013 Mark Nelson <markn@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mnet_access_control_updated extends base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'mnet_sso_access_control';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventaccesscontrolupdated', 'mnet');
    }

    /**
     * Returns relevant URL.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/admin/mnet/access_control.php');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated access control for the user with username '{$this->other['username']}' " .
            "belonging to mnet host '{$this->other['hostname']}'.";
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['username'])) {
            throw new \coding_exception('The \'username\' value must be set in other.');
        }

        if (!isset($this->other['hostname'])) {
            throw new \coding_exception('The \'hostname\' value must be set in other.');
        }

        if (!isset($this->other['accessctrl'])) {
            throw new \coding_exception('The \'accessctrl\' value must be set in other.');
        }
    }

    public static function get_objectid_mapping() {
        // Mnet info is not backed up, so no need to map on restore.
        return array('db' => 'mnet_sso_access_control', 'restore' => base::NOT_MAPPED);
    }

    public static function get_other_mapping() {
        // Nothing to map.
        return false;
    }

    public static function is_deprecated() {
        return true;
    }
}
