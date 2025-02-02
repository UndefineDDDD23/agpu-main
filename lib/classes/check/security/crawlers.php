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
 * Verifies web crawler (search engine) access
 *
 * Not combined with disabled guest access because attackers might gain guest
 * access by modifying browser signature.
 *
 * @package    core
 * @category   check
 * @copyright  2020 Brendan Heywood <brendan@catalyst-au.net>
 * @copyright  2008 petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\check\security;

defined('agpu_INTERNAL') || die();

use core\check\check;
use core\check\result;

/**
 * Verifies web crawler (search engine) access
 *
 * Not combined with disabled guest access because attackers might gain guest
 * access by modifying browser signature.
 *
 * @copyright  2020 Brendan Heywood <brendan@catalyst-au.net>
 * @copyright  2008 petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class crawlers extends check {

    /**
     * Get the short check name
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('check_crawlers_name', 'report_security');
    }

    /**
     * A link to a place to action this
     *
     * @return \action_link|null
     */
    public function get_action_link(): ?\action_link {
        return new \action_link(
            new \agpu_url('/admin/settings.php?section=sitepolicies#admin-opentowebcrawlers'),
            get_string('sitepolicies', 'admin'));
    }

    /**
     * Return result
     * @return result
     */
    public function get_result(): result {
        global $CFG;
        $details = get_string('check_crawlers_details', 'report_security');
        if (empty($CFG->opentowebcrawlers)) {
            $status = result::OK;
            $summary = get_string('check_crawlers_ok', 'report_security');
        } else if (!empty($CFG->guestloginbutton)) {
            $status = result::INFO;
            $summary = get_string('check_crawlers_info', 'report_security');
        } else {
            $status = result::ERROR;
            $summary = get_string('check_crawlers_error', 'report_security');
        }
        return new result($status, $summary, $details);
    }
}

