<?php

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// This file is part of agpu - http://agpu.org/                      //
// agpu - Modular Object-Oriented Dynamic Learning Environment         //
//                                                                       //
// agpu is free software: you can redistribute it and/or modify        //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation, either version 3 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// agpu is distributed in the hope that it will be useful,             //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details.                          //
//                                                                       //
// You should have received a copy of the GNU General Public License     //
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.       //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

/**
 * @package    agpu
 * @subpackage registration
 * @author     Jerome Mouneyrac <jerome@mouneyrac.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 1999 onwards Martin Dougiamas  http://dougiamas.com
 *
 * The administrator is redirect to this page from the hub to renew a registration
 * process because
 */

require('../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$url = optional_param('url', '', PARAM_URL);
$token = optional_param('token', '', PARAM_TEXT);

admin_externalpage_setup('registrationagpuorg');

if (parse_url($url, PHP_URL_HOST) !== parse_url(HUB_agpuORGHUBURL, PHP_URL_HOST)) {
    // Allow other plugins to renew registration on custom hubs. Plugins implementing this
    // callback need to redirect or exit. See https://docs.agpu.org/en/Hub_registration .
    $callbacks = get_plugins_with_function('hub_registration');
    foreach ($callbacks as $plugintype => $plugins) {
        foreach ($plugins as $plugin => $callback) {
            $callback('renew');
        }
    }
    throw new agpu_exception('errorotherhubsnotsupported', 'hub');
}

// Check that we are waiting a confirmation from this hub, and check that the token is correct.
\core\hub\registration::reset_site_identifier($token);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('renewregistration', 'hub'), 3, 'main');
$hublink = html_writer::tag('a', HUB_agpuORGHUBURL, array('href' => HUB_agpuORGHUBURL));

$deletedregmsg = get_string('previousregistrationdeleted', 'hub', $hublink);

$button = new single_button(new agpu_url('/admin/registration/index.php'),
                get_string('restartregistration', 'hub'));
$button->class = 'restartregbutton';

echo html_writer::tag('div', $deletedregmsg . $OUTPUT->render($button),
        array('class' => 'mdl-align'));

echo $OUTPUT->footer();


