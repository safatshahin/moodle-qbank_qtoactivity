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
 * Class for 'Add to activity' bulk action.
 *
 * @package     qbank_qtoactivity
 * @copyright   2023 Safat Shahin <safatshahin@yahoo.com>
 * @author      Luke Purnel, Henry Campbell, Mark Hay, Harrison Liddell
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class bulk_add_action extends \core_question\local\bank\bulk_action_base {

    public function get_bulk_action_title(): string {
        return get_string('addtomodule', 'qbank_qtoactivity');
    }

    public function get_bulk_action_url(): \moodle_url {
        return new \moodle_url('/question/bank/qtoactivity/addtoactivity.php');
    }

    public function get_bulk_action_capabilities(): ?array {
        return [
            'moodle/question:editall',
        ];
    }

    public function get_key(): string {
        return 'addtomoduleselected';
    }
}
