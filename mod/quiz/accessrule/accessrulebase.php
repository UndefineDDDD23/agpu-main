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
 * File only retained to prevent fatal errors in code that tries to require/include this.
 *
 * @todo MDL-76612 delete this file as part of agpu 4.6 development.
 * @deprecated This file is no longer required in agpu 4.2+.
 */
defined('agpu_INTERNAL') || die();

debugging('This file is no longer required in agpu 4.2+. Please do not include/require it.', DEBUG_DEVELOPER);

require_once($CFG->dirroot . '/mod/quiz/locallib.php');
