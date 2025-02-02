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
 * The forum summary report viewed event.
 *
 * @package forumreport_summary
 * @copyright  2019 Michael Hawkins <michaelh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace forumreport_summary\event;
defined('agpu_INTERNAL') || die();

/**
 * The forum summary report viewed event class.
 *
 * @package forumreport_summary
 * @since      agpu 3.8
 * @copyright  2019 Michael Hawkins <michaelh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report_viewed extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventreportviewed', 'forumreport_summary');
    }

    /**
     * Returns non-localised event description with ids for admin use only.
     *
     * @return string
     */
    public function get_description() {
        $whose = $this->other['hasviewall'] ? 'the' : 'their own';
        $description = "The user with id '{$this->userid}' viewed {$whose} summary report for ";

        if ($this->other['forumid']) {
            $description .= "the forum with course module id '{$this->contextinstanceid}'.";
        } else {
            $description .= "the course with id '{$this->contextinstanceid}'.";
        }

        return $description;
    }

    /**
     * Returns relevant URL.
     *
     * @return \agpu_url
     */
    public function get_url() {
        $params = ['courseid' => $this->courseid];

        if (!empty($this->other['forumid'])) {
            $params['forumid'] = $this->other['forumid'];
        }

        return new \agpu_url('/mod/forum/report/summary/index.php', $params);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['hasviewall'])) {
            throw new \coding_exception('The \'hasviewall\' value must be set');
        }
    }
}
