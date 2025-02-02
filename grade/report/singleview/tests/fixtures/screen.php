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
 * Fixtures for single view report screen class testing.
 *
 * @package    gradereport_singleview
 * @copyright  2014 onwards Simey Lameze <simey@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

class gradereport_singleview_screen_testable extends \gradereport_singleview\local\screen\screen {

    /**
     * Wrapper to make protected method accessible during testing.
     *
     * @return array returns array of users.
     */
    public function test_load_users(): array {
        return $this->load_users();
    }

    /**
     * Return the HTML for the page.
     */
    public function init($selfitemisempty = false) {
    }

    /**
     * Get the type of items on this screen, not valid so return false.
     */
    public function item_type(): string {
    }

    /**
     * Return the HTML for the page.
     */
    public function html(): string {
    }
}
