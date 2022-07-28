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

use core_question\local\bank\plugin_features_base;

/**
 * Adds question to activity bulk action in the bulk actions list.
 *
 * @package     qbank_qtoactivity
 * @copyright   2023 Safat Shahin <safatshahin@yahoo.com>
 * @author      Luke Purnel, Henry Campbell, Mark Hay, Harrison Liddell
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class plugin_feature extends plugin_features_base {

    public function get_question_columns($qbank): array {
        return [
            new add_action_column($qbank),
        ];
    }

    public function get_bulk_actions(): array {
        return [
            new bulk_add_action()
        ];
    }
}
