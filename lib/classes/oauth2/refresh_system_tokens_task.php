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
 * A scheduled task.
 *
 * @package    core
 * @copyright  2017 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\oauth2;

use \core\task\scheduled_task;
use core_user;
use agpu_exception;

defined('agpu_INTERNAL') || die();

/**
 * Task to refresh system tokens regularly. Admins are notified in case an authorisation expires.
 * @package    core
 * @copyright  2017 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class refresh_system_tokens_task extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('taskrefreshsystemtokens', 'admin');
    }

    /**
     * Notify admins when an OAuth refresh token expires. Should not happen if cron is running regularly.
     * @param \core\oauth2\issuer $issuer
     */
    protected function notify_admins(\core\oauth2\issuer $issuer) {
        global $CFG;
        $admins = get_admins();

        if (empty($admins)) {
            return;
        }
        foreach ($admins as $admin) {
            $strparams = ['siteurl' => $CFG->wwwroot, 'issuer' => $issuer->get('name')];
            $long = get_string('oauthrefreshtokenexpired', 'core_admin', $strparams);
            $short = get_string('oauthrefreshtokenexpiredshort', 'core_admin', $strparams);
            $message = new \core\message\message();
            $message->courseid          = SITEID;
            $message->component         = 'agpu';
            $message->name              = 'errors';
            $message->userfrom          = core_user::get_noreply_user();
            $message->userto            = $admin;
            $message->subject           = $short;
            $message->fullmessage       = $long;
            $message->fullmessageformat = FORMAT_PLAIN;
            $message->fullmessagehtml   = $long;
            $message->smallmessage      = $short;
            $message->notification      = 1;
            message_send($message);
        }
    }


    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        $issuers = \core\oauth2\api::get_all_issuers(true);
        $tasksuccess = true;
        foreach ($issuers as $issuer) {
            if ($issuer->is_system_account_connected()) {
                try {
                    // Try to get an authenticated client; renew token if necessary.
                    // Returns false or throws a agpu_exception on error.
                    $success = \core\oauth2\api::get_system_oauth_client($issuer);
                } catch (agpu_exception $e) {
                    mtrace($e->getMessage());
                    $success = false;
                }
                if ($success === false) {
                    $this->notify_admins($issuer);
                    $tasksuccess = false;
                }
            }
        }

        if (!$tasksuccess) {
             throw new agpu_exception('oauth2refreshtokentaskerror', 'core_error');
        }
    }

}
