@qbank @qbank_qtoactivity
Feature: Use the qbank plugin manager page for question to activity
  In order to check the plugin behaviour with enable and disable

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And the following "activities" exist:
      | activity   | name      | course | idnumber |
      | quiz       | Test quiz | C1     | quiz1    |
    And the following "question categories" exist:
      | contextlevel    | reference | name             |
      | Activity module | quiz1     | Test questions   |
    And the following "questions" exist:
      | questioncategory | qtype     | name       | questiontext               |
      | Test questions   | truefalse | Question 1 | Answer the first question  |

  @javascript
  Scenario: Enable/disable question to activity bulk action from the base view
    Given I am on the "Question 1" "core_question > edit" page logged in as "admin"
    And I change window size to "large"
    When I set the following fields to these values:
      | Tags | foo |
    And I click on "Save changes" "button"
    And I am on the "Test quiz" "mod_quiz > question bank" page
    And I apply question bank filter "Category" with value "Test questions"
    And I apply question bank filter "Tag" with value "foo"
    And I click on "Question 1" "checkbox"
    And I click on "With selected" "button"
    Then I should see question bulk action "addtomoduleselected"
    And I disable "qtoactivity" "qbank" plugin
    And I am on the "Test quiz" "mod_quiz > question bank" page
    And I apply question bank filter "Category" with value "Test questions"
    And I click on "With selected" "button"
    And I should not see question bulk action "addtomoduleselected"

  @javascript
  Scenario: Enable/disable question to activity column from the base view
    Given I log in as "admin"
    When I disable "qtoactivity" "qbank" plugin
    And I am on the "Test quiz" "mod_quiz > question bank" page
    And I change window size to "large"
    And I apply question bank filter "Category" with value "Test questions"
    Then the "Add to module" action should not exist for the "Question 1" question in the question bank
    And I enable "qtoactivity" "qbank" plugin
    And I am on the "Test quiz" "mod_quiz > question bank" page
    And I apply question bank filter "Category" with value "Test questions"
    And the "Add to module" action should exist for the "Question 1" question in the question bank
