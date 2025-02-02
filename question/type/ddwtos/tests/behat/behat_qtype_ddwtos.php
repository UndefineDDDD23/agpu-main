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
 * Behat steps definitions for drag and drop into text.
 *
 * @package   qtype_ddwtos
 * @category  test
 * @copyright 2015 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no agpu_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../../lib/behat/behat_base.php');

/**
 * Steps definitions related with the drag and drop into text question type.
 *
 * @copyright 2015 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_qtype_ddwtos extends behat_base {

    /**
     * Get the xpath for a given drag item.
     * @param string $dragitem the text of the item to drag.
     * @return string the xpath expression.
     */
    protected function drag_xpath($dragitem) {
        return '//div[@class="answercontainer"]//span[contains(@class, "draghome") and contains(., "' .
                $this->escape($dragitem) . '") and not(contains(@class, "dragplaceholder"))]';
    }

    /**
     * Get the xpath for a given drop box.
     * @param string $spacenumber the number of the drop box.
     * @return string the xpath expression.
     */
    protected function drop_xpath($spacenumber) {
        return '//span[contains(@class, " drop ") and contains(@class, "place' . $spacenumber . ' ")]';
    }

    /**
     * Get the xpath for a given drop box contain a placed drag.
     * @param string $placeddragnumber the number of the placed drag.
     * @return string the xpath expression.
     */
    protected function inplace_xpath(string $placeddragnumber): string {
        return '//span[contains(@class, "inplace' . $placeddragnumber . '")]';
    }

    /**
     * Drag the drag item with the given text to the given space.
     *
     * @param string $dragitem the text of the item to drag.
     * @param int $spacenumber the number of the gap to drop into.
     *
     * @Given /^I drag "(?P<drag_item>[^"]*)" to space "(?P<space_number>\d+)" in the drag and drop into text question$/
     */
    public function i_drag_to_space_in_the_drag_and_drop_into_text_question($dragitem, $spacenumber) {
        $generalcontext = behat_context_helper::get('behat_general');
        $generalcontext->i_drag_and_i_drop_it_in($this->drag_xpath($dragitem),
                'xpath_element', $this->drop_xpath($spacenumber), 'xpath_element');
    }

    /**
     * Drag the drag item with the given text to the given placed drag number.
     *
     * @param string $dragitem the text of the item to drag.
     * @param int $placeddragnumber the number of the placed drag to drop into.
     *
     * @Given /^I drag "(?P<drag_item>[^"]*)" to placed drag "(?P<number>\d+)" in the drag and drop into text question$/
     */
    public function i_drag_to_placed_drag_number_in_the_drag_and_drop_into_text_question(string $dragitem,
        int $placeddragnumber): void {
        $generalcontext = behat_context_helper::get('behat_general');
        $generalcontext->i_drag_and_i_drop_it_in($this->drag_xpath($dragitem),
            'xpath_element', $this->inplace_xpath($placeddragnumber), 'xpath_element');
    }

    /**
     * Type some characters while focussed on a given space.
     *
     * @param string $keys the characters to type.
     * @param int $spacenumber the number of the space to type into.
     *
     * @Given /^I type "(?P<keys>[^"]*)" into space "(?P<space_number>\d+)" in the drag and drop onto image question$/
     */
    public function i_type_into_space_in_the_drag_and_drop_into_text_question($keys, $spacenumber) {
        $node = $this->get_selected_node('xpath_element', $this->drop_xpath($spacenumber));
        $this->ensure_node_is_visible($node);
        $node->focus();
        foreach (str_split($keys) as $key) {
            behat_base::type_keys($this->getSession(), [$key]);
            $this->wait_for_pending_js();
        }
    }

    /**
     * Check that the given drag exist in drag home area
     *
     * @param string $dragitem the text of the drag item.
     *
     * @Given /^I should see "(?P<drag_item>[^"]*)" in the home area of drag and drop into text question$/
     */
    public function i_should_see_drag_in_the_home_area($dragitem) {
        $this->ensure_element_exists($this->drag_xpath($dragitem), 'xpath_element');
    }
}
