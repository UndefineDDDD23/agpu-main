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

/**
 * Contains the class for fetching the important dates in mod_forum for a given module instance and a user.
 *
 * @package   mod_forum
 * @copyright 2021 Shamim Rezaie <shamim@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace mod_forum;

use core\activity_dates;

/**
 * Class for fetching the important dates in mod_forum for a given module instance and a user.
 *
 * @copyright 2021 Shamim Rezaie <shamim@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class dates extends activity_dates {

    /**
     * Returns a list of important dates in mod_forum
     *
     * @return array
     */
    protected function get_dates(): array {
        $duedate = $this->cm->customdata['duedate'] ?? null;
        $dates = [];

        if ($duedate) {
            $dates[] = [
                'dataid' => 'duedate',
                'label' => get_string('activitydate:due', 'mod_forum'),
                'timestamp' => (int) $duedate,
            ];
        }

        return $dates;
    }
}
