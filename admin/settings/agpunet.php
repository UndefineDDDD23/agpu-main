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
 * This file gives information about agpuNet.
 *
 * @package    core
 * @copyright  2023 Huong Nguyen <huongnv13@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

if ($hassiteconfig) {
    if (!empty($CFG->enablesharingtoagpunet)) {
        if (!$ADMIN->locate('agpunet')) {
            $ADMIN->add('root', new admin_category('agpunet', get_string('pluginname', 'tool_agpunet')));
        }

        // Outbound settings page.
        $settings = new admin_settingpage('agpunetoutbound', new lang_string('agpunet:outboundsettings', 'agpu'));
        $ADMIN->add('agpunet', $settings);

        // Get all the issuers.
        $issuers = \core\oauth2\api::get_all_issuers();
        $oauth2services = [
            '' => new lang_string('none', 'admin'),
        ];
        foreach ($issuers as $issuer) {
            // Get the enabled issuer with the service type is agpuNet only.
            if ($issuer->get('servicetype') == 'agpunet' && $issuer->get('enabled')) {
                $oauth2services[$issuer->get('id')] = s($issuer->get('name'));
            }
        }

        $url = new \agpu_url('/admin/tool/oauth2/issuers.php');

        $settings->add(new admin_setting_configselect('agpunet/oauthservice', new lang_string('issuer', 'auth_oauth2'),
            new lang_string('agpunet:configoauthservice', 'agpu', $url->out()), '', $oauth2services));

    }
}
