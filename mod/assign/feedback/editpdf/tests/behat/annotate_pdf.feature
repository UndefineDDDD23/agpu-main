@mod @mod_assign @assignfeedback @assignfeedback_editpdf @_file_upload
Feature: In an assignment, teacher can annotate PDF files during grading
  In order to provide visual report on a graded PDF
  As a teacher
  I need to use the PDF editor

  @javascript
  Scenario: Submit a PDF file as a student and annotate the PDF as a teacher then overwrite the submission as a student
    Given ghostscript is installed
    And the following "courses" exist:
      | fullname | shortname | category | groupmode |
      | Course 1 | C1 | 0 | 1 |
    And the following "users" exist:
      | username | firstname | lastname | email |
      | teacher1 | Teacher | 1 | teacher1@example.com |
      | student1 | Student | 1 | student1@example.com |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | editingteacher |
      | student1 | C1 | student |
    And the following "activity" exists:
      | activity                            | assign                |
      | course                              | C1                    |
      | name                                | Test assignment name  |
      | assignfeedback_editpdf_enabled      | 1                     |
      | assignfeedback_comments_enabled     | 1                     |
      | assignsubmission_file_enabled       | 1                     |
      | assignsubmission_file_maxfiles      | 2                     |
      | assignsubmission_file_maxsizebytes  | 102400                |
      | maxfilessubmission                  | 2                     |
      | submissiondrafts                    | 0                     |
    And the following "mod_assign > submission" exists:
      | assign  | Test assignment name                                       |
      | user    | student1                                                   |
      | file    | mod/assign/feedback/editpdf/tests/fixtures/testgs.pdf  |

    When I am on the "Test assignment name" Activity page logged in as teacher1
    And I change window size to "large"
    And I go to "Submitted for grading" "Test assignment name" activity advanced grading page
    And I change window size to "medium"
    Then I should see "Page 1 of 1"
    And I wait for the complete PDF to load
    And I click on ".linebutton" "css_element"
    And I draw on the pdf
    And I press "Save changes"
    And I should see "The changes to the grade and feedback were saved"
    And I am on the "Test assignment name" Activity page logged in as student1
    And I follow "View annotated PDF..."
    Then I should see "Page 1 of 1"
    And I click on ".closebutton" "css_element"
    And I press "Edit submission"
    And I upload "mod/assign/feedback/editpdf/tests/fixtures/submission.pdf" file to "File submissions" filemanager
    And I press "Save changes"
    And I follow "View annotated PDF..."
    Then I should see "Page 1 of 1"
    And I am on the "Test assignment name" Activity page logged in as teacher1
    And I change window size to "large"
    And I go to "Submitted for grading" "Test assignment name" activity advanced grading page
    And I change window size to "medium"
    Then I should see "Page 1 of 3"
    And I wait for the complete PDF to load
    And I click on ".linebutton" "css_element"
    And I draw on the pdf
    And I press "Save changes"
    And I should see "The changes to the grade and feedback were saved"
    And I am on the "Test assignment name" Activity page logged in as student1
    And I follow "View annotated PDF..."
    Then I should see "Page 1 of 3"

  @javascript
  Scenario: Submit a PDF file as a student and annotate the PDF as a teacher
    Given ghostscript is installed
    And the following "courses" exist:
      | fullname | shortname | category | groupmode |
      | Course 1 | C1 | 0 | 1 |
    And the following "users" exist:
      | username | firstname | lastname | email |
      | teacher1 | Teacher | 1 | teacher1@example.com |
      | student1 | Student | 1 | student1@example.com |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | editingteacher |
      | student1 | C1 | student |
    And the following "activity" exists:
      | activity                            | assign                |
      | course                              | C1                    |
      | name                                | Test assignment name  |
      | assignfeedback_editpdf_enabled      | 1                     |
      | assignfeedback_comments_enabled     | 1                     |
      | assignsubmission_file_enabled       | 1                     |
      | assignsubmission_file_maxfiles      | 2                     |
      | assignsubmission_file_maxsizebytes  | 102400                |
      | maxfilessubmission                  | 2                     |
      | submissiondrafts                    | 0                     |
    And the following "mod_assign > submission" exists:
      | assign  | Test assignment name                                                                                              |
      | user    | student1                                                                                                          |
      | file    | mod/assign/feedback/editpdf/tests/fixtures/submission.pdf, mod/assign/feedback/editpdf/tests/fixtures/testgs.pdf  |
    And I log in as "admin"
    And I am on site homepage
    And I navigate to "Plugins > Activity modules > Assignment > Feedback plugins > Annotate PDF" in site administration
    And I upload "pix/agpulogo.png" file to "" filemanager
    And I upload "pix/i/test.png" file to "" filemanager
    And I press "Save changes"
    And I should see "Changes saved"
    And I follow "Test ghostscript path"
    And I should see "The ghostscript path appears to be OK"
    And I am on site homepage
    And I log out

    When I am on the "Test assignment name" Activity page logged in as teacher1
    And I change window size to "large"
    And I go to "Submitted for grading" "Test assignment name" activity advanced grading page
    And I change window size to "medium"
    Then I should see "Page 1 of 3"
    And I click on ".navigate-next-button" "css_element"
    And I should see "Page 2 of 3"
    And I click on ".stampbutton" "css_element"
    And I click on ".linebutton" "css_element"
    And I click on ".commentcolourbutton" "css_element"
    And I click on "//img[@alt=\"Blue\"]/parent::button" "xpath_element"
    And I wait until the page is ready
    And I press "Save changes"
    And I wait until the page is ready
    And I should see "The changes to the grade and feedback were saved"

  @javascript
  Scenario: Submit a PDF file as a student in a team and annotate the PDF as a teacher
    Given ghostscript is installed
    And the following "courses" exist:
      | fullname | shortname | category | groupmode |
      | Course 1 | C1 | 0 | 1 |
    And the following "users" exist:
      | username | firstname | lastname | email |
      | teacher1 | Teacher | 1 | teacher1@example.com |
      | student1 | Student | 1 | student1@example.com |
      | student2 | Student | 2 | student2@example.com |
      | student3 | Student | 3 | student3@example.com |
      | student4 | Student | 4 | student4@example.com |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | editingteacher |
      | student1 | C1 | student |
      | student2 | C1 | student |
      | student3 | C1 | student |
      | student4 | C1 | student |
    And the following "groups" exist:
      | name | course | idnumber |
      | G1 | C1 | G1 |
      | G2 | C1 | G2 |
    And the following "groupings" exist:
      | name | course | idnumber |
      | G1   | C1     | G1       |
    And the following "group members" exist:
      | user        | group |
      | student1    | G1  |
      | student2    | G1  |
      | student3    | G2  |
      | student4    | G2  |
    And the following "grouping groups" exist:
      | grouping | group |
      | G1       | G1    |
      | G1       | G2    |
    And the following "activity" exists:
      | activity                            | assign                |
      | course                              | C1                    |
      | name                                | Test assignment name  |
      | assignfeedback_comments_enabled     | 1                     |
      | assignfeedback_editpdf_enabled      | 1                     |
      | assignsubmission_file_enabled       | 1                     |
      | assignsubmission_file_maxfiles      | 2                     |
      | assignsubmission_file_maxsizebytes  | 102400                |
      | maxfilessubmission                  | 2                     |
      | teamsubmission                      | 1                     |
      | grouping                            | G1                    |
      | submissiondrafts                    | 0                     |
    And the following "mod_assign > submission" exists:
      | assign  | Test assignment name                                       |
      | user    | student1                                                   |
      | file    | mod/assign/feedback/editpdf/tests/fixtures/submission.pdf  |

    And I am on the "Test assignment name" Activity page logged in as teacher1
    And I go to "Student 1" "Test assignment name" activity advanced grading page
    And I wait for the complete PDF to load
    And I click on ".linebutton" "css_element"
    And I draw on the pdf
    And I press "Save changes"
    And I should see "The changes to the grade and feedback were saved"
    And I follow "View all submissions"
    And I should see "View annotated PDF..." in the "student2@example.com" "table_row"
