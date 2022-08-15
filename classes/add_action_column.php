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

namespace qbank_q2activity;

use core_question\local\bank\action_column_base;
use core_question\local\bank\menuable_action;


/**
 * Adds a single action titled 'Add to Quiz' to the actions menu.
 *
 * @package     qbank_q2activity
 * @copyright   2022 Harrison Liddell, hliddell@myune.edu.au
 * @copyright   Mark Hay,              mhay23@myune.edu.au
 * @copyright   Henry Campbell,        hcampb25@myune.edu.au
 * @copyright   Luke Purnell,          lpurnell@myune.edu.au
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class add_action_column extends action_column_base implements menuable_action {

    /**
     * Required by 'action_column_base' but unused here
     *
     * @param int $question the question for display
     * @param array $rowclasses rows
     */
    protected function display_content($question, $rowclasses): void {
        pass;
    }

    /**
     * Defines the name of the action
     *
     * @return string The name of the action
     */
    public function get_name(): string {
        return 'addtoquizaction';
    }

    /**
     * Defines the URL, Icon, and attributes to be used for the action.
     *
     * @param  stdClass $question
     * @return action_menu_link The action menu link to be added
     */
    public function get_action_menu_link(\stdClass $question): ?\action_menu_link {
        global $PAGE;

        // This references the html element that the event listener is added to.
        $target = 'q2activityquestion_' . $question->id;
        $datatarget = '[data-target="' . $target . '"]';

        $PAGE->requires->js_call_amd('qbank_q2activity/q2activity', 'init', [$datatarget, $question->contextid]);

        $params = [
            'data-target' => $target,
            'data-questionid' => $question->id,
        ];

        $url = new \moodle_url('#');

        return new \action_menu_link_secondary($url, new \pix_icon('t/move', ''),
            get_string('addtoquiz', 'qbank_q2activity'), $params);
    }
}
