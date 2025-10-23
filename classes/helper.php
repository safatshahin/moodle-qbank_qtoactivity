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

/**
 * Helper class for question to activity plugin which includes all the associated methods.
 *
 * @package     qbank_qtoactivity
 * @copyright   2023 Safat Shahin <safatshahin@yahoo.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class helper {
    /**
     * Get the module info from cm id.
     *
     * @param int $cmid The id of the module
     * @return array
     */
    public static function get_module(int $cmid): array {
        // TODO think of a way to add the module logo.
        [$modrec, $cmrec] = get_module_from_cmid($cmid);
        $modulearray[$cmid] = $cmrec->name;
        return $modulearray;
    }

    /**
     * Gets a list of modules for a given course.
     *
     * @param  int $courseid The ID of the given course
     * @return array An array of all the quizzes
     */
    public static function get_modules_for_course(int $courseid): array {
        $modules = [];
        $course = get_course($courseid);
        $courseactivities = \course_modinfo::get_array_of_activities($course, true);

        foreach ($courseactivities as $courseactivity) {
            // Add support for quiz activity.
            // TODO think of a better way to get the list of activities using or extending the question bank api.
            if ($courseactivity->mod === "quiz") {
                $modules[$courseactivity->cm] = $courseactivity->name;
            }
        }

        return $modules;
    }

    /**
     * Process the question came from the form post.
     *
     * @param array $rawquestions raw un-sanitised $_REQUEST data from page
     * @return array question ids got from the post are processed and structured in an array
     */
    public static function process_question_ids(array $rawquestions): array {
        $questionids = [];
        $questionlist = '';
        foreach ($rawquestions as $key => $notused) {
            // Parse input for question ids.
            if (preg_match('!^q([0-9]+)$!', $key, $matches)) {
                $key = $matches[1];
                $questionids[] = clean_param($key, PARAM_INT);
            }
        }
        if (!empty($questionids)) {
            $questionlist = implode(',', $questionids);
        }
        return [$questionids, $questionlist];
    }

    /**
     * Add question to the module.
     *
     * @param string $addtomoduleselected The selection question ids
     * @param int $addtomodule The selected module
     * @return void
     */
    public static function add_to_module(string $addtomoduleselected, int $addtomodule): void {
        global $DB;
        if ($questionids = explode(',', $addtomoduleselected)) {
            [$usql, $params] = $DB->get_in_or_equal($questionids);
            $sql = "SELECT q.*, c.contextid
                      FROM {question} q
                      JOIN {question_versions} qv ON qv.questionid = q.id
                      JOIN {question_bank_entries} qbe ON qbe.id = qv.questionbankentryid
                      JOIN {question_categories} c ON c.id = qbe.questioncategoryid
                     WHERE q.id
                     {$usql}";
            $questions = $DB->get_records_sql($sql, $params);
            [$module, $cmrec] = get_module_from_cmid($addtomodule);
            if ($cmrec->modname === 'quiz') {
                self::question_add_to_quiz_avtivity($questions, $module);
            }
        }
    }

    /**
     * Add question to the quiz.
     *
     * @param array $questions The questions to be added
     * @param \stdClass $quiz The quiz object
     * @return void
     */
    public static function question_add_to_quiz_avtivity(array $questions, \stdClass $quiz): void {
        global $CFG;
        require_once($CFG->dirroot . '/mod/quiz/locallib.php');
        foreach ($questions as $question) {
            quiz_add_quiz_question($question->id, $quiz);
        }
    }
}
