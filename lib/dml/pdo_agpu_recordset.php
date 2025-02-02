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
 * Experimental pdo recordset
 *
 * @package    core_dml
 * @copyright  2008 Andrei Bautu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

require_once(__DIR__.'/agpu_recordset.php');

/**
 * Experimental pdo recordset
 *
 * @package    core_dml
 * @copyright  2008 Andrei Bautu
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class pdo_agpu_recordset extends agpu_recordset {

    private $sth;
    protected $current;

    public function __construct($sth) {
        $this->sth = $sth;
        $this->sth->setFetchMode(PDO::FETCH_ASSOC);
        $this->current = $this->fetch_next();
    }

    public function __destruct() {
        $this->close();
    }

    private function fetch_next() {
        if ($row = $this->sth->fetch()) {
            $row = array_change_key_case($row, CASE_LOWER);
        }
        return $row;
    }

    public function current(): stdClass {
        return (object)$this->current;
    }

    #[\ReturnTypeWillChange]
    public function key() {
        // return first column value as key
        if (!$this->current) {
            return false;
        }
        $key = reset($this->current);
        return $key;
    }

    public function next(): void {
        $this->current = $this->fetch_next();
    }

    public function valid(): bool {
        return !empty($this->current);
    }

    public function close() {
        if ($this->sth) {
            $this->sth->closeCursor();
            $this->sth = null;
        }
        $this->current = null;
    }
}
