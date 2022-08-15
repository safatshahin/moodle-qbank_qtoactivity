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

/**
 * Add to quiz action selector js.
 *
 * @module     qbank_q2activity/q2activity
 * @copyright   2022 Harrison Liddell, hliddell@myune.edu.au
 * @copyright   Mark Hay,              mhay23@myune.edu.au
 * @copyright   Henry Campbell,        hcampb25@myune.edu.au
 * @copyright   Luke Purnell,          lpurnell@myune.edu.au
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Fragment from 'core/fragment';
import * as Str from 'core/str';
import ModalFactory from 'core/modal_factory';
import Notification from 'core/notification';

/**
 * Get the fragment.
 *
 * @method getFragment
 * @param {{questioned: int}} args
 * @param {int} contextId
 * @return {string}
 */
const getFragment = (args, contextId) => {
    return Fragment.loadFragment('qbank_q2activity', 'add_question', contextId, args);
};

/**
 * Event listeners for the module.
 *
 * @method clickEvent
 * @param {int} questionId
 * @param {int} contextId
 */
const addActivityEvent = (questionId, contextId) => {
    let args = {
        questionid: questionId
    };
    ModalFactory.create({
        type: ModalFactory.types.CANCEL,
        title: Str.get_string('pluginname', 'qbank_q2activity'),
        body: getFragment(args, contextId),
        large: true,
    }).then((modal) => {
        modal.show();
        modal.getRoot().on('click', 'a[href].page-link', function(e) {
            e.preventDefault();
            let attr = e.target.getAttribute("href");
            if (attr !== '#') {
                args.querystring = attr;
                modal.setBody(getFragment(args, contextId));
            }
        });
        return modal;
    }).fail(Notification.exception);
};
/**
 * Entrypoint of the js.
 *
 * @method init
 * @param {int} questionSelector the question identifier.
 * @param {int} contextId the question context id.
 */
export const init = (questionSelector, contextId) => {
    let target = document.querySelector(questionSelector);
    let questionId = target.getAttribute('data-questionid');
    target.addEventListener('click', () => {
        // Call for the event listener to listed for clicks in any usage count row.
        addActivityEvent(questionId, contextId);
    });
};
