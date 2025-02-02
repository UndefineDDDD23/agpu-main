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

namespace mod_forum\output\courseformat;

/**
 * Activity badge forum class, used for rendering unread messages.
 *
 * @package    mod_forum
 * @copyright  2023 Sara Arjona <sara@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class activitybadge extends \core_courseformat\output\activitybadge {

    /**
     * This method will be called before exporting the template.
     */
    protected function update_content(): void {
        global $CFG;

        require_once($CFG->dirroot . '/mod/forum/lib.php');

        if (forum_tp_can_track_forums()) {
            if ($unread = forum_tp_count_forum_unread_posts($this->cminfo, $this->cminfo->get_course())) {
                if ($unread == 1) {
                    $this->content = get_string('unreadpostsone', 'forum');
                } else {
                    $this->content = get_string('unreadpostsnumber', 'forum', $unread);
                }
                $this->style = self::STYLES['dark'];
            }
        }
    }
}
