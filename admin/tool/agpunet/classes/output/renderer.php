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
 * Renderer.
 *
 * @package    tool_agpunet
 * @copyright  2020 Mathew May {@link https://mathew.solutions}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_agpunet\output;

defined('agpu_INTERNAL') || die();

use plugin_renderer_base;

/**
 * Renderer class.
 *
 * @package    tool_agpunet
 * @copyright  2020 Mathew May {@link https://mathew.solutions}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Defer to template.
     *
     * @param select_page $selectpage
     * @return string HTML
     */
    protected function render_select_page(select_page $selectpage): string {

        $this->page->requires->js_call_amd('tool_agpunet/select_page', 'init', [$selectpage->get_import_info()->get_id()]);
        $data = $selectpage->export_for_template($this);
        return parent::render_from_template('tool_agpunet/select_page', $data);
    }
}
