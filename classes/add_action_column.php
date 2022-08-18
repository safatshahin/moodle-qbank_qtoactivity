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

use core_question\local\bank\menu_action_column_base;


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
class add_action_column extends menu_action_column_base {
    /**
     * Defines the URL, Icon, and Label to be used for the action.
     *
     * @param  stdClass $question
     * @return array The url, icon, and label
     */
    protected function get_url_icon_and_label(\stdClass $question): array {
        $addtoactivityurl = '/question/bank/q2activity/addtoactivity.php';

        $params = array(
            'questionid' => $question->id,
        );

        $url = new \moodle_url($addtoactivityurl, $params);

        return [$url, 't/move', get_string('addtoquiz', 'qbank_q2activity')];
    }

    /**
     * Defines the name of the action
     *
     * @return string The name of the action
     */
    public function get_name(): string {
        return 'addtoquizaction';
    }
}
