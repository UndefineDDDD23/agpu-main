<?php
// This file is part of agpu - http://agpu.org/
//
// agpu is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 2 of the License, or
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
 * sqlsrv specific recordset.
 *
 * @package    core_dml
 * @copyright  2009 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */

defined('agpu_INTERNAL') || die();

require_once(__DIR__.'/agpu_recordset.php');

class sqlsrv_native_agpu_recordset extends agpu_recordset {

    protected $rsrc;
    protected $current;

    /** @var array recordset buffer */
    protected $buffer = null;

    /** @var sqlsrv_native_agpu_database */
    protected $db;

    public function __construct($rsrc, sqlsrv_native_agpu_database $db) {
        $this->rsrc    = $rsrc;
        $this->current = $this->fetch_next();
        $this->db      = $db;
    }

    /**
     * Inform existing open recordsets that transaction
     * is starting, this works around MARS problem described
     * in MDL-37734.
     */
    public function transaction_starts() {
        if ($this->buffer !== null) {
            $this->unregister();
            return;
        }
        if (!$this->rsrc) {
            $this->unregister();
            return;
        }
        // This might eat memory pretty quickly...
        raise_memory_limit('2G');
        $this->buffer = array();

        while($next = $this->fetch_next()) {
            $this->buffer[] = $next;
        }
    }

    /**
     * Unregister recordset from the global list of open recordsets.
     */
    private function unregister() {
        if ($this->db) {
            $this->db->recordset_closed($this);
            $this->db = null;
        }
    }

    public function __destruct() {
        $this->close();
    }

    private function fetch_next() {
        if (!$this->rsrc) {
            return false;
        }
        if (!$row = sqlsrv_fetch_array($this->rsrc, SQLSRV_FETCH_ASSOC)) {
            if (is_resource($this->rsrc)) {
                // We need to make sure that the statement resource is in the correct type before freeing it.
                sqlsrv_free_stmt($this->rsrc);
            }
            $this->rsrc = null;
            $this->unregister();
            return false;
        }

        unset($row['sqlsrvrownumber']);
        $row = array_change_key_case($row, CASE_LOWER);
        // agpu expects everything from DB as strings.
        foreach ($row as $k=>$v) {
            if (is_null($v)) {
                continue;
            }
            if (!is_string($v)) {
                $row[$k] = (string)$v;
            }
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
        if ($this->buffer === null) {
            $this->current = $this->fetch_next();
        } else {
            $this->current = array_shift($this->buffer);
        }
    }

    public function valid(): bool {
        return !empty($this->current);
    }

    public function close() {
        if ($this->rsrc) {
            if (is_resource($this->rsrc)) {
                // We need to make sure that the statement resource is in the correct type before freeing it.
                sqlsrv_free_stmt($this->rsrc);
            }
            $this->rsrc  = null;
        }
        $this->current = null;
        $this->buffer  = null;
        $this->unregister();
    }
}
