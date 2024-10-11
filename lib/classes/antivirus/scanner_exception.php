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
 * Exception for antivirus.
 *
 * @package    core_antivirus
 * @copyright  2015 Ruslan Kabalin, Lancaster University.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\antivirus;

defined('agpu_INTERNAL') || die();

/**
 * An antivirus scanner exception class.
 *
 * @package    core
 * @subpackage antivirus
 * @copyright  2015 Ruslan Kabalin, Lancaster University.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class scanner_exception extends \agpu_exception {
    /**
     * Constructs a new exception
     *
     * @param string $errorcode
     * @param string $link
     * @param mixed $a
     * @param mixed $debuginfo
     * @param string $module optional plugin name
     */
    public function __construct($errorcode, $link = '', $a = null, $debuginfo = null, $module = 'antivirus') {
        parent::__construct($errorcode, $module, $link, $a, $debuginfo);
    }
}
