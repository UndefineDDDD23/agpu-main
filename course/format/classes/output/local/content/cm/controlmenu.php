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
 * Contains the default activity control menu.
 *
 * @package   core_courseformat
 * @copyright 2020 Ferran Recio <ferran@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_courseformat\output\local\content\cm;

use action_menu;
use action_menu_link;
use cm_info;
use core_courseformat\base as course_format;
use core_courseformat\output\local\content\basecontrolmenu;
use core_courseformat\output\local\courseformat_named_templatable;
use section_info;
use stdClass;

/**
 * Base class to render a course module menu inside a course format.
 *
 * @package   core_courseformat
 * @copyright 2020 Ferran Recio <ferran@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class controlmenu extends basecontrolmenu {

    /** @var array optional display options */
    protected $displayoptions;

    /**
     * Constructor.
     *
     * @param course_format $format the course format
     * @param section_info $section the section info
     * @param cm_info $mod the course module info
     * @param array $displayoptions optional extra display options
     */
    public function __construct(course_format $format, section_info $section, cm_info $mod, array $displayoptions = []) {
        parent::__construct($format, $section, $mod, $mod->id);
        $this->displayoptions = $displayoptions;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output typically, the renderer that's calling this function
     * @return stdClass|null data context for a mustache template
     */
    public function export_for_template(\renderer_base $output): ?stdClass {

        $mod = $this->mod;

        if (!$this->format->show_activity_editor_options($this->mod)) {
            return null;
        }

        $menu = $this->get_action_menu($output);

        if (empty($menu)) {
            return new stdClass();
        }

        $data = (object)[
            'menu' => $menu->export_for_template($output),
            'hasmenu' => true,
            'id' => $this->menuid,
        ];

        // After icons.
        if (!empty($mod->afterediticons)) {
            $data->afterediticons = $mod->afterediticons;
        }

        return $data;
    }

    /**
     * Generate the action menu element.
     *
     * This method is public in case some block needs to modify the menu before output it.
     * @param \renderer_base $output typically, the renderer that's calling this function
     * @return action_menu|null the activity action menu
     */
    public function get_action_menu(\renderer_base $output): ?action_menu {

        if (!empty($this->menu)) {
            return $this->menu;
        }

        $mod = $this->mod;

        // In case module is delegating a section, we should return delegated section action menu.
        if ($delegated = $mod->get_delegated_section_info()) {
            $controlmenuclass = $this->format->get_output_classname('content\\cm\\delegatedcontrolmenu');
            $controlmenu = new $controlmenuclass($this->format, $delegated, $mod);

            return $controlmenu->get_action_menu($output);
        }

        $controls = $this->cm_control_items();

        if (empty($controls)) {
            return null;
        }

        // Convert control array into an action_menu.
        $menu = new action_menu();
        $menu->set_kebab_trigger(get_string('edit'));
        $menu->attributes['class'] .= ' section-cm-edit-actions commands';

        // Prioritise the menu ahead of all other actions.
        $menu->prioritise = true;

        $ownerselector = $this->displayoptions['ownerselector'] ?? '#module-' . $mod->id;
        $menu->set_owner_selector($ownerselector);

        foreach ($controls as $control) {
            if ($control instanceof action_menu_link) {
                $control->add_class('cm-edit-action');
            }
            $menu->add($control);
        }

        $this->menu = $menu;

        return $menu;
    }

    /**
     * Generate the edit control items of a course module.
     *
     * This method uses course_get_cm_edit_actions function to get the cm actions.
     * However, format plugins can override the method to add or remove elements
     * from the menu.
     *
     * @return array of edit control items
     */
    protected function cm_control_items() {
        $format = $this->format;
        $mod = $this->mod;
        $sectionreturn = $format->get_sectionnum();
        if (!empty($this->displayoptions['disableindentation']) || !$format->uses_indentation()) {
            $indent = -1;
        } else {
            $indent = $mod->indent;
        }
        return course_get_cm_edit_actions($mod, $indent, $sectionreturn);
    }
}
