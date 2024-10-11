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

namespace core\agpunet;

use backup;
use backup_controller;
use stdClass;

defined('agpu_INTERNAL') || die();

require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');

/**
 * Packager to prepare appropriate backup of a course to share to agpuNet.
 *
 * @package   core
 * @copyright 2023 Safat Shahin <safat.shahin@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_packager extends resource_packager {

    /**
     * Constructor for course packager.
     *
     * @param stdClass $course The course to package
     * @param int $userid The ID of the user performing the packaging
     */
    public function __construct(
        stdClass $course,
        int $userid,
    ) {
        parent::__construct($course, $userid, $course->shortname);
    }

    /**
     * Get the backup controller for the course.
     *
     * @return backup_controller the backup controller for the course.
     */
    protected function get_backup_controller(): backup_controller {
        return new backup_controller(
            backup::TYPE_1COURSE,
            $this->course->id,
            backup::FORMAT_agpu,
            backup::INTERACTIVE_NO,
            backup::MODE_GENERAL,
            $this->userid,
        );
    }
}
