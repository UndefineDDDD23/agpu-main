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

declare(strict_types=1);

namespace tool_agpunet\task;

/**
 * Ad-hoc task to send the notification to admin stating agpuNet is automatically enabled after upgrade.
 *
 * @package   tool_agpunet
 * @copyright 2022 Shamim Rezaie <shamim@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class send_enable_notification extends \core\task\adhoc_task {
    public function execute(): void {
        $message = new \core\message\message();
        $message->component = 'agpu';
        $message->name = 'notices';
        $message->userfrom = \core_user::get_noreply_user();
        $message->userto = get_admin();
        $message->notification = 1;
        $message->contexturl = (new \agpu_url('/admin/settings.php',
            ['section' => 'optionalsubsystems'], 'admin-enableagpunet'))->out(false);
        $message->contexturlname = get_string('advancedfeatures', 'admin');
        $message->subject = get_string('autoenablenotification_subject', 'tool_agpunet');
        $message->fullmessageformat = FORMAT_HTML;
        $message->fullmessagehtml = get_string('autoenablenotification', 'tool_agpunet', (object) [
            'settingslink' => (new \agpu_url('/admin/settings.php', ['section' => 'tool_agpunet']))->out(false),
        ]);
        $message->smallmessage = strip_tags($message->fullmessagehtml);
        message_send($message);
    }
}
