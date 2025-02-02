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

require_once('../../config.php');
require_once($CFG->dirroot.'/mod/scorm/locallib.php');

$id = optional_param('id', '', PARAM_INT);       // Course Module ID, or
$a = optional_param('a', '', PARAM_INT);         // scorm ID
$scoid = required_param('scoid', PARAM_INT);  // sco ID
$attempt = required_param('attempt', PARAM_INT);  // attempt number.

if (!empty($id)) {
    if (! $cm = get_coursemodule_from_id('scorm', $id)) {
        throw new \agpu_exception('invalidcoursemodule');
    }
    if (! $course = $DB->get_record("course", array("id" => $cm->course))) {
        throw new \agpu_exception('coursemisconf');
    }
    if (! $scorm = $DB->get_record("scorm", array("id" => $cm->instance))) {
        throw new \agpu_exception('invalidcoursemodule');
    }
} else if (!empty($a)) {
    if (! $scorm = $DB->get_record("scorm", array("id" => $a))) {
        throw new \agpu_exception('invalidcoursemodule');
    }
    if (! $course = $DB->get_record("course", array("id" => $scorm->course))) {
        throw new \agpu_exception('coursemisconf');
    }
    if (! $cm = get_coursemodule_from_instance("scorm", $scorm->id, $course->id)) {
        throw new \agpu_exception('invalidcoursemodule');
    }
} else {
    throw new \agpu_exception('missingparameter');
}

$PAGE->set_url('/mod/scorm/datamodel.php', array('scoid' => $scoid, 'attempt' => $attempt, 'id' => $cm->id));

require_login($course, false, $cm);

if (confirm_sesskey() && (!empty($scoid))) {
    $result = true;
    $request = null;
    if (has_capability('mod/scorm:savetrack', context_module::instance($cm->id))) {
        // Preload all current tracking data.
        $sql = "SELECT e.element, v.value, v.timemodified, v.id as valueid
                  FROM {scorm_scoes_value} v
                  JOIN {scorm_attempt} a ON a.id = v.attemptid
                  JOIN {scorm_element} e on e.id = v.elementid
                  WHERE a.scormid = :scormid AND a.userid = :userid AND v.scoid = :scoid AND a.attempt = :attempt";
        $trackdata = $DB->get_records_sql($sql, ['userid' => $USER->id, 'scormid' => $scorm->id,
                                                 'scoid' => $scoid, 'attempt' => $attempt]);
        $attemptobject = scorm_get_attempt($USER->id, $scorm->id, $attempt);
        foreach (data_submitted() as $element => $value) {
            $element = str_replace('__', '.', $element);
            if (substr($element, 0, 3) == 'cmi') {
                $netelement = preg_replace('/\.N(\d+)\./', "\.\$1\.", $element);
                $result = scorm_insert_track($USER->id, $scorm->id, $scoid, $attemptobject, $element, $value,
                                             $scorm->forcecompleted, $trackdata) && $result;
            }
            if (substr($element, 0, 15) == 'adl.nav.request') {
                // SCORM 2004 Sequencing Request.
                require_once($CFG->dirroot.'/mod/scorm/datamodels/scorm_13lib.php');

                $search = array('@continue@', '@previous@', '@\{target=(\S+)\}choice@', '@exit@',
                                    '@exitAll@', '@abandon@', '@abandonAll@');
                $replace = array('continue_', 'previous_', '\1', 'exit_', 'exitall_', 'abandon_', 'abandonall');
                $action = preg_replace($search, $replace, $value);

                if ($action != $value) {
                    // Evaluating navigation request.
                    $valid = scorm_seq_overall ($scoid, $USER->id, $action, $attempt);
                    $valid = 'true';

                    // Set valid request.
                    $search = array('@continue@', '@previous@', '@\{target=(\S+)\}choice@');
                    $replace = array('true', 'true', 'true');
                    $matched = preg_replace($search, $replace, $value);
                    if ($matched == 'true') {
                        $request = 'adl.nav.request_valid["'.$action.'"] = "'.$valid.'";';
                    }
                }
            }
        }
    }
    if ($result) {
        echo "true\n0";
    } else {
        echo "false\n101";
    }
    if ($request != null) {
        echo "\n".$request;
    }
}
