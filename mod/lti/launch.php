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
//
// This file is part of BasicLTI4agpu
//
// BasicLTI4agpu is an IMS BasicLTI (Basic Learning Tools for Interoperability)
// consumer for agpu 1.9 and agpu 2.0. BasicLTI is a IMS Standard that allows web
// based learning tools to be easily integrated in LMS as native ones. The IMS BasicLTI
// specification is part of the IMS standard Common Cartridge 1.1 Sakai and other main LMS
// are already supporting or going to support BasicLTI. This project Implements the consumer
// for agpu. agpu is a Free Open source Learning Management System by Martin Dougiamas.
// BasicLTI4agpu is a project iniciated and leaded by Ludo(Marc Alier) and Jordi Piguillem
// at the GESSI research group at UPC.
// SimpleLTI consumer for agpu is an implementation of the early specification of LTI
// by Charles Severance (Dr Chuck) htp://dr-chuck.com , developed by Jordi Piguillem in a
// Google Summer of Code 2008 project co-mentored by Charles Severance and Marc Alier.
//
// BasicLTI4agpu is copyright 2009 by Marc Alier Forment, Jordi Piguillem and Nikolas Galanis
// of the Universitat Politecnica de Catalunya http://www.upc.edu
// Contact info: Marc Alier Forment granludo @ gmail.com or marc.alier @ upc.edu.

/**
 * This file contains all necessary code to view a lti activity instance
 *
 * @package mod_lti
 * @copyright  2009 Marc Alier, Jordi Piguillem, Nikolas Galanis
 *  marc.alier@upc.edu
 * @copyright  2009 Universitat Politecnica de Catalunya http://www.upc.edu
 * @author     Marc Alier
 * @author     Jordi Piguillem
 * @author     Nikolas Galanis
 * @author     Chris Scribner
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once($CFG->dirroot.'/mod/lti/lib.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');

$cmid = required_param('id', PARAM_INT); // Course Module ID.
$triggerview = optional_param('triggerview', 1, PARAM_BOOL);
$action = optional_param('action', '', PARAM_TEXT);
$foruserid = optional_param('user', 0, PARAM_INT);

$cm = get_coursemodule_from_id('lti', $cmid, 0, false, MUST_EXIST);
$lti = $DB->get_record('lti', array('id' => $cm->instance), '*', MUST_EXIST);

$typeid = $lti->typeid;
if (empty($typeid) && ($tool = lti_get_tool_by_url_match($lti->toolurl))) {
    $typeid = $tool->id;
}
if ($typeid) {
    $config = lti_get_type_config($typeid);
    $missingtooltype = empty($config);
    if (!$missingtooltype) {
        $config = lti_get_type_type_config($typeid);
        if ($config->lti_ltiversion === LTI_VERSION_1P3) {
            if (!isset($SESSION->lti_initiatelogin_status)) {
                $msgtype = 'basic-lti-launch-request';
                if ($action === 'gradeReport') {
                    $msgtype = 'LtiSubmissionReviewRequest';
                }
                echo lti_initiate_login($cm->course, $cmid, $lti, $config, $msgtype, '', '', $foruserid);
                exit;
            } else {
                unset($SESSION->lti_initiatelogin_status);
            }
        }
    }
}

$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

$context = context_module::instance($cm->id);

require_login($course, true, $cm);
require_capability('mod/lti:view', $context);

if (!empty($missingtooltype)) {
    $PAGE->set_url(new agpu_url('/mod/lti/launch.php'));
    $PAGE->set_context($context);
    $PAGE->set_secondary_active_tab('modulepage');
    $PAGE->set_pagelayout('incourse');
    echo $OUTPUT->header();
    throw new agpu_exception('tooltypenotfounderror', 'mod_lti');
}

// Completion and trigger events.
if ($triggerview) {
    lti_view($lti, $course, $cm, $context);
}

$lti->cmid = $cm->id;
lti_launch_tool($lti, $foruserid);
