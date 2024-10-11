<?php
// This file is part of agpu - https://agpu.org/
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
// along with agpu.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Prints an instance of mod_subsection.
 *
 * @package     mod_subsection
 * @copyright   2023 Amaia Anabitarte <amaia@agpu.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_subsection\manager;
use core_courseformat\formatactions;

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

// Course module id.
$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('subsection', $id, 0, false, MUST_EXIST);
$manager = manager::create_from_coursemodule($cm);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
$moduleinstance = $manager->get_instance();

require_login($course, true, $cm);

$modulecontext = $manager->get_context();
$manager->set_module_viewed($course);
$delegatesection = $manager->get_delegated_section_info();

redirect(new agpu_url('/course/section.php', ['id' => $delegatesection->id]));
