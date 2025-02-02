@core @core_tag
Feature: Users can edit tags to add description or rename
  In order to use tags
  As a manager
  I need to be able to edit tags

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                | interests         |
      | manager1 | Manager   | 1        | manager1@example.com |                   |
      | user1    | User      | 1        | user1@example.com    | Cat,Dog,Turtle    |
      | editor1  | Editor    | 1        | editor1@example.com  |                   |
    Given the following "roles" exist:
      | name       | shortname |
      | Tag editor | tageditor |
    And the following "system role assigns" exist:
      | user     | course               | role      |
      | manager1 | Acceptance test site | manager   |
      | editor1  | Acceptance test site | tageditor |
    And the following "tags" exist:
      | name         | isstandard |
      | Neverusedtag | 1          |

  @javascript
  Scenario: User with tag editing capability can change tag description
    Given the following "role capability" exists:
      | role                         | tageditor |
      | agpu/tag:edit              | allow     |
      | agpu/site:viewparticipants | allow     |
      | agpu/user:viewdetails      | allow     |
    When I log in as "editor1"
    And I turn editing mode on
    And the following config values are set as admin:
      | unaddableblocks | | theme_boost|
    # TODO MDL-57120 site "Tags" link not accessible without navigation block.
    And I add the "Navigation" block if not present
    And I click on "Site pages" "list_item" in the "Navigation" "block"
    And I click on "Tags" "link" in the "Navigation" "block"
    And I follow "Turtle"
    And I follow "User 1"
    And I follow "Cat"
    And I follow "Edit this tag"
    And I should not see "Tag name"
    And I should not see "Standard"
    And I set the following fields to these values:
      | Description | Description of tag 1 |
      | Related tags | Dog,  Turtle,Fish |
    And I press "Update"
    Then "Cat" "text" should exist in the ".breadcrumb" "css_element"
    And "Description of tag 1" "text" should exist in the ".tag-description" "css_element"
    And I should see "Related tags:" in the ".tag_list" "css_element"
    And I should see "Dog" in the ".tag_list" "css_element"
    And I should see "Turtle" in the ".tag_list" "css_element"
    And I should see "Fish" in the ".tag_list" "css_element"

  @javascript
  Scenario: Manager can change tag description, related tags and rename the tag from tag view page
    When I log in as "manager1"
    And I turn editing mode on
    And the following config values are set as admin:
      | unaddableblocks | | theme_boost|
    # TODO MDL-57120 site "Tags" link not accessible without navigation block.
    And I add the "Navigation" block if not present
    And I click on "Site pages" "list_item" in the "Navigation" "block"
    And I click on "Tags" "link" in the "Navigation" "block"
    And I follow "Turtle"
    And I follow "User 1"
    And I follow "Cat"
    And I follow "Edit this tag"
    And I set the following fields to these values:
      | Tag name | Kitten |
      | Description | Description of tag 1 |
      | Related tags | Dog,  Turtle,Fish |
      | Standard | 0 |
    And I press "Update"
    Then "Kitten" "text" should exist in the ".breadcrumb" "css_element"
    And "Description of tag 1" "text" should exist in the ".tag-description" "css_element"
    And I should see "Related tags:" in the ".tag_list" "css_element"
    And I should see "Dog" in the ".tag_list" "css_element"
    And I should see "Turtle" in the ".tag_list" "css_element"
    And I should see "Fish" in the ".tag_list" "css_element"
    And I follow "Edit this tag"
    And I click on "× Dog" "text"
    And I press "Update"
    Then "Kitten" "text" should exist in the ".breadcrumb" "css_element"
    And "Description of tag 1" "text" should exist in the ".tag-description" "css_element"
    And I should see "Related tags:" in the ".tag_list" "css_element"
    And I should see "Turtle" in the ".tag_list" "css_element"
    And I should see "Fish" in the ".tag_list" "css_element"
    And I should not see "Dog"

  Scenario: Renaming the tag from tag view page
    When I log in as "manager1"
    And I turn editing mode on
    And the following config values are set as admin:
      | unaddableblocks | | theme_boost|
      # TODO MDL-57120 site "Tags" link not accessible without navigation block.
    And I add the "Navigation" block if not present
    And I click on "Tags" "link" in the "Navigation" "block"
    And I follow "Turtle"
    And I follow "User 1"
    And I follow "Cat"
    And I follow "Edit this tag"
    And I set the following fields to these values:
      | Tag name | DOG |
    And I press "Update"
    And I should see "Tag names already being used"
    And I set the following fields to these values:
      | Tag name | Kitten |
    And I press "Update"
    Then "Kitten" "text" should exist in the ".breadcrumb" "css_element"
    And I follow "Edit this tag"
    And I set the following fields to these values:
      | Tag name | KITTEN |
    And I press "Update"
    And "KITTEN" "text" should exist in the ".breadcrumb" "css_element"

  @javascript
  Scenario: Manager can change tag description and rename the tag from tag manage page
    When I log in as "manager1"
    And I navigate to "Appearance > Manage tags" in site administration
    And I follow "Default collection"
    And I press "Edit" action in the "Cat" report row
    And I set the following fields to these values:
      | Tag name | Kitten |
      | Description | Description of tag 1 |
      | Related tags | Dog,  Turtle,Fish |
      | Standard | 0 |
    And I press "Update"
    And I follow "Kitten"
    And "Description of tag 1" "text" should exist in the ".tag-description" "css_element"
    And I should see "Related tags:" in the ".tag_list" "css_element"
    And I should see "Dog" in the ".tag_list" "css_element"
    And I should see "Turtle" in the ".tag_list" "css_element"
    And I should see "Fish" in the ".tag_list" "css_element"

  Scenario: Renaming the tag in edit tag form from tag manage page
    When I log in as "manager1"
    And I navigate to "Appearance > Manage tags" in site administration
    And I follow "Default collection"
    And I press "Edit" action in the "Cat" report row
    And I set the following fields to these values:
      | Tag name | DOG |
    And I press "Update"
    And I should see "Tag names already being used"
    And I set the following fields to these values:
      | Tag name | Kitten |
    And I press "Update"
    And I press "Edit" action in the "Kitten" report row
    And I set the following fields to these values:
      | Tag name | KITTEN |
    And I press "Update"
    And I should see "KITTEN"
    And I should not see "Kitten"

  @javascript
  Scenario: Renaming the tag using quick edit field on tag manage page
    When I log in as "manager1"
    And I navigate to "Appearance > Manage tags" in site administration
    And I follow "Default collection"
    # Renaming tag to a valid name
    And I set the field "Edit tag name" in the "Cat" "table_row" to "Kitten"
    Then the following should not exist in the "reportbuilder-table" table:
      | First name | Tag name |
      | Admin User | Cat      |
    And I reload the page
    And I should see "Kitten"
    And I should not see "Cat"
    # Renaming tag to an invalid name
    And I set the field "Edit tag name" in the "Turtle" "table_row" to "DOG"
    And I should see "The tag name is already in use. Do you want to combine these tags?"
    And I click on "Cancel" "button" in the "Confirm" "dialogue"
    And "New name for tag" "field" should not exist
    And I should see "Turtle"
    And I should see "Dog"
    And I should not see "DOG"

  @javascript
  Scenario: Combining tags when renaming
    When I log in as "manager1"
    And I navigate to "Appearance > Manage tags" in site administration
    And I follow "Default collection"
    And I set the field "Edit tag name" in the "Turtle" "table_row" to "DOG"
    And I should see "The tag name is already in use. Do you want to combine these tags?"
    And I press "Yes"
    Then I should not see "Turtle"
    And I should not see "DOG"
    And I should see "Dog"

  @javascript
  Scenario: Combining multiple tags
    When I log in as "manager1"
    And I navigate to "Appearance > Manage tags" in site administration
    And I follow "Default collection"
    And I set the following fields to these values:
      | Select tag Dog | 1 |
      | Select tag Neverusedtag | 1 |
      | Select tag Turtle | 1 |
    And I press "Combine selected"
    And I should see "Select the tag that will be used after combining"
    And I click on "Turtle" "radio" in the "#combinetags_form" "css_element"
    And I press "Continue"
    Then I should see "Tags are combined"
    And I should not see "Dog"
    And I should not see "Neverusedtag"
    And I should see "Turtle"
    # Even though Turtle was not standard but at least one of combined tags was (Neverusedtag). Now Turtle is also standard.
    And "Remove from standard tags" "link" should exist in the "Turtle" "table_row"

  @javascript
  Scenario: Combining all tags
    When I log in as "manager1"
    And I navigate to "Appearance > Manage tags" in site administration
    And I follow "Default collection"
    And I set the field "Select all" to "1"
    And I press "Combine selected"
    And I set the field "Turtle" in the "Combine selected" "dialogue" to "1"
    And I click on "Continue" "button" in the "Combine selected" "dialogue"
    Then I should see "Tags are combined"
    And I should not see "Cat"
    And I should not see "Dog"
    And I should see "Turtle"
    And I should not see "Neverusedtag"

  @javascript
  Scenario: Filtering tags
    When I log in as "manager1"
    And I navigate to "Appearance > Manage tags" in site administration
    And I follow "Default collection"
    And I click on "Filters" "button"
    And I set the following fields in the "Tag name" "core_reportbuilder > Filter" to these values:
      | Tag name operator | Is equal to |
      | Tag name value    | Cat,Dog     |
    And I click on "Apply" "button" in the "[data-region='report-filters']" "css_element"
    Then I should see "Cat" in the "reportbuilder-table" "table"
    And I should see "Dog" in the "reportbuilder-table" "table"
    And I should not see "Turtle" in the "reportbuilder-table" "table"
    And I should not see "Neverusedtag" in the "reportbuilder-table" "table"
