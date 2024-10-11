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
 * Manage AI subsystem plugins settings.
 *
 * @package    core_admin
 * @copyright  2024 Matt Porritt <matt.porritt@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once($CFG->libdir . '/adminlib.php');

$action = required_param('action', PARAM_ALPHANUMEXT);
$type = required_param('type', PARAM_PLUGIN); // Must be provider or placement.
$name = required_param('name', PARAM_PLUGIN); // Plugin name, e.g openai.

$syscontext = context_system::instance();
$PAGE->set_url('/admin/ai.php');
$PAGE->set_context($syscontext);

require_admin();
require_sesskey();

$return = new agpu_url('/admin/settings.php', ['section' => "aisettings$type"]);

$plugins = core_plugin_manager::instance()->get_plugins_of_type("ai$type");
$sortorder = array_flip(array_keys($plugins));

if (!isset($plugins[$name])) {
    throw new agpu_exception('aipluginnotfound', 'core_ai', $return, $name);
}

$plugintypename = $plugins[$name]->type . '_' . $plugins[$name]->name;

switch ($action) {
    case 'disable':
        if ($plugins[$name]->is_enabled()) {
            $class = core_plugin_manager::resolve_plugininfo_class("aisettings$type");
            $class::enable_plugin($name, false);
        }
        break;
    case 'enable':
        if (!$plugins[$name]->is_enabled()) {
            $class = core_plugin_manager::resolve_plugininfo_class("aisettings$type");
            $class::enable_plugin($name, true);
        }
        break;
}

redirect($return);
