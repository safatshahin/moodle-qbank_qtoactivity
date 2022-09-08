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

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/bank/q2activity/lib.php');

/**
 * Question2Activity library tests
 *
 * @package     qbank_q2activity
 * @copyright   2022 Harrison Liddell, hliddell@myune.edu.au
 * @copyright   Mark Hay,              mhay23@myune.edu.au
 * @copyright   Henry Campbell,        hcampb25@myune.edu.au
 * @copyright   Luke Purnell,          lpurnell@myune.edu.au
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class library_test extends \advanced_testcase {

    /**
     * Testing the retrieval of question ids
     *
     * @dataProvider qbank_q2activity_get_question_ids_provider
     * @param array|null $rawrequest The raw request data
     * @param array $expectedreturn The question ids that should be returned
     */
    public function test_qbank_q2activity_get_question_ids(?array $rawrequest, $expectedreturn) {

        $this->assertSame($expectedreturn, get_question_ids($rawrequest));
    }

    /**
     * Data provider for {@see test_qbank_q2activity_get_question_ids()}.
     *
     * @return array List of data sets - (string) data set name => (array) data
     */
    public function qbank_q2activity_get_question_ids_provider() {
        return [
            'Null request data' => [
                'rawrequest' => null,
                'expectedreturn' => []
            ],
            'No question id' => [
                'rawrequest' => array("courseid" => "1",
                    "category" => "10,2",
                    "qbshowtext" => "0",
                    "recurse" => "1",
                    "showhidden" => "0"),
                'expectedreturn' => []
            ],
            'Single id' => [
                'rawrequest' => array("courseid" => "1",
                    "cat" => "10,2",
                    "qpage" => "0",
                    "recurse" => "1",
                    "showhidden" => "0",
                    "qbshowtext" => "0",
                    "returnurl" => "http:\/\/localhost:8082\/question\/edit.php?courseid=1&cat=10%2C2&qpage=0&recurse=1&showhidden=0&qbshowtext=0",
                    "sesskey" => "yertuBiZRM",
                    "question_status_dropdown" => "ready",
                    "q10" => "1",
                    "q2activity_addtoquiz" => "Add to Quiz"),
                'expectedreturn' => ['10']
            ],
            'Multiple ids' => [
                'rawrequest' => array("courseid" => "1",
                    "cat" => "10,2",
                    "qpage" => "0",
                    "recurse" => "1",
                    "showhidden" => "0",
                    "qbshowtext" => "0",
                    "returnurl" => "http:\/\/localhost:8082\/question\/edit.php?courseid=1&cat=10%2C2&qpage=0&recurse=1&showhidden=0&qbshowtext=0",
                    "sesskey" => "yertuBiZRM",
                    "question_status_dropdown" => "ready",
                    "q11" => "1",
                    "q12" => "1",
                    "q2activity_addtoquiz" => "Add to Quiz"),
                'expectedreturn' => ['11', '12']
            ],
        ];
    }
}
