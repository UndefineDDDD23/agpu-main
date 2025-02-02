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
 * Tool registration page class.
 *
 * @package    enrol_lti
 * @copyright  2016 John Okely <john@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace enrol_lti\output;

defined('agpu_INTERNAL') || die;

use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * Tool registration page class.
 *
 * @package    enrol_lti
 * @copyright  2016 John Okely <john@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class registration implements renderable, templatable {

    /** @var returnurl The url to which the tool proxy should return */
    protected $returnurl;

    /**
     * Construct a new tool registration page
     * @param string|null $returnurl The url the consumer wants us to return the user to (optional)
     */
    public function __construct($returnurl = null) {
        $this->returnurl = $returnurl;
    }

    /**
     * Export the data.
     *
     * @param renderer_base $output
     * @return stdClass Data to be used for the template
     */
    public function export_for_template(renderer_base $output) {

        $data = new stdClass();
        $data->returnurl = $this->returnurl;

        return $data;
    }
}
