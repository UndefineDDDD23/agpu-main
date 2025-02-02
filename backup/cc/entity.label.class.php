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
 * @package   agpucore
 * @subpackage backup-imscc
 * @copyright 2009 Mauro Rondinelli (mauro.rondinelli [AT] uvcms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') or die('Direct access to this script is forbidden.');

class cc_label extends entities {

    public function generate_node() {

        cc2agpu::log_action('Creating Labels mods');

        $response = '';

        $sheet_mod_label = cc2agpu::loadsheet(SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_LABEL);

        if (!empty(cc2agpu::$instances['instances'][agpu_TYPE_LABEL])) {
            foreach (cc2agpu::$instances['instances'][agpu_TYPE_LABEL] as $instance) {
                $response .= $this->create_node_course_modules_mod_label($sheet_mod_label, $instance);
            }
        }

        return $response;
    }

    private function create_node_course_modules_mod_label($sheet_mod_label, $instance) {
        if ($instance['deep'] <= ROOT_DEEP) {
            return '';
        }

        $find_tags = array('[#mod_instance#]',
                           '[#mod_name#]',
                           '[#mod_content#]',
                           '[#date_now#]');

        $title = isset($instance['title']) && !empty($instance['title']) ? $instance['title'] : 'Untitled';
        $content = "<img src=\"$@FILEPHP@$$@SLASH@$"."files.gif\" alt=\"Folder\" title=\"{$title}\" /> {$title}";
        $replace_values = array($instance['instance'],
                                self::safexml($title),
                                self::safexml($content),
                                time());

        return str_replace($find_tags, $replace_values, $sheet_mod_label);
    }
}
