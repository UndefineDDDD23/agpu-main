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
 * Form for editing Blog tags block instances.
 *
 * @package   block_blog_tags
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Form for editing Blog tags block instances.
 *
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_blog_tags_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_blog_tags'));
        $mform->setDefault('config_title', get_string('blogtags', 'blog'));
        $mform->setType('config_title', PARAM_TEXT);

        $numberoftags = array();
        for($i = 1; $i <= 50; $i++) {
            $numberoftags[$i] = $i;
        }
        $mform->addElement('select', 'config_numberoftags', get_string('numberoftags', 'blog'), $numberoftags);
        $mform->setDefault('config_numberoftags', BLOCK_BLOG_TAGS_DEFAULTNUMBEROFTAGS);

        $timewithin = array(
            10  => get_string('numdays', '', 10),
            30  => get_string('numdays', '', 30),
            60  => get_string('numdays', '', 60),
            90  => get_string('numdays', '', 90),
            120 => get_string('numdays', '', 120),
            240 => get_string('numdays', '', 240),
            365 => get_string('numdays', '', 365),
        );
        $mform->addElement('select', 'config_timewithin', get_string('timewithin', 'blog'), $timewithin);
        $mform->setDefault('config_timewithin', BLOCK_BLOG_TAGS_DEFAULTTIMEWITHIN);

        $sort = array(
            'name' => get_string('tagtext', 'blog'),
            'id'   => get_string('tagdatelastused', 'blog'),
        );
        $mform->addElement('select', 'config_sort', get_string('tagsort', 'blog'), $sort);
        $mform->setDefault('config_sort', BLOCK_BLOG_TAGS_DEFAULTSORT);
    }
}
