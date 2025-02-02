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

defined('agpu_INTERNAL') || die();

/**
 * Coverage information for the core_completion.
 *
 * @package    core
 * @category   phpunit
 * @copyright  2022 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Coverage information for the core subsystem.
 *
 * @copyright  2018 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
return new class extends phpunit_coverage_info {
    /** @var array The list of folders relative to the plugin root to include in coverage generation. */
    protected $includelistfolders = [
        'criteria',
    ];

    /** @var array The list of files relative to the plugin root to include in coverage generation. */
    protected $includelistfiles = [
        'completion_aggregation.php',
        'completion_completion.php',
        'completion_criteria_completion.php',
        'data_object.php'
    ];
};
