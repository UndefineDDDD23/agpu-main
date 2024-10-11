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
 * Template cohorts form.
 *
 * @package    tool_lp
 * @copyright  2015 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_lp\form;
defined('agpu_INTERNAL') || die();

use agpuform;

require_once($CFG->libdir . '/formslib.php');

/**
 * Template cohorts form class.
 *
 * @package    tool_lp
 * @copyright  2015 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class template_cohorts extends agpuform {

    /**
     * Form definition
     *
     * @return void
     */
    public function definition() {
        $mform = $this->_form;

        $options = array(
            'multiple' => true,
            'exclude' => implode(',', $this->_customdata['excludecohorts']),
            'contextid' => $this->_customdata['pagecontextid'],
        );
        $mform->addElement('cohort', 'cohorts', get_string('selectcohortstosync', 'tool_lp'), $options);
        $mform->addElement('submit', 'submit', get_string('addcohorts', 'tool_lp'));
    }
}