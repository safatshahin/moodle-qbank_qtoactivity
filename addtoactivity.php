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

// Context and page setup.
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/question/bank/q2activity/add_to_activity.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('pluginname', 'qbank_q2activity'));

// Get the question ID from the URL.
$questionidtoadd = optional_param('questionid', 0, PARAM_INT);

// Display some placeholder elements for now.
echo $OUTPUT->header();

echo '<h3>501</h3>';
echo '<h4>Implementation Pending.</h4>';
echo '<br></br>';

$rawrequestdata = $_REQUEST; // Get the reuqest parameters to check over.

// If the 'questionid' parameter is set, we know it's a single action.
if (array_key_exists('questionid', $rawrequestdata)) {
    echo '<h5>Single Action Question ID</h5>';
    echo '<p>' . $questionidtoadd . '</p>';
} else {
    echo '<h5>Bulk Action Question ID\'s</h5>';

    $questionids = get_question_ids($rawrequestdata);
    foreach ($questionids as $val) {
        echo '<p>' . $val . '</p>';
    }
}

// Some testing for getting all the activites that use the QBank API.
//$allcoursemods = get_course_mods(1);
//var_dump($allcoursemods);

// Deprecated method, but oh boy was finding it useful.
// $allcourseactivities = get_array_of_activities(1);
// var_dump($allcourseactivities);

$targetcourse = get_course(2);
$courseactivities = course_modinfo::get_array_of_activities($targetcourse);

foreach ($courseactivities as $value) {
    var_dump($value);
    echo '<p>----------------</p>';
}

echo '<h2> END OF DATA</h2>';


// Show the footer.
echo $OUTPUT->footer();
