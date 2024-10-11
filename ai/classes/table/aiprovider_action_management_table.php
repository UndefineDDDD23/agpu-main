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

namespace core_ai\table;

use core_table\dynamic as dynamic_table;
use flexible_table;
use agpu_url;
use stdClass;

/**
 * Table to manage AI actions used in provider plugins.
 *
 * @package core_ai
 * @copyright 2024 Matt Porritt <matt.porritt@agpu.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class aiprovider_action_management_table extends flexible_table implements dynamic_table {
    /** @var string The name of the plugin these actions related too */
    protected string $pluginname;

    /** @var array The list of actions this manager covers */
    protected array $actions;

    /**
     * Constructor.
     *
     * @param string $uniqueid The table unique id
     */
    public function __construct(string $uniqueid) {
        $parseuniqueid = explode('-', $uniqueid);
        $pluginname = end($parseuniqueid);
        $this->pluginname = $pluginname;

        // Get the list of actions that this provider supports.
        $this->actions = \core_ai\manager::get_supported_actions($this->pluginname);

        parent::__construct($this->get_table_id());

        $this->setup_column_configuration();
        $this->set_filterset(new aiprovider_action_management_table_filterset());
        $this->setup();
    }

    #[\Override]
    public function get_context(): \context_system {
        return \context_system::instance();
    }

    /**
     * Set up the column configuration for this table.
     */
    protected function setup_column_configuration(): void {
        $columnlist = $this->get_column_list();
        $this->define_columns(array_keys($columnlist));
        $this->define_headers(array_values($columnlist));
    }

    /**
     * Get the ID of the table.
     *
     * @return string
     */
    protected function get_table_id(): string {
        return "aiprovideraction_management_table-{$this->pluginname}";
    }

    /**
     * Get the web service method used to toggle state.
     *
     * @return null|string
     */
    protected function get_toggle_service(): ?string {
        return 'core_ai_set_action';
    }

    /**
     * Get the JS module used to manage this table.
     *
     * This should be a class which extends 'core_admin/plugin_management_table'.
     *
     * @return string
     */
    protected function get_table_js_module(): string {
        return 'core_admin/plugin_management_table';
    }

    #[\Override]
    protected function get_dynamic_table_html_end(): string {
        global $PAGE;

        $PAGE->requires->js_call_amd($this->get_table_js_module(), 'init');
        return parent::get_dynamic_table_html_end();
    }

    /**
     * Get a list of the column titles
     *
     * @return string[]
     */
    protected function get_column_list(): array {
        return [
            'namedesc' => get_string('action', 'core_ai'),
            'enabled' => get_string('pluginenabled', 'core_plugin'),
            'settings' => get_string('settings', 'core'),
        ];
    }

    /**
     * Show the name column content.
     *
     * @param stdClass $row
     * @return string
     */
    protected function col_namedesc(stdClass $row): string {
        global $OUTPUT;

        $params = [
            'name' => $row->action::get_name(),
            'description' => $row->action::get_description(),
        ];

        return $OUTPUT->render_from_template('core_admin/table/namedesc', $params);
    }

    /**
     * Show the enable/disable column content.
     *
     * @param stdClass $row
     * @return string
     */
    protected function col_enabled(stdClass $row): string {
        global $OUTPUT;

        $enabled = $row->enabled;
        $identifier = $enabled ? 'disableplugin' : 'enableplugin';
        $labelstr = get_string($identifier, 'core_admin', $row->action::get_name());

        $params = [
            'id' => 'admin-toggle-' . $row->action::get_basename(),
            'checked' => $enabled,
            'dataattributes' => [
                'name' => 'id',
                'value' => $row->action,
                'toggle-method' => $this->get_toggle_service(),
                'action' => 'togglestate',
                'plugin' => $this->pluginname . "-" . $row->action::get_basename(),
                'state' => $enabled ? 1 : 0,
            ],
            'title' => $labelstr,
            'label' => $labelstr,
            'labelclasses' => 'sr-only',
        ];

        return $OUTPUT->render_from_template('core_admin/setting_configtoggle', $params);
    }

    /**
     * Show the settings column content.
     *
     * @param stdClass $row
     * @return string
     */
    protected function col_settings(stdClass $row): string {
        global $CFG;
        require_once($CFG->libdir . '/adminlib.php'); // Needed for the AJAX calls.
        $tree = \admin_get_root();
        $sectionname = $this->pluginname . '_' . $row->action::get_basename();
        $section = $tree->locate($sectionname);
        if ($section) {
            return \html_writer::link($section->get_settings_page_url(), get_string('settings'));
        }
        return '';
    }

    /**
     * Get any class to add to the row.
     *
     * @param mixed $row
     * @return string
     */
    protected function get_row_class($row): string {
        if (!$row->enabled) {
            return 'dimmed_text';
        }
        return '';
    }

    /**
     * Get the table content.
     */
    public function get_content(): string {
        ob_start();
        $this->out();
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * Print the table.
     */
    public function out(): void {
        foreach ($this->actions as $actionclass) {
            // Construct the row data.
            $rowdata = (object) [
                'action' => $actionclass,
                'enabled' => \core_ai\manager::is_action_enabled($this->pluginname, $actionclass),
            ];
            $this->add_data_keyed(
                $this->format_row($rowdata),
                $this->get_row_class($rowdata),
            );
        }

        $this->finish_output(false);
    }

    #[\Override]
    public function is_downloadable($downloadable = null): bool {
        return false;
    }

    #[\Override]
    public function guess_base_url(): void {
        $url = new agpu_url('/');
        $this->define_baseurl($url);
    }

    /**
     * Check capability for users accessing the action management table.
     *
     * @return bool
     */
    public function has_capability(): bool {
        return has_capability('agpu/site:config', $this->get_context());
    }
}