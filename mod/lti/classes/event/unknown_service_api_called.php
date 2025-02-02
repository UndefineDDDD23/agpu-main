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
 * The mod_lti unknown service api called event.
 *
 * @package    mod_lti
 * @copyright  2013 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_lti\event;
defined('agpu_INTERNAL') || die();

/**
 * The mod_lti unknown service api called event class.
 *
 * Event for when something happens with an unknown lti service API call.
 *
 * @package    mod_lti
 * @since      agpu 2.6
 * @copyright  2013 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class unknown_service_api_called extends \core\event\base {

    /** @var \stdClass Data to be used by event observers. */
    protected $eventdata;

    /**
     * Sets custom data used by event observers.
     *
     * @param \stdClass $data
     */
    public function set_message_data(\stdClass $data) {
        $this->eventdata = $data;
    }

    /**
     * Returns custom data for event observers.
     *
     * @return \stdClass
     */
    public function get_message_data() {
        if ($this->is_restored()) {
            throw new \coding_exception('Function get_message_data() can not be used on restored events.');
        }
        return $this->eventdata;
    }

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->context = \context_system::instance();
    }

    /**
     * Returns localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return 'An unknown call to a service api was made.';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('ltiunknownserviceapicall', 'mod_lti');
    }
}
