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

namespace core_form;

use agpuQuickForm_autocomplete;

defined('agpu_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/form/autocomplete.php');

/**
 * Unit tests for agpuQuickForm_autocomplete
 *
 * Contains test cases for testing agpuQuickForm_autocomplete
 *
 * @package    core_form
 * @copyright  2015 Damyon Wiese <damyon@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class autocomplete_test extends \basic_testcase {
    /**
     * Testcase for validation
     */
    public function test_validation(): void {
        // A default select with single values validates the data.
        $options = array('1' => 'One', 2 => 'Two');
        $element = new agpuQuickForm_autocomplete('testel', null, $options);
        $submission = array('testel' => 2);
        $this->assertEquals($element->exportValue($submission), 2);
        $submission = array('testel' => 3);
        $this->assertEquals('', $element->exportValue($submission));

        // A select with multiple values validates the data.
        $options = array('1' => 'One', 2 => 'Two');
        $element = new agpuQuickForm_autocomplete('testel', null, $options, array('multiple'=>'multiple'));
        $submission = array('testel' => array(2, 3));
        $this->assertEquals($element->exportValue($submission), array(2));

        // A select where the values are fetched via ajax does not validate the data.
        $element = new agpuQuickForm_autocomplete('testel', null, array(), array('multiple'=>'multiple', 'ajax'=>'anything'));
        $submission = array('testel' => array(2, 3));
        $this->assertEquals($element->exportValue($submission), array(2, 3));

        // A select with single value without anything selected.
        $options = array('1' => 'One', 2 => 'Two');
        $element = new agpuQuickForm_autocomplete('testel', null, $options);
        $submission = array();
        $this->assertEquals('', $element->exportValue($submission));

        // A select with multiple values without anything selected.
        $options = array('1' => 'One', 2 => 'Two');
        $element = new agpuQuickForm_autocomplete('testel', null, $options, array('multiple' => 'multiple'));
        $submission = array();
        $this->assertEquals([], $element->exportValue($submission));
    }

}
