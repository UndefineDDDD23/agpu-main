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
 * User competency viewed event.
 *
 * @package    core_competency
 * @copyright  2016 Issam Taboubi <issam.taboubi@umontreal.ca>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

use core\event\base;
use core_competency\user_competency;
use context_course;
defined('agpu_INTERNAL') || die();

/**
 * User competency viewed in plan event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int planid: id of plan for which competency is associated.
 *      - int competencyid: id of competency.
 * }
 *
 * @package    core_competency
 * @since      agpu 3.1
 * @copyright  2016 Issam Taboubi <issam.taboubi@umontreal.ca>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class competency_user_competency_viewed_in_plan extends base {

    /**
     * Convenience method to instantiate the event in plan.
     *
     * @param user_competency $usercompetency The user competency.
     * @param int $planid The pland ID
     * @return self
     */
    public static function create_from_user_competency_viewed_in_plan(user_competency $usercompetency, $planid) {
        if (!$usercompetency->get('id')) {
            throw new \coding_exception('The user competency ID must be set.');
        }
        $params = array(
            'contextid' => $usercompetency->get_context()->id,
            'objectid' => $usercompetency->get('id'),
            'relateduserid' => $usercompetency->get('userid'),
            'other' => array(
                'competencyid' => $usercompetency->get('competencyid'),
                'planid' => $planid
            )
        );

        $event = static::create($params);
        $event->add_record_snapshot(user_competency::TABLE, $usercompetency->to_record());
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the user competency with id '$this->objectid' "
                . "in plan with id '" . $this->other['planid'] . "'";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventusercompetencyviewedinplan', 'core_competency');
    }

    /**
     * Get URL related to the action
     *
     * @return \agpu_url
     */
    public function get_url() {
        return \core_competency\url::user_competency_in_plan($this->relateduserid, $this->other['competencyid'],
            $this->other['planid']);
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = user_competency::TABLE;
    }

    /**
     * Get_objectid_mapping method.
     *
     * @return string the name of the restore mapping the objectid links to
     */
    public static function get_objectid_mapping() {
        return base::NOT_MAPPED;
    }

    /**
     * Custom validation.
     *
     * Throw \coding_exception notice in case of any problems.
     */
    protected function validate_data() {
        if ($this->other === null) {
            throw new \coding_exception('The \'competencyid\' and \'planid\' values must be set.');
        }

        if (!isset($this->other['competencyid'])) {
            throw new \coding_exception('The \'competencyid\' value must be set.');
        }

        if (!isset($this->other['planid'])) {
            throw new \coding_exception('The \'planid\' value must be set.');
        }
    }

}
