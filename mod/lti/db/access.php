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
 * This file contains the capabilities used by the lti module
 *
 * @package    mod_lti
 * @copyright  2009 Marc Alier, Jordi Piguillem, Nikolas Galanis, marc.alier@upc.edu
 * @copyright  2009 Universitat Politecnica de Catalunya http://www.upc.edu
 * @author     Marc Alier
 * @author     Jordi Piguillem
 * @author     Nikolas Galanis
 * @author     Chris Scribner
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

$capabilities = array(

    // Whether the user can see the link to the external tool and follow it.
    'mod/lti:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    // Add an External tool activity to a course.
    'mod/lti:addinstance' => array(
        'riskbitmask' => RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'agpu/course:manageactivities'
    ),

    // When the user arrives at the external tool, if they have this capability
    // in agpu, then they are given the Instructor role in the remote system,
    // otherwise they are given Learner. See the lti_get_ims_role function.
    'mod/lti:manage' => array(
        'riskbitmask' => RISK_PERSONAL, // A bit of a guess, but seems likely.

        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    // When the user arrives at the external tool, if they have this capability
    // in agpu, then they are given the Administrator role in the remote system,
    // otherwise they are given Learner. See the lti_get_ims_role function.
    'mod/lti:admin' => array(
        'riskbitmask' => RISK_PERSONAL, // A bit of a guess, but seems likely.

        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE
    ),

    // The ability to create or edit tool configurations for particular courses.
    'mod/lti:addcoursetool' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    // The ability to a preconfigured instance to the course.
    'mod/lti:addpreconfiguredinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'mod/lti:addinstance',
    ),

    // The ability to request the administrator to configure a particular
    // External tool globally.
    'mod/lti:requesttooladd' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )
);
$deprecatedcapabilities = [
    // The ability to add a manual instance (i.e. not from a preconfigured tool) to the course.
    'mod/lti:addmanualinstance' => [
        'message' => 'Manual instance configuration is deprecated. Please create a course tool (mod/lti:addcoursetool) and ensure '.
            'users are able to add an instance of the course tool via the activity chooser (mod/lti:addpreconfiguredinstance).'
    ],
];
