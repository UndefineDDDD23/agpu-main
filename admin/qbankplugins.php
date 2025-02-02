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
 * Question bank plugin settings.
 *
 * @package    core
 * @subpackage questionbank
 * @copyright  2021 Catalyst IT Australia Pty Ltd
 * @author     Safat Shahin <safatshahin@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');

use core\event\qbank_plugin_enabled;
use core\event\qbank_plugin_disabled;

$action = required_param('action', PARAM_ALPHANUMEXT);
$name   = required_param('name', PARAM_PLUGIN);

$syscontext = context_system::instance();
$PAGE->set_url('/admin/qbankplugins.php');
$PAGE->set_context($syscontext);

require_admin();
require_sesskey();

$return = new agpu_url('/admin/settings.php', ['section' => 'manageqbanks']);

$plugins = core_plugin_manager::instance()->get_plugins_of_type('qbank');
$sortorder = array_flip(array_keys($plugins));

if (!isset($plugins[$name])) {
    throw new agpu_exception('qbanknotfound', 'question', $return, $name);
}

$plugintypename = $plugins[$name]->type . '_' . $plugins[$name]->name;

switch ($action) {
    case 'disable':
        if ($plugins[$name]->is_enabled()) {
            qbank_plugin_disabled::create_for_plugin($plugintypename)->trigger();
            $class = \core_plugin_manager::resolve_plugininfo_class('qbank');
            $class::enable_plugin($name, false);
            set_config('disabled', 1, 'qbank_'. $name);
        }
        break;
    case 'enable':
        if (!$plugins[$name]->is_enabled()) {
            qbank_plugin_enabled::create_for_plugin($plugintypename)->trigger();
            $class = \core_plugin_manager::resolve_plugininfo_class('qbank');
            $class::enable_plugin($name, true);
        }
        break;
}

redirect($return);
