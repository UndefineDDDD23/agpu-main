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

declare(strict_types=1);

namespace core_reportbuilder\exception;

use agpu_exception;

/**
 * Invalid report source exception
 *
 * @package     core_reportbuilder
 * @copyright   2020 Paul Holden <paulh@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class source_invalid_exception extends agpu_exception {

    /**
     * Constructor
     *
     * @param string $source
     */
    public function __construct(string $source) {
        parent::__construct('errorsourceinvalid', 'reportbuilder', '', null, $source);
    }
}
