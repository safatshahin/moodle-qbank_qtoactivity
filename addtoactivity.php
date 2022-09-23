<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Add to activity page
 *
 * @package     qbank_q2activity
 * @copyright   2022 Harrison Liddell, hliddell@myune.edu.au
 * @copyright   Mark Hay,              mhay23@myune.edu.au
 * @copyright   Henry Campbell,        hcampb25@myune.edu.au
 * @copyright   Luke Purnell,          lpurnell@myune.edu.au
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/question/bank/q2activity/lib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

global $DB, $OUTPUT, $PAGE;

// Get params from the URL.
$contextid = optional_param('contextid', 0, PARAM_INT);
$flag = optional_param('flag', false, PARAM_BOOL); // If true an add request has been triggered.
$selectedquiz = optional_param('selectedquiz', '', PARAM_RAW);
$questionids = optional_param('questionids', '', PARAM_RAW);

// Context and page setup.
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/question/bank/q2activity/addtoactivity.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('pluginname', 'qbank_q2activity'));

// Get question IDs as array.
$rawrequestdata = $_REQUEST; // Get the request parameters to check over.

if (array_key_exists('questionids', $rawrequestdata)) {
    $questionids = explode(',', $questionids);
} else {
    $questionids = get_question_ids($rawrequestdata);
}

echo $OUTPUT->header();

// Display questions.
echo '<h4> Selected questions: </h4>';
foreach ($questionids as $qid) {
    echo $DB->get_field('question', 'name', array('id' => $qid)) . '<br />';
}
echo '</br>';

echo '<h6>' . get_string('addtoquizinstruction', 'qbank_q2activity') . '</h6> <br />';

// Get quiz activities (currently testing with course id '2'). TODO: Implement for current context.
$allquizzes = qbank_q2activity_get_all_quizzes(2);

// Display 'add' button for each available quiz.
echo $OUTPUT->box_start('card-columns');
foreach ($allquizzes as $quiz) {

    echo html_writer::start_tag('div', array('class' => 'card-body'));
    echo html_writer::tag('h5', format_text($quiz->name, FORMAT_PLAIN), array('class' => 'card-text, center'));
    echo html_writer::end_tag('p');

    // Capture params to pass when 'add' selected.
    $params = array(
        'id' => $quiz->id,
        'flag' => true,
        'selectedquiz' => json_encode($quiz),
        'questionids' => implode(',', $questionids)
        );

    echo html_writer::start_tag('p', array('class' => 'card-footer text-center'));

    echo html_writer::link(new moodle_url($PAGE->url, $params), $OUTPUT->pix_icon('i/nosubcat', ''));
    echo 'Add';
    echo html_writer::end_tag('p');
    echo html_writer::end_tag('div');
}
echo $OUTPUT->box_end();

// Page has been submitted with an add request.
if ($flag) {
    foreach ($questionids as $qid) {
        $quiz = json_decode($selectedquiz);
        quiz_add_quiz_question($qid, $quiz);
    }
    echo '<h5> Question(s) successfully added to '. $quiz->name .'</h5>';
}

// Show the footer.
echo $OUTPUT->footer();
