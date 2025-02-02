@mod @mod_choice
Feature: Choice with no calendar capabilites
  In order to allow work effectively
  As a teacher
  I need to be able to create choices even when I cannot edit calendar events

  Background:
    Given the following "courses" exist:
      | fullname | shortname | category | groupmode |
      | Course 1 | C1 | 0 | 1 |
    And the following "users" exist:
      | username | firstname | lastname | email |
      | teacher1 | Teacher | 1 | teacher1@example.com |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | editingteacher |
    And I log in as "admin"
    And I am on the "Course 1" "permissions" page
    And I override the system permissions of "Teacher" role with:
      | capability | permission |
      | agpu/calendar:manageentries | Prohibit |
    And I log out

  Scenario: Editing a choice
    And the following "activities" exist:
      | activity | name             | intro                   | course | idnumber | option             | section |
      | choice   | Test choice name | Test choice description | C1     | choice1  | Option 1, Option 2 | 1       |
    Given I log in as "admin"
    And I am on "Course 1" course homepage
    And I follow "Test choice name"
    And I navigate to "Settings" in current page administration
    And I set the following fields to these values:
      | id_timeopen_enabled | 1 |
      | id_timeopen_day | 1 |
      | id_timeopen_month | 1 |
      | id_timeopen_year | 2017 |
      | id_timeclose_enabled | 1 |
      | id_timeclose_day | 1 |
      | id_timeclose_month | 2 |
      | id_timeclose_year | 2017 |
    And I press "Save and return to course"
    And I log out
    When I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    And I follow "Test choice name"
    And I navigate to "Settings" in current page administration
    And I set the following fields to these values:
      | id_timeopen_year | 2018 |
      | id_timeclose_year | 2018 |
    And I press "Save and return to course"
    Then I should see "Test choice name"
