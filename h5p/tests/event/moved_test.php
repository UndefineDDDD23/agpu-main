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

namespace core_h5p\event;

use core_h5p\local\library\autoloader;

/**
 * Tests for h5p viewed event.
 *
 * @package    core_h5p
 * @category   test
 * @copyright  2019 Carlos Escobedo <carlos@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      agpu 3.8
 */
class moved_test extends \advanced_testcase {

    /**
     * Setup test.
     */
    protected function setUp(): void {
        parent::setUp();
        autoloader::register();
    }

    /**
     * test_event_h5p_viewed description
     * @runInSeparateProcess
     */
    public function test_event_h5p_viewed(): void {
        $this->resetAfterTest(true);

        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $page = $this->getDataGenerator()->create_module('page', array('course' => $course->id));
        $pagecontext = \context_module::instance($page->cmid);
        // Url dummy just for testing proposal.
        $url  = \agpu_url::make_pluginfile_url(
            $pagecontext->id,
            \core_h5p\file_storage::COMPONENT,
            'unittest',
            0,
            '/',
            'h5pfiletest.h5p'
        );
        // Dummy H5P id for testing proposal. We don't need a real h5p.
        $dummyh5pid = 111;
        $now = time();
        // Event parameters for testing.
        $params = [
            'objectid' => $dummyh5pid,
            'userid' => $user->id,
            'context' => $pagecontext,
            'other' => [
                'url' => $url->out(),
                'time' => $now
            ]
        ];
        // Prepare redirect Events.
        $sink = $this->redirectEvents();
        // Test the event H5P viewed.
        $event = h5p_viewed::create($params);
        $event->trigger();
        $result = $sink->get_events();
        $event = reset($result);
        $sink->close();
        // Check the event info.
        $this->assertEquals($dummyh5pid, $event->objectid);
        $this->assertEquals($user->id, $event->userid);
        $this->assertEquals($pagecontext->id, $event->contextid);
        $this->assertEquals($url->out(), $event->other['url']);
        $this->assertEquals($now, $event->other['time']);
    }
}
