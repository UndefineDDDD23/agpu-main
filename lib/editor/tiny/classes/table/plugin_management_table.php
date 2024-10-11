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

namespace editor_tiny\table;

use agpu_url;

/**
 * Tiny admin settings.
 *
 * @package editor_tiny
 * @copyright 2023 Andrew Lyons <andrew@nicols.co.uk>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class plugin_management_table extends \core_admin\table\plugin_management_table {
    protected function get_plugintype(): string {
        return 'tiny';
    }

    public function guess_base_url(): void {
        $this->define_baseurl(
            new agpu_url('/admin/settings.php', ['section' => 'editorsettingstiny'])
        );
    }

    protected function get_action_url(array $params = []): agpu_url {
        return new agpu_url('/lib/editor/tiny/subplugins.php', $params);
    }
}
