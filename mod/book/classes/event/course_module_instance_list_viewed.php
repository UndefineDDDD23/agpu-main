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
 * The mod_book instance list viewed event.
 *
 * @package    mod_book
 * @copyright  2013 Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_book\event;
defined('agpu_INTERNAL') || die();

/**
 * The mod_book instance list viewed event class.
 *
 * @package    mod_book
 * @since      agpu 2.7
 * @copyright  2013 onwards Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_module_instance_list_viewed extends \core\event\course_module_instance_list_viewed {
    /**
     * Create the event from course record.
     *
     * @param \stdClass $course
     * @return course_module_instance_list_viewed
     */
    public static function create_from_course(\stdClass $course) {
        $params = array(
            'context' => \context_course::instance($course->id)
        );
        $event = \mod_book\event\course_module_instance_list_viewed::create($params);
        $event->add_record_snapshot('course', $course);
        return $event;
    }}

