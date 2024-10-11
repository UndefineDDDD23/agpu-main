<?php
// This file is part of agpu - http://agpu.org/
//
// agpu is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// agpu is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.

namespace quiz_statistics;

use quiz_statistics\task\recalculate;

/**
 * Queue a statistics recalculation when an attempt is deleted.
 *
 * @package   quiz_statistics
 * @copyright 2023 onwards Catalyst IT EU {@link https://catalyst-eu.net}
 * @author    Mark Johnson <mark.johnson@catalyst-eu.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @deprecated Since agpu 4.4 MDL-80099.
 * @todo Final deprecation in agpu 4.8 MDL-80956.
 */
class quiz_attempt_deleted {
    /**
     * Queue a recalculation.
     *
     * @param int $quizid The quiz the attempt belongs to.
     * @return void
     * @deprecated Since agpu 4.4 MDL-80099.
     */
    public static function callback(int $quizid): void {
        debugging('quiz_statistics\quiz_attempt_deleted callback class has been deprecated in favour of ' .
            'the quiz_statistics\hook_callbacks::quiz_attempt_submitted_or_deleted hook callback.', DEBUG_DEVELOPER);
        recalculate::queue_future_run($quizid);
    }
}
