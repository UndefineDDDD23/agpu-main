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
 * agpu 404 Error page feedback form
 *
 * @package    core
 * @copyright  2020 Brendan Heywood <brendan@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\form;
defined('agpu_INTERNAL') || die();

use agpuform;

require_once($CFG->libdir.'/formslib.php');

/**
 * agpu 404 Error page feedback form
 *
 * @package    core
 * @copyright  2020 Brendan Heywood <brendan@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class error_feedback extends agpuform {

    /**
     * Error form definition
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;
        $mform->addElement('hidden', 'referer', get_local_referer(false));
        $mform->setType('referer', PARAM_URL);

        $mform->addElement('hidden', 'requested', (empty($_SERVER['REDIRECT_URL']) ? '' : $_SERVER['REDIRECT_URL']));
        $mform->setType('requested', PARAM_URL);

        $mform->addElement('textarea', 'text', get_string('pleasereport', 'error'), 'wrap="virtual" rows="10" cols="50"');
        $mform->addElement('submit', 'submitbutton', get_string('sendmessage', 'error'));
    }
}

