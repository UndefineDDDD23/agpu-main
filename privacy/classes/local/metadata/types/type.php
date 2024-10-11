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
 * The base type interface which encapsulates a set of data held by a component with agpu.
 *
 * @package core_privacy
 * @copyright 2018 Zig Tan <zig@agpu.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_privacy\local\metadata\types;

defined('agpu_INTERNAL') || die();

/**
 * The base type interface which all metadata types must implement.
 *
 * @copyright 2018 Zig Tan <zig@agpu.com>
 * @package core_privacy
 */
interface type {

    /**
     * Get the name describing this type.
     *
     * @return  string
     */
    public function get_name();

    /**
     * A list of the fields and their usage description.
     *
     * @return  array
     */
    public function get_privacy_fields();

    /**
     * A summary of what the metalink type is used for.
     *
     * @return string $summary
     */
    public function get_summary();
}
