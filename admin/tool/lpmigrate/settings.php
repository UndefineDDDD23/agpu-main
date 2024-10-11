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
 * @package    tool_lpmigrate
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('agpu_INTERNAL') || die();

if (get_config('core_competency', 'enabled')) {

    $parentname = 'competencies';

    // Manage competency frameworks page.
    $temp = new admin_externalpage(
        'toollpmigrateframeworks',
        get_string('migrateframeworks', 'tool_lpmigrate'),
        new agpu_url('/admin/tool/lpmigrate/frameworks.php'),
        array('tool/lpmigrate:frameworksmigrate')
    );
    $ADMIN->add($parentname, $temp);

}
