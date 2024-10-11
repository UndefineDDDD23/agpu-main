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

use core\oauth2\client;
use agpu_exception;
use stdClass;
use stored_file;

/**
 * API for sharing agpu LMS resources to agpuNet instances.
 *
 * @package   core
 * @copyright 2023 Safat Shahin <safat.shahin@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class resource_sender {

    /**
     * @var int Backup share format - the content is being shared as a agpu backup file.
     */
    public const SHARE_FORMAT_BACKUP = 0;

    /**
     * @var int Maximum upload file size (1.07 GB).
     */
    public const MAX_FILESIZE = 1070000000;

    /**
     * @var stdClass The course where the activity is located.
     */
    protected stdClass $course;

    /** @var resource_packager Resource packager. */
    protected resource_packager $packager;

    /**
     * Class constructor.
     *
     * @param int $resourceid The resource ID of the resource being shared.
     * @param int $userid The user ID who is sharing the activity.
     * @param agpunet_client $agpunetclient The agpunet_client object used to perform the share.
     * @param client $oauthclient The OAuth 2 client for the agpuNet instance.
     * @param int $shareformat The data format to share in. Defaults to a agpu backup (SHARE_FORMAT_BACKUP).
     * @throws agpu_exception
     */
    public function __construct(
        int $resourceid,
        protected int $userid,
        protected agpunet_client $agpunetclient,
        protected client $oauthclient,
        protected int $shareformat = self::SHARE_FORMAT_BACKUP,
    ) {
        if (!in_array($shareformat, self::get_allowed_share_formats(), true)) {
            throw new agpu_exception('agpunet:invalidshareformat');
        }
    }

    /**
     * Return the list of supported share formats.
     *
     * @return array Array of supported share format values.
     */
    protected static function get_allowed_share_formats(): array {
        return [
            self::SHARE_FORMAT_BACKUP,
        ];
    }

    /**
     * Share a resource to agpuNet.
     *
     * @return array The HTTP response code from agpuNet and the agpuNet draft resource URL (URL empty string on fail).
     *               Format: ['responsecode' => 201, 'drafturl' => 'https://draft.mnurl/here']
     */
    abstract public function share_resource(): array;

    /**
     * Prepare the data for sharing, in the format specified.
     *
     * @return stored_file
     */
    protected function prepare_share_contents(): stored_file {
        return match ($this->shareformat) {
            self::SHARE_FORMAT_BACKUP => $this->packager->get_package(),
            default => throw new \coding_exception("Unknown share format: {$this->shareformat}'"),
        };
    }
}
