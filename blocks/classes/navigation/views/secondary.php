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

namespace core_block\navigation\views;

/**
 * Class secondary
 *
 * @package core_block
 * @category navigation
 */
class secondary extends \core\navigation\views\secondary {
    /**
     * Blocks don't require secondary navs as they can be accessed from multiple places and in different contexts.
     */
    public function initialise(): void {

    }
}
