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
 * Edit wiki files form
 *
 * @package   mod_wiki
 * @copyright 2011 Dongsheng Cai <dongsheng@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class mod_wiki_filesedit_form extends agpuform {
    protected function definition() {
        $mform = $this->_form;

        $data    = $this->_customdata['data'];
        $options = $this->_customdata['options'];
        $mform->addElement('header', 'general', get_string('editfiles', 'wiki'));
        $mform->addElement('filemanager', 'files_filemanager', get_string('files'), null, $options);

        $mform->addElement('hidden', 'returnurl', $data->returnurl);
        $mform->setType('returnurl', PARAM_LOCALURL);

        $mform->addElement('hidden', 'subwiki', $data->subwikiid);
        $mform->setType('subwiki', PARAM_INT);

        $this->add_action_buttons(true, get_string('savechanges'));

        $this->set_data($data);
    }
}
