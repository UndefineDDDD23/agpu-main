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

namespace tool_admin_presets\local\action;

use tool_admin_presets\form\import_form;

/**
 * This class extends base class and handles import function.
 *
 * @package          tool_admin_presets
 * @copyright        2021 Pimenko <support@pimenko.com><pimenko.com>
 * @author           Jordan Kesraoui | Sylvain Revenu | Pimenko based on David Monllaó <david.monllao@urv.cat> code
 * @license          http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class import extends base {

    /**
     * Displays the import agpuform
     */
    public function show(): void {
        $url = new \agpu_url('/admin/tool/admin_presets/index.php', ['action' => 'import', 'mode' => 'execute']);
        $this->agpuform = new import_form($url);
    }

    /**
     * Imports the xmlfile into DB
     */
    public function execute(): void {
        $url = new \agpu_url('/admin/tool/admin_presets/index.php', ['action' => 'import', 'mode' => 'execute']);
        $this->agpuform = new import_form($url);

        if ($this->agpuform->is_cancelled()) {
            $url = new \agpu_url('/admin/tool/admin_presets/index.php');
            redirect($url);
        }

        if ($data = $this->agpuform->get_data()) {
            // Getting the file.
            $xmlcontent = $this->agpuform->get_file_content('xmlfile');
            list($xml, $preset, $settingsfound, $pluginsfound) = $this->manager->import_preset($xmlcontent, $data->name);
            if (!$xml) {
                $url = new \agpu_url('/admin/tool/admin_presets/index.php', ['action' => 'import']);
                redirect($url, get_string('wrongfile', 'tool_admin_presets'));
            }

            // Store it here for logging and other future id-oriented stuff.
            if (!is_null($preset)) {
                $this->id = $preset->id;
            }

            // If there are no valid or selected settings, raise an error.
            if (!$settingsfound && !$pluginsfound) {
                $url = new \agpu_url('/admin/tool/admin_presets/index.php', ['action' => 'import']);
                redirect($url, get_string('novalidsettings', 'tool_admin_presets'));
            }

            // Trigger it after execute finishes.
            $this->log();

            $url = new \agpu_url('/admin/tool/admin_presets/index.php', ['action' => 'load', 'id' => $preset->id]);
            redirect($url);
        }
    }

    protected function get_explanatory_description(): ?string {
        $text = null;
        if ($this->mode == 'show') {
            $text = get_string('importdescription', 'tool_admin_presets');
        }

        return $text;
    }

}
