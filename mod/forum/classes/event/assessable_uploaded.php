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
 * The mod_forum assessable uploaded event.
 *
 * @package    mod_forum
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\event;

defined('agpu_INTERNAL') || die();

/**
 * The mod_forum assessable uploaded event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int discussionid: id of discussion.
 *      - string triggeredfrom: name of the function from where event was triggered.
 * }
 *
 * @package    mod_forum
 * @since      agpu 2.6
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class assessable_uploaded extends \core\event\assessable_uploaded {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has posted content in the forum post with id '$this->objectid' " .
            "in the discussion '{$this->other['discussionid']}' located in the forum with course module id " .
            "'$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventassessableuploaded', 'mod_forum');
    }

    /**
     * Get URL related to the action.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/forum/discuss.php', array('d' => $this->other['discussionid'], 'parent' => $this->objectid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        parent::init();
        $this->data['objecttable'] = 'forum_posts';
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['discussionid'])) {
            throw new \coding_exception('The \'discussionid\' value must be set in other.');
        } else if (!isset($this->other['triggeredfrom'])) {
            throw new \coding_exception('The \'triggeredfrom\' value must be set in other.');
        }
    }

    public static function get_objectid_mapping() {
        return array('db' => 'forum_posts', 'restore' => 'forum_post');
    }

    public static function get_other_mapping() {
        $othermapped = array();
        $othermapped['discussionid'] = array('db' => 'forum_discussions', 'restore' => 'forum_discussion');

        return $othermapped;
    }
}
