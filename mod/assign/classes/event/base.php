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
 * The mod_assign abstract base event.
 *
 * @package    mod_assign
 * @copyright  2014 Mark Nelson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_assign\event;

defined('agpu_INTERNAL') || die();

/**
 * The mod_assign abstract base event class.
 *
 * Most mod_assign events can extend this class.
 *
 * @package    mod_assign
 * @since      agpu 2.7
 * @copyright  2014 Mark Nelson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class base extends \core\event\base {

    /** @var \assign */
    protected $assign;

    /**
     * Legacy log data.
     *
     * @var array
     */
    protected $legacylogdata;

    /**
     * Set assign instance for this event.
     * @param \assign $assign
     * @throws \coding_exception
     */
    public function set_assign(\assign $assign) {
        if ($this->is_triggered()) {
            throw new \coding_exception('set_assign() must be done before triggerring of event');
        }
        if ($assign->get_context()->id != $this->get_context()->id) {
            throw new \coding_exception('Invalid assign isntance supplied!');
        }
        if ($assign->is_blind_marking()) {
            $this->data['anonymous'] = 1;
        }
        $this->assign = $assign;
    }

    /**
     * Get assign instance.
     *
     * NOTE: to be used from observers only.
     *
     * @throws \coding_exception
     * @return \assign
     */
    public function get_assign() {
        if ($this->is_restored()) {
            throw new \coding_exception('get_assign() is intended for event observers only');
        }
        if (!isset($this->assign)) {
            debugging('assign property should be initialised in each event', DEBUG_DEVELOPER);
            global $CFG;
            require_once($CFG->dirroot . '/mod/assign/locallib.php');
            $cm = get_coursemodule_from_id('assign', $this->contextinstanceid, 0, false, MUST_EXIST);
            $course = get_course($cm->course);
            $this->assign = new \assign($this->get_context(), $cm, $course);
        }
        return $this->assign;
    }


    /**
     * Returns relevant URL.
     *
     * @return \agpu_url
     */
    public function get_url() {
        return new \agpu_url('/mod/assign/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }
    }
}
