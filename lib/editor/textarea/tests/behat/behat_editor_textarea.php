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
 * agpu textarea editor field.
 *
 * @package    core_form
 * @category   test
 * @copyright  2022 Andrew Lyons <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../behat/behat_base.php');
require_once(__DIR__ . '/../../../../behat/classes/settable_editor.php');

class behat_editor_textarea extends behat_base implements \core_behat\settable_editor {

    /**
     * Set the value for the editor.
     *
     * @param string $editorid
     * @param string $value
     */
    public function set_editor_value(string $editorid, string $value): void {
        $js = <<<EOF
            (function() {
                const editor = document.getElementById("{$editorid}");
                if (editor && editor.tagName.toLowerCase() === 'textarea') {
                    editor.value = "{$value}";
                }
            })();
        EOF;
        $this->execute_script($js);
    }
}
