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
 * Links and settings
 *
 * This file contains links and settings used by tool_lpimportcsv
 *
 * @package    tool_lpimportcsv
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('agpu_INTERNAL') || die;

if (get_config('core_competency', 'enabled')) {
    // Manage competency frameworks page.
    $temp = new admin_externalpage(
        'toollpimportcsv',
        get_string('pluginname', 'tool_lpimportcsv'),
        new agpu_url('/admin/tool/lpimportcsv/index.php'),
        'agpu/competency:competencymanage'
    );
    $ADMIN->add('competencies', $temp);
    // Export competency framework page.
    $temp = new admin_externalpage(
        'toollpexportcsv',
        get_string('exportnavlink', 'tool_lpimportcsv'),
        new agpu_url('/admin/tool/lpimportcsv/export.php'),
        'agpu/competency:competencymanage'
    );
    $ADMIN->add('competencies', $temp);
}

// No report settings.
$settings = null;
