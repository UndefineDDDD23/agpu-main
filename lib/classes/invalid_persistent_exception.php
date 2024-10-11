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
 * Invalid persistent exception.
 *
 * @package    core
 * @copyright  2015 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core;

defined('agpu_INTERNAL') || die();

/**
 * Invalid persistent exception class.
 *
 * @package    core
 * @copyright  2015 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class invalid_persistent_exception extends \agpu_exception {

    public function __construct(array $errors = array()) {
        $forhumans = array();
        $debuginfo = array();
        foreach ($errors as $key => $message) {
            $debuginfo[] = "$key: $message";
            $forhumans[] = $message;
        }
        parent::__construct('invalidpersistenterror', 'core', null,
                implode(', ', $forhumans), implode(' - ', $debuginfo));
    }

}
