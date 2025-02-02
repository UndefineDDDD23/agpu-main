@tool @tool_admin_presets @javascript
Feature: I can add a new preset with current settings

  Background:
    Given I log in as "admin"
    And I navigate to "Site admin presets" in site administration

  Scenario: Export settings with an existing name
    Given I should see "Starter"
    And I click on "Create preset" "button"
    And I set the field "Name" to "Starter"
    And I set the field "Description" to "Non-core starter preset"
    When I click on "Create preset" "button"
    Then the following should exist in the "reportbuilder-table" table:
      | Name    | Description                                                                                                                        |
      | Starter | agpu with all of the most popular features, including Assignment, Feedback, Forum, H5P, Quiz and Completion tracking.            |
      | Full    | All the Starter features plus External (LTI) tool, SCORM, Workshop, Analytics, Badges, Competencies, Learning plans and lots more. |
      | Starter | Non-core starter preset                                                                                                            |

  Scenario: Export current settings
    Given I click on "Create preset" "button"
    And I set the field "Name" to "Current"
    And I click on "Create preset" "button"
    And I press "Review settings and apply" action in the "Current" report row
    And I should not see "Setting changes"
    And I click on "Continue" "button"
    And the following config values are set as admin:
      | enableportfolios | 1 |
    And I press "Review settings and apply" action in the "Current" report row
    Then I should see "Setting changes"
