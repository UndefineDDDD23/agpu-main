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
 * Settings
 *
 * This file contains settings used by tool_mobile
 *
 * @package    tool_mobile
 * @copyright  2016 Juan Leyva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

use core_admin\local\settings\autocomplete;

if ($hassiteconfig) {

    // We should wait to the installation to finish since we depend on some configuration values that are set once
    // the admin user profile is configured.
    if (!during_initial_install()) {
        $enablemobiledocurl = new agpu_url(get_docs_url('Enable_mobile_web_services'));
        $enablemobiledoclink = html_writer::link($enablemobiledocurl, new lang_string('documentation'));
        $default = is_https() ? 1 : 0;
        $optionalsubsystems = $ADMIN->locate('optionalsubsystems');
        $optionalsubsystems->add(new admin_setting_enablemobileservice('enablemobilewebservice',
                new lang_string('enablemobilewebservice', 'admin'),
                new lang_string('configenablemobilewebservice', 'admin', $enablemobiledoclink), $default));
    }

    $ismobilewsdisabled = empty($CFG->enablemobilewebservice);
    $ADMIN->add('root',
        new admin_category('mobileapp', new lang_string('mobileapp', 'tool_mobile'), $ismobilewsdisabled),
        'development'
    );

    $temp = new admin_settingpage('mobilesettings',
        new lang_string('mobilesettings', 'tool_mobile'),
        'agpu/site:config',
        $ismobilewsdisabled
    );

    $temp->add(new admin_setting_configtext('tool_mobile/apppolicy', new lang_string('apppolicy', 'tool_mobile'),
        new lang_string('apppolicy_help', 'tool_mobile'), '', PARAM_URL));

    $ADMIN->add('mobileapp', $temp);

    $featuresnotice = null;
    if (empty($CFG->disablemobileappsubscription)) {
        // General notification about limited features due to app restrictions.
        $subscriptionurl = (new agpu_url("/$CFG->admin/tool/mobile/subscription.php"))->out(false);
        $notify = new \core\output\notification(
            get_string('agpuappsportalfeatureswarning', 'tool_mobile', $subscriptionurl),
            \core\output\notification::NOTIFY_WARNING);
        $featuresnotice = $OUTPUT->render($notify);
    }

    $hideappsubscription = (isset($CFG->disablemobileappsubscription) && !empty($CFG->disablemobileappsubscription));
    $hideappsubscription = $ismobilewsdisabled || $hideappsubscription;

    $ADMIN->add(
        'mobileapp',
        new admin_externalpage(
            'mobileappsubscription',
            new lang_string('mobileappsubscription', 'tool_mobile'),
            "$CFG->wwwroot/$CFG->admin/tool/mobile/subscription.php",
            'agpu/site:config',
            $hideappsubscription
        )
    );

    // Type of login.
    $temp = new admin_settingpage(
        'mobileauthentication',
        new lang_string('mobileauthentication', 'tool_mobile'),
        'agpu/site:config',
        $ismobilewsdisabled
    );

    $temp->add(new admin_setting_heading('tool_mobile/agpuappsportalfeaturesauth', '', $featuresnotice));

    $options = array(
        tool_mobile\api::LOGIN_VIA_APP => new lang_string('loginintheapp', 'tool_mobile'),
        tool_mobile\api::LOGIN_VIA_BROWSER => new lang_string('logininthebrowser', 'tool_mobile'),
        tool_mobile\api::LOGIN_VIA_EMBEDDED_BROWSER => new lang_string('loginintheembeddedbrowser', 'tool_mobile'),
    );
    $temp->add(new admin_setting_configselect('tool_mobile/typeoflogin',
                new lang_string('typeoflogin', 'tool_mobile'),
                new lang_string('typeoflogin_desc', 'tool_mobile'), 1, $options));

    $options = [
        tool_mobile\api::AUTOLOGOUT_DISABLED => new lang_string('never'),
        tool_mobile\api::AUTOLOGOUT_INMEDIATE => new lang_string('autologoutinmediate', 'tool_mobile'),
        tool_mobile\api::AUTOLOGOUT_CUSTOM => new lang_string('autologoutcustom', 'tool_mobile'),
    ];
    $temp->add(new admin_setting_configselect('tool_mobile/autologout',
        new lang_string('autologout', 'tool_mobile'),
        new lang_string('autologout_desc', 'tool_mobile'), 0, $options));

    $temp->add(new admin_setting_configduration('tool_mobile/autologouttime',
        new lang_string('autologouttime', 'tool_mobile'), '', DAYSECS));
    $temp->hide_if('tool_mobile/autologouttime', 'tool_mobile/autologout', 'neq', tool_mobile\api::AUTOLOGOUT_CUSTOM);

    $options = [
        tool_mobile\api::QR_CODE_DISABLED => new lang_string('qrcodedisabled', 'tool_mobile'),
        tool_mobile\api::QR_CODE_URL => new lang_string('qrcodetypeurl', 'tool_mobile'),
    ];
    $qrcodetypedefault = tool_mobile\api::QR_CODE_URL;

    if (is_https()) {   // Allow QR login for https sites.
        $options[tool_mobile\api::QR_CODE_LOGIN] = new lang_string('qrcodetypelogin', 'tool_mobile');
        $qrcodetypedefault = tool_mobile\api::QR_CODE_LOGIN;
    }

    $temp->add(new admin_setting_configselect('tool_mobile/qrcodetype',
                new lang_string('qrcodetype', 'tool_mobile'),
                new lang_string('qrcodetype_desc', 'tool_mobile'), $qrcodetypedefault, $options));

    $temp->add(new admin_setting_configduration('tool_mobile/qrkeyttl',
        new lang_string('qrkeyttl', 'tool_mobile'),
        new lang_string('qrkeyttl_desc', 'tool_mobile'), tool_mobile\api::LOGIN_QR_KEY_TTL, MINSECS));
    $temp->hide_if('tool_mobile/qrkeyttl', 'tool_mobile/qrcodetype', 'neq', tool_mobile\api::QR_CODE_LOGIN);

    $temp->add(new admin_setting_configcheckbox('tool_mobile/qrsameipcheck',
                new lang_string('qrsameipcheck', 'tool_mobile'),
                new lang_string('qrsameipcheck_desc', 'tool_mobile'), 1));
    $temp->hide_if('tool_mobile/qrsameipcheck', 'tool_mobile/qrcodetype', 'neq', tool_mobile\api::QR_CODE_LOGIN);

    $temp->add(new admin_setting_configtext('tool_mobile/forcedurlscheme',
                new lang_string('forcedurlscheme_key', 'tool_mobile'),
                new lang_string('forcedurlscheme', 'tool_mobile'), 'agpumobile', PARAM_NOTAGS));

    $temp->add(new admin_setting_configtext('tool_mobile/minimumversion',
                new lang_string('minimumversion_key', 'tool_mobile'),
                new lang_string('minimumversion', 'tool_mobile'), '', PARAM_NOTAGS));

    $options = [
        60 => new lang_string('numminutes', '', 1),
        180 => new lang_string('numminutes', '', 3),
        360 => new lang_string('numminutes', '', 6),
        900 => new lang_string('numminutes', '', 15),
        1800 => new lang_string('numminutes', '', 30),
        3600 => new lang_string('numminutes', '', 60)
    ];
    $temp->add(new admin_setting_configselect('tool_mobile/autologinmintimebetweenreq',
        new lang_string('autologinmintimebetweenreq', 'tool_mobile'),
        new lang_string('autologinmintimebetweenreq_desc', 'tool_mobile'), 360, $options));

    $ADMIN->add('mobileapp', $temp);

    // Appearance related settings.
    $temp = new admin_settingpage(
        'mobileappearance',
        new lang_string('mobileappearance', 'tool_mobile'),
        'agpu/site:config',
        $ismobilewsdisabled
    );

    if (!empty($featuresnotice)) {
        $temp->add(new admin_setting_heading('tool_mobile/agpuappsportalfeaturesappearance', '', $featuresnotice));
    }

    $temp->add(new admin_setting_configtext('mobilecssurl', new lang_string('mobilecssurl', 'tool_mobile'),
                new lang_string('configmobilecssurl', 'tool_mobile'), '', PARAM_URL));

    // Reference to Branded Mobile App.
    if (empty($CFG->disableserviceads_branded)) {
        $temp->add(new admin_setting_description('agpubrandedappreference',
            new lang_string('agpubrandedapp', 'admin'),
            new lang_string('agpubrandedappreference', 'admin')
        ));
    }

    $temp->add(new admin_setting_heading('tool_mobile/smartappbanners',
                new lang_string('smartappbanners', 'tool_mobile'), ''));

    $temp->add(new admin_setting_configcheckbox('tool_mobile/enablesmartappbanners',
                new lang_string('enablesmartappbanners', 'tool_mobile'),
                new lang_string('enablesmartappbanners_desc', 'tool_mobile'), 0));

    $temp->add(new admin_setting_configtext('tool_mobile/iosappid', new lang_string('iosappid', 'tool_mobile'),
                new lang_string('iosappid_desc', 'tool_mobile'), tool_mobile\api::DEFAULT_IOS_APP_ID, PARAM_ALPHANUM));

    $temp->add(new admin_setting_configtext('tool_mobile/androidappid', new lang_string('androidappid', 'tool_mobile'),
                new lang_string('androidappid_desc', 'tool_mobile'), tool_mobile\api::DEFAULT_ANDROID_APP_ID, PARAM_NOTAGS));

    $temp->add(new admin_setting_configtext('tool_mobile/setuplink', new lang_string('setuplink', 'tool_mobile'),
        new lang_string('setuplink_desc', 'tool_mobile'), 'https://download.agpu.org/mobile', PARAM_URL));

    $ADMIN->add('mobileapp', $temp);

    // Features related settings.
    $temp = new admin_settingpage(
        'mobilefeatures',
        new lang_string('mobilefeatures', 'tool_mobile'),
        'agpu/site:config',
        $ismobilewsdisabled
    );

    if (!empty($featuresnotice)) {
        $temp->add(new admin_setting_heading('tool_mobile/agpuappsportalfeatures', '', $featuresnotice));
    }

    $temp->add(new admin_setting_heading('tool_mobile/logout',
                new lang_string('logout'), ''));

    $temp->add(new admin_setting_configcheckbox('tool_mobile/forcelogout',
                new lang_string('forcelogout', 'tool_mobile'),
                new lang_string('forcelogout_desc', 'tool_mobile'), 0));

    $temp->add(new admin_setting_heading('tool_mobile/features',
                new lang_string('mobilefeatures', 'tool_mobile'), ''));

    $options = tool_mobile\api::get_features_list();
    $temp->add(new admin_setting_configmultiselect('tool_mobile/disabledfeatures',
                new lang_string('disabledfeatures', 'tool_mobile'),
                new lang_string('disabledfeatures_desc', 'tool_mobile'), array(), $options));

    $temp->add(new admin_setting_configtextarea('tool_mobile/custommenuitems',
                new lang_string('custommenuitems', 'tool_mobile'),
                new lang_string('custommenuitems_desc', 'tool_mobile'), '', PARAM_RAW, '50', '10'));

    // File type exclusionlist.
    $choices = [];
    foreach (core_filetypes::get_types() as $key => $info) {
        $text = '.' . $key;
        if (!empty($info['type'])) {
            $text .= ' (' . $info['type'] . ')';
        }
        $choices[$key] = $text;
    }

    $attributes = [
        'manageurl' => new \agpu_url('/admin/tool/filetypes/index.php'),
        'managetext' => get_string('managefiletypes', 'tool_mobile'),
        'multiple' => true,
        'delimiter' => ',',
        'placeholder' => get_string('filetypeexclusionlistplaceholder', 'tool_mobile')
    ];
    $temp->add(new autocomplete('tool_mobile/filetypeexclusionlist',
        new lang_string('filetypeexclusionlist', 'tool_mobile'),
        new lang_string('filetypeexclusionlist_desc', 'tool_mobile'), array(), $choices, $attributes));

    $temp->add(new admin_setting_heading('tool_mobile/language',
                new lang_string('language'), ''));

    $temp->add(new admin_setting_configtextarea('tool_mobile/customlangstrings',
                new lang_string('customlangstrings', 'tool_mobile'),
                new lang_string('customlangstrings_desc', 'tool_mobile'), '', PARAM_RAW, '50', '10'));

    $ADMIN->add('mobileapp', $temp);
}
