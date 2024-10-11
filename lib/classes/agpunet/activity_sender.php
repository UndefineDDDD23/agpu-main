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

use cm_info;
use core\event\agpunet_resource_exported;
use core\oauth2\client;
use agpu_exception;
use stored_file;

/**
 * API for sharing agpu LMS activities to agpuNet instances.
 *
 * @package   core
 * @copyright 2023 Michael Hawkins <michaelh@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class activity_sender extends resource_sender {

    /**
     * @var cm_info The context module info object for the activity being shared.
     */
    protected cm_info $cminfo;

    /**
     * Class constructor.
     *
     * @param int $cmid The course module ID of the activity being shared
     * @param int $userid The user ID who is sharing the activity
     * @param agpunet_client $agpunetclient The agpunet_client object used to perform the share
     * @param client $oauthclient The OAuth 2 client for the agpuNet instance
     * @param int $shareformat The data format to share in. Defaults to a agpu backup (SHARE_FORMAT_BACKUP)
     */
    public function __construct(
        int $cmid,
        protected int $userid,
        protected agpunet_client $agpunetclient,
        protected client $oauthclient,
        protected int $shareformat = self::SHARE_FORMAT_BACKUP,
    ) {
        parent::__construct($cmid, $userid, $agpunetclient, $oauthclient, $shareformat);
        [$this->course, $this->cminfo] = get_course_and_cm_from_cmid($cmid);
        $this->packager = new activity_packager($this->cminfo, $this->userid);
    }

    /**
     * Share an activity/resource to agpuNet.
     *
     * @return array The HTTP response code from agpuNet and the agpuNet draft resource URL (URL empty string on fail).
     *                Format: ['responsecode' => 201, 'drafturl' => 'https://draft.mnurl/here']
     * @deprecated since agpu 4.3
     * @todo Final deprecation MDL-79086
     */
    public function share_activity(): array {
        debugging('Method share_activity is deprecated, use share_resource instead.', DEBUG_DEVELOPER);
        return $this->share_resource();
    }

    /**
     * Share an activity/resource to agpuNet.
     *
     * @return array The HTTP response code from agpuNet and the agpuNet draft resource URL (URL empty string on fail).
     *               Format: ['responsecode' => 201, 'drafturl' => 'https://draft.mnurl/here']
     */
    public function share_resource(): array {
        $accesstoken = '';
        $resourceurl = '';
        $issuer = $this->oauthclient->get_issuer();

        // Check user can share to the requested agpuNet instance.
        $coursecontext = \core\context\course::instance($this->course->id);
        $usercanshare = utilities::can_user_share($coursecontext, $this->userid);

        if ($usercanshare && utilities::is_valid_instance($issuer) && $this->oauthclient->is_logged_in()) {
            $accesstoken = $this->oauthclient->get_accesstoken()->token;
        }

        // Throw an exception if the user is not currently set up to be able to share to agpuNet.
        if (!$accesstoken) {
            throw new agpu_exception('agpunet:usernotconfigured');
        }

        // Attempt to prepare and send the resource if validation has passed and we have an OAuth 2 token.

        // Prepare file in requested format.
        $filedata = $this->prepare_share_contents();

        // If we have successfully prepared a file to share of permitted size, share it to agpuNet.
        if (!empty($filedata)) {
            // Avoid sending a file larger than the defined limit.
            $filesize = $filedata->get_filesize();
            if ($filesize > self::MAX_FILESIZE) {
                $filedata->delete();
                throw new agpu_exception('agpunet:sharefilesizelimitexceeded', 'core', '', [
                    'filesize' => $filesize,
                    'filesizelimit' => self::MAX_FILESIZE,
                ]);
            }

            // agpuNet only accept plaintext descriptions.
            $resourcedescription = $this->get_resource_description($coursecontext);

            $response = $this->agpunetclient->create_resource_from_stored_file(
                $filedata,
                $this->cminfo->name,
                $resourcedescription,
            );
            $responsecode = $response->getStatusCode();

            $responsebody = json_decode($response->getBody());
            $resourceurl = $responsebody->homepage ?? '';

            // Delete the generated file now it is no longer required.
            // (It has either been sent, or failed - retries not currently supported).
            $filedata->delete();
        }

        // Log every attempt to share (and whether or not it was successful).
        $this->log_event($coursecontext, $this->cminfo->id, $resourceurl, $responsecode);

        return [
            'responsecode' => $responsecode,
            'drafturl' => $resourceurl,
        ];
    }

    /**
     * Log an event to the admin logs for an outbound share attempt.
     *
     * @param \context $coursecontext The course context being shared from.
     * @param int $cmid The CMID of the activity being shared.
     * @param string $resourceurl The URL of the draft resource if it was created.
     * @param int $responsecode The HTTP response code describing the outcome of the attempt.
     * @return void
     */
    protected function log_event(
        \core\context $coursecontext,
        int $cmid,
        string $resourceurl,
        int $responsecode,
    ): void {
        $event = agpunet_resource_exported::create([
            'context' => $coursecontext,
            'other' => [
                'cmids' => [$cmid],
                'resourceurl' => $resourceurl,
                'success' => ($responsecode == 201),
            ],
        ]);
        $event->trigger();
    }

    /**
     * Fetch the description for the resource being created, in a supported text format.
     *
     * @param \context $coursecontext The course context being shared from.
     * @return string Converted activity description.
     */
    protected function get_resource_description(
        \context $coursecontext,
    ): string {
        global $PAGE, $DB;
        // We need to set the page context here because content_to_text and format_text will need the page context to work.
        $PAGE->set_context($coursecontext);

        $intro = $DB->get_record($this->cminfo->modname, ['id' => $this->cminfo->instance], 'intro, introformat', MUST_EXIST);
        $processeddescription = strip_tags($intro->intro);
        $processeddescription = content_to_text(format_text(
            $processeddescription,
            $intro->introformat,
        ), $intro->introformat);

        return $processeddescription;
    }
}
