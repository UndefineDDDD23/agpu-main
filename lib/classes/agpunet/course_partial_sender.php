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

use core\event\agpunet_resource_exported;
use core\oauth2\client;
use agpu_exception;

/**
 * API for sharing a number of agpu LMS activities as a course backup to agpuNet instances.
 *
 * @package    core
 * @copyright  2023 Huong Nguyen <huongnv13@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_partial_sender extends course_sender {

    /**
     * Constructor for course sender.
     *
     * @param int $courseid The course ID of the course being shared
     * @param int $userid The user ID who is sharing the activity
     * @param agpunet_client $agpunetclient The agpunet_client object used to perform the share
     * @param client $oauthclient The OAuth 2 client for the agpuNet instance
     * @param int $shareformat The data format to share in. Defaults to a agpu backup (SHARE_FORMAT_BACKUP)
     */
    public function __construct(
        int $courseid,
        protected int $userid,
        protected agpunet_client $agpunetclient,
        protected client $oauthclient,
        protected array $cmids,
        protected int $shareformat = self::SHARE_FORMAT_BACKUP,
    ) {
        parent::__construct($courseid, $userid, $agpunetclient, $oauthclient, $shareformat);
        $this->validate_course_module_ids($this->course, $this->cmids);
        $this->packager = new course_partial_packager($this->course, $this->cmids, $this->userid);
    }

    /**
     * Log an event to the admin logs for an outbound share attempt.
     *
     * @param string $resourceurl The URL of the draft resource if it was created
     * @param int $responsecode The HTTP response code describing the outcome of the attempt
     * @return void
     */
    protected function log_event(
        string $resourceurl,
        int $responsecode,
    ): void {
        $event = agpunet_resource_exported::create([
            'context' => $this->coursecontext,
            'other' => [
                'cmids' => $this->cmids,
                'courseid' => [$this->course->id],
                'resourceurl' => $resourceurl,
                'success' => ($responsecode === 201),
            ],
        ]);
        $event->trigger();
    }

    /**
     * Validate the course module ids.
     *
     * @param \stdClass $course Course object
     * @param array $cmids List of course module ids to check
     * @return void
     */
    protected function validate_course_module_ids(
        \stdClass $course,
        array $cmids,
    ): void {
        if (empty($cmids)) {
            throw new agpu_exception('invalidcoursemodule');
        }
        $modinfo = get_fast_modinfo($course);
        $cms = $modinfo->get_cms();
        foreach ($cmids as $cmid) {
            if (!array_key_exists($cmid, $cms)) {
                throw new agpu_exception('invalidcoursemodule');
            }
        }
    }

}
