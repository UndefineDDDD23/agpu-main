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
 * Class file field for database activity
 *
 * @package    datafield_file
 * @copyright  2005 Martin Dougiamas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class data_field_file extends data_field_base {
    var $type = 'file';

    public function supports_preview(): bool {
        return true;
    }

    public function get_data_content_preview(int $recordid): stdClass {
        return (object)[
            'id' => 0,
            'fieldid' => $this->field->id,
            'recordid' => $recordid,
            'content' => 'samplefile.csv',
            'content1' => 'samplefile.csv',
            'content2' => null,
            'content3' => null,
            'content4' => null,
        ];
    }

    function display_add_field($recordid = 0, $formdata = null) {
        global $CFG, $DB, $OUTPUT, $PAGE;

        // Necessary for the constants used in args.
        require_once($CFG->dirroot . '/repository/lib.php');

        $itemid = null;

        // editing an existing database entry
        if ($formdata) {
            $fieldname = 'field_' . $this->field->id . '_file';
            $itemid = clean_param($formdata->$fieldname, PARAM_INT);
        } else if ($recordid) {
            if (!$content = $DB->get_record('data_content', array('fieldid' => $this->field->id, 'recordid' => $recordid))) {
                // Quickly make one now!
                $content = new stdClass();
                $content->fieldid  = $this->field->id;
                $content->recordid = $recordid;
                $id = $DB->insert_record('data_content', $content);
                $content = $DB->get_record('data_content', array('id' => $id));
            }
            file_prepare_draft_area($itemid, $this->context->id, 'mod_data', 'content', $content->id);

        } else {
            $itemid = file_get_unused_draft_itemid();
        }

        // database entry label
        $html = '<div title="' . s($this->field->description) . '">';
        $html .= '<fieldset><legend><span class="accesshide">'.s($this->field->name);

        if ($this->field->required) {
            $html .= '&nbsp;' . get_string('requiredelement', 'form') . '</span></legend>';
            $image = $OUTPUT->pix_icon('req', get_string('requiredelement', 'form'));
            $html .= html_writer::div($image, 'inline-req');
        } else {
            $html .= '</span></legend>';
        }

        // itemid element
        $html .= '<input type="hidden" name="field_'.$this->field->id.'_file" value="'.s($itemid).'" />';

        $options = new stdClass();
        $options->maxbytes = $this->field->param3;
        $options->maxfiles  = 1; // Limit to one file for the moment, this may be changed if requested as a feature in the future.
        $options->itemid    = $itemid;
        $options->accepted_types = '*';
        $options->return_types = FILE_INTERNAL | FILE_CONTROLLED_LINK;
        $options->context = $PAGE->context;

        $fm = new form_filemanager($options);
        // Print out file manager.

        $output = $PAGE->get_renderer('core', 'files');
        $html .= '<div class="mod-data-input">';
        $html .= $output->render($fm);
        $html .= '</div>';
        $html .= '</fieldset>';
        $html .= '</div>';

        return $html;
    }

    function display_search_field($value = '') {
        return '<label class="accesshide" for="f_' . $this->field->id . '">' . s($this->field->name) . '</label>' .
               '<input type="text" size="16" id="f_'.$this->field->id.'" name="f_'.$this->field->id.'" ' .
                    'value="'.s($value).'" class="form-control"/>';
    }

    function generate_sql($tablealias, $value) {
        global $DB;

        static $i=0;
        $i++;
        $name = "df_file_$i";
        return array(" ({$tablealias}.fieldid = {$this->field->id} AND ".$DB->sql_like("{$tablealias}.content", ":$name", false).") ", array($name=>"%$value%"));
    }

    public function parse_search_field($defaults = null) {
        $param = 'f_'.$this->field->id;
        if (empty($defaults[$param])) {
            $defaults = array($param => '');
        }
        return optional_param($param, $defaults[$param], PARAM_NOTAGS);
    }

    function get_file($recordid, $content=null) {
        global $DB;
        if (empty($content)) {
            if (!$content = $this->get_data_content($recordid)) {
                return null;
            }
        }
        $fs = get_file_storage();
        if (!$file = $fs->get_file($this->context->id, 'mod_data', 'content', $content->id, '/', $content->content)) {
            return null;
        }

        return $file;
    }

    function display_browse_field($recordid, $template) {
        global $OUTPUT;

        $content = $this->get_data_content($recordid);

        if (!$content || empty($content->content)) {
            return '';
        }

        $file = null;
        $url = '';
        $name = !empty($content->content1) ? $content->content1 : $content->content;

        if ($this->preview) {
            $file = (object)[
                'filename' => $content->content,
                'mimetype' => 'text/csv',
            ];
            $name = $content->content;
        } else {
            $file = $this->get_file($recordid, $content);
            if (!$file) {
                return '';
            }
            $fileurl = agpu_url::make_pluginfile_url(
                $file->get_contextid(),
                $file->get_component(),
                $file->get_filearea(),
                $file->get_itemid(),
                $file->get_filepath(),
                $file->get_filename()
            );
            $url = $fileurl->out();
        }

        $icon = $OUTPUT->pix_icon(
            file_file_icon($file),
            get_mimetype_description($file),
            'agpu',
            ['width' => 16, 'height' => 16]
        );

        return $icon . '&nbsp;<a class="data-field-link" href="'.$url.'" >' . s($name) . '</a>';
    }


    // content: "a##b" where a is the file name, b is the display name
    function update_content($recordid, $value, $name='') {
        global $CFG, $DB, $USER;
        $fs = get_file_storage();

        // Should always be available since it is set by display_add_field before initializing the draft area.
        $content = $DB->get_record('data_content', array('fieldid' => $this->field->id, 'recordid' => $recordid));
        if (!$content) {
            $content = (object)array('fieldid' => $this->field->id, 'recordid' => $recordid);
            $content->id = $DB->insert_record('data_content', $content);
        }

        file_save_draft_area_files($value, $this->context->id, 'mod_data', 'content', $content->id);

        $usercontext = context_user::instance($USER->id);
        $files = $fs->get_area_files($this->context->id, 'mod_data', 'content', $content->id, 'itemid, filepath, filename', false);

        // We expect no or just one file (maxfiles = 1 option is set for the form_filemanager).
        if (count($files) == 0) {
            $content->content = null;
        } else {
            $content->content = array_values($files)[0]->get_filename();
            if (count($files) > 1) {
                // This should not happen with a consistent database. Inform admins/developers about the inconsistency.
                debugging('more then one file found in mod_data instance {$this->data->id} file field (field id: {$this->field->id}) area during update data record {$recordid} (content id: {$content->id})', DEBUG_NORMAL);
            }
        }
        $DB->update_record('data_content', $content);
    }

    /**
     * Here we export the text value of a file field which is the filename of the exported file.
     *
     * @param stdClass $record the record which is being exported
     * @return string the value which will be stored in the exported file for this field
     */
    public function export_text_value(stdClass $record): string {
        return !empty($record->content) ? $record->content : '';
    }

    /**
     * Specifies that this field type supports the export of files.
     *
     * @return bool true which means that file export is being supported by this field type
     */
    public function file_export_supported(): bool {
        return true;
    }

    /**
     * Specifies that this field type supports the import of files.
     *
     * @return bool true which means that file import is being supported by this field type
     */
    public function file_import_supported(): bool {
        return true;
    }

    /**
     * Provides the necessary code for importing a file when importing the content of a mod_data instance.
     *
     * @param int $contentid the id of the mod_data content record
     * @param string $filecontent the content of the file to import as string
     * @param string $filename the filename the imported file should get
     * @return void
     */
    public function import_file_value(int $contentid, string $filecontent, string $filename): void {
        $filerecord = [
            'contextid' => $this->context->id,
            'component' => 'mod_data',
            'filearea' => 'content',
            'itemid' => $contentid,
            'filepath' => '/',
            'filename' => $filename,
        ];
        $fs = get_file_storage();
        $fs->create_file_from_string($filerecord, $filecontent);
    }

    /**
     * Exports the file content for file export.
     *
     * @param stdClass $record the data content record the file belongs to
     * @return null|string The file content of the stored file or null if no file should be exported for this record
     */
    public function export_file_value(stdClass $record): null|string {
        $file = $this->get_file($record->id);
        return $file ? $file->get_content() : null;
    }

    function file_ok($path) {
        return true;
    }

    /**
     * Custom notempty function
     *
     * @param string $value
     * @param string $name
     * @return bool
     */
    function notemptyfield($value, $name) {
        global $USER;

        $names = explode('_', $name);
        if ($names[2] == 'file') {
            $usercontext = context_user::instance($USER->id);
            $fs = get_file_storage();
            $files = $fs->get_area_files($usercontext->id, 'user', 'draft', $value);
            return count($files) >= 2;
        }
        return false;
    }

    /**
     * Return the plugin configs for external functions.
     *
     * @return array the list of config parameters
     * @since agpu 3.3
     */
    public function get_config_for_external() {
        // Return all the config parameters.
        $configs = [];
        for ($i = 1; $i <= 10; $i++) {
            $configs["param$i"] = $this->field->{"param$i"};
        }
        return $configs;
    }

    public function get_field_params(): array {
        global $DB, $CFG;

        $data = parent::get_field_params();

        $course = $DB->get_record('course', ['id' => $this->data->course]);
        $filesizes = get_max_upload_sizes($CFG->maxbytes, $course->maxbytes, 0, $this->field->param3);

        foreach ($filesizes as $value => $name) {
            if (!((isset($this->field->param3) && $value == $this->field->param3))) {
                $data['filesizes'][] = ['name' => $name, 'value' => $value, 'selected' => 0];
            } else {
                $data['filesizes'][] = ['name' => $name, 'value' => $value, 'selected' => 1];
            }
        }

        return $data;
    }
}
