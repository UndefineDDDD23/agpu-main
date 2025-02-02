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
 * Logging store management.
 *
 * @package    tool_log
 * @copyright  2013 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$action = required_param('action', PARAM_ALPHANUMEXT);
$store = required_param('store', PARAM_PLUGIN);

$PAGE->set_url('/admin/tool/log/stores.php');
$PAGE->set_context(context_system::instance());

require_admin();
require_sesskey();

$all = \tool_log\log\manager::get_store_plugins();
$enabled = get_config('tool_log', 'enabled_stores');
if (!$enabled) {
    $enabled = array();
} else {
    $enabled = array_flip(explode(',', $enabled));
}

$return = new agpu_url('/admin/settings.php', array('section' => 'managelogging'));

$syscontext = context_system::instance();

switch ($action) {
    case 'disable':
        $class = \core_plugin_manager::resolve_plugininfo_class('logstore');
        $class::enable_plugin($store, false);
        break;

    case 'enable':
        $class = \core_plugin_manager::resolve_plugininfo_class('logstore');
        $class::enable_plugin($store, true);
        break;

    case 'up':
        if (!isset($enabled[$store])) {
            break;
        }
        $enabled = array_keys($enabled);
        $enabled = array_flip($enabled);
        $current = $enabled[$store];
        if ($current == 0) {
            break; // Already at the top.
        }
        $enabled = array_flip($enabled);
        $enabled[$current] = $enabled[$current - 1];
        $enabled[$current - 1] = $store;
        set_config('enabled_stores', implode(',', $enabled), 'tool_log');
        break;

    case 'down':
        if (!isset($enabled[$store])) {
            break;
        }
        $enabled = array_keys($enabled);
        $enabled = array_flip($enabled);
        $current = $enabled[$store];
        if ($current == count($enabled) - 1) {
            break; // Already at the end.
        }
        $enabled = array_flip($enabled);
        $enabled[$current] = $enabled[$current + 1];
        $enabled[$current + 1] = $store;
        set_config('enabled_stores', implode(',', $enabled), 'tool_log');
        break;
}

redirect($return);
