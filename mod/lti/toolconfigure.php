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
 * This page allows the configuration of external tools that meet the LTI specification.
 *
 * @package    mod_lti
 * @copyright  2015 Ryan Wyllie <ryan@agpu.com>
 * @author     Ryan Wyllie
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/mod/lti/lib.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');

$cartridgeurl = optional_param('cartridgeurl', '', PARAM_URL);

// No guest autologin.
require_login(0, false);
admin_externalpage_setup('ltitoolconfigure');

if ($cartridgeurl) {
    $type = new stdClass();
    $data = new stdClass();
    $type->state = LTI_TOOL_STATE_CONFIGURED;
    $data->lti_coursevisible = 1;
    lti_load_type_from_cartridge($cartridgeurl, $data);
    lti_add_type($type, $data);
}

$pageurl = new agpu_url('/mod/lti/toolconfigure.php');
$PAGE->set_url($pageurl);
$PAGE->set_title(get_string('toolregistration', 'mod_lti'));
$PAGE->requires->string_for_js('success', 'agpu');
$PAGE->requires->string_for_js('error', 'agpu');
$PAGE->requires->string_for_js('successfullycreatedtooltype', 'mod_lti');
$PAGE->requires->string_for_js('failedtocreatetooltype', 'mod_lti');
$output = $PAGE->get_renderer('mod_lti');

echo $output->header();

$page = new \mod_lti\output\tool_configure_page();
echo $output->render($page);

echo $output->footer();
