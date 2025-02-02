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
 * Restore instructions for the seb (Safe Exam Browser) quiz access subplugin.
 *
 * @package    quizaccess_seb
 * @category   backup
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2020 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use quizaccess_seb\seb_quiz_settings;
use quizaccess_seb\settings_provider;
use quizaccess_seb\template;

defined('agpu_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/backup/agpu2/restore_mod_quiz_access_subplugin.class.php');

/**
 * Restore instructions for the seb (Safe Exam Browser) quiz access subplugin.
 *
 * @copyright  2020 Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_quizaccess_seb_subplugin extends restore_mod_quiz_access_subplugin {

    /**
     * Provides path structure required to restore data for seb quiz access plugin.
     *
     * @return array
     */
    protected function define_quiz_subplugin_structure() {
        $paths = [];

        // Quiz settings.
        $path = $this->get_pathfor('/quizaccess_seb_quizsettings'); // Subplugin root path.
        $paths[] = new restore_path_element('quizaccess_seb_quizsettings', $path);

        // Template settings.
        $path = $this->get_pathfor('/quizaccess_seb_quizsettings/quizaccess_seb_template');
        $paths[] = new restore_path_element('quizaccess_seb_template', $path);

        return $paths;
    }

    /**
     * Process the restored data for the quizaccess_seb_quizsettings table.
     *
     * @param stdClass $data Data for quizaccess_seb_quizsettings retrieved from backup xml.
     */
    public function process_quizaccess_seb_quizsettings($data) {
        global $DB, $USER;

        // Process quizsettings.
        $data = (object) $data;
        $data->quizid = $this->get_new_parentid('quiz'); // Update quizid with new reference.
        $data->cmid = $this->task->get_moduleid();

        unset($data->id);
        $data->timecreated = $data->timemodified = time();
        $data->usermodified = $USER->id;

        // Do not use template if it is no longer enabled.
        if ($data->requiresafeexambrowser == settings_provider::USE_SEB_TEMPLATE &&
                !$DB->record_exists(template::TABLE, ['id' => $data->templateid, 'enabled' => '1'])) {
            $data->templateid = 0;
            $data->requiresafeexambrowser = settings_provider::USE_SEB_NO;
        }

        $DB->insert_record(seb_quiz_settings::TABLE, $data);

        // Process attached files.
        $this->add_related_files('quizaccess_seb', 'filemanager_sebconfigfile', null);
    }

    /**
     * Process the restored data for the quizaccess_seb_template table.
     *
     * @param stdClass $data Data for quizaccess_seb_template retrieved from backup xml.
     */
    public function process_quizaccess_seb_template($data) {
        global $DB;

        $data = (object) $data;

        $quizid = $this->get_new_parentid('quiz');

        $template = null;
        if ($this->task->is_samesite()) {
            $template = \quizaccess_seb\template::get_record(['id' => $data->id]);
        } else {
            // In a different site, try to find existing template with the same name and content.
            $candidates = \quizaccess_seb\template::get_records(['name' => $data->name]);
            foreach ($candidates as $candidate) {
                if ($candidate->get('content') == $data->content) {
                    $template = $candidate;
                    break;
                }
            }
        }

        if (empty($template)) {
            unset($data->id);
            $template = new \quizaccess_seb\template(0, $data);
            $template->save();
        }

        // Update the restored quiz settings to use restored template.
        // Check if template is enabled before using it.
        if ($template->get('enabled')) {
            $DB->set_field(seb_quiz_settings::TABLE, 'templateid', $template->get('id'), ['quizid' => $quizid]);
        }
    }

}

