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
 * Main class for plugin 'media_vimeo'
 *
 * @package   media_vimeo
 * @copyright 2016 Marina Glancy
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

/**
 * Player that embeds Vimeo links.
 *
 * @package   media_vimeo
 * @copyright 2016 Marina Glancy
 * @author    2011 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class media_vimeo_plugin extends core_media_player_external {
    protected function embed_external(agpu_url $url, $name, $width, $height, $options) {
        global $OUTPUT;

        $donottrack = get_config('media_vimeo', 'donottrack');
        $videoid = $this->get_video_id();
        $info = s($name);
        $params = [];

        // Note: resizing via url is not supported, user can click the fullscreen
        // button instead. iframe embedding is not xhtml strict but it is the only
        // option that seems to work on most devices.
        self::pick_video_size($width, $height);

        // Add do not track parameter.
        if ($donottrack) {
            $params['dnt'] = 1;
        }

        $embedurl = new agpu_url("https://player.vimeo.com/video/$videoid", $params);
        // Template context.
        $context = [
            'width' => $width,
            'height' => $height,
            'title' => $info,
            'embedurl' => $embedurl->out(false),
        ];

        // Return the rendered template.
        return $OUTPUT->render_from_template('media_vimeo/embed', $context);
    }

    /**
     * Get Vimeo video ID.
     * @return string
     */
    protected function get_video_id(): string {
        return $this->get_video_id_with_code() ?? $this->matches[1] ?? '';
    }

    /**
     * Get video id with code.
     * @return string|null If NULL then the URL does not contain the code.
     */
    protected function get_video_id_with_code(): ?string {
        $id = $this->matches[2] ?? null;

        if (!empty($id)) {
            $code = $this->matches[3] ?? null;
            if (!empty($code)) {
                return "{$id}?h={$code}";
            }

            return $id;
        }

        return null;
    }

    /**
     * Returns regular expression to match vimeo URLs.
     * @return string
     */
    protected function get_regex() {
        // Initial part of link.
        $start = '~^https?://vimeo\.com/';
        // Middle bit: either 123456789 or 123456789/abdef12345.
        $middle = '(([0-9]+)/([0-9a-f]+)|[0-9]+)';
        return $start . $middle . core_media_player_external::END_LINK_REGEX_PART;
    }

    public function get_embeddable_markers() {
        return array('vimeo.com/');
    }

    /**
     * Default rank
     * @return int
     */
    public function get_rank() {
        return 1010;
    }
}
