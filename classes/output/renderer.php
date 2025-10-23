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

namespace qbank_qtoactivity\output;

/**
 * Renderer for the question to activity.
 *
 * @package     qbank_qtoactivity
 * @copyright   2023 Safat Shahin <safatshahin@yahoo.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends \plugin_renderer_base {
    /**
     * Renderer for module form.
     *
     * @param \moodle_url $addtomoduleurl Add to module url
     * @param \moodle_url $returnurl The return url to question bank
     * @param array $modules The array of modules
     * @return string
     */
    public function render_add_to_module_form(\moodle_url $addtomoduleurl, \moodle_url $returnurl, array $modules): string {
        $displaydata = [];
        $displaydata['returnurl'] = $returnurl;
        $displaydata['modules'] = false;

        if (!empty($modules)) {
            // Module selection form.
            $addtomoduleform = new \qbank_qtoactivity\output\form\add_to_module_form(null, ['modules' => $modules]);

            $displaydata['modules'] = true;
            $displaydata['moduledropdown'] = $addtomoduleform->render();
            $displaydata['addtomoduleurl'] = $addtomoduleurl;
        }

        return $this->render_from_template('qbank_qtoactivity/add_to_activity_form', $displaydata);
    }
}
