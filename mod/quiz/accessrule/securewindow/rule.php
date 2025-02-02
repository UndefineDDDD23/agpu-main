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

use mod_quiz\local\access_rule_base;
use mod_quiz\quiz_settings;

/**
 * A rule for ensuring that the quiz is opened in a popup, with some JavaScript
 * to prevent copying and pasting, etc.
 *
 * @package   quizaccess_securewindow
 * @copyright  2009 Tim Hunt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quizaccess_securewindow extends access_rule_base {
    /** @var array options that should be used for opening the secure popup. */
    protected static $popupoptions = [
        'left' => 0,
        'top' => 0,
        'fullscreen' => true,
        'scrollbars' => true,
        'resizeable' => false,
        'directories' => false,
        'toolbar' => false,
        'titlebar' => false,
        'location' => false,
        'status' => false,
        'menubar' => false,
    ];

    public static function make(quiz_settings $quizobj, $timenow, $canignoretimelimits) {

        if ($quizobj->get_quiz()->browsersecurity !== 'securewindow') {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    public function attempt_must_be_in_popup() {
        return !$this->quizobj->is_preview_user();
    }

    public function get_popup_options() {
        return self::$popupoptions;
    }

    public function setup_attempt_page($page) {
        $page->set_popup_notification_allowed(false); // Prevent message notifications.
        $page->set_title($this->quizobj->get_course()->shortname . ': ' . $page->title);
        $page->set_pagelayout('secure');

        if ($this->quizobj->is_preview_user()) {
            return;
        }

        $page->add_body_class('quiz-secure-window');
        $page->requires->js_init_call('M.mod_quiz.secure_window.init',
                null, false, quiz_get_js_module());
    }

    /**
     * @return array key => lang string any choices to add to the quiz Browser
     *      security settings menu.
     */
    public static function get_browser_security_choices() {
        return ['securewindow' =>
                get_string('popupwithjavascriptsupport', 'quizaccess_securewindow')];
    }
}
