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

use core_question\local\bank\menu_action_column_base;
use core_question\local\bank\question_action_base;

/**
 * Adds a single action titled 'Add to Quiz' to the actions' menu.
 *
 * @package     qbank_qtoactivity
 * @copyright   2025 Safat Shahin <safatshahin@yahoo.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class addtomodule_action extends question_action_base {
    /**
     * Array of the return parameters.
     * @var array $returnparams
     */
    protected $returnparams;

    #[\Override]
    public function init(): void {
        parent::init();
        if (!empty($this->qbank->cm->id)) {
            $this->returnparams['cmid'] = $this->qbank->cm->id;
        }
        if (!empty($this->qbank->course->id)) {
            $this->returnparams['courseid'] = $this->qbank->course->id;
        }
        if (!empty($this->qbank->returnurl)) {
            $this->returnparams['returnurl'] = $this->qbank->returnurl;
        }
    }

    #[\Override]
    public function get_menu_position(): int {
        return 200;
    }

    #[\Override]
    protected function get_url_icon_and_label(\stdClass $question): array {
        $params = [
            'addtomoduleselected' => $question->id,
            'q' . $question->id => 1,
            'sesskey' => sesskey(),
        ];
        $addtomoduleparams = array_merge($params, $this->returnparams);
        $url = new \moodle_url('/question/bank/qtoactivity/addtoactivity.php', $addtomoduleparams);

        return [$url, 't/add', get_string('addtomodule', 'qbank_qtoactivity')];
    }
}
