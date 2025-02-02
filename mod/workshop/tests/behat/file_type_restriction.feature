@mod @mod_workshop
Feature: File types of the submission and feedback attachments can be limitted
    In order to constrain student submission and feedback attachments
    As a teacher
    I need to be able to specify the list of allowed file types

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Terry1    | Teacher1 | teacher1@example.com |
      | student1 | Sam1      | Student1 | student1@example.com |
      | student2 | Sam2      | Student2 | student2@example.com |
    And the following "courses" exist:
      | fullname | shortname |
      | Course1  | c1        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | c1     | editingteacher |
      | student1 | c1     | student        |
      | student2 | c1     | student        |
    And the following "activities" exist:
      | activity | name         | course | idnumber  | submissiontypetext | submissiontypefile |
      | workshop | TestWorkshop | c1     | workshop1 | 2                  | 1                  |

  @_file_upload @javascript
  Scenario: Student submission attachments obey the list of allowed file types
    # Define workshop to accept only images as submission attachments.
    Given I am on the "TestWorkshop" "workshop activity editing" page logged in as teacher1
    And I expand all fieldsets
    And I set the field "Submission attachment allowed file types" to "image"
    And I press "Save and display"
    And I change phase in workshop "TestWorkshop" to "Submission phase"
    # As a student, attempt to attach a non-image file.
    And I am on the TestWorkshop "workshop activity" page logged in as student1
    And I press "Add submission"
    And I set the following fields to these values:
      | Title              | Submission1           |
      | Submission content | See the attached file |
    # We can't directly upload the invalid file here as the upload repository would throw an exception.
    # So instead we try to trick the filemanager and bypass its checks, to be finally stopped by the
    # form field validation.
    And I upload "mod/workshop/tests/fixtures/agpulogo.png" file to "Attachment" filemanager
    And I follow "agpulogo.png"
    And I set the field "Name" to "testable.php"
    And I press "Update"
    And I should see "The original file extension has been modified as a part of the file name change. Changing the extension from \".png\" to \".php\" may result in a file which cannot be opened."
    And I click on "Yes" "button" in the "Confirm" "dialogue"
    When I press "Save changes"
    Then I should see "Some files (testable.php) cannot be uploaded. Only file types image are allowed."
    # Remove the invalid file and attach an image instead.
    And I delete "testable.php" from "Attachment" filemanager
    And I upload "mod/workshop/tests/fixtures/agpulogo.png" file to "Attachment" filemanager
    And I press "Save changes"
    And "//div[@class='submission-full' and contains(.,'Submission1') and contains(.,'submitted on')]" "xpath_element" should exist

  @_file_upload @javascript
  Scenario: Overall feedback attachments obey the list of allowed file types
    # Define workshop to accept only .php files as overall feedback attachments.
    Given I am on the "Course1" course page logged in as teacher1
    And I edit assessment form in workshop "TestWorkshop" as:
      | id_description__idx_0_editor | Aspect1 |
      | id_description__idx_1_editor | Aspect2 |
      | id_description__idx_2_editor |         |
    And I am on the TestWorkshop "workshop activity editing" page
    And I expand all fieldsets
    And I set the field "Maximum number of overall feedback attachments" to "2"
    And I set the field "Feedback attachment allowed file types" to "PHP"
    And I press "Save and display"
    And I change phase in workshop "TestWorkshop" to "Submission phase"
    # As a student, attempt to attach an invalid file.
    And I am on the TestWorkshop "workshop activity" page logged in as student1
    And I add a submission in workshop "TestWorkshop" as:
      | Title              | Submission1  |
      | Submission content | Some content |
    # As a teacher, allocate that submission to be assessed by another student.
    And I am on the TestWorkshop "workshop activity" page logged in as teacher1
    And I allocate submissions in workshop "TestWorkshop" as:
      | Participant   | Reviewer      |
      | Sam1 Student1 | Sam2 Student2 |
    And I change phase in workshop "TestWorkshop" to "Assessment phase"
    # As the other student, assess the assigned submission.
    And I am on the TestWorkshop "workshop activity" page logged in as student2
    And I follow "Submission1"
    And I press "Assess"
    And I set the following fields to these values:
      | grade__idx_0            | 5 / 10            |
      | peercomment__idx_0      | You can do better |
      | grade__idx_1            | 10 / 10           |
      | peercomment__idx_1      | Amazing           |
      | Feedback for the author | Good work         |
    # We can't directly upload the invalid file here as the upload repository would throw an exception.
    # So instead we try to trick the filemanager and bypass its checks, to be finally stopped by the
    # form field validation.
    And I upload "mod/workshop/tests/fixtures/testable.php" file to "Attachment" filemanager
    And I follow "testable.php"
    And I set the field "Name" to "renamed.png"
    And I press "Update"
    And I should see "The original file extension has been modified as a part of the file name change. Changing the extension from \".php\" to \".png\" may result in a file which cannot be opened."
    And I click on "Yes" "button" in the "Confirm" "dialogue"
    When I press "Save and close"
    Then I should see "Some files (renamed.png) cannot be uploaded. Only file types .php are allowed."
    And I should not see "Assigned submissions to assess"
    # Finally make sure that allowed file gets uploaded.
    And I delete "renamed.png" from "Attachment" filemanager
    And I upload "mod/workshop/tests/fixtures/testable.php" file to "Attachment" filemanager
    And I press "Save and close"
    And I should see "Assigned submissions to assess"
