@block @block_search_forums @mod_forum
Feature: The search forums block allows users to search for forum posts on frontpage
  In order to search for a forum post
  As an administrator
  I can add the search forums block

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email | idnumber |
      | student1 | Student | 1 | student1@example.com | S1 |
    And the following "blocks" exist:
      | blockname     | contextlevel | reference | pagetypepattern | defaultregion |
      | search_forums | System       | 1         | site-index      | side-pre      |

  Scenario: Use the search forum block on the frontpage and search for posts as a user
    Given I log in as "student1"
    And I am on site homepage
    When I set the field "Search" to "agpu"
    And I press "Search"
    Then I should see "No posts"

  Scenario: Use the search forum block on the frontpage and search for posts as a guest
    Given I log in as "guest"
    And I am on site homepage
    When I set the field "Search" to "agpu"
    And I press "Search"
    Then I should see "No posts"
