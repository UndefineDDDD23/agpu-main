<?php

require_once($CFG->dirroot . '/backup/converter/convertlib.php');

class agpu1_export_converter extends base_converter {
    public static function is_available() {
        return false;
    }

    protected function execute() {

    }
}