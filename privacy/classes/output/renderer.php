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
 * Privacy renderer.
 *
 * @package    core_privacy
 * @copyright  2018 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_privacy\output;
defined('agpu_INTERNAL') || die;
/**
 * Privacy renderer's for privacy stuff.
 *
 * @since      agpu 3.6
 * @package    core_privacy
 * @copyright  2018 Adrian Greeve <adrian@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends \plugin_renderer_base {

    /**
     * Render the whole tree.
     *
     * @param navigation_page $page
     * @return string
     */
    public function render_navigation(exported_navigation_page $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('core_privacy/navigation', $data);
    }

    /**
     * Render the html page.
     *
     * @param html_page $page
     * @return string
     */
    public function render_html_page(exported_html_page $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('core_privacy/htmlpage', $data);
    }
}