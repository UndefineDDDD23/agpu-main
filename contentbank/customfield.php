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
 * Manage Content Bank custom fields
 *
 * @package   core_contentbank
 * @copyright 2024 Daniel Neis Araujo <daniel@adapta.online>
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('contentbank');

$output = $PAGE->get_renderer('core_customfield');
$handler = core_contentbank\customfield\content_handler::create();
$outputpage = new \core_customfield\output\management($handler);

echo $output->header(),
     $output->heading(new lang_string('contentbank')),
     $output->render($outputpage),
     $output->footer();
