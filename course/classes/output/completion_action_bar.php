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

namespace core_course\output;

use core\output\select_menu;
use core_completion\manager;
use agpu_url;
use renderable;
use renderer_base;
use templatable;
use url_select;

/**
 * Renderable class for the action bar elements in the course completion pages.
 *
 * @package    core_course
 * @copyright  2022 Mihail Geshoski <mihail@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class completion_action_bar implements templatable, renderable {

    /** @var int $courseid The course id. */
    private $courseid;

    /** @var agpu_url $currenturl The URL of the current page. */
    private $currenturl;

    /**
     * The class constructor.
     *
     * @param int $courseid The course id.
     * @param agpu_url $pageurl The URL of the current page.
     */
    public function __construct(int $courseid, agpu_url $pageurl) {
        $this->courseid = $courseid;
        $this->currenturl = $pageurl;
    }

    /**
     * Export the data for the mustache template.
     *
     * @param renderer_base $output renderer to be used to render the action bar elements.
     * @return array The array which contains the data required to output the tertiary navigation selector for the course
     *               completion pages.
     */
    public function export_for_template(renderer_base $output): array {
        $selectmenu = new select_menu(
            'coursecompletionnavigation',
            manager::get_available_completion_options($this->courseid),
            $this->currenturl->out(false)
        );
        $selectmenu->set_label(
            get_string('coursecompletionnavigation', 'completion'),
            ['class' => 'sr-only']
        );

        return [
            'navigation' => $selectmenu->export_for_template($output),
        ];
    }
}
