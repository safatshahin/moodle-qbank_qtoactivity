<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace qbank_qtoactivity;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/editlib.php');

/**
 * Question to activity helper tests.
 *
 * @package     qbank_qtoactivity
 * @copyright   2023 Safat Shahin <safatshahin@yahoo.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \qbank_qtoactivity\helper
 */
final class helper_test extends \advanced_testcase {
    /**
     * @var \stdClass $questiondata1
     */
    protected $questiondata1;

    /**
     * @var \stdClass $questiondata2
     */
    protected $questiondata2;

    /**
     * @var array $rawdata
     */
    protected $rawdata;

    /**
     * Test bulk move of questions.
     *
     * @covers ::add_to_module
     * @covers ::question_add_to_quiz_avtivity
     */
    public function test_add_to_module(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        // Generate data.
        $datagenerator = $this->getDataGenerator();
        $course = $datagenerator->create_course();
        $quiz = $datagenerator->create_module('quiz', ['course' => $course->id]);
        $qgenerator = $datagenerator->get_plugin_generator('core_question');
        $context = \context_module::instance($quiz->cmid);
        $qcategory = $qgenerator->create_question_category(['contextid' => $context->id]);
        $this->questiondata1 = $qgenerator->create_question(
            'numerical',
            null,
            ['name' => 'Example question', 'category' => $qcategory->id],
        );

        // Ensure the question is not in the cache.
        $cache = \cache::make('core', 'questiondata');
        $cache->delete($this->questiondata1->id);

        $this->questiondata2 = $qgenerator->create_question(
            'numerical',
            null,
            ['name' => 'Example question second', 'category' => $qcategory->id],
        );

        // Ensure the question is not in the cache.
        $cache = \cache::make('core', 'questiondata');
        $cache->delete($this->questiondata2->id);

        // Posted raw data.
        $this->rawdata = [
            'courseid' => $course->id,
            'cat' => "{$qcategory->id},{$context->id}",
            'qpage' => '0',
            "q{$this->questiondata1->id}" => '1',
            "q{$this->questiondata2->id}" => '1',
        ];

        // Get the processed question ids.
        $questionlist = $this->process_question_ids_test();

        // Create a quiz.
        /** @var \mod_quiz_generator $quizgenerator */
        $quizgenerator = $this->getDataGenerator()->get_plugin_generator('mod_quiz');
        $quiz = $quizgenerator->create_instance([
            'course' => $course->id,
            'questionsperpage' => 0,
            'grade' => 100.0,
            'sumgrades' => 2,
        ]);
        $quizcontext = \context_module::instance($quiz->cmid);

        helper::add_to_module($questionlist, $quiz->cmid);

        $this->assertCount(2, \mod_quiz\question\bank\qbank_helper::get_question_structure($quiz->id, $quizcontext));
    }

    /**
     * Test the question processing and return the question list.
     *
     * @return string
     */
    protected function process_question_ids_test(): string {
        // Test the raw data processing.
        [$questionids, $questionlist] = helper::process_question_ids($this->rawdata);
        $this->assertEquals([$this->questiondata1->id, $this->questiondata2->id], $questionids);
        $this->assertEquals("{$this->questiondata1->id},{$this->questiondata2->id}", $questionlist);
        return $questionlist;
    }

    /**
     * Test get module for course only gets quiz.
     *
     * @covers ::get_modules_for_course
     */
    public function test_get_modules_for_course(): void {
        $this->resetAfterTest();
        $generator = $this->getDataGenerator();

        // Create a course.
        $course = $generator->create_course();
        $context = \context_course::instance($course->id);

        // Create a quiz.
        /** @var \mod_quiz_generator $quizgenerator */
        $quizgenerator = $this->getDataGenerator()->get_plugin_generator('mod_quiz');
        $quizgenerator->create_instance([
            'course' => $course->id,
            'questionsperpage' => 0,
            'grade' => 100.0,
            'sumgrades' => 2,
        ]);

        // Create a page.
        /** @var \mod_page_generator $pagegenerator */
        $pagegenerator = $this->getDataGenerator()->get_plugin_generator('mod_page');
        $pagegenerator->create_instance(['course' => $course->id]);

        $courseactivities = \course_modinfo::get_array_of_activities($course, true);
        $this->assertCount(2, $courseactivities);

        $addtomoduleactivities = helper::get_modules_for_course($course->id);
        $this->assertCount(1, $addtomoduleactivities);
    }
}
