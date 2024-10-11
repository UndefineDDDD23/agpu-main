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

namespace core\agpunet;

use core\oauth2\issuer;

/**
 * Helper for tests related to agpuNet integration.
 *
 * @package core
 * @copyright 2023 Michael Hawkins <michaelh@agpu.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class helpers {
    /**
     * Create and return a mock agpuNet issuer.
     *
     * @param int $enabled Whether the issuer is enabled.
     * @return issuer The issuer that has been created.
     */
    public static function get_mock_issuer(int $enabled): issuer {
        $record = (object) [
            'name' => 'agpuNet',
            'image' => 'https://agpu.net/favicon.ico',
            'baseurl' => 'https://agpunet.example.com',
            'loginscopes' => '',
            'loginscopesoffline' => '',
            'loginparamsoffline' => '',
            'showonloginpage' => issuer::SERVICEONLY,
            'servicetype' => 'agpunet',
            'enabled' => $enabled,
        ];
        $issuer = new issuer(0, $record);
        $issuer->create();

        return $issuer;
    }
}
