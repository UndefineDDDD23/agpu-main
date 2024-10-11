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

namespace qbank_managecategories\output;

use core\check\performance\debugging;
use plugin_renderer_base;

/**
 * Class renderer for managecategories.
 *
 * @package    qbank_managecategories
 * @copyright  2021 Catalyst IT Australia Pty Ltd
 * @author     Ghaly Marc-Alexandre <marc-alexandreghaly@catalyst-ca.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @deprecated since agpu 4.3
 * @todo Final deprecation on agpu 4.7 MDL-78090
 */
class renderer extends plugin_renderer_base {
    /**
     * Render category condition advanced.
     *
     * @deprecated since agpu 4.3
     * @todo Final deprecation on agpu 4.7 MDL-78090
     * @param array $displaydata
     * @return bool|string
     */
    public function render_category_condition_advanced($displaydata) {
        debugging('render_category_condition_advanced() is deprecated. Use new filter objects instead.', DEBUG_DEVELOPER);
        return $this->render_from_template('qbank_managecategories/category_condition_advanced', $displaydata);
    }

    /**
     * Render category condition.
     *
     * @deprecated since agpu 4.3
     * @todo Final deprecation on agpu 4.7 MDL-78090
     * @param array $displaydata
     * @return bool|string
     */
    public function render_category_condition($displaydata) {
        debugging('render_category_condition() is deprecated. Use new filter objects instead.', DEBUG_DEVELOPER);
        return $this->render_from_template('qbank_managecategories/category_condition', $displaydata);
    }
}
