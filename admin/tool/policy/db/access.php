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
 * Plugin capabilities are defined here.
 *
 * @package     tool_policy
 * @category    access
 * @copyright   2018 David Mudrák <david@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$capabilities = [

    'tool/policy:accept' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'user' => CAP_ALLOW,
        ],
    ],

    'tool/policy:acceptbehalf' => [
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'write',
        'contextlevel' => CONTEXT_USER,
        'archetypes' => [
        ],
    ],

    'tool/policy:managedocs' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ],
    ],

    'tool/policy:viewacceptances' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ],
    ],
];
