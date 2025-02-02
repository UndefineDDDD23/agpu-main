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
 * Class for exporting a blog post (entry).
 *
 * @package    core_blog
 * @copyright  2018 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_blog\external;
defined('agpu_INTERNAL') || die();

use core\external\exporter;
use core_external\util as external_util;
use core_external\external_files;
use renderer_base;
use context_system;
use core_tag\external\tag_item_exporter;

/**
 * Class for exporting a blog post (entry).
 *
 * @copyright  2018 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class post_exporter extends exporter {

    /**
     * Return the list of properties.
     *
     * @return array list of properties
     */
    protected static function define_properties() {
        return array(
            'id' => array(
                'type' => PARAM_INT,
                'null' => NULL_ALLOWED,
                'description' => 'Post/entry id.',
            ),
            'module' => array(
                'type' => PARAM_ALPHANUMEXT,
                'null' => NULL_NOT_ALLOWED,
                'description' => 'Where it was published the post (blog, blog_external...).',
            ),
            'userid' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'Post author.',
            ),
            'courseid' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'Course where the post was created.',
            ),
            'groupid' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'Group post was created for.',
            ),
            'moduleid' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'Module id where the post was created (not used anymore).',
            ),
            'coursemoduleid' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'Course module id where the post was created.',
            ),
            'subject' => array(
                'type' => PARAM_TEXT,
                'null' => NULL_NOT_ALLOWED,
                'description' => 'Post subject.',
            ),
            'summary' => array(
                'type' => PARAM_RAW,
                'null' => NULL_ALLOWED,
                'description' => 'Post summary.',
            ),
            'content' => array(
                'type' => PARAM_RAW,
                'null' => NULL_ALLOWED,
                'description' => 'Post content.',
            ),
            'uniquehash' => array(
                'type' => PARAM_RAW,
                'null' => NULL_NOT_ALLOWED,
                'description' => 'Post unique hash.',
            ),
            'rating' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'Post rating.',
            ),
            'format' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'Post content format.',
            ),
            'summaryformat' => array(
                'choices' => array(FORMAT_HTML, FORMAT_agpu, FORMAT_PLAIN, FORMAT_MARKDOWN),
                'type' => PARAM_INT,
                'default' => FORMAT_agpu,
                'description' => 'Format for the summary field.',
            ),
            'attachment' => array(
                'type' => PARAM_RAW,
                'null' => NULL_ALLOWED,
                'description' => 'Post atachment.',
            ),
            'publishstate' => array(
                'type' => PARAM_ALPHA,
                'null' => NULL_NOT_ALLOWED,
                'default' => 'draft',
                'description' => 'Post publish state.',
            ),
            'lastmodified' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'When it was last modified.',
            ),
            'created' => array(
                'type' => PARAM_INT,
                'null' => NULL_NOT_ALLOWED,
                'default' => 0,
                'description' => 'When it was created.',
            ),
            'usermodified' => array(
                'type' => PARAM_INT,
                'null' => NULL_ALLOWED,
                'description' => 'User that updated the post.',
            ),
        );
    }

    protected static function define_related() {
        return array(
            'context' => 'context'
        );
    }

    protected static function define_other_properties() {
        return array(
            'summaryfiles' => array(
                'type' => external_files::get_properties_for_exporter(),
                'multiple' => true
            ),
            'attachmentfiles' => array(
                'type' => external_files::get_properties_for_exporter(),
                'multiple' => true,
                'optional' => true
            ),
            'tags' => array(
                'type' => tag_item_exporter::read_properties_definition(),
                'description' => 'Tags.',
                'multiple' => true,
                'optional' => true,
            ),
            'canedit' => array(
                'type' => PARAM_BOOL,
                'description' => 'Whether the user can edit the post.',
                'optional' => true,
            ),
        );
    }

    protected function get_other_values(renderer_base $output) {
        global $CFG;
        require_once($CFG->dirroot . '/blog/lib.php');

        $context = context_system::instance(); // Files always on site context.

        $values['summaryfiles'] = external_util::get_area_files($context->id, 'blog', 'post', $this->data->id);
        $values['attachmentfiles'] = external_util::get_area_files($context->id, 'blog', 'attachment', $this->data->id);
        if ($this->data->module == 'blog_external') {
            // For external blogs, the content field has the external blog id.
            $values['tags'] = \core_tag\external\util::get_item_tags('core', 'blog_external', $this->data->content);
        } else {
            $values['tags'] = \core_tag\external\util::get_item_tags('core', 'post', $this->data->id);
        }
        $values['canedit'] = blog_user_can_edit_entry($this->data);

        return $values;
    }
}
