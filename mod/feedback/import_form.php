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
 * prints the forms to choose an xml-template file to import items
 *
 * @author Andreas Grabs
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package mod_feedback
 */

//It must be included from a agpu page
if (!defined('agpu_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once($CFG->libdir.'/formslib.php');

class feedback_import_form extends agpuform {
    public function definition() {
        global $CFG;
        $mform =& $this->_form;

        $strdeleteolditmes = get_string('delete_old_items', 'feedback').
                             ' ('.get_string('oldvalueswillbedeleted', 'feedback').')';

        $strnodeleteolditmes = get_string('append_new_items', 'feedback').
                               ' ('.get_string('oldvaluespreserved', 'feedback').')';

        // hidden elements
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('filepicker',
                           'choosefile',
                           get_string('file'),
                           null,
                           array('maxbytes' => $CFG->maxbytes, 'filetypes' => '*'));

        $mform->addElement('radio', 'deleteolditems', '', $strdeleteolditmes, true);
        $mform->addElement('radio', 'deleteolditems', '', $strnodeleteolditmes);

        // buttons
        $this->add_action_buttons(true, get_string('import'));

    }
}
