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
 * View all document policy with a version, one under another.
 *
 * Script parameters:
 *  -
 *
 * @package     tool_policy
 * @copyright   2018 Sara Arjona (sara@agpu.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_policy\api;
use tool_policy\output\page_viewalldoc;

// Do not check for the site policies in require_login() to avoid the redirect loop.
define('NO_SITEPOLICY_CHECK', true);

// See the {@see page_viewalldoc} for the access control checks.
require(__DIR__.'/../../../config.php'); // phpcs:ignore

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL); // A return URL.

$viewallpage = new page_viewalldoc($returnurl);

$output = $PAGE->get_renderer('tool_policy');

echo $output->header();
echo $output->render($viewallpage);
echo $output->footer();
