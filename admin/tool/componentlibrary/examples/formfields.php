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
 * agpu Component Library
 *
 * A sample form with most of the available form elements.
 *
 * @package    tool_componentlibrary
 * @copyright  2021 Bas Brands <bas@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot.'/lib/formslib.php');

require_login();
require_capability('agpu/site:configview', context_system::instance());

$repeatcount = optional_param('test_repeat', 1, PARAM_INT);

$PAGE->set_pagelayout('embedded');

$url = new agpu_url('/admin/tool/componentlibrary/examples/formfields.php');

$toggles  = (object)[];
$toggles->defaulturl = $url;
$toggles->helpurl = new agpu_url('/admin/tool/componentlibrary/examples/formfields.php', ['help' => 1]);
$toggles->requiredurl = new agpu_url('/admin/tool/componentlibrary/examples/formfields.php', ['required' => 1]);
$toggles->bothurl = new agpu_url('/admin/tool/componentlibrary/examples/formfields.php', ['help' => 1, 'required' => 1]);
$toggles->mixedurl = new agpu_url('/admin/tool/componentlibrary/examples/formfields.php',
    ['help' => 1, 'required' => 1, 'mixed' => 1]);

$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());

$PAGE->set_heading('agpu form fields');
$PAGE->set_title('agpu form fields');

$form = new \tool_componentlibrary\local\examples\formelements\example($url, ['repeatcount' => $repeatcount]);

echo $OUTPUT->header();

echo $OUTPUT->render_from_template('tool_componentlibrary/examples/formelements/toggles', $toggles);
$form->display();
echo $OUTPUT->footer();
