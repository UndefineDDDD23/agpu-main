@core
Feature: Forms with a large number of fields
  In order to use certain forms on large agpu installations
  As an admin
  I need forms to work with more fields than the PHP max_input_vars setting

  Background:
    # Get to the fixture page.
    Given the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "activities" exist:
      | activity   | name | intro                                                                   | course | idnumber |
      | label      | L1   | <a href="../lib/tests/fixtures/max_input_vars.php">FixtureLink</a> | C1     | label1   |
    When I am on the "C1" "Course" page logged in as "admin"
    And I click on "FixtureLink" "link" in the "region-main" "region"

  # Note: These tests do not actually use JavaScript but they don't work with
  # the headless 'browser'.
  @javascript
  Scenario: Small form with checkboxes (not using workaround)
    When I follow "Advanced checkboxes / Small"
    And I press "Submit here!"
    Then I should see "_qf__core_max_input_vars_form=1"
    And I should see "mform_isexpanded_id_general=1"
    And I should see "arraytest=[13,42]"
    And I should see "array2test=[13,42]"
    And I should see "submitbutton=Submit here!"
    And I should see "Bulk checkbox success: true"

  @javascript
  Scenario: Small form with array fields (not using workaround)
    When I follow "Select options / Small"
    And I press "Submit here!"
    Then I should see "_qf__core_max_input_vars_form=1"
    And I should see "mform_isexpanded_id_general=1"
    And I should see "arraytest=[13,42]"
    And I should see "array2test=[13,42]"
    And I should see "submitbutton=Submit here!"
    And I should see "Bulk array success: true"

  @javascript
  Scenario: Below limit form with array fields (uses workaround but doesn't need it)
    When I follow "Select options / Below limit"
    And I press "Submit here!"
    Then I should see "_qf__core_max_input_vars_form=1"
    And I should see "mform_isexpanded_id_general=1"
    And I should see "arraytest=[13,42]"
    And I should see "array2test=[13,42]"
    And I should see "submitbutton=Submit here!"
    And I should see "Bulk array success: true"

  @javascript
  Scenario: Exact PHP limit length form with array fields (uses workaround but doesn't need it)
    When I follow "Select options / Exact PHP limit"
    And I press "Submit here!"
    Then I should see "_qf__core_max_input_vars_form=1"
    And I should see "mform_isexpanded_id_general=1"
    And I should see "arraytest=[13,42]"
    And I should see "array2test=[13,42]"
    And I should see "submitbutton=Submit here!"
    And I should see "Bulk array success: true"
