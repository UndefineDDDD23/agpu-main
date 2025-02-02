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
 * Definition of assignment scheduled tasks.
 *
 * @package   mod_assign
 * @copyright 2019 Simey Lameze <simey@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('agpu_INTERNAL') || die();
$tasks = array(
    array(
        'classname' => '\mod_assign\task\cron_task',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*'
    ),
    [
        'classname' => '\mod_assign\task\queue_all_assignment_due_soon_notification_tasks',
        'blocking' => 0,
        'minute' => 'R',
        'hour' => '*/2',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
    ],
    [
        'classname' => '\mod_assign\task\queue_all_assignment_overdue_notification_tasks',
        'blocking' => 0,
        'minute' => 'R',
        'hour' => '*/1',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
    ],
    [
        'classname' => '\mod_assign\task\queue_all_assignment_due_digest_notification_tasks',
        'blocking' => 0,
        'minute' => 'R',
        'hour' => '1',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
    ],
);
