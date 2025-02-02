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

namespace mod_bigbluebuttonbn\event;

use coding_exception;
use agpu_url;

/**
 * The mod_bigbluebuttonbn abstract base event class. Most mod_bigbluebuttonbn events can extend this class.
 *
 * @package   mod_bigbluebuttonbn
 * @copyright 2010 onwards, Blindside Networks Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class base extends \core\event\base {

    /**
     * Object Id Mapping.
     *
     * @var array
     */
    protected static $objectidmapping = ['db' => 'bigbluebuttonbn', 'restore' => 'bigbluebuttonbn'];

    /** @var $bigbluebuttonbn */
    protected $bigbluebuttonbn;

    /**
     * Description.
     *
     * @var string
     */
    protected $description;

    /**
     * Legacy log data.
     *
     * @var array
     */
    protected $legacylogdata;

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        $vars = [
            'userid' => $this->userid,
            'courseid' => $this->courseid,
            'objectid' => $this->objectid,
            'contextinstanceid' => $this->contextinstanceid,
            'other' => $this->other
        ];
        $string = $this->description;
        foreach ($vars as $key => $value) {
            if ($value !== null) {
                $string = str_replace("##" . $key, $value, $string);
            }
        }
        return $string;
    }

    /**
     * Returns relevant URL.
     *
     * @return agpu_url
     */
    public function get_url() {
        return new agpu_url('/mod/bigbluebuttonbn/view.php', ['id' => $this->contextinstanceid]);
    }

    /**
     * Init method.
     *
     * @param string $crud
     * @param int $edulevel
     */
    protected function init($crud = 'r', $edulevel = self::LEVEL_PARTICIPATING) {
        $this->data['crud'] = $crud;
        $this->data['edulevel'] = $edulevel;
        $this->data['objecttable'] = 'bigbluebuttonbn';
    }

    /**
     * Custom validation.
     *
     * @throws coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new coding_exception('Context level must be CONTEXT_MODULE.');
        }
    }
}
