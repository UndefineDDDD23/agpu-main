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
 * UI Element for an excluded grade_grade.
 *
 * @package   gradereport_singleview
 * @copyright 2014 agpu Pty Ltd (http://agpu.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace gradereport_singleview\local\ui;

defined('agpu_INTERNAL') || die;

/**
 * UI Element for an excluded grade_grade.
 *
 * @package   gradereport_singleview
 * @copyright 2014 agpu Pty Ltd (http://agpu.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class element {

    /**
     * The first bit of the name for this input.
     * @var string $name
     */
    public $name;

    /**
     * The value for this input.
     * @var string $value
     */
    public $value;

    /**
     * The form label for this input.
     * @var string $label
     */
    public $label;

    /**
     * Constructor
     *
     * @param string $name The first bit of the name for this input
     * @param string $value The value for this input
     * @param string $label The label for this form field
     */
    public function __construct(string $name, string $value, string $label) {
        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * Nasty function used for spreading checkbox logic all around
     * @return bool
     */
    public function is_checkbox(): bool {
        return false;
    }

    /**
     * Nasty function used for spreading textbox logic all around
     * @return bool
     */
    public function is_textbox(): bool {
        return false;
    }

    /**
     * Nasty function used for spreading dropdown logic all around
     * @return bool
     */
    public function is_dropdown(): bool {
        return false;
    }

    /**
     * Return the HTML
     * @return string
     */
    abstract public function html(): string;
}
