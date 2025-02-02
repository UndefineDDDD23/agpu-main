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
 * Renderer.
 *
 * @package    tool_analytics
 * @copyright  2016 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_analytics\output;

defined('agpu_INTERNAL') || die();

use plugin_renderer_base;


/**
 * Renderer class.
 *
 * @package    tool_analytics
 * @copyright  2016 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Defer to template.
     *
     * @param \tool_analytics\output\models_list $modelslist
     * @return string HTML
     */
    protected function render_models_list(\tool_analytics\output\models_list $modelslist) {
        $data = $modelslist->export_for_template($this);
        return parent::render_from_template('tool_analytics/models_list', $data);
    }

    /**
     * Renders a table.
     *
     * @param \table_sql $table
     * @return string HTML
     */
    public function render_table(\table_sql $table) {

        ob_start();
        $table->out(10, true);
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * Web interface evaluate results.
     *
     * @param \stdClass[] $results
     * @param string[] $logs
     * @return string HTML
     */
    public function render_evaluate_results($results, $logs = array()) {
        $output = '';

        foreach ($results as $timesplittingid => $result) {

            if (!CLI_SCRIPT) {
                $output .= $this->output->box_start('generalbox mb-3');
            }

            // Check that the array key is a string, not all results depend on time splitting methods (e.g. general errors).
            if (!is_numeric($timesplittingid)) {
                $timesplitting = \core_analytics\manager::get_time_splitting($timesplittingid);
                $langstrdata = (object)array('name' => $timesplitting->get_name(), 'id' => $timesplittingid);

                if (CLI_SCRIPT) {
                    $output .= $this->output->heading(get_string('scheduledanalysisresultscli', 'tool_analytics', $langstrdata), 3);
                } else {
                    $output .= $this->output->heading(get_string('scheduledanalysisresults', 'tool_analytics', $langstrdata), 3);
                }
            }

            if ($result->status == 0) {
                $output .= $this->output->notification(get_string('goodmodel', 'tool_analytics'),
                    \core\output\notification::NOTIFY_SUCCESS);
            } else if ($result->status === \core_analytics\model::NO_DATASET) {
                $output .= $this->output->notification(get_string('nodatatoevaluate', 'tool_analytics'),
                    \core\output\notification::NOTIFY_WARNING);
            }

            if (isset($result->score)) {
                // Score.
                $output .= $this->output->heading(get_string('accuracy', 'tool_analytics') . ': ' .
                    round(floatval($result->score), 4) * 100  . '%', 4);
            }

            if (!empty($result->info)) {
                foreach ($result->info as $message) {
                    $output .= $this->output->notification($message, \core\output\notification::NOTIFY_WARNING);
                }
            }

            if (!CLI_SCRIPT) {
                $output .= $this->output->box_end();
            }
        }

        // Info logged during evaluation.
        if (!empty($logs) && debugging()) {
            $output .= $this->output->heading(get_string('extrainfo', 'tool_analytics'), 3);
            foreach ($logs as $log) {
                $output .= $this->output->notification($log, \core\output\notification::NOTIFY_WARNING);
            }
        }

        if (!CLI_SCRIPT) {
            $output .= $this->output->single_button(new \agpu_url('/admin/tool/analytics/index.php'),
                    get_string('continue'), 'get');
        }

        return $output;
    }


    /**
     * Web interface training & prediction results.
     *
     * @param \stdClass|false $trainresults
     * @param string[] $trainlogs
     * @param \stdClass|false $predictresults
     * @param string[] $predictlogs
     * @return string HTML
     */
    public function render_get_predictions_results($trainresults = false, $trainlogs = array(), $predictresults = false, $predictlogs = array()) {
        $output = '';

        if ($trainresults || (!empty($trainlogs) && debugging())) {
            $output .= $this->output->heading(get_string('trainingresults', 'tool_analytics'), 3);
        }

        if ($trainresults) {
            if ($trainresults->status == 0) {
                $output .= $this->output->notification(
                        get_string('trainingprocessfinished', 'tool_analytics'),
                    \core\output\notification::NOTIFY_SUCCESS);
            } else if ($trainresults->status === \core_analytics\model::NO_DATASET ||
                    $trainresults->status === \core_analytics\model::NOT_ENOUGH_DATA) {
                $output .= $this->output->notification(
                        get_string('nodatatotrain', 'tool_analytics'),
                    \core\output\notification::NOTIFY_WARNING);
            } else {
                $output .= $this->output->notification(
                        get_string('generalerror', 'tool_analytics', $trainresults->status),
                    \core\output\notification::NOTIFY_ERROR);
            }
        }

        if (!empty($trainlogs) && debugging()) {
            $output .= $this->output->heading(get_string('extrainfo', 'tool_analytics'), 4);
            foreach ($trainlogs as $log) {
                $output .= $this->output->notification($log, \core\output\notification::NOTIFY_WARNING);
            }
        }

        if ($predictresults || (!empty($predictlogs) && debugging())) {
            $output .= $this->output->heading(
                    get_string('predictionresults', 'tool_analytics'), 3, 'main mt-3');
        }

        if ($predictresults) {
            if ($predictresults->status == 0) {
                $output .= $this->output->notification(
                        get_string('predictionprocessfinished', 'tool_analytics'),
                    \core\output\notification::NOTIFY_SUCCESS);
            } else if ($predictresults->status === \core_analytics\model::NO_DATASET ||
                    $predictresults->status === \core_analytics\model::NOT_ENOUGH_DATA) {
                $output .= $this->output->notification(
                        get_string('nodatatopredict', 'tool_analytics'),
                    \core\output\notification::NOTIFY_WARNING);
            } else {
                $output .= $this->output->notification(
                        get_string('generalerror', 'tool_analytics', $predictresults->status),
                    \core\output\notification::NOTIFY_ERROR);
            }
        }

        if (!empty($predictlogs) && debugging()) {
            $output .= $this->output->heading(get_string('extrainfo', 'tool_analytics'), 4);
            foreach ($predictlogs as $log) {
                $output .= $this->output->notification($log, \core\output\notification::NOTIFY_WARNING);
            }
        }

        if (!CLI_SCRIPT) {
            $output .= $this->output->single_button(new \agpu_url('/admin/tool/analytics/index.php'),
                    get_string('continue'), 'get');
        }

        return $output;
    }

    /**
     * Defer to template.
     *
     * @param \tool_analytics\output\insights_report $insightsreport
     * @return string HTML
     */
    protected function render_insights_report(\tool_analytics\output\insights_report $insightsreport): string {
        $data = $insightsreport->export_for_template($this);
        return parent::render_from_template('tool_analytics/insights_report', $data);
    }

    /**
     * Defer to template.
     *
     * @param \tool_analytics\output\invalid_analysables $invalidanalysables
     * @return string HTML
     */
    protected function render_invalid_analysables(\tool_analytics\output\invalid_analysables $invalidanalysables) {
        $data = $invalidanalysables->export_for_template($this);
        return parent::render_from_template('tool_analytics/invalid_analysables', $data);
    }

    /**
     * Renders an analytics disabled notification.
     *
     * @return string HTML
     */
    public function render_analytics_disabled() {
        global $FULLME;

        $this->page->set_url($FULLME);
        $this->page->set_title(get_string('pluginname', 'tool_analytics'));
        $this->page->set_heading(get_string('pluginname', 'tool_analytics'));

        $output = $this->output->header();
        $output .= $this->output->notification(get_string('analyticsdisabled', 'analytics'),
                \core\output\notification::NOTIFY_INFO);
        $output .= \html_writer::tag('a', get_string('continue'), ['class' => 'btn btn-primary',
            'href' => (new \agpu_url('/'))->out()]);
        $output .= $this->output->footer();

        return $output;
    }

}
