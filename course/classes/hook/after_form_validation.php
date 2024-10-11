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

namespace core_course\hook;

use course_edit_form;

/**
 * Allows plugins to extend course form validation.
 *
 * @see course_edit_form::validation()
 *
 * @package    core_course
 * @copyright  2023 Dmitrii Metelkin <dmitriim@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\core\attribute\label('Allow plugins to extend a validation of the course editing form')]
#[\core\attribute\tags('course')]
class after_form_validation {
    /**
     * Plugin errors.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Creates new hook.
     *
     * @param course_edit_form $formwrapper Course form wrapper..
     * @param array $data Submitted data.
     * @param array $files Submitted files.
     */
    public function __construct(
        /** @var course_edit_form Course form wrapper */
        public readonly course_edit_form $formwrapper,
        /** @var array The submitted data */
        private array $data,
        /** @var array Submitted files */
        private array $files = [],
    ) {
    }

    /**
     * Returns submitted data.
     *
     * @return array
     */
    public function get_data(): array {
        return $this->data;
    }

    /**
     * Returns submitted files.
     *
     * @return array
     */
    public function get_files(): array {
        return $this->files;
    }

    /**
     * Return plugin generated errors.
     *
     * @return array
     */
    public function get_errors(): array {
        return $this->errors;
    }

    /**
     * Plugins implementing a callback can add validation errors.
     *
     * @param array $errors Validation errors generated by a plugin.
     */
    public function add_errors(array $errors): void {
        $this->errors = array_merge($this->errors, $errors);
    }
}