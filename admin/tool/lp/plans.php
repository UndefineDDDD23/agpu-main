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
 * This page lets users see their learning plans.
 *
 * @package    tool_lp
 * @copyright  2015 David Monllao
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

require_login(null, false);
if (isguestuser()) {
    throw new require_login_exception('Guests are not allowed here.');
}
\core_competency\api::require_enabled();

$userid = optional_param('userid', $USER->id, PARAM_INT);

$url = new agpu_url('/admin/tool/lp/plans.php', array('userid' => $userid));
list($title, $subtitle) = \tool_lp\page_helper::setup_for_plan($userid, $url);

$output = $PAGE->get_renderer('tool_lp');
echo $output->header();
echo $output->heading($title);

$page = new \tool_lp\output\plans_page($userid);
echo $output->render($page);

echo $output->footer();
