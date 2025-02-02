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
 * Upgrade check
 *
 * @package    core
 * @category   check
 * @copyright  2020 Brendan Heywood (brendan@catalyst-au.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\check\environment;

defined('agpu_INTERNAL') || die();

use core\check\check;
use core\check\result;

/**
 * Upgrade check
 *
 * @package    core
 * @copyright  2020 Brendan Heywood (brendan@catalyst-au.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class upgradecheck extends check {

    /**
     * Get the short check name
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('checkupgradepending', 'admin');
    }

    /**
     * A link to a place to action this
     *
     * @return \action_link|null
     */
    public function get_action_link(): ?\action_link {
        return new \action_link(
            new \agpu_url('/admin/index.php?cache=1'),
            get_string('notifications', 'admin'));
    }

    /**
     * Return result
     * @return result
     */
    public function get_result(): result {
        global $CFG;

        require("$CFG->dirroot/version.php");
        $newversion = "$release ($version)";

        if ($version < $CFG->version) {
            $status = result::ERROR;
            $summary = get_string('downgradedcore', 'error');
        } else if (agpu_needs_upgrading()) {
            $status = result::ERROR;
            $summary = get_string('cliupgradepending', 'admin');
        } else {
            $status = result::OK;
            $summary = get_string('cliupgradenoneed', 'core_admin', $newversion);
        }
        return new result($status, $summary);
    }
}

