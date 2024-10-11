@core
Feature: agpuNet outbound share course
  In order to send a course to agpuNet server
  As a teacher
  I need to be able to backup the course and share to agpuNet

  Background:
    Given the following course exists:
      | name      | Test course |
      | shortname | C1          |
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

  Scenario: Share course to agpuNet option only be available for teachers and managers
    Given I am on the "C1" "course" page logged in as student1
    And "Share to agpuNet" "link" should not exist in current page administration
    When I am on the "C1" "course" page logged in as teacher1
    And "Share to agpuNet" "link" should exist in current page administration
    Then I am on the "C1" "course" page logged in as manager1
    And "Share to agpuNet" "link" should exist in current page administration

  Scenario: Share course to agpuNet option only be available for user that has capability only
    Given the following "permission overrides" exist:
      | capability                    | permission | role           | contextlevel | reference |
      | agpu/agpunet:sharecourse  | Prohibit   | editingteacher | Course       | C1        |
    When I am on the "C1" "course" page logged in as teacher1
    Then "Share to agpuNet" "link" should not exist in current page administration
    And I am on the "C1" "course" page logged in as manager1
    And "Share to agpuNet" "link" should exist in current page administration
    And the following "permission overrides" exist:
      | capability                    | permission | role    | contextlevel | reference |
      | agpu/agpunet:sharecourse  | Prohibit   | manager | Course       | C1        |
    And I am on the "C1" "course" page logged in as manager1
    And "Share to agpuNet" "link" should not exist in current page administration

  @javascript
  Scenario: User can share course to agpuNet
    Given I am on the "C1" "course" page logged in as teacher1
    When I navigate to "Share to agpuNet" in current page administration
    Then I should see "Course" in the "Share to agpuNet" "dialogue"
    And I should see "Test course 1" in the "Share to agpuNet" "dialogue"
    And I should see "This course is being shared with agpuNet as a resource." in the "Share to agpuNet" "dialogue"
    And I click on "Share" "button" in the "Share to agpuNet" "dialogue"
    And I switch to "agpunet_auth" window
    And I press "Allow" and switch to main window
    And I should see "Saved to agpuNet drafts"
    And "Go to agpuNet drafts" "link" should exist in the "Share to agpuNet" "dialogue"
