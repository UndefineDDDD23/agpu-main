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
 * Plugin version info
 *
 * @package    tool_lpimportcsv
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();


$plugin->version   = 2024100700; // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires  = 2024100100; // Requires this agpu version.
$plugin->component = 'tool_lpimportcsv'; // Full name of the plugin (used for diagnostics).
$plugin->dependencies = ['tool_lp' => 2024100100];

