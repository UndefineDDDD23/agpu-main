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
 * Atto recordrtc library functions
 *
 * @package    atto_recordrtc
 * @author     Jesus Federico (jesus [at] blindsidenetworks [dt] com)
 * @author     Jacob Prud'homme (jacob [dt] prudhomme [at] blindsidenetworks [dt] com)
 * @copyright  2017 Blindside Networks Inc.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Default maximum recording length allowed for the audio/video clips.
 */
define('DEFAULT_TIME_LIMIT', 120);

/**
 * Set params for this plugin.
 *
 * @param string $elementid
 * @param stdClass $options - the options for the editor, including the context.
 * @param stdClass $fpoptions - unused.
 */
function atto_recordrtc_params_for_js($elementid, $options, $fpoptions) {
    $context = $options['context'];
    if (!$context) {
        $context = context_system::instance();
    }

    $sesskey = sesskey();
    $allowedtypes = get_config('atto_recordrtc', 'allowedtypes');
    $audiobitrate = get_config('atto_recordrtc', 'audiobitrate');
    $videobitrate = get_config('atto_recordrtc', 'videobitrate');
    $audiotimelimit = get_config('atto_recordrtc', 'audiotimelimit');
    $videotimelimit = get_config('atto_recordrtc', 'videotimelimit');

    // Update $allowedtypes to account for capabilities.
    $audioallowed = $allowedtypes === 'audio' || $allowedtypes === 'both';
    $videoallowed = $allowedtypes === 'video' || $allowedtypes === 'both';
    $audioallowed = $audioallowed && has_capability('atto/recordrtc:recordaudio', $context);
    $videoallowed = $videoallowed && has_capability('atto/recordrtc:recordvideo', $context);
    if ($audioallowed && $videoallowed) {
        $allowedtypes = 'both';
    } else if ($audioallowed) {
        $allowedtypes = 'audio';
    } else if ($videoallowed) {
        $allowedtypes = 'video';
    } else {
        $allowedtypes = '';
    }

    $maxrecsize = get_max_upload_file_size();
    if (!empty($options['maxbytes'])) {
        $maxrecsize = min($maxrecsize, $options['maxbytes']);
    }
    $audiortcicon = 'i/audiortc';
    $videortcicon = 'i/videortc';
    $params = array('contextid' => $context->id,
                    'sesskey' => $sesskey,
                    'allowedtypes' => $allowedtypes,
                    'audiobitrate' => $audiobitrate,
                    'videobitrate' => $videobitrate,
                    'audiotimelimit' => $audiotimelimit,
                    'videotimelimit' => $videotimelimit,
                    'defaulttimelimit' => DEFAULT_TIME_LIMIT,
                    'audiortcicon' => $audiortcicon,
                    'videortcicon' => $videortcicon,
                    'maxrecsize' => $maxrecsize
              );

    return $params;
}

/**
 * Initialise the js strings required for this module.
 */
function atto_recordrtc_strings_for_js() {
    global $PAGE;

    $strings = array('audiortc',
                     'videortc',
                     'nowebrtc_title',
                     'nowebrtc',
                     'gumabort_title',
                     'gumabort',
                     'gumnotallowed_title',
                     'gumnotallowed',
                     'gumnotfound_title',
                     'gumnotfound',
                     'gumnotreadable_title',
                     'gumnotreadable',
                     'gumnotsupported',
                     'gumnotsupported_title',
                     'gumoverconstrained_title',
                     'gumoverconstrained',
                     'gumsecurity_title',
                     'gumsecurity',
                     'gumtype_title',
                     'gumtype',
                     'insecurealert_title',
                     'insecurealert',
                     'startrecording',
                     'recordagain',
                     'stoprecording',
                     'recordingfailed',
                     'attachrecording',
                     'norecordingfound_title',
                     'norecordingfound',
                     'nearingmaxsize_title',
                     'nearingmaxsize',
                     'uploadprogress',
                     'uploadfailed',
                     'uploadfailed404',
                     'uploadaborted'
               );

    $PAGE->requires->strings_for_js($strings, 'atto_recordrtc');
}

/**
 * Map icons for font-awesome themes.
 */
function atto_recordrtc_get_fontawesome_icon_map() {
    return [
        'atto_recordrtc:i/audiortc' => 'fa-microphone',
        'atto_recordrtc:i/videortc' => 'fa-video',
    ];
}
