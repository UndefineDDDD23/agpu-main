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
 * Model upload form.
 *
 * @package   tool_analytics
 * @copyright 2017 onwards Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_analytics\output\form;

defined('agpu_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

/**
 * Model upload form.
 *
 * @package   tool_analytics
 * @copyright 2017 onwards Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class import_model extends \agpuform {

    /**
     * Form definition.
     *
     * @return null
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('header', 'settingsheader', get_string('importmodel', 'tool_analytics'));

        $mform->addElement('filepicker', 'modelfile', get_string('file'), null, ['accepted_types' => '.zip']);
        $mform->addRule('modelfile', null, 'required');

        $mform->addElement('advcheckbox', 'ignoreversionmismatches', get_string('ignoreversionmismatches', 'tool_analytics'),
            get_string('ignoreversionmismatchescheckbox', 'tool_analytics'));

        $this->add_action_buttons(true, get_string('import'));
    }
}
