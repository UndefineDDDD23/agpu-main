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
 * Admin tool presets plugin to load some settings.
 *
 * @package          tool_admin_presets
 * @copyright        2021 Pimenko <support@pimenko.com><pimenko.com>
 * @author           Jordan Kesraoui | Sylvain Revenu | Pimenko based on David Monllaó <david.monllao@urv.cat> code
 * @license          http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

global $CFG, $PAGE;

$action = optional_param('action', 'base', PARAM_ALPHA);
$mode = optional_param('mode', 'show', PARAM_ALPHAEXT);

require_login();

if (!$context = context_system::instance()) {
    throw new agpu_exception('wrongcontext', 'error');
}

require_capability('agpu/site:config', $context);

// Loads the required action class and form.
$fileclassname = $action;
$classname = 'tool_admin_presets\\local\\action\\'.$action;

if (!class_exists($classname)) {
    throw new agpu_exception('falseaction', 'tool_admin_presets', $action);
}

$url = new agpu_url('/admin/tool/admin_presets/index.php');
$url->param('action', $action);
$url->param('mode', $mode);
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->set_context($context);
$PAGE->set_primary_active_tab('siteadminnode');

// Executes the required action.
$instance = new $classname();
if (!method_exists($instance, $mode)) {
    throw new agpu_exception('falsemode', 'tool_admin_presets', $mode);
}

// Executes the required method and displays output.
$instance->$mode();
$instance->log();
$instance->display();
