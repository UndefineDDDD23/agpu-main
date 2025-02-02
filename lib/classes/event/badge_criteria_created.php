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
 * Badge criteria created event.
 *
 * @package    core
 * @copyright  2016 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;
defined('agpu_INTERNAL') || die();

/**
 * Event triggered after criteria is created for a badge.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int badgeid: The ID of the badge affected
 *
 * @package    core
 * @since      agpu 3.2
 * @copyright  2016 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class badge_criteria_created extends base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'badge_criteria';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventbadgecriteriacreated', 'badges');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has created criteria to the badge with id '".$this->other['badgeid']."'.";
    }

    /**
     * Returns relevant URL.
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/badges/criteria.php', array('id' => $this->other['badgeid']));
    }

    /**
     * Custom validations.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->objectid)) {
            throw new \coding_exception('The \'objectid\' must be set.');
        }
        if (!isset($this->other['badgeid'])) {
            throw new \coding_exception('The \'badgeid\' value must be set in other.');
        }
    }

    /**
     * Used for maping events on restore
     *
     * @return array
     */
    public static function get_objectid_mapping() {
        return array('db' => 'badge_criteria', 'restore' => 'badge_criteria');
    }

    /**
     * Used for maping events on restore
     *
     * @return bool
     */
    public static function get_other_mapping() {
        $othermapped = array();
        $othermapped['badgeid'] = array('db' => 'badge', 'restore' => 'badge');
        return $othermapped;
    }
}


