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
 * Add hidden links db transfer tool
 *
 * @package    tool_dbtransfer
 * @copyright  2011 Petr Skoda {@link http://skodak.org/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('experimental', new admin_externalpage('tooldbtransfer', get_string('dbtransfer', 'tool_dbtransfer'),
        $CFG->wwwroot.'/'.$CFG->admin.'/tool/dbtransfer/index.php', 'agpu/site:config', false));
    // DB export/import is not ready yet - keep it hidden for now.
    $ADMIN->add('experimental', new admin_externalpage('tooldbexport', get_string('dbexport', 'tool_dbtransfer'),
        $CFG->wwwroot.'/'.$CFG->admin.'/tool/dbtransfer/dbexport.php', 'agpu/site:config', true));
}
