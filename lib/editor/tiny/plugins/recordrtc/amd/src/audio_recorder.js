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
 * Tiny Record RTC - audio recorder configuration.
 *
 * @module      tiny_recordrtc/audio_recorder
 * @copyright   2022 Stevani Andolo <stevani@hotmail.com.au>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import BaseClass from './base_recorder';
import Modal from './modal';
import {component} from 'tiny_recordrtc/common';

export default class Audio extends BaseClass {
    configurePlayer() {
        return this.modalRoot.querySelector('audio');
    }

    getSupportedTypes() {
        return [
            // Firefox supports webm and ogg but Chrome only supports ogg.
            // So we use ogg to maximize the compatibility.
            'audio/ogg;codecs=opus',

            // Safari supports mp4.
            'audio/mp4;codecs=opus',
            'audio/mp4;codecs=wav',
            'audio/mp4;codecs=mp3',
        ];
    }

    getRecordingOptions() {
        return {
            audioBitsPerSecond: parseInt(this.config.audiobitrate),
        };
    }

    getMediaConstraints() {
        return {
            audio: true,
        };
    }

    getRecordingType() {
        return 'audio';
    }

    getTimeLimit() {
        return this.config.audiotimelimit;
    }

    getEmbedTemplateName() {
        return 'tiny_recordrtc/embed_audio';
    }

    getFileName(prefix) {
        return `${prefix}-audio.${this.getFileExtension()}`;
    }

    getFileExtension() {
        if (window.MediaRecorder.isTypeSupported('audio/ogg')) {
            return 'ogg';
        } else if (window.MediaRecorder.isTypeSupported('audio/mp4')) {
            return 'mp4';
        }

        window.console.warn(`Unknown file type for MediaRecorder API`);
        return '';
    }

    static getModalClass() {
        return class extends Modal {
            static TYPE = `${component}/audio_recorder`;
            static TEMPLATE = `${component}/audio_recorder`;
        };
    }
}
