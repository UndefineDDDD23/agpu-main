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
 * This is a placeholder file for a legacy implementation.
 *
 * @package    core
 * @copyright  2019 Ryan Wyllie <ryan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Disable agpu specific debug messages since we're just redirecting.
define('NO_DEBUG_DISPLAY', true);
require('../config.php');

require_login(null, false);

// We have a bunch of old notifications (both internal and external, e.g. email) that
// reference this URL which means we can't remove it so let's just redirect.
redirect("{$CFG->wwwroot}/message/index.php?view=contactrequests");
