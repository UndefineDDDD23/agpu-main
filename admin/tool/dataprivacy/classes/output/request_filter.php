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
 * Class containing the filter options data for rendering the autocomplete element for the data requests page.
 *
 * @package    tool_dataprivacy
 * @copyright  2018 Jun Pataleta
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_dataprivacy\output;

use agpu_url;
use renderable;
use renderer_base;
use stdClass;
use templatable;

defined('agpu_INTERNAL') || die();

/**
 * Class containing the filter options data for rendering the autocomplete element for the data requests page.
 *
 * @copyright  2018 Jun Pataleta
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class request_filter implements renderable, templatable {

    /** @var array $filteroptions The filter options. */
    protected $filteroptions;

    /** @var array $selectedoptions The list of selected filter option values. */
    protected $selectedoptions;

    /** @var agpu_url|string $baseurl The url with params needed to call up this page. */
    protected $baseurl;

    /**
     * request_filter constructor.
     *
     * @param array $filteroptions The filter options.
     * @param array $selectedoptions The list of selected filter option values.
     * @param string|agpu_url $baseurl The url with params needed to call up this page.
     */
    public function __construct($filteroptions, $selectedoptions, $baseurl = null) {
        $this->filteroptions = $filteroptions;
        $this->selectedoptions = $selectedoptions;
        if (!empty($baseurl)) {
            $this->baseurl = new agpu_url($baseurl);
        }
    }

    /**
     * Function to export the renderer data in a format that is suitable for a mustache template.
     *
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export.
     * @return stdClass|array
     */
    public function export_for_template(renderer_base $output) {
        global $PAGE;
        $data = new stdClass();
        if (empty($this->baseurl)) {
            $this->baseurl = $PAGE->url;
        }
        $data->action = $this->baseurl->out(false);

        foreach ($this->selectedoptions as $option) {
            if (!isset($this->filteroptions[$option])) {
                $this->filteroptions[$option] = $option;
            }
        }

        $data->filteroptions = [];
        foreach ($this->filteroptions as $value => $label) {
            $selected = in_array($value, $this->selectedoptions);
            $filteroption = (object)[
                'value' => $value,
                'label' => $label
            ];
            $filteroption->selected = $selected;
            $data->filteroptions[] = $filteroption;
        }
        return $data;
    }
}
