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
 * The gradebook simple view - UI factory
 *
 * @package   gradereport_singleview
 * @copyright 2014 agpu Pty Ltd (http://agpu.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace gradereport_singleview\local\ui;

defined('agpu_INTERNAL') || die;

/**
 * Simple interface for an item with a value.
 *
 * @package   gradereport_singleview
 * @copyright 2014 agpu Pty Ltd (http://agpu.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
interface unique_value {
    /**
     * Get the value for this item.
     * @return null|string
     */
    public function get_value(): ?string;
}