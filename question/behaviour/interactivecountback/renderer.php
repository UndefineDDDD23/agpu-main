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
 * Defines the renderer for the interactive with countback behaviour.
 *
 * @package    qbehaviour
 * @subpackage interactivecountback
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('agpu_INTERNAL') || die();

require_once(__DIR__ . '/../interactive/renderer.php');


/**
 * Renderer for outputting parts of a question belonging to the interactive with
 * countback behaviour.
 *
 * There are not differences from the interactive output. We just need a class
 * definition.
 *
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qbehaviour_interactivecountback_renderer extends qbehaviour_interactive_renderer {
}