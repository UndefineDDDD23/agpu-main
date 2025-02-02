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
 * Atto text editor recordrtc capabilities.
 *
 * @package    atto_recordrtc
 * @copyright  2018 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$capabilities = [
    // Capability to record audio using this plugin.
    'atto/recordrtc:recordaudio' => [
        'captype'      => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => [
            'user' => CAP_ALLOW,
        ],
    ],
    // Capability to record video using this plugin.
    'atto/recordrtc:recordvideo' => [
        'captype'      => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes'   => [
            'user' => CAP_ALLOW,
        ],
    ],
];
