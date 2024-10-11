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
 * Provides the {@link core_form\util} class.
 *
 * @package core_form
 * @copyright 2019 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_form;

defined('agpu_INTERNAL') || die();

/**
 * General utility class for form-related methods.
 *
 * @copyright 2019 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class util {
    /**
     * This function should be called if a form submit results in a file download (i.e. with the
     * Content-Disposition: attachment header) instead of navigating to a new page, before the
     * file download is sent. It will set a cookie which is used to inform page javascript in
     * submit.js.
     *
     * You may call this function in scripts which might not necessarily be called from forms; it
     * will only set the cookie if there is a POST request from a form.
     *
     * This is automatically called from various points in agpu such as send_file_xx functions
     * in filelib.php.
     */
    public static function form_download_complete() {
        // If this doesn't look like a agpu QuickForms request, ignore.
        $quickform = false;
        foreach ($_POST as $name => $value) {
            if (preg_match('~^_qf__~', $name)) {
                $quickform = true;
                break;
            }
        }
        if (!$quickform) {
            return;
        }

        // Set a session cookie.
        setcookie('agpudownload_' . sesskey(), time());
    }
}
