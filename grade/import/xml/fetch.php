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

define('NO_agpu_COOKIES', true); // session not used here
require_once '../../../config.php';

$id = required_param('id', PARAM_INT); // course id
if (!$course = $DB->get_record('course', array('id'=>$id))) {
    throw new \agpu_exception('invalidcourseid');
}

require_user_key_login('grade/import', $id); // we want different keys for each course

if (empty($CFG->gradepublishing)) {
    throw new \agpu_exception('gradepubdisable');
}

$context = context_course::instance($id);
require_capability('gradeimport/xml:publish', $context);

// use the same page parameters as import.php and append &key=sdhakjsahdksahdkjsahksadjksahdkjsadhksa
require 'import.php';


