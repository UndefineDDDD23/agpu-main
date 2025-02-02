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

namespace mod_data\output;

use templatable;
use renderable;

/**
 * Renderable class for the action bar elements in the field pages in the database activity.
 *
 * @package    mod_data
 * @copyright  2021 Mihail Geshoski <mihail@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class fields_action_bar implements templatable, renderable {

    /** @var int $id The database module id. */
    private $id;

    /**
     * The class constructor.
     *
     * @param int $id The database module id
     * @param null $unused1 This parameter has been deprecated since 4.1 and should not be used anymore.
     * @param null $unused2 This parameter has been deprecated since 4.1 and should not be used anymore.
     * @param null $unused3 This parameter has been deprecated since 4.1 and should not be used anymore.
     * @param null $unused4 This parameter has been deprecated since 4.1 and should not be used anymore.
     * @param \action_menu|null $unused5 This parameter has been deprecated since 4.2 and should not be used anymore.
     */
    public function __construct(int $id, $unused1 = null, $unused2 = null,
            $unused3 = null, $unused4 = null,
            ?\action_menu $unused5 = null) {

        if ($unused1 !== null || $unused2 !== null || $unused3 !== null || $unused4 !== null || $unused5 !== null) {
            debugging('Deprecated argument passed to fields_action_bar constructor', DEBUG_DEVELOPER);
        }

        $this->id = $id;
    }

    /**
     * Export the data for the mustache template.
     *
     * @param \renderer_base $output The renderer to be used to render the action bar elements.
     * @return array
     */
    public function export_for_template(\renderer_base $output): array {

        $data = [
            'd' => $this->id,
            'title' => get_string('managefields', 'mod_data'),
        ];

        return $data;
    }
}
