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
 * Definition of log events for the quiz module.
 *
 * @package    mod_quiz
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$logs = [
    ['module' => 'quiz', 'action' => 'add', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'update', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'view', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'report', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'attempt', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'submit', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'review', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'editquestions', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'preview', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'start attempt', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'close attempt', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'continue attempt', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'edit override', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'delete override', 'mtable' => 'quiz', 'field' => 'name'],
    ['module' => 'quiz', 'action' => 'view summary', 'mtable' => 'quiz', 'field' => 'name'],
];
