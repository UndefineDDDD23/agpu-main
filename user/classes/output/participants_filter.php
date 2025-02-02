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
 * Class for rendering user filters on the course participants page.
 *
 * @package    core_user
 * @copyright  2020 Michael Hawkins <michaelh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_user\output;

use core_user\fields;
use renderer_base;
use stdClass;

/**
 * Class for rendering user filters on the course participants page.
 *
 * @copyright  2020 Michael Hawkins <michaelh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class participants_filter extends \core\output\datafilter {

    /**
     * Get data for all filter types.
     *
     * @return array
     */
    protected function get_filtertypes(): array {
        $filtertypes = [];

        $filtertypes[] = $this->get_keyword_filter();

        if ($filtertype = $this->get_enrolmentstatus_filter()) {
            $filtertypes[] = $filtertype;
        }

        if ($filtertype = $this->get_roles_filter()) {
            $filtertypes[] = $filtertype;
        }

        if ($filtertype = $this->get_enrolments_filter()) {
            $filtertypes[] = $filtertype;
        }

        if ($filtertype = $this->get_groups_filter()) {
            $filtertypes[] = $filtertype;
        }

        if ($filtertype = $this->get_accesssince_filter()) {
            $filtertypes[] = $filtertype;
        }

        if ($filtertype = $this->get_country_filter()) {
            $filtertypes[] = $filtertype;
        }

        return $filtertypes;
    }

    /**
     * Get data for the enrolment status filter.
     *
     * @return stdClass|null
     */
    protected function get_enrolmentstatus_filter(): ?stdClass {
        if (!has_capability('agpu/course:enrolreview', $this->context)) {
            return null;
        }

        return $this->get_filter_object(
            'status',
            get_string('participationstatus', 'core_enrol'),
            false,
            true,
            null,
            [
                (object) [
                    'value' => ENROL_USER_ACTIVE,
                    'title' => get_string('active'),
                ],
                (object) [
                    'value' => ENROL_USER_SUSPENDED,
                    'title'  => get_string('inactive'),
                ],
            ]
        );
    }

    /**
     * Get data for the roles filter.
     *
     * @return stdClass|null
     */
    protected function get_roles_filter(): ?stdClass {
        $roles = [];
        $roles += [-1 => get_string('noroles', 'role')];
        $roles += get_viewable_roles($this->context, null, ROLENAME_BOTH);

        if (has_capability('agpu/role:assign', $this->context)) {
            $roles += get_assignable_roles($this->context, ROLENAME_BOTH);
        }

        return $this->get_filter_object(
            'roles',
            get_string('roles', 'core_role'),
            false,
            true,
            null,
            array_map(function($id, $title) {
                return (object) [
                    'value' => $id,
                    'title' => $title,
                ];
            }, array_keys($roles), array_values($roles))
        );
    }

    /**
     * Get data for the roles filter.
     *
     * @return stdClass|null
     */
    protected function get_enrolments_filter(): ?stdClass {
        if (!has_capability('agpu/course:enrolreview', $this->context)) {
            return null;
        }

        if ($this->course->id == SITEID) {
            // No enrolment methods for the site.
            return null;
        }

        $instances = enrol_get_instances($this->course->id, true);
        $plugins = enrol_get_plugins(false);

        return $this->get_filter_object(
            'enrolments',
            get_string('enrolmentinstances', 'core_enrol'),
            false,
            true,
            null,
            array_filter(array_map(function($instance) use ($plugins): ?stdClass {
                if (!array_key_exists($instance->enrol, $plugins)) {
                    return null;
                }

                return (object) [
                    'value' => $instance->id,
                    'title' => $plugins[$instance->enrol]->get_instance_name($instance),
                ];
            }, array_values($instances)))
        );
    }

    /**
     * Get data for the groups filter.
     *
     * @return stdClass|null
     */
    protected function get_groups_filter(): ?stdClass {
        global $USER;

        // Filter options for groups, if available.
        $seeallgroups = has_capability('agpu/site:accessallgroups', $this->context);
        $seeallgroups = $seeallgroups || ($this->course->groupmode != SEPARATEGROUPS);
        if ($seeallgroups) {
            $groups = [];
            $groups += [USERSWITHOUTGROUP => (object) [
                    'id' => USERSWITHOUTGROUP,
                    'name' => get_string('nogroup', 'group'),
                ]];
            $groups += groups_get_all_groups($this->course->id);
        } else {
            // Otherwise, just list the groups the user belongs to.
            $groups = groups_get_all_groups($this->course->id, $USER->id);
        }

        // Return no data if no groups found (which includes if the only value is 'No group').
        if (empty($groups) || (count($groups) === 1 && array_key_exists(-1, $groups))) {
            return null;
        }

        return $this->get_filter_object(
            'groups',
            get_string('groups', 'core_group'),
            false,
            true,
            null,
            array_map(function($group) {
                return (object) [
                    'value' => $group->id,
                    'title' => format_string($group->name, true, ['context' => $this->context]),
                ];
            }, array_values($groups))
        );
    }

    /**
     * Get data for the accesssince filter.
     *
     * @return stdClass|null
     */
    protected function get_accesssince_filter(): ?stdClass {
        global $CFG, $DB;

        $hiddenfields = [];
        if (!has_capability('agpu/course:viewhiddenuserfields', $this->context)) {
            $hiddenfields = array_flip(explode(',', $CFG->hiddenuserfields));
        }

        if (array_key_exists('lastaccess', $hiddenfields)) {
            return null;
        }

        // Get minimum lastaccess for this course and display a dropbox to filter by lastaccess going back this far.
        // We need to make it diferently for normal courses and site course.
        if (!($this->course->id == SITEID)) {
            // Regular course.
            $params = [
                'courseid' => $this->course->id,
                'timeaccess' => 0,
            ];
            $select = 'courseid = :courseid AND timeaccess != :timeaccess';
            $minlastaccess = $DB->get_field_select('user_lastaccess', 'MIN(timeaccess)', $select, $params);

            // Determine enrolled users, who do not have accompanying lastaccess to the course.
            [$enrolledsql, $enrolledparams] = get_enrolled_sql($this->context);

            $sql = "SELECT 'x'
                     FROM {user} u
                     JOIN ({$enrolledsql}) je ON je.id = u.id
                LEFT JOIN {user_lastaccess} ula ON ula.userid = je.id AND ula.courseid = :courseid
                    WHERE COALESCE(ula.timeaccess, 0) = :timeaccess";

            $lastaccess0exists = $DB->record_exists_sql($sql, array_merge($params, $enrolledparams));
        } else {
            // Front page.
            $params = ['lastaccess' => 0];
            $select = 'lastaccess != :lastaccess';
            $minlastaccess = $DB->get_field_select('user', 'MIN(lastaccess)', $select, $params);
            $lastaccess0exists = $DB->record_exists('user', $params);
        }

        $now = usergetmidnight(time());

        $getoptions = function(int $count, string $singletype, string $type) use ($now, $minlastaccess): array {
            $values = [];
            for ($i = 1; $i <= $count; $i++) {
                $timestamp = strtotime("-{$i} {$type}", $now);
                if ($timestamp < $minlastaccess) {
                    break;
                }

                if ($i === 1) {
                    $title = get_string("num{$singletype}", 'agpu', $i);
                } else {
                    $title = get_string("num{$type}", 'agpu', $i);
                }

                $values[] = [
                    'value' => $timestamp,
                    'title' => $title,
                ];
            }

            return $values;
        };

        $values = array_merge(
            $getoptions(6, 'day', 'days'),
            $getoptions(10, 'week', 'weeks'),
            $getoptions(11, 'month', 'months'),
            $getoptions(1, 'year', 'years')
        );

        if ($lastaccess0exists) {
            $values[] = [
                'value' => -1,
                'title' => get_string('never', 'agpu'),
            ];
        }

        if (count($values) <= 1) {
            // Nothing to show.
            return null;
        }

        return $this->get_filter_object(
            'accesssince',
            get_string('usersnoaccesssince'),
            false,
            false,
            null,
            $values
        );
    }

    /**
     * Get data for the country filter
     *
     * @return stdClass|null
     */
    protected function get_country_filter(): ?stdClass {
        $extrauserfields = fields::get_identity_fields($this->context, false);
        if (array_search('country', $extrauserfields) === false) {
            return null;
        }

        $countries = get_string_manager()->get_list_of_countries(true);

        return $this->get_filter_object(
            'country',
            get_string('country'),
            false,
            true,
            'core/datafilter/filtertypes/country',
            array_map(function(string $code, string $name): stdClass {
                return (object) [
                    'value' => $code,
                    'title' => $name,
                ];
            }, array_keys($countries), array_values($countries))
        );
    }

    /**
     * Get data for the keywords filter.
     *
     * @return stdClass|null
     */
    protected function get_keyword_filter(): ?stdClass {
        return $this->get_filter_object(
            'keywords',
            get_string('filterbykeyword', 'core_user'),
            true,
            true,
            'core/datafilter/filtertypes/keyword',
            [],
            true
        );
    }

    /**
     * Export the renderer data in a mustache template friendly format.
     *
     * @param renderer_base $output Unused.
     * @return stdClass Data in a format compatible with a mustache template.
     */
    public function export_for_template(renderer_base $output): stdClass {
        return (object) [
            'tableregionid' => $this->tableregionid,
            'courseid' => $this->context->instanceid,
            'filtertypes' => $this->get_filtertypes(),
            'rownumber' => 1,
        ];

        return $data;
    }
}
