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
 * Capability assigned event.
 *
 * @package    core
 * @since      agpu 3.8
 * @copyright  2019 Simey Lameze <simey@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

defined('agpu_INTERNAL') || die();

/**
 * Capability assigned event class.
 *
 * @package    core
 * @since      agpu 3.8
 * @copyright  2019 Simey Lameze <simey@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class capability_assigned extends base {
    /**
     * Initialise event parameters.
     */
    protected function init() {
        $this->data['objecttable'] = 'role_capabilities';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcapabilityassigned', 'role');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {

        $strpermissions = [
            CAP_INHERIT => get_string('notset', 'role'),
            CAP_ALLOW => get_string('allow', 'role'),
            CAP_PREVENT => get_string('prevent', 'role'),
            CAP_PROHIBIT => get_string('prohibit', 'role')
        ];

        $capability = $this->other['capability'];
        $oldpermission = $this->other['oldpermission'];
        $permission = $this->other['permission'];

        if ($oldpermission == CAP_INHERIT && $permission == CAP_ALLOW) {
            $description = "The user id '$this->userid' assigned the '$capability' capability for " .
                "role '$this->objectid' with '$strpermissions[$permission]' permission";
        } else {
            $description = "The user id '$this->userid' changed the '$capability' capability permission for " .
            "role '$this->objectid' from '$strpermissions[$oldpermission]' to '$strpermissions[$permission]'";
        }

        return $description;
    }

    /**
     * Returns relevant URL.
     *
     * @return \agpu_url
     */
    public function get_url() {
        if ($this->contextlevel == CONTEXT_SYSTEM) {
            return new \agpu_url('/admin/roles/define.php', ['action' => 'edit', 'roleid' => $this->objectid]);
        } else {
            return new \agpu_url('/admin/roles/override.php', ['contextid' => $this->contextid,
                'roleid' => $this->objectid]);
        }
    }
}
