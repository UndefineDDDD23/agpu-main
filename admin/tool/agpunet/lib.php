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
 * This page lists public api for tool_agpunet plugin.
 *
 * @package    tool_agpunet
 * @copyright  2020 Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU
 */

defined('agpu_INTERNAL') || die;

use \core_course\local\entity\activity_chooser_footer;

/**
 * The default endpoint to agpuNet.
 */
define('agpuNET_DEFAULT_ENDPOINT', "lms/agpu/search");

/**
 * Generate the endpoint url to the user's agpunet site.
 *
 * @param string $profileurl The user's agpunet profile page
 * @param int $course The agpu course the mnet resource will be added to
 * @param int $section The section of the course will be added to. Defaults to the 0th element.
 * @return string the resulting endpoint
 * @throws agpu_exception
 */
function generate_mnet_endpoint(string $profileurl, int $course, int $section = 0) {
    global $CFG;
    $urlportions = explode('@', $profileurl);
    $domain = end($urlportions);
    $parsedurl = parse_url($domain);
    $params = [
        'site' => $CFG->wwwroot,
        'course' => $course,
        'section' => $section
    ];
    $endpoint = new agpu_url(agpuNET_DEFAULT_ENDPOINT, $params);
    return (isset($parsedurl['scheme']) ? $domain : "https://$domain")."/{$endpoint->out(false)}";
}

/**
 * Hooking function to build up the initial Activity Chooser footer information for agpuNet
 *
 * @param int $courseid The course the user is currently in and wants to add resources to
 * @param int $sectionid The section the user is currently in and wants to add resources to
 * @return activity_chooser_footer
 * @throws dml_exception
 * @throws agpu_exception
 */
function tool_agpunet_custom_chooser_footer(int $courseid, int $sectionid): activity_chooser_footer {
    global $CFG, $USER, $OUTPUT;
    $defaultlink = get_config('tool_agpunet', 'defaultagpunet');
    $enabled = get_config('tool_agpunet', 'enableagpunet');

    $advanced = false;
    // We are in the agpuNet lib. It is safe assume we have our own functions here.
    $mnetprofile = \tool_agpunet\profile_manager::get_agpunet_user_profile($USER->id);
    if ($mnetprofile !== null) {
        $advanced = $mnetprofile->get_domain() ?? false;
    }

    $defaultlink = generate_mnet_endpoint($defaultlink, $courseid, $sectionid);
    if ($advanced !== false) {
        $advanced = generate_mnet_endpoint($advanced, $courseid, $sectionid);
    }

    $renderedfooter = $OUTPUT->render_from_template('tool_agpunet/chooser_footer', (object)[
        'enabled' => (bool)$enabled,
        'generic' => $defaultlink,
        'advanced' => $advanced,
        'courseID' => $courseid,
        'sectionnum' => $sectionid,
        'img' => $OUTPUT->image_url('agpuNet', 'tool_agpunet')->out(false),
    ]);

    $renderedcarousel = $OUTPUT->render_from_template('tool_agpunet/chooser_agpunet', (object)[
        'buttonName' => get_config('tool_agpunet', 'defaultagpunetname'),
        'generic' => $defaultlink,
        'courseID' => $courseid,
        'sectionnum' => $sectionid,
        'img' => $OUTPUT->image_url('agpuNet', 'tool_agpunet')->out(false),
    ]);
    return new activity_chooser_footer(
        'tool_agpunet/instance_form',
        $renderedfooter,
        $renderedcarousel
    );
}
