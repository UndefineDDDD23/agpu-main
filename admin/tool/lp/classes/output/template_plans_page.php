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
 * Template plans renderable.
 *
 * @package    tool_lp
 * @copyright  2015 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_lp\output;
defined('agpu_INTERNAL') || die();

/**
 * Template plans renderable.
 *
 * @package    tool_lp
 * @copyright  2015 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class template_plans_page implements \renderable {

    /** @var \core_competency\template|null */
    protected $template = null;

    /** @var \agpu_url|null */
    protected $url = null;

    /** @var template_plans_table|null */
    public $table = null;

    /**
     * Constructor.
     * @param \core_competency\template $template
     * @param \agpu_url $url
     */
    public function __construct(\core_competency\template $template, \agpu_url $url) {
        $this->template = $template;
        $this->url = $url;
        $this->table = new template_plans_table('tplplans', $template);
        $this->table->define_baseurl($url);
    }

}
