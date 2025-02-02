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
 * Scheduled tasks.
 *
 * @package    tool_task
 * @copyright  2014 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add(
        'taskconfig',
        new admin_externalpage(
            'scheduledtasks',
            new lang_string('scheduledtasks', 'tool_task'),
            "$CFG->wwwroot/$CFG->admin/tool/task/scheduledtasks.php"
        )
    );

    $ADMIN->add(
        'taskconfig',
        new admin_externalpage(
            'adhoctasks',
            new lang_string('adhoctasks', 'tool_task'),
            "$CFG->wwwroot/$CFG->admin/tool/task/adhoctasks.php"
        )
    );

    $ADMIN->add(
        'taskconfig',
        new admin_externalpage(
            'runningtasks',
            new lang_string('runningtasks', 'tool_task'),
            "$CFG->wwwroot/$CFG->admin/tool/task/runningtasks.php"
        )
    );
}
