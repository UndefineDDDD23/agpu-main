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
 * Badge revoked event.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int expiredate: Badge expire timestamp.
 *      - int badgeissuedid: Badge issued ID.
 * }
 *
 * @package    core
 * @copyright  2016 Matt Davidson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;
defined('agpu_INTERNAL') || die();

/**
 * Event triggered after a badge is revoked from a user.
 *
 * @package    core
 * @since      agpu 3.2
 * @copyright  2016 Matt Davidson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class badge_revoked extends base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'badge';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventbadgerevoked', 'badges');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->relateduserid' has had the badge with id '$this->objectid' revoked.";
    }

    /**
     * Returns relevant URL.
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/badges/overview.php', array('id' => $this->objectid));
    }

    /**
     * Custom validations.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->objectid)) {
            throw new \coding_exception('The \'objectid\' must be set.');
        }
    }

    /**
     * Get_objectid_mapping method.
     *
     * @return array
     */
    public static function get_objectid_mapping() {
        return array('db' => 'badge', 'restore' => 'badge');
    }

    /**
     * Get_other_mapping method.
     *
     * @return array
     */
    public static function get_other_mapping() {
        $othermapped = array();
        $othermapped['badgeissuedid'] = array('db' => 'badge_issued', 'restore' => base::NOT_MAPPED);

        return $othermapped;
    }
}
