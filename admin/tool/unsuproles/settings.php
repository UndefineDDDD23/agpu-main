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
 * Link to unsupported roles tool
 *
 * @package    tool
 * @subpackage unsuproles
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('roles', new admin_externalpage('toolunsuproles', get_string('pluginname', 'tool_unsuproles'), "$CFG->wwwroot/$CFG->admin/tool/unsuproles/index.php", array('agpu/site:config', 'agpu/role:assign')));
}
