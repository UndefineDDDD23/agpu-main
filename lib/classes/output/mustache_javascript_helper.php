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

/**
 * Store a list of JS calls to insert at the end of the page.
 *
 * @package core
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      2.9
 */
class mustache_javascript_helper {
    /** @var \agpu_page $page - Page used to get requirement manager */
    private $page = null;

    /**
     * Create new instance of mustache javascript helper.
     *
     * @param \agpu_page $page Page.
     */
    public function __construct($page) {
        $this->page = $page;
    }

    /**
     * Add the block of text to the page requires so it is appended in the footer. The
     * content of the block can contain further mustache tags which will be resolved.
     *
     * This function will always return an empty string because the JS is added to the page via the requirements manager.
     *
     * @param string $text The script content of the section.
     * @param \Mustache_LambdaHelper $helper Used to render the content of this block.
     * @return string The text of the block
     */
    public function help($text, \Mustache_LambdaHelper $helper) {
        $this->page->requires->js_amd_inline($helper->render($text));
        return '';
    }
}
