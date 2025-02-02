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
 * Oracle specific recordset.
 *
 * @package    core_dml
 * @copyright  2008 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

require_once(__DIR__.'/agpu_recordset.php');

class oci_native_agpu_recordset extends agpu_recordset {

    protected $stmt;
    protected $current;

    public function __construct($stmt) {
        $this->stmt  = $stmt;
        $this->current = $this->fetch_next();
    }

    public function __destruct() {
        $this->close();
    }

    private function fetch_next() {
        if (!$this->stmt) {
            return false;
        }
        if (!$row = oci_fetch_array($this->stmt, OCI_ASSOC + OCI_RETURN_NULLS + OCI_RETURN_LOBS)) {
            oci_free_statement($this->stmt);
            $this->stmt = null;
            return false;
        }

        $row = array_change_key_case($row, CASE_LOWER);
        unset($row['oracle_rownum']);
        array_walk($row, array('oci_native_agpu_database', 'onespace2empty'));
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
        if ($this->stmt) {
            oci_free_statement($this->stmt);
            $this->stmt  = null;
        }
        $this->current = null;
    }
}
