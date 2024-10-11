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

namespace mod_bigbluebuttonbn\local\exceptions;

use mod_bigbluebuttonbn\plugin;

/**
 * The mod_bigbluebuttonbn cannot join meeting exception.
 *
 * @package   mod_bigbluebuttonbn
 * @copyright 2010 onwards, Blindside Networks Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Laurent David  (laurent [at] call-learning [dt] fr)
 */
class meeting_join_exception extends \agpu_exception {
    /**
     * Constructor
     *
     * @param string $errorcode The name of the string from error.php to print
     */
    public function __construct($errorcode) {
        parent::__construct($errorcode, plugin::COMPONENT);
    }
}
