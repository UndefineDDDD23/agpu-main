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
 * Class containing data for Recently accessed items block.
 *
 * @package    block_recentlyaccesseditems
 * @copyright  2018 Victor Deniz <victor@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_recentlyaccesseditems\output;
defined('agpu_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;

/**
 * Class containing data for Recently accessed items block.
 *
 * @package    block_recentlyaccesseditems
 * @copyright  2018 Victor Deniz <victor@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class main implements renderable, templatable {
    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output
     * @return array
     */
    public function export_for_template(renderer_base $output) {

        $noitemsimgurl = $output->image_url('items', 'block_recentlyaccesseditems')->out();

        return [
            'noitemsimgurl' => $noitemsimgurl
        ];
    }
}