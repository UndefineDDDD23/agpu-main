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
 * The mod_workshop submission viewed event.
 *
 * @package    mod_workshop
 * @copyright  2013 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_workshop\event;
defined('agpu_INTERNAL') || die();

/**
 * The mod_workshop submission viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int workshopid: (optional) workshop ID.
 * }
 *
 * @package    mod_workshop
 * @since      agpu 2.7
 * @copyright  2013 Adrian Greeve
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class submission_viewed extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'workshop_submissions';
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the submission with id '$this->objectid' for the workshop " .
            "with course module id '$this->contextinstanceid'.";
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubmissionviewed', 'workshop');
    }

    /**
     * Returns relevant URL.
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/workshop/submission.php',
                array('cmid' => $this->contextinstanceid, 'id' => $this->objectid));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }

    public static function get_objectid_mapping() {
        return array('db' => 'workshop_submissions', 'restore' => 'workshop_submission');
    }

    public static function get_other_mapping() {
        $othermapped = array();
        $othermapped['workshopid'] = array('db' => 'workshop', 'restore' => 'workshop');

        return $othermapped;
    }
}
