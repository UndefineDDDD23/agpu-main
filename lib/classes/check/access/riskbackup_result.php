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
 * Lists all roles that have the ability to backup user data, as well as users
 *
 * @package    core
 * @category   check
 * @copyright  2020 Brendan Heywood <brendan@catalyst-au.net>
 * @copyright  2008 petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\check\access;

use context;
use stdClass;
use core\check\result;

/**
 * Lists all roles that have the ability to backup user data, as well as users
 *
 * @copyright  2020 Brendan Heywood <brendan@catalyst-au.net>
 * @copyright  2008 petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class riskbackup_result extends \core\check\result {

    /** @var stdClass[] $systemroles */
    private $systemroles;

    /** @var stdClass[] $overriddenroles */
    private $overriddenroles;

    /** @var string $sqluserinfo */
    private $sqluserinfo;

    /**
     * Constructor
     */
    public function __construct() {
        global $DB;

        $syscontext = \context_system::instance();

        $params = array('capability' => 'agpu/backup:userinfo', 'permission' => CAP_ALLOW, 'contextid' => $syscontext->id);
        $sql = "SELECT DISTINCT r.id, r.name, r.shortname, r.sortorder, r.archetype
                  FROM {role} r
                  JOIN {role_capabilities} rc ON rc.roleid = r.id
                 WHERE rc.capability = :capability
                   AND rc.contextid  = :contextid
                   AND rc.permission = :permission";
        $this->systemroles = $DB->get_records_sql($sql, $params);

        // Ensure first field is unique (role.id + role_capabilities.contextid).
        $roleidcontextfield = $DB->sql_concat_join("','", ['r.id', 'rc.contextid']);
        $params = array('capability' => 'agpu/backup:userinfo', 'permission' => CAP_ALLOW, 'contextid' => $syscontext->id);
        $sql = "SELECT DISTINCT {$roleidcontextfield} AS rolecontext, r.id, r.name, r.shortname, r.sortorder, r.archetype,
                       rc.contextid
                  FROM {role} r
                  JOIN {role_capabilities} rc ON rc.roleid = r.id
                 WHERE rc.capability = :capability
                   AND rc.contextid <> :contextid
                   AND rc.permission = :permission";
        $this->overriddenroles = $DB->get_records_sql($sql, $params);

        // List of users that are able to backup personal info
        // note:
        // "sc" is context where is role assigned,
        // "c" is context where is role overridden or system context if in role definition.
        $params = [
            'capability' => 'agpu/backup:userinfo',
            'permission' => CAP_ALLOW,
            'context1' => CONTEXT_COURSE,
            'context2' => CONTEXT_COURSE,
        ];

        $this->sqluserinfo = "
            FROM (SELECT DISTINCT rcx.contextid,
                         rcx.roleid
                    FROM {role_capabilities} rcx
                   WHERE rcx.permission = :permission
                     AND rcx.capability = :capability) rc
            JOIN {context} c ON c.id = rc.contextid
            JOIN {context} sc ON sc.contextlevel <= :context1
            JOIN {role_assignments} ra ON ra.contextid = sc.id AND ra.roleid = rc.roleid
            JOIN {user} u ON u.id = ra.userid AND u.deleted = 0
           WHERE (sc.path = c.path OR
                  sc.path LIKE " . $DB->sql_concat('c.path', "'/%'") . " OR
                   c.path LIKE " . $DB->sql_concat('sc.path', "'/%'") . ")
             AND c.contextlevel <= :context2";

        $usercount = $DB->count_records_sql("SELECT COUNT('x') FROM (SELECT DISTINCT u.id $this->sqluserinfo) userinfo", $params);
        $systemrolecount = empty($this->systemroles) ? 0 : count($this->systemroles);
        $overriddenrolecount = empty($this->overriddenroles) ? 0 : count($this->overriddenroles);

        if (max($usercount, $systemrolecount, $overriddenrolecount) > 0) {
            $this->status = result::WARNING;
        } else {
            $this->status = result::OK;
        }

        $a = (object)array(
            'rolecount' => $systemrolecount,
            'overridecount' => $overriddenrolecount,
            'usercount' => $usercount,
        );
        $this->summary = get_string('check_riskbackup_warning', 'report_security', $a);
    }

    /**
     * Showing the full list of roles may be slow so defer it
     *
     * @return string
     */
    public function get_details(): string {

        global $CFG, $DB;

        $details = '';

        // Make a list of roles.
        if ($this->systemroles) {
            $links = array();
            foreach ($this->systemroles as $role) {
                $role->name = role_get_name($role);
                $role->url = (new \agpu_url('/admin/roles/manage.php', ['action' => 'edit', 'roleid' => $role->id]))->out();
                $links[] = \html_writer::tag('li', get_string('check_riskbackup_editrole', 'report_security', $role));
            }
            $links = \html_writer::tag('ul', implode('', $links));
            $details .= get_string('check_riskbackup_details_systemroles', 'report_security', $links);
        }

        // Make a list of overrides to roles.
        if ($this->overriddenroles) {
            $links = array();
            foreach ($this->overriddenroles as $role) {
                $context = context::instance_by_id($role->contextid);
                $role->name = role_get_name($role, $context, ROLENAME_BOTH);
                $role->contextname = $context->get_context_name();
                $role->url = (new \agpu_url('/admin/roles/override.php',
                    ['contextid' => $role->contextid, 'roleid' => $role->id]))->out();
                $links[] = \html_writer::tag('li', get_string('check_riskbackup_editoverride', 'report_security', $role));
            }
            $links = \html_writer::tag('ul', implode('', $links));
            $details .= get_string('check_riskbackup_details_overriddenroles', 'report_security', $links);
        }

        // Get a list of affected users as well.
        $users = array();

        list($sort, $sortparams) = users_order_by_sql('u');
        $params = [
            'capability' => 'agpu/backup:userinfo',
            'permission' => CAP_ALLOW,
            'context1' => CONTEXT_COURSE,
            'context2' => CONTEXT_COURSE,
        ];
        $userfieldsapi = \core_user\fields::for_userpic();
        $userfields = $userfieldsapi->get_sql('u', false, '', '', false)->selects;
        $rs = $DB->get_recordset_sql("
            SELECT DISTINCT $userfields,
                            ra.contextid,
                            ra.roleid
                            $this->sqluserinfo
                   ORDER BY $sort", array_merge($params, $sortparams));

        foreach ($rs as $user) {
            $context = \context::instance_by_id($user->contextid);
            $url = new \agpu_url('/admin/roles/assign.php', ['contextid' => $user->contextid, 'roleid' => $user->roleid]);
            $a = (object)array(
                'fullname' => fullname($user),
                'url' => $url->out(),
                'email' => s($user->email),
                'contextname' => $context->get_context_name(),
            );
            $users[] = \html_writer::tag('li', get_string('check_riskbackup_unassign', 'report_security', $a));
        }
        $rs->close();
        if (!empty($users)) {
            $users = \html_writer::tag('ul', implode('', $users));
            $details .= get_string('check_riskbackup_details_users', 'report_security', $users);
        }

        return $details;
    }
}

