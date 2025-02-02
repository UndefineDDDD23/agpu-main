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
 * Contains event class for displaying a list of calendar events for a single course.
 *
 * @package   core_calendar
 * @copyright 2017 Ryan Wyllie <ryan@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_calendar\external;

defined('agpu_INTERNAL') || die();

use \renderer_base;

/**
 * Class for displaying a list of calendar events for a single course.
 *
 * This class uses the events relateds cache in order to get the related
 * data for exporting an event without having to naively hit the database
 * for each event.
 *
 * @package   core_calendar
 * @copyright 2017 Ryan Wyllie <ryan@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class events_same_course_exporter extends events_exporter {

    /**
     * @var array $courseid The id of the course for these events.
     */
    protected $courseid;

    /**
     * Constructor.
     *
     * @param int $courseid The course id for these events
     * @param array $events An array of event_interface objects
     * @param array $related An array of related objects
     */
    public function __construct($courseid, array $events, $related = []) {
        parent::__construct($events, $related);
        $this->courseid = $courseid;
    }

    /**
     * Return the list of additional properties.
     *
     * @return array
     */
    protected static function define_other_properties() {
        $properties = parent::define_other_properties();
        $properties['courseid'] = ['type' => PARAM_INT];
        return $properties;
    }

    /**
     * Get the additional values to inject while exporting.
     *
     * @param renderer_base $output The renderer.
     * @return array Keys are the property names, values are their values.
     */
    protected function get_other_values(renderer_base $output) {
        $values = parent::get_other_values($output);
        $values['courseid'] = $this->courseid;
        return $values;
    }
}
