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
 * The mod_wiki diff viewed event.
 *
 * @package    mod_wiki
 * @copyright  2013 Rajesh Taneja <rajesh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_wiki\event;
defined('agpu_INTERNAL') || die();

/**
 * The mod_wiki diff viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int comparewith: version number to compare with.
 *      - int compare: version number to compare.
 * }
 *
 * @package    mod_wiki
 * @since      agpu 2.7
 * @copyright  2013 Rajesh Taneja <rajesh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class page_diff_viewed extends \core\event\base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'wiki_pages';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventdiffviewed', 'mod_wiki');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the diff for the page with id '$this->objectid' for the wiki with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/wiki/diff.php', array(
            'pageid' => $this->objectid,
            'comparewith' => $this->other['comparewith'],
            'compare' => $this->other['compare']
            ));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['comparewith'])) {
            throw new \coding_exception('The \'comparewith\' value must be set in other.');
        }
        if (!isset($this->other['compare'])) {
            throw new \coding_exception('The \'compare\' value must be set in other.');
        }
    }

    public static function get_objectid_mapping() {
        return array('db' => 'wiki_pages', 'restore' => 'wiki_page');
    }

    public static function get_other_mapping() {
        // Nothing to map.
        return false;
    }
}
