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
 * Privacy Subsystem implementation for datafield_file.
 *
 * @package    datafield_file
 * @copyright  2018 Carlos Escobedo <carlos@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace datafield_file\privacy;
use mod_data\privacy\datafield_provider;
use core_privacy\local\request\writer;

defined('agpu_INTERNAL') || die();
/**
 * Privacy Subsystem for datafield_file implementing null_provider.
 *
 * @copyright  2018 Carlos Escobedo <carlos@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\null_provider,
        datafield_provider {
    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }

    /**
     * Exports data about one record in {data_content} table.
     *
     * @param \context_module $context
     * @param \stdClass $recordobj record from DB table {data_records}
     * @param \stdClass $fieldobj record from DB table {data_fields}
     * @param \stdClass $contentobj record from DB table {data_content}
     * @param \stdClass $defaultvalue pre-populated default value that most of plugins will use
     */
    public static function export_data_content($context, $recordobj, $fieldobj, $contentobj, $defaultvalue) {
        if ($fieldobj->param3) {
            $defaultvalue->field['maxbytes'] = $fieldobj->param3;
        }
        // Change file name to file path.
        $defaultvalue->file = writer::with_context($context)
            ->rewrite_pluginfile_urls([$recordobj->id, $contentobj->id], 'mod_data', 'content', $contentobj->id,
                '@@PLUGINFILE@@/' . $defaultvalue->content);
        unset($defaultvalue->content);
        writer::with_context($context)->export_data([$recordobj->id, $contentobj->id], $defaultvalue);
    }

    /**
     * Allows plugins to delete locally stored data.
     *
     * @param \context_module $context
     * @param \stdClass $recordobj record from DB table {data_records}
     * @param \stdClass $fieldobj record from DB table {data_fields}
     * @param \stdClass $contentobj record from DB table {data_content}
     */
    public static function delete_data_content($context, $recordobj, $fieldobj, $contentobj) {

    }
}