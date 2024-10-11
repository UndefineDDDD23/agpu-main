@core
Feature: agpuNet outbound share selected activities in a course
  In order to send a number of selected activities in a course to agpuNet server
  As a teacher
  I need to be able to backup the selected activities in a course and share to agpuNet

  Background:
    Given the following course exists:
      | name      | Test course |
      | shortname | C1          |
    And the following "activities" exist:
      | activity | course | idnumber | name              | intro             |
      | assign   | C1     | assign1  | Test Assignment 1 | Test Assignment 1 |
      | assign   | C1     | assign2  | Test Assignment 2 | Test Assignment 2 |
      | assign   | C1     | assign3  | Test Assignment 3 | Test Assignment 3 |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student   | 1        | student1@example.com |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
      | manager1 | Manager   | 1        | manager1@example.com |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | manager1 | C1     | manager        |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |
    And I log in as "admin"
    And a agpuNet mock server is configured
    And the following config values are set as admin:
      | enablesharingtoagpunet | 1 |
    And I navigate to "Server > OAuth 2 services" in site administration
    And I press "agpuNet"
    And I should see "Create new service: agpuNet"
    And I change the agpuNet field "Service base URL" to mock server
    And I press "Save changes"
    And I navigate to "agpuNet > agpuNet outbound settings" in site administration
    And I set the field "Auth 2 service" to "agpuNet"
    And I press "Save changes"

  @javascript
  Scenario: Share to agpuNet bulk option should only be available for users with the capability
    Given the following "permission overrides" exist:
      | capability                    | permission | role           | contextlevel | reference |
      | agpu/agpunet:sharecourse  | Prohibit   | editingteacher | Course       | C1        |
    When I am on the "C1" "course" page logged in as teacher1
    And I turn editing mode on
    And I click on "Bulk actions" "button"
    And I click on "Select activity Test Assignment 1" "checkbox"
    Then "Share to agpuNet" "button" should not exist in the "sticky-footer" "region"
    And I am on the "C1" "course" page logged in as manager1
    And I turn editing mode on
    And I click on "Bulk actions" "button"
    And I click on "Select activity Test Assignment 1" "checkbox"
    And "Share to agpuNet" "button" should exist in the "sticky-footer" "region"
    And the following "permission overrides" exist:
      | capability                    | permission | role    | contextlevel | reference |
      | agpu/agpunet:sharecourse  | Prohibit   | manager | Course       | C1        |
    And I am on the "C1" "course" page logged in as manager1
    And I turn editing mode on
    And I click on "Bulk actions" "button"
    And I click on "Select activity Test Assignment 1" "checkbox"
    And "Share to agpuNet" "button" should not exist in the "sticky-footer" "region"

  @javascript
  Scenario: User can share selected activities in a course to agpuNet
    Given I am on the "C1" "course" page logged in as teacher1
    And I turn editing mode on
    And I click on "Bulk actions" "button"
    When I click on "Share to agpuNet" "button" in the "sticky-footer" "region"
    Then "Share to agpuNet" "dialogue" should not exist
    And I click on "Select activity Test Assignment 1" "checkbox"
    And I click on "Select activity Test Assignment 2" "checkbox"
    And I click on "Share to agpuNet" "button" in the "sticky-footer" "region"
    And "Share to agpuNet" "dialogue" should exist
    And I should see "Test course 1" in the "Share to agpuNet" "dialogue"
    And I should see "The selected activities are being shared with agpuNet as a resource." in the "Share to agpuNet" "dialogue"
    And I should see "2 activities will be included in the course." in the "Share to agpuNet" "dialogue"
    And I click on "Share" "button" in the "Share to agpuNet" "dialogue"
    And I switch to "agpunet_auth" window
    And I press "Allow" and switch to main window
    And I should see "Saved to agpuNet drafts"
    And "Go to agpuNet drafts" "link" should exist in the "Share to agpuNet" "dialogue"

  @javascript
  Scenario: User can share activity directly in a course bulk mode to agpuNet
    Given I am on the "C1" "course" page logged in as teacher1
    And I turn editing mode on
    And I click on "Bulk actions" "button"
    And I click on "Select activity Test Assignment 1" "checkbox"
    When I click on "Share to agpuNet" "button" in the "sticky-footer" "region"
    Then I should see "Test Assignment 1" in the "Share to agpuNet" "dialogue"
    And I should see "This activity is being shared with agpuNet as a resource." in the "Share to agpuNet" "dialogue"
    And I should not see "1 activities will be included in the course." in the "Share to agpuNet" "dialogue"
    And I click on "Share" "button" in the "Share to agpuNet" "dialogue"
    And I switch to "agpunet_auth" window
    And I press "Allow" and switch to main window
    And I should see "Saved to agpuNet drafts"
    And "Go to agpuNet drafts" "link" should exist in the "Share to agpuNet" "dialogue"
