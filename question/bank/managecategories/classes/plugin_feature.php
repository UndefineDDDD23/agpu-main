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

namespace qbank_managecategories;

use core_question\local\bank\navigation_node_base;
use core_question\local\bank\plugin_features_base;
use core_question\local\bank\view;

/**
 * Class plugin_feature.
 *
 * Entry point for qbank plugin.
 * Every qbank plugin must extent this class.
 *
 * @package    qbank_managecategories
 * @copyright  2021 Catalyst IT Australia Pty Ltd
 * @author     Safat Shahin <safatshahin@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class plugin_feature extends plugin_features_base {

    public function get_navigation_node(): ?navigation_node_base {
        return new navigation();
    }

    public function get_question_filters(?view $qbank = null): array {
        return [
            new category_condition($qbank),
        ];
    }
}
