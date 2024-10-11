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
 * URL rewriter base.
 *
 * @package    core
 * @author     Brendan Heywood <brendan@catalyst-au.net>
 * @copyright  Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\output;

/**
 * URL rewriter interface
 *
 * @package    core
 * @author     Brendan Heywood <brendan@catalyst-au.net>
 * @copyright  Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
interface url_rewriter {
    /**
     * Rewrite agpu_urls into another form.
     *
     * @param \agpu_url $url a url to potentially rewrite
     * @return \agpu_url Returns a new, or the original, agpu_url;
     */
    public static function url_rewrite(\agpu_url $url);

    /**
     * Gives a url rewriting plugin a chance to rewrite the current page url
     * avoiding redirects and improving performance.
     *
     * @return void
     */
    public static function html_head_setup();
}
