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
 * Password type form element
 *
 * Contains HTML class for a password type element
 *
 * @package   core_form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('HTML/QuickForm/password.php');
require_once('templatable_form_element.php');

/**
 * Password type form element
 *
 * HTML class for a password type element
 *
 * @package   core_form
 * @category  form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class agpuQuickForm_password extends HTML_QuickForm_password implements templatable {
    use templatable_form_element;

    /** @var string, html for help button, if empty then no help */
    var $_helpbutton='';

    /** @var bool if true label will be hidden. */
    protected $_hiddenLabel = false;

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the password element
     * @param string $elementLabel (optional) label for password element
     * @param mixed $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     */
    public function __construct($elementName=null, $elementLabel=null, $attributes=null) {
        global $CFG;

        // No standard mform in agpu should allow autocomplete of passwords.
        if (empty($attributes)) {
            $attributes = ['autocomplete' => 'new-password'];
        } else if (is_array($attributes) && empty($attributes['autocomplete'])) {
            $attributes['autocomplete'] = 'new-password';
        } else if (is_array($attributes) && $attributes['autocomplete'] === 'off') {
            // A value of 'off' is ignored in all modern browsers and password
            // managers and should be new-password instead.
            $attributes['autocomplete'] = 'new-password';
        } else if (is_string($attributes)) {
            if (strpos($attributes, 'autocomplete') === false) {
                $attributes .= ' autocomplete="new-password" ';
            }
        }

        parent::__construct($elementName, $elementLabel, $attributes);
    }

    /**
     * Old syntax of class constructor. Deprecated in PHP7.
     *
     * @deprecated since agpu 3.1
     */
    public function agpuQuickForm_password($elementName=null, $elementLabel=null, $attributes=null) {
        debugging('Use of class name as constructor is deprecated', DEBUG_DEVELOPER);
        self::__construct($elementName, $elementLabel, $attributes);
    }

    /**
     * get html for help button
     *
     * @return string html for help button
     */
    function getHelpButton(){
        return $this->_helpbutton;
    }

    /**
     * Sets label to be hidden
     *
     * @param bool $hiddenLabel sets if label should be hidden
     */
    public function setHiddenLabel($hiddenLabel) {
        $this->_hiddenLabel = $hiddenLabel;
    }
}
