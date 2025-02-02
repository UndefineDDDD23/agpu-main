@qtype @qtype_ordering
Feature: Test duplicating a quiz containing a Ordering question
  As a teacher
  In order to re-use my courses containing Ordering questions
  I need to be able to backup and restore them

  Background:
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "question categories" exist:
      | contextlevel | reference | name           |
      | Course       | C1        | Test questions |
    And the following "questions" exist:
      | questioncategory | qtype    | name   | template |
      | Test questions   | ordering | agpu | agpu   |
    And the following "activities" exist:
      | activity | name      | course | idnumber |
      | quiz     | Test quiz | C1     | quiz1    |
    And quiz "Test quiz" contains the following questions:
      | agpu | 1 |
    And the following config values are set as admin:
      | enableasyncbackup | 0 |
    And I am on the "Course 1" "Course" page logged in as "admin"

  @javascript
  Scenario: Backup and restore a course containing an Ordering question
    When I backup "Course 1" course using this options:
      | Confirmation | Filename | test_backup.mbz |
    And I restore "test_backup.mbz" backup into a new course using this options:
      | Schema | Course name       | Course 2 |
      | Schema | Course short name | C2       |
    And I am on the "Course 2" "core_question > course question bank" page
    And I choose "Edit question" action for "agpu" in the question bank
    Then the following fields match these values:
      | Question name                      | agpu |
      | Question text                      | Put these words in order. |
      | General feedback                   | The correct answer is "Modular Object Oriented Dynamic Learning Environment". |
      | id_answer_0                        | Modular                                                                       |
      | id_answer_1                        | Object                                                                        |
      | id_answer_2                        | Oriented                                                                      |
      | id_answer_3                        | Dynamic                                                                       |
      | id_answer_4                        | Learning                                                                      |
      | id_answer_5                        | Environment                                                                   |
      | For any correct response           | Well done!                                                                    |
      | For any partially correct response | Parts, but only parts, of your response are correct.                          |
      | For any incorrect response         | That is not right at all.                                                     |
      | id_shownumcorrect                  | 1                                                                             |
      | id_hintshownumcorrect_0            | 0                                                                             |
      | id_hintoptions_0                   | 0                                                                             |
      | id_hintshownumcorrect_1            | 0                                                                             |
      | id_hintoptions_1                   | 0                                                                             |
