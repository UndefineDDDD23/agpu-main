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
 * Behat steps definitions for block site main menu
 *
 * @package    block_site_main_menu
 * @category   test
 * @copyright  2016 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no agpu_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Mink\Exception\ExpectationException as ExpectationException,
    Behat\Mink\Exception\DriverException as DriverException,
    Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException;

/**
 * Behat steps definitions for block site main menu
 *
 * @package    block_site_main_menu
 * @category   test
 * @copyright  2016 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_block_site_main_menu extends behat_base {

    /**
     * Returns the DOM node of the activity in the site menu block
     *
     * @throws ElementNotFoundException Thrown by behat_base::find
     * @param string $activityname The activity name
     * @return NodeElement
     */
    protected function get_site_menu_activity_node($activityname) {
        $activityname = behat_context_helper::escape($activityname);
        $xpath = "//*[contains(concat(' ',normalize-space(@class),' '),' block_site_main_menu ')]//li[contains(., $activityname)]";

        return $this->find('xpath', $xpath);
    }

    /**
     * Checks that the specified activity's action menu contains an item.
     *
     * @Then /^"(?P<activity_name_string>(?:[^"]|\\")*)" activity in site main menu block should have "(?P<icon_name_string>(?:[^"]|\\")*)" editing icon$/
     * @param string $activityname
     * @param string $iconname
     */
    public function activity_in_site_main_menu_block_should_have_editing_icon($activityname, $iconname) {
        $activitynode = $this->get_site_menu_activity_node($activityname);

        $notfoundexception = new ExpectationException('"' . $activityname . '" doesn\'t have a "' .
            $iconname . '" editing icon', $this->getSession());
        $this->find('named_partial', array('link', $iconname), $notfoundexception, $activitynode);
    }

    /**
     * Checks that the specified activity's action menu contains an item.
     *
     * @Then /^"(?P<activity_name_string>(?:[^"]|\\")*)" activity in site main menu block should not have "(?P<icon_name_string>(?:[^"]|\\")*)" editing icon$/
     * @param string $activityname
     * @param string $iconname
     */
    public function activity_in_site_main_menu_block_should_not_have_editing_icon($activityname, $iconname) {
        $activitynode = $this->get_site_menu_activity_node($activityname);

        try {
            $this->find('named_partial', array('link', $iconname), false, $activitynode);
            throw new ExpectationException('"' . $activityname . '" has a "' . $iconname .
                '" editing icon when it should not', $this->getSession());
        } catch (ElementNotFoundException $e) {
            // This is good, the menu item should not be there.
        }
    }

    /**
     * Clicks on the specified element of the activity. You should be in the course page with editing mode turned on.
     *
     * @Given /^I click on "(?P<element_string>(?:[^"]|\\")*)" "(?P<selector_string>(?:[^"]|\\")*)" in the "(?P<activity_name_string>(?:[^"]|\\")*)" activity in site main menu block$/
     * @param string $element
     * @param string $selectortype
     * @param string $activityname
     */
    public function i_click_on_in_the_activity_in_site_main_menu_block($element, $selectortype, $activityname) {
        $element = $this->get_site_menu_activity_element($element, $selectortype, $activityname);
        $element->click();
    }

    /**
     * Clicks on the specified element inside the activity container.
     *
     * @throws ElementNotFoundException
     * @param string $element
     * @param string $selectortype
     * @param string $activityname
     * @return NodeElement
     */
    protected function get_site_menu_activity_element($element, $selectortype, $activityname) {
        $activitynode = $this->get_site_menu_activity_node($activityname);

        $exception = new ElementNotFoundException($this->getSession(), "'{$element}' '{$selectortype}' in '{$activityname}'");
        return $this->find($selectortype, $element, $exception, $activitynode);
    }

    /**
     * Checks that the specified activity is hidden.
     *
     * @Then /^"(?P<activity_name_string>(?:[^"]|\\")*)" activity in site main menu block should be hidden$/
     * @param string $activityname
     */
    public function activity_in_site_main_menu_block_should_be_hidden($activityname) {
        $activitynode = $this->get_site_menu_activity_node($activityname);
        $exception = new ExpectationException('"' . $activityname . '" is not hidden', $this->getSession());
        $this->find('named_partial', array('badge', get_string('hiddenfromstudents')), $exception, $activitynode);
    }

    /**
     * Checks that the specified activity is hidden.
     *
     * @Then /^"(?P<activity_name_string>(?:[^"]|\\")*)" activity in site main menu block should be available but hidden from course page$/
     * @param string $activityname
     */
    public function activity_in_site_main_menu_block_should_be_available_but_hidden_from_course_page($activityname) {
        $activitynode = $this->get_site_menu_activity_node($activityname);
        $exception = new ExpectationException('"' . $activityname . '" is not hidden but available', $this->getSession());
        $this->find('named_partial', array('badge', get_string('hiddenoncoursepage')), $exception, $activitynode);
    }

    /**
     * Opens an activity actions menu if it is not already opened.
     *
     * @Given /^I open "(?P<activity_name_string>(?:[^"]|\\")*)" actions menu in site main menu block$/
     * @throws DriverException The step is not available when Javascript is disabled
     * @param string $activityname
     */
    public function i_open_actions_menu_in_site_main_menu_block($activityname) {
        $activityname = behat_context_helper::escape($activityname);
        $xpath = "//*[contains(concat(' ',normalize-space(@class),' '),' block_site_main_menu ')]//li[contains(., $activityname)]";
        $this->execute('behat_action_menu::i_open_the_action_menu_in', [$xpath, 'xpath_element']);
    }

    /**
     * Return the list of partial named selectors.
     *
     * @return array
     */
    public static function get_partial_named_selectors(): array {
        return [
            new behat_component_named_selector('Activity', [
                "//*[contains(concat(' ',normalize-space(@class),' '),' block_site_main_menu ')]//li[contains(., %locator%)]"
            ]),
        ];
    }
}
