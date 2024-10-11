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

namespace qbank_managecategories\form;

use agpuform;

defined('agpu_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');


/**
 * Form for moving questions between categories.
 *
 * @package    qbank_managecategories
 * @copyright  2008 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class question_move_form extends agpuform {

    /**
     * Build the form definition.
     *
     * This adds all the form fields that the question move feature needs.
     * @throws \coding_exception
     */
    protected function definition() {
        $mform = $this->_form;

        $currentcat = $this->_customdata['currentcat'];
        $contexts = $this->_customdata['contexts'];

        $mform->addElement('questioncategory', 'category', get_string('category', 'question'), compact('contexts', 'currentcat'));

        $this->add_action_buttons(true, get_string('categorymoveto', 'question'));

        $mform->addElement('hidden', 'delete', $currentcat);
        $mform->setType('delete', PARAM_INT);
    }
}