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
 * Meta course enrolment plugin.
 *
 * @package    enrol_meta
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * ENROL_META_CREATE_GROUP constant for automatically creating a group for a meta course.
 */
define('ENROL_META_CREATE_GROUP', -1);

/**
 * Meta course enrolment plugin.
 * @author Petr Skoda
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_meta_plugin extends enrol_plugin {

    /**
     * Returns localised name of enrol instance
     *
     * @param stdClass $instance (null is accepted too)
     * @return string
     */
    public function get_instance_name($instance) {
        global $DB;

        if (empty($instance)) {
            $enrol = $this->get_name();
            return get_string('pluginname', 'enrol_'.$enrol);
        } else if (empty($instance->name)) {
            $enrol = $this->get_name();
            $course = $DB->get_record('course', array('id'=>$instance->customint1));
            if ($course) {
                $coursename = format_string(get_course_display_name_for_list($course));
            } else {
                // Use course id, if course is deleted.
                $coursename = $instance->customint1;
            }
            return get_string('pluginname', 'enrol_' . $enrol) . ' (' . $coursename . ')';
        } else {
            return format_string($instance->name);
        }
    }

    /**
     * Returns true if we can add a new instance to this course.
     *
     * @param int $courseid
     * @return boolean
     */
    public function can_add_instance($courseid) {
        $context = context_course::instance($courseid, MUST_EXIST);
        if (!has_capability('agpu/course:enrolconfig', $context) or !has_capability('enrol/meta:config', $context)) {
            return false;
        }
        // Multiple instances supported - multiple parent courses linked.
        return true;
    }

    /**
     * Does this plugin allow manual unenrolment of a specific user?
     * Yes, but only if user suspended...
     *
     * @param stdClass $instance course enrol instance
     * @param stdClass $ue record from user_enrolments table
     *
     * @return bool - true means user with 'enrol/xxx:unenrol' may unenrol this user, false means nobody may touch this user enrolment
     */
    public function allow_unenrol_user(stdClass $instance, stdClass $ue) {
        if ($ue->status == ENROL_USER_SUSPENDED) {
            return true;
        }

        return false;
    }

    /**
     * Called after updating/inserting course.
     *
     * @param bool $inserted true if course just inserted
     * @param stdClass $course
     * @param stdClass $data form data
     * @return void
     */
    public function course_updated($inserted, $course, $data) {
        // Meta sync updates are slow, if enrolments get out of sync teacher will have to wait till next cron.
        // We should probably add some sync button to the course enrol methods overview page.
    }

    /**
     * Add new instance of enrol plugin.
     * @param object $course
     * @param array $fields instance fields
     * @return int id of last instance, null if can not be created
     */
    public function add_instance($course, ?array $fields = null) {
        global $CFG;

        require_once("$CFG->dirroot/enrol/meta/locallib.php");

        // Support creating multiple at once.
        if (isset($fields['customint1']) && is_array($fields['customint1'])) {
            $courses = array_unique($fields['customint1']);
        } else if (isset($fields['customint1'])) {
            $courses = array($fields['customint1']);
        } else {
            $courses = array(null); // Strange? Yes, but that's how it's working or instance is not created ever.
        }
        foreach ($courses as $courseid) {
            if (!empty($fields['customint2']) && $fields['customint2'] == ENROL_META_CREATE_GROUP) {
                $context = context_course::instance($course->id);
                require_capability('agpu/course:managegroups', $context);
                $groupid = enrol_meta_create_new_group($course->id, $courseid);
                $fields['customint2'] = $groupid;
            }

            $fields['customint1'] = $courseid;
            $result = parent::add_instance($course, $fields);
        }

        enrol_meta_sync($course->id);

        return $result;
    }

    /**
     * Update instance of enrol plugin.
     * @param stdClass $instance
     * @param stdClass $data modified instance fields
     * @return boolean
     */
    public function update_instance($instance, $data) {
        global $CFG;

        require_once("$CFG->dirroot/enrol/meta/locallib.php");

        if (!empty($data->customint2) && $data->customint2 == ENROL_META_CREATE_GROUP) {
            $context = context_course::instance($instance->courseid);
            require_capability('agpu/course:managegroups', $context);
            $groupid = enrol_meta_create_new_group($instance->courseid, $data->customint1);
            $data->customint2 = $groupid;
        }

        $result = parent::update_instance($instance, $data);

        enrol_meta_sync($instance->courseid);

        return $result;
    }

    /**
     * Update instance status
     *
     * @param stdClass $instance
     * @param int $newstatus ENROL_INSTANCE_ENABLED, ENROL_INSTANCE_DISABLED
     * @return void
     */
    public function update_status($instance, $newstatus) {
        global $CFG;

        parent::update_status($instance, $newstatus);

        require_once("$CFG->dirroot/enrol/meta/locallib.php");
        enrol_meta_sync($instance->courseid);
    }

    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/meta:config', $context);
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/meta:config', $context);
    }

    /**
     * We are a good plugin and don't invent our own UI/validation code path.
     *
     * @return boolean
     */
    public function use_standard_editing_ui() {
        return true;
    }

    /**
     * Return an array of valid options for the courses.
     *
     * @param stdClass $instance
     * @param context $coursecontext
     * @return array
     */
    protected function get_course_options($instance, $coursecontext) {
        global $DB;

        if ($instance->id) {
            $where = 'WHERE c.id = :courseid';
            $params = array('courseid' => $instance->customint1);
            $existing = array();
        } else {
            $where = '';
            $params = array();
            $instanceparams = array('enrol' => 'meta', 'courseid' => $instance->courseid);
            $existing = $DB->get_records('enrol', $instanceparams, '', 'customint1, id');
        }

        // TODO: this has to be done via ajax or else it will fail very badly on large sites!
        $courses = array();
        $select = ', ' . context_helper::get_preload_record_columns_sql('ctx');
        $join = "LEFT JOIN {context} ctx ON (ctx.instanceid = c.id AND ctx.contextlevel = :contextlevel)";

        $sortorder = 'c.' . $this->get_config('coursesort', 'sortorder') . ' ASC';

        $sql = "SELECT c.id, c.fullname, c.shortname, c.visible $select FROM {course} c $join $where ORDER BY $sortorder";
        $rs = $DB->get_recordset_sql($sql, array('contextlevel' => CONTEXT_COURSE) + $params);
        foreach ($rs as $c) {
            if ($c->id == SITEID or $c->id == $instance->courseid or isset($existing[$c->id])) {
                continue;
            }
            context_helper::preload_from_record($c);
            $coursecontext = context_course::instance($c->id);
            if (!$c->visible and !has_capability('agpu/course:viewhiddencourses', $coursecontext)) {
                continue;
            }
            if (!has_capability('enrol/meta:selectaslinked', $coursecontext)) {
                continue;
            }
            $courses[$c->id] = $coursecontext->get_context_name(false);
        }
        $rs->close();
        return $courses;
    }

    /**
     * Return an array of valid options for the groups.
     *
     * @param context $coursecontext
     * @return array
     */
    protected function get_group_options($coursecontext) {
        $groups = array(0 => get_string('none'));
        $courseid = $coursecontext->instanceid;
        if (has_capability('agpu/course:managegroups', $coursecontext)) {
            $groups[ENROL_META_CREATE_GROUP] = get_string('creategroup', 'enrol_meta');
        }
        foreach (groups_get_all_groups($courseid) as $group) {
            $groups[$group->id] = format_string($group->name, true, array('context' => $coursecontext));
        }
        return $groups;
    }

    /**
     * Add elements to the edit instance form.
     *
     * @param stdClass $instance
     * @param agpuQuickForm $mform
     * @param context $coursecontext
     * @return bool
     */
    public function edit_instance_form($instance, agpuQuickForm $mform, $coursecontext) {
        global $DB;

        $groups = $this->get_group_options($coursecontext);
        $existing = $DB->get_records('enrol', array('enrol' => 'meta', 'courseid' => $coursecontext->instanceid), '', 'customint1, id');

        $excludelist = array($coursecontext->instanceid);
        foreach ($existing as $existinginstance) {
            $excludelist[] = $existinginstance->customint1;
        }

        $options = array(
            'requiredcapabilities' => array('enrol/meta:selectaslinked'),
            'multiple' => empty($instance->id),  // We only accept multiple values on creation.
            'exclude' => $excludelist
        );
        $mform->addElement('course', 'customint1', get_string('linkedcourse', 'enrol_meta'), $options);
        $mform->addRule('customint1', get_string('required'), 'required', null, 'client');
        if (!empty($instance->id)) {
            $mform->freeze('customint1');
        }

        $mform->addElement('select', 'customint2', get_string('addgroup', 'enrol_meta'), $groups);
    }

    /**
     * Perform custom validation of the data used to edit the instance.
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @param object $instance The instance loaded from the DB
     * @param context $context The context of the instance we are editing
     * @return array of "element_name"=>"error_description" if there are errors,
     *         or an empty array if everything is OK.
     * @return void
     */
    public function edit_instance_validation($data, $files, $instance, $context) {
        global $DB;

        $errors = array();
        $thiscourseid = $context->instanceid;

        if (!empty($data['customint1'])) {
            $coursesidarr = is_array($data['customint1']) ? $data['customint1'] : [$data['customint1']];
            list($coursesinsql, $coursesinparams) = $DB->get_in_or_equal($coursesidarr, SQL_PARAMS_NAMED, 'metacourseid');
            if ($coursesrecords = $DB->get_records_select('course', "id {$coursesinsql}",
                $coursesinparams, '', 'id,visible')) {
                // Cast NULL to 0 to avoid possible mess with the SQL.
                $instanceid = $instance->id ?? 0;

                $existssql = "enrol = :meta AND courseid = :currentcourseid AND id != :id AND customint1 {$coursesinsql}";
                $existsparams = [
                    'meta' => 'meta',
                    'currentcourseid' => $thiscourseid,
                    'id' => $instanceid
                ];
                $existsparams += $coursesinparams;
                if ($DB->record_exists_select('enrol', $existssql, $existsparams)) {
                    // We may leave right here as further checks do not make sense in case we have existing enrol records
                    // with the parameters from above.
                    $errors['customint1'] = get_string('invalidcourseid', 'error');
                } else {
                    foreach ($coursesrecords as $coursesrecord) {
                        $coursecontext = context_course::instance($coursesrecord->id);
                        if (!$coursesrecord->visible and !has_capability('agpu/course:viewhiddencourses', $coursecontext)) {
                            $errors['customint1'] = get_string('nopermissions', 'error',
                                'agpu/course:viewhiddencourses');
                        } else if (!has_capability('enrol/meta:selectaslinked', $coursecontext)) {
                            $errors['customint1'] = get_string('nopermissions', 'error',
                                'enrol/meta:selectaslinked');
                        } else if ($coursesrecord->id == SITEID or $coursesrecord->id == $thiscourseid) {
                            $errors['customint1'] = get_string('invalidcourseid', 'error');
                        }
                    }
                }
            } else {
                $errors['customint1'] = get_string('invalidcourseid', 'error');
            }
        } else {
            $errors['customint1'] = get_string('required');
        }

        $validgroups = array_keys($this->get_group_options($context));

        $tovalidate = array(
            'customint2' => $validgroups
        );
        $typeerrors = $this->validate_param_types($data, $tovalidate);
        $errors = array_merge($errors, $typeerrors);

        return $errors;
    }

    /**
     * Check if data is valid for a given enrolment plugin
     *
     * @param array $enrolmentdata enrolment data to validate.
     * @param int|null $courseid Course ID.
     * @return array Errors
     */
    public function validate_enrol_plugin_data(array $enrolmentdata, ?int $courseid = null): array {
        global $DB;

        $errors = parent::validate_enrol_plugin_data($enrolmentdata, $courseid);

        if (isset($enrolmentdata['addtogroup'])) {
            $addtogroup = $enrolmentdata['addtogroup'];
            if (($addtogroup == 1) || ($addtogroup == 0)) {
                if (isset($enrolmentdata['groupname'])) {
                    $errors['erroraddtogroupgroupname'] =
                        new lang_string('erroraddtogroupgroupname', 'group');
                }
            } else {
                $errors['erroraddtogroup'] =
                    new lang_string('erroraddtogroup', 'group');
            }
        }

        if ($courseid) {
            $enrolmentdata = $this->fill_enrol_custom_fields($enrolmentdata, $courseid);

            if (isset($enrolmentdata['groupname']) && $enrolmentdata['groupname']) {
                $groupname = $enrolmentdata['groupname'];
                if (!groups_get_group_by_name($courseid, $groupname)) {
                    $errors['errorinvalidgroup'] =
                        new lang_string('errorinvalidgroup', 'group', $groupname);
                }
            }
        }

        if (!isset($enrolmentdata['metacoursename'])) {
            $errors['missingmandatoryfields'] =
                new lang_string('missingmandatoryfields', 'tool_uploadcourse',
                    'metacoursename');
        } else {
            $metacoursename = $enrolmentdata['metacoursename'];
            $metacourseid = $DB->get_field('course', 'id', ['shortname' => $metacoursename]);

            if (!$metacourseid) {
                $errors['unknownmetacourse'] =
                    new lang_string('unknownmetacourse', 'enrol_meta', $metacoursename);
            }

            if ($courseid && ($courseid == $metacourseid)) {
                $errors['samemetacourse'] =
                    new lang_string('samemetacourse', 'enrol_meta', $metacoursename);
            }
        }
        return $errors;
    }

    /**
     * Fill custom fields data for a given enrolment plugin.
     *
     * @param array $enrolmentdata enrolment data.
     * @param int $courseid Course ID.
     * @return array Updated enrolment data with custom fields info.
     */
    public function fill_enrol_custom_fields(array $enrolmentdata, int $courseid): array {
        global $DB;

        $metacoursename = $enrolmentdata['metacoursename'];
        $enrolmentdata['customint1'] =
            $DB->get_field('course', 'id', ['shortname' => $metacoursename]);

        if (isset($enrolmentdata['addtogroup'])) {
            if ($enrolmentdata['addtogroup'] == 0) {
                $enrolmentdata['customint2'] = 0;
            } else if ($enrolmentdata['addtogroup'] == 1) {
                $enrolmentdata['customint2'] = ENROL_META_CREATE_GROUP;
            }
        } else if (isset($enrolmentdata['groupname'])) {
            $enrolmentdata['customint2'] = groups_get_group_by_name($courseid, $enrolmentdata['groupname']);
        }
        return $enrolmentdata + [
            'customint1' => null,
            'customint2' => null,
        ];
    }

    /**
     * Check if enrolment plugin is supported in csv course upload.
     *
     * @return bool
     */
    public function is_csv_upload_supported(): bool {
        return true;
    }

    /**
     * Finds matching instances for a given course.
     *
     * @param array $enrolmentdata enrolment data.
     * @param int $courseid Course ID.
     * @return stdClass|null Matching instance
     */
    public function find_instance(array $enrolmentdata, int $courseid): ?stdClass {
        global $DB;
        $instances = enrol_get_instances($courseid, false);

        $instance = null;
        if (isset($enrolmentdata['metacoursename'])) {
            $metacourseid = $DB->get_field('course', 'id', ['shortname' => $enrolmentdata['metacoursename']]);
            if ($metacourseid) {
                foreach ($instances as $i) {
                    if ($i->enrol == 'meta' && $i->customint1 == $metacourseid) {
                        $instance = $i;
                        break;
                    }
                }
            }
        }
        return $instance;
    }

    /**
     * Add new instance of enrol plugin with custom settings,
     * called when adding new instance manually or when adding new course.
     * Used for example on course upload.
     *
     * Not all plugins support this.
     *
     * @param stdClass $course Course object
     * @param array|null $fields instance fields
     * @return int|null id of new instance or null if not supported
     */
    public function add_custom_instance(stdClass $course, ?array $fields = null): ?int {
        return $this->add_instance($course, $fields);
    }

    /**
     * Restore instance and map settings.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $course
     * @param int $oldid
     */
    public function restore_instance(restore_enrolments_structure_step $step, stdClass $data, $course, $oldid) {
        global $DB, $CFG;

        if (!$step->get_task()->is_samesite()) {
            // No meta restore from other sites.
            $step->set_mapping('enrol', $oldid, 0);
            return;
        }

        if (!empty($data->customint2)) {
            $data->customint2 = $step->get_mappingid('group', $data->customint2);
        }

        if ($DB->record_exists('course', array('id' => $data->customint1))) {
            $instance = $DB->get_record('enrol', array('roleid' => $data->roleid, 'customint1' => $data->customint1,
                'courseid' => $course->id, 'enrol' => $this->get_name()));
            if ($instance) {
                $instanceid = $instance->id;
            } else {
                $instanceid = $this->add_instance($course, (array)$data);
            }
            $step->set_mapping('enrol', $oldid, $instanceid);

            require_once("$CFG->dirroot/enrol/meta/locallib.php");
            enrol_meta_sync($data->customint1);

        } else {
            $step->set_mapping('enrol', $oldid, 0);
        }
    }

    /**
     * Restore user enrolment.
     *
     * @param restore_enrolments_structure_step $step
     * @param stdClass $data
     * @param stdClass $instance
     * @param int $userid
     * @param int $oldinstancestatus
     */
    public function restore_user_enrolment(restore_enrolments_structure_step $step, $data, $instance, $userid, $oldinstancestatus) {
        global $DB;

        if ($this->get_config('unenrolaction') != ENROL_EXT_REMOVED_SUSPENDNOROLES) {
            // Enrolments were already synchronised in restore_instance(), we do not want any suspended leftovers.
            return;
        }

        // ENROL_EXT_REMOVED_SUSPENDNOROLES means all previous enrolments are restored
        // but without roles and suspended.

        if (!$DB->record_exists('user_enrolments', array('enrolid' => $instance->id, 'userid' => $userid))) {
            $this->enrol_user($instance, $userid, null, $data->timestart, $data->timeend, ENROL_USER_SUSPENDED);
            if ($instance->customint2) {
                groups_add_member($instance->customint2, $userid, 'enrol_meta', $instance->id);
            }
        }
    }

    /**
     * Restore user group membership.
     * @param stdClass $instance
     * @param int $groupid
     * @param int $userid
     */
    public function restore_group_member($instance, $groupid, $userid) {
        // Nothing to do here, the group members are added in $this->restore_group_restored().
        return;
    }

}
