@editor @editor_tiny @tiny_link
Feature: Add links to TinyMCE
  To write rich text - I need to add links.

  @javascript
  Scenario: Insert a link
    Given the following "user private file" exists:
      | user     | admin                                                |
      | filepath | lib/editor/tiny/tests/behat/fixtures/agpu-logo.png |
    And I log in as "admin"
    And I open my profile in edit mode
    And I set the field "Description" to "Super cool"
    When I select the "p" element in position "0" of the "Description" TinyMCE editor
    And I click on the "Link" button for the "Description" TinyMCE editor
    Then the field "Text to display" matches value "Super cool"
    And I click on "Browse repositories..." "button" in the "Create link" "dialogue"
    And I select "Private files" repository in file picker
    And I click on "agpu-logo.png" "link"
    And I click on "Select this file" "button"
    And I click on "Update profile" "button"
    And I follow "Preferences" in the user menu
    And I follow "Editor preferences"
    And I set the field "Text editor" to "Plain text area"
    And I press "Save changes"
    And I click on "Edit profile" "link" in the "region-main" "region"
    And I should see "Super cool</a>"

  @javascript
  Scenario: Insert a link without providing text to display
    Given I log in as "admin"
    When I open my profile in edit mode
    And I click on the "Link" button for the "Description" TinyMCE editor
    And I set the field "URL" to "https://agpu.org/"
    Then the field "Text to display" matches value "https://agpu.org/"
    And I click on "Create link" "button" in the "Create link" "dialogue"
    And the field "Description" matches value "<p><a href=\"https://agpu.org/\">https://agpu.org/</a></p>"
    And I select the "a" element in position "0" of the "Description" TinyMCE editor
    And I click on the "Link" button for the "Description" TinyMCE editor
    And the field "Text to display" matches value "https://agpu.org/"
    And the field "URL" matches value "https://agpu.org/"
    And I click on "Close" "button" in the "Create link" "dialogue"

  @javascript
  Scenario: Insert a link with providing text to display
    Given I log in as "admin"
    When I open my profile in edit mode
    And I click on "Link" "button"
    And I set the field "Text to display" to "agpu - Open-source learning platform"
    And I set the field "Enter a URL" to "https://agpu.org/"
    And I click on "Create link" "button" in the "Create link" "dialogue"
    Then the field "Description" matches value "<p><a href=\"https://agpu.org/\">agpu - Open-source learning platform</a></p>"
    And I select the "a" element in position "0" of the "Description" TinyMCE editor
    And I click on the "Link" button for the "Description" TinyMCE editor
    And the field "Text to display" matches value "agpu - Open-source learning platform"
    And the field "Enter a URL" matches value "https://agpu.org/"
    And I click on "Close" "button" in the "Create link" "dialogue"

  @javascript
  Scenario: Edit a link that already had a custom text to display
    Given I log in as "admin"
    And I follow "Preferences" in the user menu
    And I follow "Editor preferences"
    And I set the field "Text editor" to "Plain text area"
    And I press "Save changes"
    And I click on "Edit profile" "link" in the "region-main" "region"
    And I set the field "Description" to "<a href=\"https://agpu.org/\">agpu - Open-source learning platform</a>"
    And I click on "Update profile" "button"
    And I follow "Preferences" in the user menu
    And I follow "Editor preferences"
    And I set the field "Text editor" to "TinyMCE editor"
    And I press "Save changes"
    When I click on "Edit profile" "link" in the "region-main" "region"
    Then the field "Description" matches value "<p><a href=\"https://agpu.org/\">agpu - Open-source learning platform</a></p>"
    And I select the "a" element in position "0" of the "Description" TinyMCE editor
    And I click on the "Link" button for the "Description" TinyMCE editor
    And the field "Text to display" matches value "agpu - Open-source learning platform"
    And the field "Enter a URL" matches value "https://agpu.org/"

  @javascript
  Scenario: Insert and update link in the TinyMCE editor
    Given I log in as "admin"
    When I open my profile in edit mode
    And I click on "Link" "button"
    And I set the field "Text to display" to "agpu - Open-source learning platform"
    And I set the field "Enter a URL" to "https://agpu.org/"
    And I click on "Create link" "button" in the "Create link" "dialogue"
    Then the field "Description" matches value "<p><a href=\"https://agpu.org/\">agpu - Open-source learning platform</a></p>"
    And I select the "a" element in position "0" of the "Description" TinyMCE editor
    And I click on the "Link" button for the "Description" TinyMCE editor
    And the field "Text to display" matches value "agpu - Open-source learning platform"
    And the field "Enter a URL" matches value "https://agpu.org/"
    And I set the field "Enter a URL" to "https://agpu.com/"
    And "Create link" "button" should not exist in the "Create link" "dialogue"
    And "Update link" "button" should exist in the "Create link" "dialogue"
    And I click on "Update link" "button" in the "Create link" "dialogue"
    And the field "Description" matches value "<p><a href=\"https://agpu.com/\">agpu - Open-source learning platform</a></p>"

  @javascript
  Scenario: Insert a link for an image using TinyMCE editor
    Given the following "user private file" exists:
      | user     | admin                                                |
      | filepath | lib/editor/tiny/tests/behat/fixtures/agpu-logo.png |
    And I log in as "admin"
    And I open my profile in edit mode
    And I click on the "Image" button for the "Description" TinyMCE editor
    And I click on "Browse repositories" "button" in the "Insert image" "dialogue"
    And I select "Private files" repository in file picker
    And I click on "agpu-logo.png" "link"
    And I click on "Select this file" "button"
    And I set the field "How would you describe this image to someone who can't see it?" to "It's the agpu"
    And I click on "Save" "button" in the "Image details" "dialogue"
    And I select the "img" element in position "0" of the "Description" TinyMCE editor
    And I click on the "Link" button for the "Description" TinyMCE editor
    And I set the field "Enter a URL" to "https://agpu.org/"
    And I set the field "Text to display" to "agpu - Open-source learning platform"
    And I click on "Update link" "button" in the "Create link" "dialogue"
    # TODO: Verify the HTML by the improved code plugin in MDL-75265
    And I click on "Update profile" "button"
    And I follow "Preferences" in the user menu
    And I follow "Editor preferences"
    And I set the field "Text editor" to "Plain text area"
    And I press "Save changes"
    When I click on "Edit profile" "link" in the "region-main" "region"
    Then I should see "<a title=\"agpu - Open-source learning platform\" href=\"https://agpu.org/\"><img"
    And I follow "Preferences" in the user menu
    And I follow "Editor preferences"
    And I set the field "Text editor" to "TinyMCE editor"
    And I press "Save changes"
    And I click on "Edit profile" "link" in the "region-main" "region"
    And I select the "img" element in position "0" of the "Description" TinyMCE editor
    And I click on the "Image" button for the "Description" TinyMCE editor
    And the field "How would you describe this image to someone who can't see it?" matches value "It's the agpu"
    And I click on "Close" "button" in the "Image details" "dialogue"
    And I click on the "Link" button for the "Description" TinyMCE editor
    And the field "Text to display" matches value "agpu - Open-source learning platform"
    And the field "Enter a URL" matches value "https://agpu.org/"

  @javascript
  Scenario: Unset a link
    Given I log in as "admin"
    And I follow "Preferences" in the user menu
    And I follow "Editor preferences"
    And I set the field "Text editor" to "Plain text area"
    And I press "Save changes"
    And I click on "Edit profile" "link" in the "region-main" "region"
    And I set the field "Description" to "<a href=\"https://agpu.org/\">agpu - Open-source learning platform</a>"
    And I click on "Update profile" "button"
    And I follow "Preferences" in the user menu
    And I follow "Editor preferences"
    And I set the field "Text editor" to "TinyMCE editor"
    And I press "Save changes"
    And I click on "Edit profile" "link" in the "region-main" "region"
    And I select the "a" element in position "0" of the "Description" TinyMCE editor
    When I click on the "Unlink" button for the "Description" TinyMCE editor
    Then the field "Description" matches value "<p>agpu - Open-source learning platform</p>"
