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

namespace core\event;

use advanced_testcase;
use context_course;
use context_system;
use Exception;
use agpu_url;

defined('agpu_INTERNAL') || die();
require_once(__DIR__.'/../fixtures/event_mod_fixtures.php');

/**
 * Tests for base course module instance list viewed event.
 *
 * @package    core
 * @category   phpunit
 * @covers     \core\event\course_module_instance_list_viewed
 * @copyright  2013 Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class course_module_instance_list_viewed_test extends advanced_testcase {

    /**
     * Test event properties and methods.
     */
    public function test_event_attributes() {

        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        // Trigger the page view event.
        $sink = $this->redirectEvents();
        $event = \mod_unittests\event\course_module_instance_list_viewed::create(array(
             'context' => $context,
        ));
        $event->trigger();
        $result = $sink->get_events();
        $event = reset($result);
        $sink->close();

        // Test event data.
        $url = new agpu_url('/mod/unittests/index.php', array('id' => $course->id));
        $this->assertEquals($url, $event->get_url());
        $this->assertEventContextNotUsed($event);

    }

    /**
     * Test custom validations of the event.
     */
    public function test_event_validations() {
        try {
            \mod_unittests\event\course_module_instance_list_viewed::create(array('context' => context_system::instance()));
            $this->fail('Event validation should not allow course_module_instance_list_viewed event to be triggered without outside
                    course context');
        } catch (Exception $e) {
            $this->assertInstanceOf('coding_exception', $e);
        }
    }
}
