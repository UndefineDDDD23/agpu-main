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

namespace tool_brickfield\local\htmlchecker\common\checks;

use tool_brickfield\local\htmlchecker\common\brickfield_accessibility_test;

/**
 * Brickfield accessibility HTML checker library.
 *
 * 'object' must have a valid title.
 * 'object' element must not have a title attribute with value of null or whitespace.
 *
 * @package    tool_brickfield
 * @copyright  2020 onward: Brickfield Education Labs, www.brickfield.ie
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class object_must_have_valid_title extends brickfield_accessibility_test {

    /** @var int The default severity code for this test. */
    public $defaultseverity = \tool_brickfield\local\htmlchecker\brickfield_accessibility::BA_TEST_SEVERE;

    /** @var \string[][] An array of strings, broken up by language domain. */
    public $strings =
        [
            'en' => ['nbsp', '&nbsp;', 'object', 'an object', 'spacer', 'image', 'img', 'photo', ' '],
            'es' => ['nbsp', '&nbsp;', 'objeto', 'un objeto', 'espacio', 'imagen', 'img', 'foto', ' '],
        ];

    /**
     * The main check function. This is called by the parent class to actually check content
     */
    public function check(): void {
        foreach ($this->get_all_elements('object') as $object) {
            if ($object->hasAttribute('title')) {
                if (trim($object->getAttribute('title')) == '') {
                    $this->add_report($object);
                } else if (!in_array(trim(strtolower($object->getAttribute('title'))), $this->translation())) {
                    $this->add_report($object);
                }
            }
        }
    }
}
