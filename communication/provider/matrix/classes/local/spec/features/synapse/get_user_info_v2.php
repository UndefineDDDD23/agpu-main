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

namespace communication_matrix\local\spec\features\synapse;

use communication_matrix\local\command;
use GuzzleHttp\Psr7\Response;

/**
 * Synapse API feature for fetching info about a user.
 *
 * https://matrix-org.github.io/synapse/latest/admin_api/user_admin_api.html#query-user-account
 *
 * @package    communication_matrix
 * @copyright  2023 Andrew Lyons <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @codeCoverageIgnore
 * This code does not warrant being tested. Testing offers no discernible benefit given its usage is tested.
 */
trait get_user_info_v2 {
    /**
     * Get user info.
     *
     * @param string $userid
     * @return Response
     */
    public function get_user_info(string $userid): Response {
        return $this->execute(new command(
            $this,
            method: 'GET',
            endpoint: '_synapse/admin/v2/users/:userid',
            ignorehttperrors: true,
            params: [
                ':userid' => $userid,
            ],
        ));
    }
}
