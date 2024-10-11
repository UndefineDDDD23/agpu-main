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

namespace tool_admin_presets\form;

defined('agpu_INTERNAL') || die();

use agpuform;

global $CFG;
require_once($CFG->dirroot . '/lib/formslib.php');

/**
 * Form for loading continue button.
 *
 * @package    tool_admin_presets
 * @copyright  2021 Amaia Anabitarte <amaia@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class continue_form extends agpuform {

    public function definition(): void {
        $this->add_action_buttons(false, get_string('continue'));
    }
}
