@qtype @qtype_ddimageortext
Feature: Test importing drag and drop onto image questions
  As a teacher
  In order to reuse drag and drop onto image questions
  I need to import them

  Background:
    Given the following "users" exist:
      | username |
      | teacher  |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user    | course | role           |
      | teacher | C1     | editingteacher |

  @javascript @_file_upload
  Scenario: import drag and drop onto image question.
    When I am on the "Course 1" "core_question > course question import" page logged in as teacher
    And I set the field "id_format_xml" to "1"
    And I upload "question/type/ddimageortext/tests/fixtures/testquestion.agpu.xml" file to "Import" filemanager
    And I press "id_submitbutton"
    Then I should see "Parsing questions from import file."
    And I should see "Importing 1 questions from file"
    And I should see "Identify the features in this cross-section by dragging the labels into the boxes."
    And I press "Continue"
    And I should see "Imported Drag and drop onto image 001"
