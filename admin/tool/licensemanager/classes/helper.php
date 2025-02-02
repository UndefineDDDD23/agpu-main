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


namespace tool_licensemanager;

use agpu_url;


/**
 * License manager helper class.
 *
 * @package    tool_licensemanager
 * @copyright  2019 Tom Dickman <tomdickman@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class helper {

    /**
     * agpu relative path to the licenses manager.
     */
    const MANAGER_PATH = '/admin/tool/licensemanager/index.php';

    /**
     * Get the URL for viewing the license manager interface.
     *
     * @return \agpu_url
     */
    public static function get_licensemanager_url(): agpu_url {
        return new agpu_url(self::MANAGER_PATH);
    }

    /**
     * Get the URL for endpoint enabling a license.
     *
     * @param string $licenseshortname the shortname of license to enable.
     *
     * @return \agpu_url
     */
    public static function get_enable_license_url(string $licenseshortname): agpu_url {
        $url = new agpu_url(self::MANAGER_PATH,
            ['action' => manager::ACTION_ENABLE, 'license' => $licenseshortname, 'sesskey' => sesskey()]);

        return $url;
    }

    /**
     * Get the URL for endpoint disabling a license.
     *
     * @param string $licenseshortname the shortname of license to disable.
     *
     * @return \agpu_url
     */
    public static function get_disable_license_url(string $licenseshortname): agpu_url {
        $url = new agpu_url(self::MANAGER_PATH,
            ['action' => manager::ACTION_DISABLE, 'license' => $licenseshortname, 'sesskey' => sesskey()]);

        return $url;
    }

    /**
     * Get the URL endpoint to create a new license.
     *
     * @return \agpu_url
     */
    public static function get_create_license_url(): agpu_url {
        $url = self::get_licensemanager_url();
        $url->params(['action' => manager::ACTION_CREATE]);
        return $url;
    }

    /**
     * Get the URL endpoint to update an existing license.
     *
     * @param string $licenseshortname the shortname of license to update.
     *
     * @return \agpu_url
     */
    public static function get_update_license_url(string $licenseshortname): agpu_url {
        $url = self::get_licensemanager_url();
        $url->params(['action' => manager::ACTION_UPDATE, 'license' => $licenseshortname]);
        return $url;
    }

    /**
     * Get the URL endpoint to move a license up order.
     *
     * @param string $licenseshortname the shortname of license to move up.
     *
     * @return \agpu_url
     */
    public static function get_moveup_license_url(string $licenseshortname): agpu_url {
        $url = new agpu_url(self::MANAGER_PATH,
            ['action' => manager::ACTION_MOVE_UP, 'license' => $licenseshortname, 'sesskey' => sesskey()]);

        return $url;
    }

    /**
     * Get the URL endpoint to move a license down order.
     *
     * @param string $licenseshortname the shortname of license to move down.
     *
     * @return \agpu_url
     */
    public static function get_movedown_license_url(string $licenseshortname): agpu_url {
        $url = new agpu_url(self::MANAGER_PATH,
            ['action' => manager::ACTION_MOVE_DOWN, 'license' => $licenseshortname, 'sesskey' => sesskey()]);

        return $url;
    }

    /**
     * Convert a license version number string to a UNIX epoch.
     *
     * @param string $version
     *
     * @return int $epoch
     */
    public static function convert_version_to_epoch(string $version): int {
        $date = substr($version, 0, 8);
        $epoch = strtotime($date);

        return $epoch;
    }
}
