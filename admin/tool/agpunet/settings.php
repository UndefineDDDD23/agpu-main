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
 * Puts the plugin actions into the admin settings tree.
 *
 * @package     tool_agpunet
 * @copyright   2020 Jake Dallimore <jrhdallimore@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

if ($hassiteconfig) {
    // Add an enable subsystem setting to the "Advanced features" settings page.
    $optionalsubsystems = $ADMIN->locate('optionalsubsystems');
    $optionalsubsystems->add(new admin_setting_configcheckbox('tool_agpunet/enableagpunet',
        new lang_string('enableagpunet', 'tool_agpunet'),
        new lang_string('enableagpunet_desc', 'tool_agpunet'),
        1, 1, 0)
    );

    // Create a agpuNet category.
    if (get_config('tool_agpunet', 'enableagpunet')) {
        if (!$ADMIN->locate('agpunet')) {
            $ADMIN->add('root', new admin_category('agpunet', get_string('pluginname', 'tool_agpunet')));
        }
        // Our settings page.
        $settings = new admin_settingpage('tool_agpunet', get_string('agpunetsettings', 'tool_agpunet'));
        $ADMIN->add('agpunet', $settings);

        $temp = new admin_setting_configtext('tool_agpunet/defaultagpunetname',
            get_string('defaultagpunetname', 'tool_agpunet'), new lang_string('defaultagpunetname_desc', 'tool_agpunet'),
            new lang_string('defaultagpunetnamevalue', 'tool_agpunet'));
        $settings->add($temp);

        $temp = new admin_setting_configtext('tool_agpunet/defaultagpunet', get_string('defaultagpunet', 'tool_agpunet'),
            new lang_string('defaultagpunet_desc', 'tool_agpunet'), 'https://agpu.net');
        $settings->add($temp);

    }
}
