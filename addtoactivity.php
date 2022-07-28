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
 * Add to activity page.
 *
 * @package     qbank_qtoactivity
 * @copyright   2023 Safat Shahin <safatshahin@yahoo.com>
 * @author      Luke Purnel, Henry Campbell, Mark Hay, Harrison Liddell
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CFG, $OUTPUT, $PAGE, $COURSE;

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/question/editlib.php');

$addtomoduleselected = optional_param('addtomoduleselected', false, PARAM_BOOL);
$returnurl = optional_param('returnurl', 0, PARAM_LOCALURL);
$cmid = optional_param('cmid', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$confirm = optional_param('confirm', '', PARAM_ALPHANUM);
$addtomodule = optional_param('addtomodule', null, PARAM_INT);
$addtomodulesquestions = optional_param('addtomodulesquestions', null, PARAM_RAW);

if ($returnurl) {
    $returnurl = new moodle_url($returnurl);
}

// Check if plugin is enabled or not.
\core_question\local\bank\helper::require_plugin_enabled('qbank_qtoactivity');

if ($cmid) {
    list($module, $cm) = get_module_from_cmid($cmid);
    require_login($cm->course, false, $cm);
    $thiscontext = context_module::instance($cmid);
    $modules = \qbank_qtoactivity\helper::get_module($cmid);
} else if ($courseid) {
    require_login($courseid, false);
    $thiscontext = context_course::instance($courseid);
    $modules = \qbank_qtoactivity\helper::get_modules_for_course($courseid);
} else {
    throw new moodle_exception('missingcourseorcmid', 'question');
}

$contexts = new core_question\local\bank\question_edit_contexts($thiscontext);
$url = new moodle_url('/question/bank/qtoactivity/addtoactivity.php');
$title = get_string('addtomodule', 'qbank_qtoactivity');

// Context and page setup.
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($COURSE->fullname);
$PAGE->set_pagelayout('standard');
$PAGE->activityheader->disable();
$PAGE->set_secondary_active_tab("questionbank");



if ($addtomodulesquestions && $confirm && confirm_sesskey()) {
    if ($confirm == md5($addtomodulesquestions)) {
        \qbank_qtoactivity\helper::add_to_module($addtomodulesquestions, $addtomodule);
    }
    redirect($returnurl);
}

// Show the header.
echo $OUTPUT->header();



if ($addtomoduleselected) {
    $rawquestions = $_REQUEST;
    list($questionids, $questionlist) = \qbank_qtoactivity\helper::process_question_ids($rawquestions);
    // No questions were selected.
    if (!$questionids) {
        redirect($returnurl);
    }
    // Create the urls.
    $addtomoduleparams = [
        'addtomodulesquestions' => $questionlist,
        'confirm' => md5($questionlist),
        'sesskey' => sesskey(),
        'returnurl' => $returnurl,
        'cmid' => $cmid,
        'courseid' => $courseid,
    ];
    $addtomoduleurl = new \moodle_url($url, $addtomoduleparams);
    echo $PAGE->get_renderer('qbank_qtoactivity')
        ->render_add_to_module_form($addtomoduleurl, $returnurl, $modules);
}

// Show the footer.
echo $OUTPUT->footer();
