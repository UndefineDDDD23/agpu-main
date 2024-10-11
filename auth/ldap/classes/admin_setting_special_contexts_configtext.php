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
 * Special setting for auth_ldap that cleans up context values on save..
 *
 * @package    auth_ldap
 * @copyright  2017 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Special setting for auth_ldap that cleans up context values on save..
 *
 * @package    auth_ldap
 * @copyright  2017 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class auth_ldap_admin_setting_special_contexts_configtext extends admin_setting_configtext {

    /**
     * We need to remove duplicates on save to prevent issues in other areas of agpu.
     *
     * @param string $data Form data.
     * @return string Empty when no errors.
     */
    public function write_setting($data) {
        // Try to remove duplicates before storing the contexts (to avoid problems in sync_users()).
        $data = explode(';', $data);
        $data = array_map(function($x) {
            return core_text::strtolower(trim($x));
        }, $data);
        $data = implode(';', array_unique($data));
        return parent::write_setting($data);
    }
}
