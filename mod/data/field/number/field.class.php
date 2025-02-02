<?php
///////////////////////////////////////////////////////////////////////////
//                                                                       //
// NOTICE OF COPYRIGHT                                                   //
//                                                                       //
// agpu - Modular Object-Oriented Dynamic Learning Environment         //
//          http://agpu.org                                            //
//                                                                       //
// Copyright (C) 1999-onwards agpu Pty Ltd  http://agpu.com          //
//                                                                       //
// This program is free software; you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation; either version 2 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// This program is distributed in the hope that it will be useful,       //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details:                          //
//                                                                       //
//          http://www.gnu.org/copyleft/gpl.html                         //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

class data_field_number extends data_field_base {
    var $type = 'number';

    public function supports_preview(): bool {
        return true;
    }

    public function get_data_content_preview(int $recordid): stdClass {
        return (object)[
            'id' => 0,
            'fieldid' => $this->field->id,
            'recordid' => $recordid,
            'content' => 1233 + $recordid,
            'content1' => null,
            'content2' => null,
            'content3' => null,
            'content4' => null,
        ];
    }

    function update_content($recordid, $value, $name='') {
        global $DB;

        $content = new stdClass();
        $content->fieldid = $this->field->id;
        $content->recordid = $recordid;
        $value = trim($value);
        if (strlen($value) > 0) {
            $content->content = floatval($value);
        } else {
            $content->content = null;
        }
        if ($oldcontent = $DB->get_record('data_content', array('fieldid'=>$this->field->id, 'recordid'=>$recordid))) {
            $content->id = $oldcontent->id;
            return $DB->update_record('data_content', $content);
        } else {
            return $DB->insert_record('data_content', $content);
        }
    }

    function display_browse_field($recordid, $template) {
        $content = $this->get_data_content($recordid);
        if (!$content || $content->content === '') {
            return '';
        }
        $number = $content->content;
        $decimals = trim($this->field->param1 ?? '');
        // Only apply number formatting if param1 contains an integer number >= 0.
        if (preg_match("/^\d+$/", $decimals)) {
            $decimals = $decimals * 1;
            // Removes leading zeros (eg. '007' -> '7'; '00' -> '0').
            $str = format_float($number, $decimals, true);
        } else {
            $str = $number;
        }
        return $str;
    }

    function display_search_field($value = '') {
        return '<label class="accesshide" for="f_'.$this->field->id.'">' . get_string('fieldname', 'data') . '</label>' .
               '<input type="text" size="16" id="f_'.$this->field->id.'" name="f_'.$this->field->id.'" ' .
               'value="'.s($value).'" class="form-control d-inline"/>';
    }

    public function parse_search_field($defaults = null) {
        $param = 'f_'.$this->field->id;
        if (empty($defaults[$param])) {
            $defaults = array($param => '');
        }
        return optional_param($param, $defaults[$param], PARAM_NOTAGS);
    }

    // need to cast?
    function generate_sql($tablealias, $value) {
        global $DB;

        static $i=0;
        $i++;
        $name = "df_number_$i";
        $varcharcontent = $DB->sql_compare_text("{$tablealias}.content");
        return array(" ({$tablealias}.fieldid = {$this->field->id} AND $varcharcontent = :$name) ", array($name=>$value));
    }

    function get_sort_sql($fieldname) {
        global $DB;
        return $DB->sql_cast_char2real($fieldname, true);
    }

    /**
     * Check if a field from an add form is empty
     *
     * @param mixed $value
     * @param mixed $name
     * @return bool
     */
    function notemptyfield($value, $name) {
        return strval($value) !== '';
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
}
