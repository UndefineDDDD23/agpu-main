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
 * Definition of log events
 *
 * @package    mod_survey
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$logs = array(
    array('module'=>'survey', 'action'=>'add', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'update', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'download', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'view form', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'view graph', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'view report', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'submit', 'mtable'=>'survey', 'field'=>'name'),
);