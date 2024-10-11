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
 * Module admin settings.
 *
 * @package    mod_h5pactivity
 * @copyright  2023 Sara Arjona (sara@agpu.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('mod_h5pactivity/enablesavestate',
        get_string('enablesavestate', 'mod_h5pactivity'), get_string('enablesavestate_help', 'mod_h5pactivity'), 1));

    $settings->add(new admin_setting_configtext('mod_h5pactivity/savestatefreq',
        get_string('savestatefreq', 'mod_h5pactivity'), get_string('savestatefreq_help', 'mod_h5pactivity'), 60, PARAM_INT));
}
