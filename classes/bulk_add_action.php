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

/**
 * Class for 'Add to Quiz' bulk action.
 *
 * @package     qbank_q2activity
 * @copyright   2022 Harrison Liddell, hliddell@myune.edu.au
 * @copyright   Mark Hay,              mhay23@myune.edu.au
 * @copyright   Henry Campbell,        hcampb25@myune.edu.au
 * @copyright   Luke Purnell,          lpurnell@myune.edu.au
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class bulk_add_action extends \core_question\local\bank\bulk_action_base {
    /**
     * The title of the bulk action
     *
     * @return string Title
     */
    public function get_bulk_action_title(): string {
        return get_string('addtoquiz', 'qbank_q2activity');
    }

    /**
     * A unique key for the bulk action, this will be used in the api to identify the action data.
     *
     * @return string Action key
     */
    public function get_bulk_action_key(): string {
        return 'q2activity_addtoquiz';
    }

    /**
     * URL of the bulk action redirect page.
     *
     * @return moodle_url URL
     */
    public function get_bulk_action_url(): \moodle_url {
        return new \moodle_url('/question/bank/q2activity/addtoactivity.php');
    }

    /**
     * Get the capabilities for the bulk action.
     * The bulk actions might have some capabilities to action them as a user.
     *
     * @return array Capabilities
     */
    public function get_bulk_action_capabilities(): ?array {
        return [
            'moodle/question:editall',
        ];
    }
}
