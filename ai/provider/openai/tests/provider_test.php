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

namespace aiprovider_openai;

/**
 * Test OpenAI provider methods.
 *
 * @package    aiprovider_openai
 * @copyright  2024 Matt Porritt <matt.porritt@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \aiprovider_openai\provider
 */
final class provider_test extends \advanced_testcase {
    /**
     * Test get_action_list
     */
    public function test_get_action_list(): void {
        $provider = new provider();
        $actionlist = $provider->get_action_list();
        $this->assertIsArray($actionlist);
        $this->assertCount(3, $actionlist);
        $this->assertContains(\core_ai\aiactions\generate_text::class, $actionlist);
        $this->assertContains(\core_ai\aiactions\generate_image::class, $actionlist);
        $this->assertContains(\core_ai\aiactions\summarise_text::class, $actionlist);
    }

    /**
     * Test generate_userid.
     */
    public function test_generate_userid(): void {
        $provider = new provider();
        $userid = $provider->generate_userid(1);

        // Assert that the generated userid is a string of proper length.
        $this->assertIsString($userid);
        $this->assertEquals(64, strlen($userid));
    }

    /**
     * Test is_request_allowed.
     */
    public function test_is_request_allowed(): void {
        $this->resetAfterTest();

        // Set plugin config rate limiter settings.
        set_config('enableglobalratelimit', 1, 'aiprovider_openai');
        set_config('globalratelimit', 5, 'aiprovider_openai');
        set_config('enableuserratelimit', 1, 'aiprovider_openai');
        set_config('userratelimit', 3, 'aiprovider_openai');

        $contextid = 1;
        $userid = 1;
        $prompttext = 'This is a test prompt';
        $aspectratio = 'square';
        $quality = 'hd';
        $numimages = 1;
        $style = 'vivid';
        $action = new \core_ai\aiactions\generate_image(
            contextid: $contextid,
            userid: $userid,
            prompttext: $prompttext,
            quality: $quality,
            aspectratio: $aspectratio,
            numimages: $numimages,
            style: $style,
        );
        $provider = new provider();

        // Make 3 requests, all should be allowed.
        for ($i = 0; $i < 3; $i++) {
            $this->assertTrue($provider->is_request_allowed($action));
        }

        // The 4th request for the same user should be denied.
        $result = $provider->is_request_allowed($action);
        $this->assertFalse($result['success']);
        $this->assertEquals('User rate limit exceeded', $result['errormessage']);

        // Change user id to make a request for a different user, should pass (4 requests for global rate).
        $action = new \core_ai\aiactions\generate_image(
            contextid: $contextid,
            userid: 2,
            prompttext: $prompttext,
            quality: $quality,
            aspectratio: $aspectratio,
            numimages: $numimages,
            style: $style,
        );
        $this->assertTrue($provider->is_request_allowed($action));

        // Make a 5th request for the global rate limit, it should be allowed.
        $this->assertTrue($provider->is_request_allowed($action));

        // The 6th request should be denied.
        $result = $provider->is_request_allowed($action);
        $this->assertFalse($result['success']);
        $this->assertEquals('Global rate limit exceeded', $result['errormessage']);
    }

    /**
     * Test is_provider_configured.
     */
    public function test_is_provider_configured(): void {
        $this->resetAfterTest();

        // No configured values.
        $provider = new \aiprovider_openai\provider();
        $this->assertFalse($provider->is_provider_configured());

        // Partially configured values.
        set_config('apikey', '123', 'aiprovider_openai');
        set_config('orgid', '', 'aiprovider_openai');
        $provider = new \aiprovider_openai\provider();
        $this->assertFalse($provider->is_provider_configured());

        // Properly configured values.
        set_config('apikey', '123', 'aiprovider_openai');
        set_config('orgid', 'abc', 'aiprovider_openai');
        $provider = new \aiprovider_openai\provider();
        $this->assertTrue($provider->is_provider_configured());
    }
}
