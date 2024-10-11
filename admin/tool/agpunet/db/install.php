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
 * Install script for tool_agpunet.
 *
 * @package   tool_agpunet
 * @copyright 2022 Shamim Rezaie <shamim@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

/**
 * Perform the post-install procedures.
 */
function xmldb_tool_agpunet_install() {
    // Use an ad-hoc task to set the active activity chooser footer plugin to tool_agpunet.
    // We couldn't do this in admin/settings/courses.php for 2 reasons:
    // - First, because it would be a breach of component communications principles to do so there.
    // - Second, because we can't call get_plugins_with_function() during install and upgrade (or it will return []).
    // We couldn't do this directly here either, because there is an admin_apply_default_settings() call after all plugins are
    // installed and that would reset whatever value we set here to 'hidden'.
    $postinstall = new tool_agpunet\task\post_install();
    core\task\manager::queue_adhoc_task($postinstall);
}
