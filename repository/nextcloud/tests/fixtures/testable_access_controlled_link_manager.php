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
 * Test support class for testing access_controlled_link_manager.
 *
 * @package    repository_nextcloud
 * @copyright  2018 Nina Herrmann (Learnweb, University of Münster)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('agpu_INTERNAL') || die();

use core\oauth2\client;
use repository_nextcloud\access_controlled_link_manager;
use repository_nextcloud\ocs_client;

/**
 * Test support class for testing access_controlled_link_manager.
 *
 * @package    repository_nextcloud
 * @copyright  2018 Nina Herrmann (Learnweb, University of Münster)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class testable_access_controlled_link_manager extends access_controlled_link_manager {

    /**
     * Access_controlled_link_manager constructor.
     * @param ocs_client $ocsclient
     * @param client $systemoauthclient
     * @param ocs_client $systemocsclient
     * @param \core\oauth2\issuer $issuer
     * @param string $repositoryname
     * @param \webdav_client $systemdav
     */
    public function __construct($ocsclient, $systemoauthclient, $systemocsclient, \core\oauth2\issuer $issuer, $repositoryname,
                                $systemdav) {
        $this->ocsclient = $ocsclient;
        $this->systemoauthclient = $systemoauthclient;
        $this->systemocsclient = $systemocsclient;
        $this->repositoryname = $repositoryname;
        $this->issuer = $issuer;
        $this->systemwebdavclient = $systemdav;
    }
}
