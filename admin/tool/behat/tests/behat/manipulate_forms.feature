@tool @tool_behat
Feature: Forms manipulation
  In order to interact with agpu
  As a user
  I need to set forms values

  @javascript
  Scenario: Basic forms manipulation
    Given I log in as "admin"
    And I open my profile in edit mode
    When I set the field "First name" to "Field value"
    And I set the field "Select a country" to "Japan"
    And I set the field "New password" to "TestPass"
    Then the field "First name" matches value "Field value"
    And the "Select a country" select box should contain "Japan"
    And the field "New password" matches value "TestPass"

  @javascript
  Scenario: Expand all fieldsets and advanced elements
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1 | 0 |
    And the following "activities" exist:
      | activity | course | section | name     |
      | quiz     | C1     | 1       | Quiz 1   |
    And I am on the "Quiz 1" "quiz activity editing" page logged in as admin
    When I expand all fieldsets
    Then I should see "Close the quiz"
    And I should see "Group mode"
    And I should see "ID number"
    And I should not see "Show more..." in the "region-main" "region"
    And I should see "Show less..."
