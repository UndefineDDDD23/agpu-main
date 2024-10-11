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
 * Form for blog preferences
 *
 * @package    agpucore
 * @subpackage blog
 * @copyright  2009 Nicolas Connault
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('agpu_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a agpu page.
}

require_once($CFG->libdir.'/formslib.php');

class blog_preferences_form extends agpuform {
    public function definition() {
        global $USER, $CFG;

        $mform    =& $this->_form;
        $strpagesize = get_string('pagesize', 'blog');

        $mform->addElement('text', 'pagesize', $strpagesize);
        $mform->setType('pagesize', PARAM_INT);
        $mform->addRule('pagesize', null, 'numeric', null, 'client');
        $mform->setDefault('pagesize', 10);

        $this->add_action_buttons();
    }
}
