@core @core_course @core_courseformat
Feature: Course index depending on role
  In order to quickly access the course structure
  As a user
  I need to see the current course structure in the course index.

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
      | student1 | Student   | 1        | student1@example.com |
    And the following "course" exists:
      | fullname         | Course 1 |
      | shortname        | C1       |
      | category         | 0        |
      | enablecompletion | 1        |
      | numsections      | 4        |
      | initsections     | 1        |
    And the following "activities" exist:
      | activity | name                | intro                       | course | idnumber | section |
      | assign   | Activity sample 1   | Test assignment description | C1     | sample1  | 1       |
      | book     | Activity sample 2   |                             | C1     | sample2  | 2       |
      | choice   | Activity sample 3   | Test choice description     | C1     | sample3  | 3       |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | student1 | C1     | student        |
      | teacher1 | C1     | editingteacher |
    # The course index is hidden by default in small devices.
    And I change window size to "large"

  @javascript
  Scenario: Course index is present on course pages.
    Given I am on the "C1" "Course" page logged in as "teacher1"
    And the "multilang" filter is "on"
    And the "multilang" filter applies to "content and headings"
#    Course index is visible on Course main page
    When I am on the "C1" "Course" page logged in as "teacher1"
    And "courseindex-content" "region" should be visible
#    Course index is visible on Settings page
    And I am on the "C1" "course editing" page
    And "courseindex-content" "region" should be visible
#    Course index is visible on Participants page
    And I am on the "C1" "enrolled users" page
    And "courseindex-content" "region" should be visible
#    Course index is visible on Enrolment methods page
    And I am on the "C1" "enrolment methods" page
    And "courseindex-content" "region" should be visible
#    Course index is visible on Groups page
    And I am on the "C1" "groups" page
    And "courseindex-content" "region" should be visible
#    Course index is visible on Permissions page
    And I am on the "C1" "permissions" page
    And "courseindex-content" "region" should be visible
#    Course index is visible on Activity edition page
    And I am on the "Activity sample 1" "assign activity editing" page
    And "courseindex-content" "region" should be visible
    And I set the field "Assignment name" in the "General" "fieldset" to "<span lang=\"en\" class=\"multilang\">Activity</span><span lang=\"de\" class=\"multilang\">Aktivität</span> sample 1"
    And I press "Save and display"
#    Course index is visible on Activity page
    And "courseindex-content" "region" should be visible
    And I should see "Activity sample 1" in the "courseindex-content" "region"

  @javascript
  Scenario: Course index as a teacher
    Given I log in as "teacher1"
    When I am on "Course 1" course homepage
    Then I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"

  @javascript
  Scenario: Teacher can see hiden activities and sections
    Given I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And I hide section "2"
    And I open "Activity sample 3" actions menu
    And I choose "Hide" in the open action menu
    And I log out
    And I log in as "teacher1"
    When I am on "Course 1" course homepage
    Then I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"

  @javascript
  Scenario: Students can only see visible activies and sections
    Given I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And I hide section "2"
    And I open "Activity sample 3" actions menu
    And I choose "Hide" in the open action menu
    And I log out
    And I log in as "student1"
    When I am on "Course 1" course homepage
    Then I should see "Section 1" in the "courseindex-content" "region"
    And I should not see "Section 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should not see "Activity sample 2" in the "courseindex-content" "region"
    And I should not see "Activity sample 3" in the "courseindex-content" "region"

  @javascript
  Scenario: Delete an activity as a teacher
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    When I delete "Activity sample 2" activity
    Then I should not see "Activity sample 2" in the "courseindex-content" "region"

  @javascript
  Scenario: Highlight sections are represented in the course index.
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    And I turn section "2" highlighting on
    # Current section is only marked visually in the course index.
    And the "class" attribute of "#courseindex-content [data-for='section'][data-number='2']" "css_element" should contain "current"
    And I should not see "Highlighted" in the "#courseindex-content [data-for='section'][data-number='1']" "css_element"
    And I should see "Highlighted" in the "#courseindex-content [data-for='section'][data-number='2']" "css_element"
    When I turn section "1" highlighting on
    # Current section is only marked visually in the course index.
    Then the "class" attribute of "#courseindex-content [data-for='section'][data-number='1']" "css_element" should contain "current"
    And I should see "Highlighted" in the "#courseindex-content [data-for='section'][data-number='1']" "css_element"
    And I should not see "Highlighted" in the "#courseindex-content [data-for='section'][data-number='2']" "css_element"

  @javascript
  Scenario: Course index toggling
    Given the following "activities" exist:
      | activity | name                         | course | idnumber | section |
      | book     | Second activity in section 1 | C1     | sample4  | 1       |
    When I am on the "Course 1" course page logged in as teacher1
    # Sections should be opened by default.
    Then I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Second activity in section 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"
    # Collapse a section 1 via chevron.
    And I click on "Collapse" "link" in the ".courseindex-section[data-number='1']" "css_element"
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should not see "Activity sample 1" in the "courseindex-content" "region"
    And I should not see "Second activity in section 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"
    # Expand section 1 via section name.
    And I click on "Section 1" "link" in the "courseindex-content" "region"
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Second activity in section 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"
    # Collapse a section 2 via chevron.
    And I click on "Collapse" "link" in the ".courseindex-section[data-number='2']" "css_element"
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Second activity in section 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should not see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"
    # Expand section 2 via chevron.
    And I click on "Expand" "link" in the ".courseindex-section[data-number='2']" "css_element"
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Second activity in section 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"
    # Click a section name does not collapse the section.
    And I click on "Section 2" "link" in the "courseindex-content" "region"
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Second activity in section 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"

  @javascript
  Scenario: Course index toggling all sections
    When I am on the "Course 1" course page logged in as teacher1
    # Sections should be opened by default.
    Then I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"
    # Collapse all sections
    And I click on "Course index options" "button" in the "#courseindexdrawercontrols" "css_element"
    And I click on "Collapse all" "link" in the "#courseindexdrawercontrols" "css_element"
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should not see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should not see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should not see "Activity sample 3" in the "courseindex-content" "region"
    # Expand all sections
    And I click on "Course index options" "button" in the "#courseindexdrawercontrols" "css_element"
    And I click on "Expand all" "link" in the "#courseindexdrawercontrols" "css_element"
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"

  @javascript
  Scenario: Course index section preferences
    When I am on the "C1" "Course" page logged in as "teacher1"
    Then I should see "Section 1" in the "courseindex-content" "region"
    And I should see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"
    # Collapse section 1.
    And I click on "Collapse" "link" in the ".courseindex-section[data-number='1']" "css_element"
    And I reload the page
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should not see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should see "Activity sample 3" in the "courseindex-content" "region"
    # Collapse section 3.
    And I click on "Collapse" "link" in the ".courseindex-section[data-number='3']" "css_element"
    And I reload the page
    And I should see "Section 1" in the "courseindex-content" "region"
    And I should not see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should not see "Activity sample 3" in the "courseindex-content" "region"
    # Delete section 1
    And I turn editing mode on
    And I delete section "1"
    And I click on "Delete" "button" in the ".modal" "css_element"
    And I reload the page
    And I should not see "Activity sample 1" in the "courseindex-content" "region"
    And I should see "Section 2" in the "courseindex-content" "region"
    And I should see "Activity sample 2" in the "courseindex-content" "region"
    And I should see "Section 3" in the "courseindex-content" "region"
    And I should not see "Activity sample 3" in the "courseindex-content" "region"

  @javascript
  Scenario: Adding section should alter the course index
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    When I click on "Add section" "link" in the "course-addsection" "region"
    Then I should see "New section" in the "courseindex-content" "region"

  @javascript
  Scenario: Remove a section should alter the course index
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    When I delete section "4"
    And I click on "Delete" "button" in the ".modal" "css_element"
    Then I should not see "Section 4" in the "courseindex-content" "region"

  @javascript
  Scenario: Delete a previous section should alter the course index unnamed sections
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    When I delete section "1"
    And I click on "Delete" "button" in the ".modal" "css_element"
    Then I should not see "Section 1" in the "courseindex-content" "region"
    And I should not see "Activity sample 1" in the "courseindex-content" "region"

  @javascript
  Scenario: Course index locked activity link
    Given the following config values are set as admin:
      | enableavailability | 1 |
    And I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    And I navigate to "Settings" in current page administration
    And I expand all fieldsets
    And I set the field "Course layout" to "Show one section per page"
    And I click on "Save and display" "button"
    # Add access restriction to Activity sample 3.
    And I open "Activity sample 3" actions menu
    And I click on "Edit settings" "link" in the "Activity sample 3" activity
    And I expand all fieldsets
    And I click on "Add restriction..." "button"
    And I click on "Date" "button" in the "Add restriction..." "dialogue"
    And I set the following fields to these values:
      | x[day]   | 31                  |
      | x[month] | 12                  |
      | x[year]  | ## +1 year ## %Y ## |
    And I press "Save and return to course"
    And I log out
    # Check course index link goes to the specific section.
    When I log in as "student1"
    And I am on "Course 1" course homepage
    And I click on "Section 1" "link" in the "region-main" "region"
    And I should not see "Activity sample 3" in the "region-main" "region"
    And I click on "Activity sample 3" "link" in the "courseindex-content" "region"
    Then I should see "Activity sample 3" in the "region-main" "region"

  @javascript
  Scenario Outline: Course index is displayed by default depending on the screen size.
    When I change window size to "<device>"
    And I am on the "C1" "Course" page logged in as "student1"
    Then "courseindex-content" "region" should <bydefault> visible
    And I reload the page
    And "courseindex-content" "region" should <bydefault> visible
    # Check whenever preferences are saved.
    And I click on "<action1> course index" "button"
    And I reload the page
    And "courseindex-content" "region" should <visible1> visible
    And I click on "<action2> course index" "button"
    And I reload the page
    And "courseindex-content" "region" should <visible2> visible

    Examples:
      | device | bydefault | action1 | visible1 | action2 | visible2 |
      | large  | be        | Close   | not be   | Open    | be       |
      | tablet | not be    | Open    | not be   | Open    | not be   |
      | mobile | not be    | Open    | not be   | Open    | not be   |

  @javascript
  Scenario: Course index is refreshed when we change role.
    When I am on the "C1" "Course" page logged in as "teacher1"
    And I turn editing mode on
    And I hide section "1"
    And I turn editing mode off
    And I should see "Section 1" in the "courseindex-content" "region"
    And I follow "Switch role to..." in the user menu
    And I press "Student"
    Then I should not see "Section 1" in the "courseindex-content" "region"

  @javascript
  Scenario: Course index behaviour for activities without url
    # Add a label to the course (labels doesn't have URL, because they can't be displayed in a separate page).
    Given the following "activities" exist:
      | activity | name                | intro       | course | idnumber | section |
      | label    | Activity sample 4   | Test label  | C1     | sample4  | 2       |
    # Check resources without URL, as labels, are displayed in the CI and the link goes to the main page when it is clicked.
    When I am on the "sample1" "Activity" page logged in as "student1"
    Then I should see "Activity sample 4" in the "#courseindex" "css_element"
    And I click on "Activity sample 4" "link" in the "#courseindex" "css_element"
    And I should see "Test label" in the "region-main" "region"
    And I should see "Activity sample 2" in the "region-main" "region"
    # Check resources without URL, as labels, are displayed for teachers too, and the link is working even when edit mode is on.
    And I am on the "sample1" "Activity" page logged in as "teacher1"
    And I should see "Activity sample 4" in the "#courseindex" "css_element"
    And I turn editing mode on
    And I should see "Activity sample 4" in the "#courseindex" "css_element"
    And I click on "Activity sample 4" "link" in the "#courseindex" "css_element"
    And I should see "Test label" in the "region-main" "region"
    And I should see "Activity sample 2" in the "region-main" "region"

  @javascript
  Scenario: Course index behaviour for labels with name or without name
    # Add two labels to the course (one with name and one without name).
    Given the following "activities" exist:
      | activity | name                | intro         | course | idnumber | section |
      | label    | Activity sample 5   | Test label 1  | C1     | sample4  | 2       |
      | label    |                     | Test label 2  | C1     | sample5  | 2       |
    When I am on the "Course 1" course page logged in as teacher1
    And I should see "Section 2" in the "courseindex-content" "region"
    # Label name should be displayed if it is set.
    And I should see "Activity sample 5" in the "courseindex-content" "region"
    # Label intro text should be displayed if label name is not set.
    And I should see "Test label 2" in the "courseindex-content" "region"

  @javascript
  Scenario: Change the section name inline in section page
    When I am on the "Course 1 > Section 2" "course > section" page logged in as "teacher1"
    And I turn editing mode on
    When I set the field "Edit section name" in the "page-header" "region" to "Custom section name"
    Then I should see "Custom section name" in the "courseindex-content" "region"

  @javascript
  Scenario: We cannot add a section when the number of section reaches maxsections but as soon as we reach under the limit we can add a section again.
    Given the following config values are set as admin:
      | maxsections | 4 | agpucourse|
    And I log in as "teacher1"
    And I am on "Course 1" course homepage with editing mode on
    Then I should see "Section 1" in the "courseindex-content" "region"
    And ".disabled" "css_element" should exist in the "[data-action='addSection']" "css_element"
    And I should see "You have reached the maximum number of sections allowed for a course."
    And I delete section "4"
    And I click on "Delete" "button" in the ".modal" "css_element"
    And ".disabled" "css_element" should not exist in the "[data-action='addSection']" "css_element"
    And I should not see "You have reached the maximum number of sections allowed for a course."
