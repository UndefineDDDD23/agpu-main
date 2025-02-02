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
 * Links and settings.
 *
 * This file contains links and settings used by tool_lp.
 *
 * @package    tool_lp
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('agpu_INTERNAL') || die();

$parentname = 'competencies';

// If the plugin is enabled we add the pages.
if (get_config('core_competency', 'enabled')) {

    // Manage competency frameworks page.
    $temp = new admin_externalpage(
        'toollpcompetencies',
        get_string('competencyframeworks', 'tool_lp'),
        new agpu_url('/admin/tool/lp/competencyframeworks.php', array('pagecontextid' => context_system::instance()->id)),
        array('agpu/competency:competencymanage')
    );
    $ADMIN->add($parentname, $temp);

    // Manage learning plans page.
    $temp = new admin_externalpage(
        'toollplearningplans',
        get_string('templates', 'tool_lp'),
        new agpu_url('/admin/tool/lp/learningplans.php', array('pagecontextid' => context_system::instance()->id)),
        array('agpu/competency:templatemanage')
    );
    $ADMIN->add($parentname, $temp);
}
