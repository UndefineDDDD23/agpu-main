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
 * Block search forums renderer.
 *
 * @package    block_search_forums
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_search_forums\output;
defined('agpu_INTERNAL') || die();

use plugin_renderer_base;
use renderable;

/**
 * Block search forums renderer.
 *
 * @package    block_search_forums
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Render search form.
     *
     * @param renderable $searchform The search form.
     * @return string
     */
    public function render_search_form(renderable $searchform) {
        return $this->render_from_template('block_search_forums/search_form', $searchform->export_for_template($this));
    }

}
