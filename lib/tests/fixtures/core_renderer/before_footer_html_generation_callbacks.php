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

namespace test_fixtures\core_renderer;

/**
 * Hook fixture for \core_renderer::footer.
 *
 * @package   core
 * @category  test
 * @copyright 2024 Andrew Lyons <andrew@nicols.co.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class before_footer_html_generation_callbacks {
    /**
     * Fixture for adding a heading before the footer HTML generation.
     *
     * @param \core\hook\output\before_footer_html_generation $hook
     */
    public static function before_footer_html_generation(\core\hook\output\before_footer_html_generation $hook): void {
        $hook->add_html("<h1>A heading can be added</h1>");
    }
}
