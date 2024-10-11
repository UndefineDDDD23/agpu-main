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
 * Report insights webservice definitions.
 *
 * @package    report_insights
 * @copyright  2017 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$functions = array(

    'report_insights_set_notuseful_prediction' => array(
        'classname'   => 'report_insights\external',
        'methodname'  => 'set_notuseful_prediction',
        'description' => 'Flags the prediction as not useful.',
        'type'        => 'write',
        'ajax'          => true,
        'services'    => array(agpu_OFFICIAL_MOBILE_SERVICE)
    ),

    'report_insights_set_fixed_prediction' => array(
        'classname'   => 'report_insights\external',
        'methodname'  => 'set_fixed_prediction',
        'description' => 'Flags a prediction as fixed.',
        'type'        => 'write',
        'services'    => array(agpu_OFFICIAL_MOBILE_SERVICE),
        'ajax'          => true,
    ),

    'report_insights_action_executed' => array(
        'classname'   => 'report_insights\external',
        'methodname'  => 'action_executed',
        'description' => 'Stores an action executed over a group of predictions.',
        'type'        => 'write',
        'services'    => array(agpu_OFFICIAL_MOBILE_SERVICE),
        'ajax'          => true,
    )

);

