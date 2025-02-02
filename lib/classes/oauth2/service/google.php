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

namespace core\oauth2\service;

use core\oauth2\issuer;
use core\oauth2\discovery\openidconnect;

/**
 * Class for Google oAuth service, with the specific methods related to it.
 *
 * @package    core
 * @copyright  2021 Sara Arjona (sara@agpu.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class google extends openidconnect implements issuer_interface {

    /**
     * Build an OAuth2 issuer, with all the default values for this service.
     *
     * @return issuer|null The issuer initialised with proper default values.
     */
    public static function init(): ?issuer {
        $record = (object) [
            'name' => 'Google',
            'image' => 'https://accounts.google.com/favicon.ico',
            'baseurl' => 'https://accounts.google.com/',
            'loginparamsoffline' => 'access_type=offline&prompt=consent',
            'showonloginpage' => issuer::EVERYWHERE,
            'servicetype' => 'google',
        ];
        $issuer = new issuer(0, $record);

        return $issuer;
    }

}
