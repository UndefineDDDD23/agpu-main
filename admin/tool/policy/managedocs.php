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
 * Manage policy documents used on the site.
 *
 * Script arguments:
 * - archived=<int> Show only archived versions of the given policy document
 *
 * @package     tool_policy
 * @copyright   2018 David Mudrák <david@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

$archived = optional_param('archived', 0, PARAM_INT);

admin_externalpage_setup('tool_policy_managedocs', '', ['archived' => $archived]);

$output = $PAGE->get_renderer('tool_policy');

$manpage = new \tool_policy\output\page_managedocs_list($archived);

echo $output->header();
echo $output->render($manpage);
echo $output->footer();
