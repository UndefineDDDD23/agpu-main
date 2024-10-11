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

namespace mod_lti\external;

use core_external\external_api;

defined('agpu_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/mod/lti/tests/mod_lti_testcase.php');

/**
 * PHPUnit tests for get_tool_types_and_proxies_count external function.
 *
 * @package    mod_lti
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2021 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_tool_types_and_proxies_count_test extends \mod_lti_testcase {

    /**
     * This method runs before every test.
     */
    public function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
        $this->setAdminUser();
    }

    /**
     * Test get_tool_types_and_proxies_count returns the correct number.
     */
    public function test_mod_lti_get_tool_types_and_proxies_count(): void {
        for ($i = 0; $i < 10; $i++) {
            $proxy = $this->generate_tool_proxy($i);
            $this->generate_tool_type($i, $proxy->id);
        }

        $data = \mod_lti\external\get_tool_types_and_proxies_count::execute(0, false);
        $data = external_api::clean_returnvalue(\mod_lti\external\get_tool_types_and_proxies_count::execute_returns(), $data);

        $this->assertEquals(20, $data['count']);
    }

    /**
     * Test get_tool_types_and_proxies_count returns the correct number.
     */
    public function test_mod_lti_get_tool_types_and_proxies_count_with_no_tools_configured(): void {
        $data = \mod_lti\external\get_tool_types_and_proxies_count::execute(0, false);
        $data = external_api::clean_returnvalue(\mod_lti\external\get_tool_types_and_proxies_count::execute_returns(), $data);

        $this->assertEquals(0, $data['count']);
    }
}
