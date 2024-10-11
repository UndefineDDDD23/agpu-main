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

namespace core_backup;

use backup_course_task;

defined('agpu_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/agpu2/backup_course_task.class.php');

/**
 * Tests for encoding content links in backup_course_task.
 *
 * The code that this tests is actually in backup/agpu2/backup_course_task.class.php,
 * but there is no place for unit tests near there, and perhaps one day it will
 * be refactored so it becomes more generic.
 *
 * @package    core_backup
 * @category   test
 * @copyright  2013 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_encode_content_test extends \basic_testcase {

    /**
     * Test the encode_content_links method for course.
     */
    public function test_course_encode_content_links(): void {
        global $CFG;
        $httpsroot = "https://agpu.org";
        $httproot = "http://agpu.org";
        $oldroot = $CFG->wwwroot;

        // HTTPS root and links of both types in content.
        $CFG->wwwroot = $httpsroot;
        $encoded = backup_course_task::encode_content_links(
            $httproot . '/course/view.php?id=123, ' .
            $httpsroot . '/course/view.php?id=123, ' .
            $httpsroot . '/grade/index.php?id=123, ' .
            $httpsroot . '/grade/report/index.php?id=123, ' .
            $httpsroot . '/badges/index.php?type=2&id=123, ' .
            $httpsroot . '/user/index.php?id=123, ' .
            $httpsroot . '/pluginfile.php/123 and ' .
            urlencode($httpsroot . '/pluginfile.php/123') . '.'
        );
        $this->assertEquals('$@COURSEVIEWBYID*123@$, $@COURSEVIEWBYID*123@$, $@GRADEINDEXBYID*123@$, ' .
                '$@GRADEREPORTINDEXBYID*123@$, $@BADGESVIEWBYID*123@$, $@USERINDEXVIEWBYID*123@$, ' .
                '$@PLUGINFILEBYCONTEXT*123@$ and $@PLUGINFILEBYCONTEXTURLENCODED*123@$.', $encoded);

        // HTTP root and links of both types in content.
        $CFG->wwwroot = $httproot;
        $encoded = backup_course_task::encode_content_links(
            $httproot . '/course/view.php?id=123, ' .
            $httpsroot . '/course/view.php?id=123, ' .
            $httproot . '/grade/index.php?id=123, ' .
            $httproot . '/grade/report/index.php?id=123, ' .
            $httproot . '/badges/index.php?type=2&id=123, ' .
            $httproot . '/user/index.php?id=123, ' .
            $httproot . '/pluginfile.php/123 and ' .
            urlencode($httproot . '/pluginfile.php/123') . '.'
        );
        $this->assertEquals('$@COURSEVIEWBYID*123@$, $@COURSEVIEWBYID*123@$, $@GRADEINDEXBYID*123@$, ' .
                '$@GRADEREPORTINDEXBYID*123@$, $@BADGESVIEWBYID*123@$, $@USERINDEXVIEWBYID*123@$, ' .
                '$@PLUGINFILEBYCONTEXT*123@$ and $@PLUGINFILEBYCONTEXTURLENCODED*123@$.', $encoded);
        $CFG->wwwroot = $oldroot;
    }
}