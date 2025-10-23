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
    /**
     * Array of the return parameters.
     * @var array $requiredparams
     */
    protected $requiredparams;

    #[\Override]
    public function init(): void {
        parent::init();
        if (!empty($this->qbank->cm->id)) {
            $this->requiredparams['cmid'] = $this->qbank->cm->id;
        }
        if (!empty($this->qbank->course->id)) {
            $this->requiredparams['courseid'] = $this->qbank->course->id;
        }
        if (!empty($this->qbank->returnurl)) {
            $this->requiredparams['returnurl'] = $this->qbank->returnurl;
        }
    }

    #[\Override]
    public function get_bulk_action_title(): string {
        return get_string('addtomodule', 'qbank_qtoactivity', $this->requiredparams);
    }

    #[\Override]
    public function get_bulk_action_url(): \moodle_url {
        return new \moodle_url('/question/bank/qtoactivity/addtoactivity.php');
    }

    #[\Override]
    public function get_bulk_action_capabilities(): ?array {
        return [
            'moodle/question:editall',
        ];
    }

    #[\Override]
    public function get_bulk_action_key(): string {
        return 'move';
    }

    #[\Override]
    public function get_key(): string {
        return 'addtomoduleselected';
    }
}
