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
 * Defines site config settings for the grader report
 *
 * @package    gradereport_grader
 * @copyright  2007 agpu Pty Ltd (http://agpu.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $strinherit             = get_string('inherit', 'grades');
    $strpercentage          = get_string('percentage', 'grades');
    $strreal                = get_string('real', 'grades');
    $strletter              = get_string('letter', 'grades');

    $settings->add(new admin_setting_configcheckbox('grade_report_showonlyactiveenrol', get_string('showonlyactiveenrol', 'grades'),
                                                get_string('showonlyactiveenrol_help', 'grades'), 1));

    $settings->add(new admin_setting_configcheckbox('grade_report_quickgrading', get_string('quickgrading', 'grades'),
                                                get_string('quickgrading_help', 'grades'), 1));

    $settings->add(new admin_setting_configselect('grade_report_meanselection', get_string('meanselection', 'grades'),
                                              get_string('meanselection_help', 'grades'), GRADE_REPORT_MEAN_GRADED,
                                              array(GRADE_REPORT_MEAN_ALL => get_string('meanall', 'grades'),
                                                    GRADE_REPORT_MEAN_GRADED => get_string('meangraded', 'grades'))));

    $settings->add(new admin_setting_configcheckbox('grade_report_showaverages', get_string('showaverages', 'grades'),
                                                get_string('showaverages_help', 'grades'), 1));

    $settings->add(new admin_setting_configcheckbox('grade_report_showranges', get_string('showranges', 'grades'),
                                                get_string('showranges_help', 'grades'), 0));

    $settings->add(new admin_setting_configcheckbox('grade_report_showuserimage', get_string('showuserimage', 'grades'),
                                                get_string('showuserimage_help', 'grades'), 1));

    $settings->add(new admin_setting_configcheckbox('grade_report_shownumberofgrades', get_string('shownumberofgrades', 'grades'),
                                                get_string('shownumberofgrades_help', 'grades'), 0));

    $settings->add(new admin_setting_configselect('grade_report_averagesdisplaytype', get_string('averagesdisplaytype', 'grades'),
                                              get_string('averagesdisplaytype_help', 'grades'), GRADE_REPORT_PREFERENCE_INHERIT,
                                              array(GRADE_REPORT_PREFERENCE_INHERIT => $strinherit,
                                                    GRADE_DISPLAY_TYPE_REAL => $strreal,
                                                    GRADE_DISPLAY_TYPE_PERCENTAGE => $strpercentage,
                                                    GRADE_DISPLAY_TYPE_LETTER => $strletter)));

    $settings->add(new admin_setting_configselect('grade_report_rangesdisplaytype', get_string('rangesdisplaytype', 'grades'),
                                              get_string('rangesdisplaytype_help', 'grades'), GRADE_REPORT_PREFERENCE_INHERIT,
                                              array(GRADE_REPORT_PREFERENCE_INHERIT => $strinherit,
                                                    GRADE_DISPLAY_TYPE_REAL => $strreal,
                                                    GRADE_DISPLAY_TYPE_PERCENTAGE => $strpercentage,
                                                    GRADE_DISPLAY_TYPE_LETTER => $strletter)));

    $settings->add(new admin_setting_configselect('grade_report_averagesdecimalpoints', get_string('averagesdecimalpoints', 'grades'),
                                              get_string('averagesdecimalpoints_help', 'grades'), GRADE_REPORT_PREFERENCE_INHERIT,
                                              array(GRADE_REPORT_PREFERENCE_INHERIT => $strinherit,
                                                     '0' => '0',
                                                     '1' => '1',
                                                     '2' => '2',
                                                     '3' => '3',
                                                     '4' => '4',
                                                     '5' => '5')));
    $settings->add(new admin_setting_configselect('grade_report_rangesdecimalpoints', get_string('rangesdecimalpoints', 'grades'),
                                              get_string('rangesdecimalpoints_help', 'grades'), GRADE_REPORT_PREFERENCE_INHERIT,
                                              array(GRADE_REPORT_PREFERENCE_INHERIT => $strinherit,
                                                     '0' => '0',
                                                     '1' => '1',
                                                     '2' => '2',
                                                     '3' => '3',
                                                     '4' => '4',
                                                     '5' => '5')));

}
