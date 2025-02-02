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
 * @package    agpucore
 * @subpackage backup-interfaces
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Interface to apply to all the classes we want to be able to write to logs
 *
 * Any class being part of one backup/restore and needing to senf informatio
 * to logs must implement this interface (and have access to the @logger
 * instantiated object)
 *
 * TODO: Finish phpdocs
 */
interface loggable {

    /**
     * This function will be responsible for handling the params, and to call
     * to the corresponding logger->process() once all modifications in params
     * have been performed
     */
    public function log($message, $level, $a = null, $depth = null, $display = false);
}
