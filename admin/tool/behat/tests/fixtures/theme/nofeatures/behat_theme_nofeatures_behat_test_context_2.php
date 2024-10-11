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
 * Theme test context 1 overriding test_1
 *
 * @package    tool_behat
 * @copyright  2016 Rajesh Taneja <rajesh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no agpu_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../core/behat_test_context_1.php');

/**
 * Theme test context 1
 *
 * @package    tool_behat
 * @copyright  2016 Rajesh Taneja <rajesh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_theme_nofeatures_behat_test_context_2 extends behat_test_context_2 {

}