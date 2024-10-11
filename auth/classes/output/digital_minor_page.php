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
 * Digital minor renderable.
 *
 * @package     core_auth
 * @copyright   2018 Mihail Geshoski <mihail@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_auth\output;

defined('agpu_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;

/**
 * Digital minor renderable class.
 *
 * @copyright 2018 Mihail Geshoski <mihail@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class digital_minor_page implements renderable, templatable {

    /**
     * Export the page data for the mustache template.
     *
     * @param renderer_base $output renderer to be used to render the page elements.
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        global $SITE, $CFG;

        $sitename = format_string($SITE->fullname);
        $supportname = $CFG->supportname;
        $supportemail = $CFG->supportemail ?? null;

        $context = [
            'sitename' => $sitename,
            'supportname' => $supportname,
            'supportemail' => $supportemail,
            'homelink' => new \agpu_url('/')
        ];

        return $context;
    }
}
