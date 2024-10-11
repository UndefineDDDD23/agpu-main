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

namespace mod_subsection\local\callbacks;

use core_course\hook\before_activitychooserbutton_exported;
use action_link;
use agpu_url;
use mod_subsection\permission;
use pix_icon;
use section_info;

/**
 * Class before activity choooser button export handler.
 *
 * @package    mod_subsection
 * @copyright  2024 Mikel Martín <mikel@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class before_activitychooserbutton_exported_handler {
    /**
     * Handle the activity chooser button extra items addition.
     *
     * @param before_activitychooserbutton_exported $hook
     */
    public static function callback(before_activitychooserbutton_exported $hook): void {
        /** @var section_info $section */
        $section = $hook->get_section();

        if (!permission::can_add_subsection($section)) {
            return;
        }

        $attributes = [
            'class' => 'dropdown-item',
            'data-action' => 'addModule',
            'data-modname' => 'subsection',
            'data-sectionnum' => $section->sectionnum,
        ];
        if ($hook->get_cm()) {
            $attributes['data-beforemod'] = $hook->get_cm()->id;
        }

        $hook->get_activitychooserbutton()->add_action_link(new action_link(
            new agpu_url('#'),
            get_string('modulename', 'mod_subsection'),
            null,
            $attributes,
            new pix_icon('subsection', '', 'mod_subsection')
        ));
    }
}
