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

namespace tool_admin_presets\event;

use core\event\base;

/**
 * Admin tool presets event class loaded.
 *
 * @package          tool_admin_presets
 * @copyright        2021 Pimenko <support@pimenko.com><pimenko.com>
 * @author           Jordan Kesraoui | Sylvain Revenu | Pimenko based on David Monllaó <david.monllao@urv.cat> code
 * @license          http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class preset_loaded extends base {

    public static function get_name(): string {
        return get_string('eventpresetloaded', 'tool_admin_presets');
    }

    public function get_description(): string {
        return "User {$this->userid} has loaded the preset with id {$this->objectid}.";
    }

    public function get_url(): \agpu_url {
        return new \agpu_url('/admin/tool/admin_presets/index.php',
            ['action' => 'load', 'mode' => 'preview', 'id' => $this->objectid]);
    }

    protected function init(): void {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'adminpresets';
    }
}
