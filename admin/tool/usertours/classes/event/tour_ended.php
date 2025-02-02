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

namespace tool_usertours\event;

/**
 * The tool_usertours tour_ended event.
 *
 * @package    tool_usertours
 * @copyright  2016 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int       tourid:     The id of the tour
 *      - string    pageurl:    The URL of the page viewing the tour
 * }
 */
class tour_ended extends \core\event\base {
    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'tool_usertours_tours';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('event_tour_ended', 'tool_usertours');
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['stepindex'])) {
            throw new \coding_exception('The \'stepindex\' value must be set in other.');
        }

        if (!isset($this->other['stepid'])) {
            throw new \coding_exception('The \'stepid\' value must be set in other.');
        }

        if (!isset($this->other['pageurl'])) {
            throw new \coding_exception('The \'pageurl\' value must be set in other.');
        }
    }

    /**
     * This is used when restoring course logs where it is required that we
     * map the information in 'other' to it's new value in the new course.
     *
     * Does nothing in the base class except display a debugging message warning
     * the user that the event does not contain the required functionality to
     * map this information. For events that do not store any other information this
     * won't be called, so no debugging message will be displayed.
     *
     * @return array an array of other values and their corresponding mapping
     */
    public static function get_other_mapping() {
        return [
            'stepindex' => \core\event\base::NOT_MAPPED,
            'stepid'    => [
                'db'        => 'tool_usertours_steps',
                'restore'   => \core\event\base::NOT_MAPPED,
            ],
            'pageurl'   => \core\event\base::NOT_MAPPED,
        ];
    }

    /**
     * This is used when restoring course logs where it is required that we
     * map the objectid to it's new value in the new course.
     *
     * Does nothing in the base class except display a debugging message warning
     * the user that the event does not contain the required functionality to
     * map this information. For events that do not store an objectid this won't
     * be called, so no debugging message will be displayed.
     *
     * @return string the name of the restore mapping the objectid links to
     */
    public static function get_objectid_mapping() {
        return [
            'db'        => 'tool_usertours_tours',
            'restore'   => \core\event\base::NOT_MAPPED,
        ];
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '{$this->userid}' has ended the tour with id " .
            "'{$this->objectid}' at step index " .
            "'{$this->other['stepindex']}' (id '{$this->other['stepid']}') on the page with URL " .
            "'{$this->other['pageurl']}'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return \tool_usertours\helper::get_view_tour_link($this->objectid);
    }
}
