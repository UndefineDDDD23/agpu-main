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

namespace core\external;

use core\oauth2\api;
use core_external\external_api;
use externallib_advanced_testcase;

defined('agpu_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/tests/agpunet/helpers.php');
require_once($CFG->dirroot . '/webservice/tests/helpers.php');

/**
 * External functions test for agpunet_get_shared_course_info.
 *
 * @package    core
 * @category   test
 * @copyright  2023 Safat Shahin <safat.shahin@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \core\external\agpunet_get_shared_course_info
 */
class agpunet_get_shared_course_info_test extends externallib_advanced_testcase {

    /**
     * Test the behaviour of agpunet_get_shared_course_info().
     *
     * @covers ::execute
     */
    public function test_agpunet_get_shared_course_info(): void {
        global $CFG;
        $this->resetAfterTest();
        $this->setAdminUser();
        $CFG->enablesharingtoagpunet = true;

        // Generate course and activities.
        $course = $this->getDataGenerator()->create_course();

        // Create dummy enabled issuer.
        $issuer = \core\agpunet\helpers::get_mock_issuer(1);

        // Test the course with no OAuth2 setup yet.
        $result = agpunet_get_shared_course_info::execute($course->id);
        $result = external_api::clean_returnvalue(agpunet_get_shared_course_info::execute_returns(), $result);
        $this->assertFalse($result['status']);
        $this->assertEmpty($result['name']);
        $this->assertEmpty($result['type']);
        $this->assertEmpty($result['server']);
        $this->assertEmpty($result['supportpageurl']);
        $this->assertNotEmpty($result['warnings']);
        $this->assertEquals(0, $result['warnings'][0]['item']);
        $this->assertEquals('errorissuernotset', $result['warnings'][0]['warningcode']);
        $this->assertEquals(get_string('agpunet:issuerisnotset', 'agpu'), $result['warnings'][0]['message']);

        // Test the course with OAuth2 disabled.
        set_config('oauthservice', $issuer->get('id'), 'agpunet');
        $issuer->set('enabled', 0);
        $irecord = $issuer->to_record();
        api::update_issuer($irecord);

        $result = agpunet_get_shared_course_info::execute($course->id);
        $result = external_api::clean_returnvalue(agpunet_get_shared_course_info::execute_returns(), $result);
        $this->assertFalse($result['status']);
        $this->assertEmpty($result['name']);
        $this->assertEmpty($result['type']);
        $this->assertEmpty($result['server']);
        $this->assertEmpty($result['supportpageurl']);
        $this->assertNotEmpty($result['warnings']);
        $this->assertEquals($issuer->get('id'), $result['warnings'][0]['item']);
        $this->assertEquals('errorissuernotenabled', $result['warnings'][0]['warningcode']);
        $this->assertEquals(get_string('agpunet:issuerisnotenabled', 'agpu'), $result['warnings'][0]['message']);

        // Test the course with support url is set to the internal contact site support page.
        $issuer->set('enabled', 1);
        $irecord = $issuer->to_record();
        api::update_issuer($irecord);

        $expectedsupporturl = $CFG->wwwroot . '/user/contactsitesupport.php';
        $result = agpunet_get_shared_course_info::execute($course->id);
        $result = external_api::clean_returnvalue(agpunet_get_shared_course_info::execute_returns(), $result);
        $this->assertTrue($result['status']);
        $this->assertEquals($course->fullname, $result['name']);
        $this->assertEquals(get_string('course'), $result['type']);
        $this->assertEquals($issuer->get_display_name(), $result['server']);
        $this->assertEquals($expectedsupporturl, $result['supportpageurl']);
    }
}
