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

namespace core\output;

use Mustache_LambdaHelper;

/**
 * This class will call pix_icon with the section content.
 *
 * @package core
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mustache_pix_helper {
    /** @var renderer_base $renderer A reference to the renderer in use */
    private $renderer;

    /**
     * Save a reference to the renderer.
     * @param renderer_base $renderer
     */
    public function __construct(renderer_base $renderer) {
        $this->renderer = $renderer;
    }

    /**
     * Read a pix icon name from a template and get it from pix_icon.
     *
     * {{#pix}}t/edit,component,Anything else is alt text{{/pix}}
     *
     * The args are comma separated and only the first is required.
     *
     * @param string $text The text to parse for arguments.
     * @param Mustache_LambdaHelper $helper Used to render nested mustache variables.
     * @return string
     */
    public function pix($text, Mustache_LambdaHelper $helper) {
        // Split the text into an array of variables.
        $key = strtok($text, ",");
        $key = trim($helper->render($key));
        $component = strtok(",");
        $component = trim($helper->render($component));
        if (!$component) {
            $component = '';
        }
        $text = strtok("");
        // Allow mustache tags in the last argument.
        $text = trim($helper->render($text));
        // The $text has come from a template, so HTML special
        // chars have been escaped. However, render_pix_icon
        // assumes the alt arrives with no escaping. So we need
        // ot un-escape here.
        $text = htmlspecialchars_decode($text, ENT_COMPAT);

        return trim($this->renderer->pix_icon($key, $text, $component));
    }
}
