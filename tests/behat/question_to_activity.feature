@qbank @qbank_question_to_activity @javascript
Feature: Use the qbank plugin manager page for question to activity
  In order to check the plugin behaviour with enable and disable

  Background:
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "activities" exist:
      | activity   | name      | course | idnumber |
      | quiz       | Test quiz | C1     | quiz1    |
    And the following "question categories" exist:
      | contextlevel | reference | name           |
      | Course         | C1     | Test questions |
    And the following "questions" exist:
      | questioncategory | qtype     | name           | questiontext              |
      | Test questions   | truefalse | First question | Answer the first question |

  @javascript
  Scenario: Enable/disable question to activity bulk action from the base view
    Given I log in as "admin"
    When I navigate to "Plugins > Question bank plugins > Manage question bank plugins" in site administration
    And I should see "Question to activity"
    And I click on "Disable" "link" in the "Question to activity" "table_row"
    And I am on the "Test quiz" "mod_quiz > question bank" page
    And I click on "First question" "checkbox"
    And I click on "With selected" "button"
    Then I should not see question bulk action "addtomoduleselected"
    And I navigate to "Plugins > Question bank plugins > Manage question bank plugins" in site administration
    And I click on "Enable" "link" in the "Question to activity" "table_row"
    And I am on the "Test quiz" "mod_quiz > question bank" page
    And I click on "First question" "checkbox"
    And I click on "With selected" "button"
    And I should see question bulk action "addtomoduleselected"

  Scenario: Enable/disable question to activity column from the base view
    Given I log in as "admin"
    When I navigate to "Plugins > Question bank plugins > Manage question bank plugins" in site administration
    And I should see "Question to activity"
    And I click on "Disable" "link" in the "Question to activity" "table_row"
    And I am on the "Test quiz" "mod_quiz > question bank" page
    Then the "Add to module" action should not exist for the "First question" question in the question bank
    And I navigate to "Plugins > Question bank plugins > Manage question bank plugins" in site administration
    And I click on "Enable" "link" in the "Question to activity" "table_row"
    And I am on the "Test quiz" "mod_quiz > question bank" page
    And the "Add to module" action should exist for the "First question" question in the question bank
