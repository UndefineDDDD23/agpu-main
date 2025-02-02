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
 * @package    report_insights
 * @copyright  2016 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_insights\output;

defined('agpu_INTERNAL') || die();

use plugin_renderer_base;
use templatable;
use renderable;

/**
 * Renderer class.
 *
 * @package    report_insights
 * @copyright  2016 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Renders the list of insights
     *
     * @param renderable $renderable
     * @return string HTML
     */
    protected function render_insights_list(renderable $renderable) {
        $data = $renderable->export_for_template($this);
        return parent::render_from_template('report_insights/insights_list', $data);
    }

    /**
     * Renders an insight
     *
     * @param renderable $renderable
     * @return string HTML
     */
    protected function render_insight(renderable $renderable) {
        $data = $renderable->export_for_template($this);
        $renderable->get_model()->get_target()->add_bulk_actions_js();
        return parent::render_from_template('report_insights/insight_details', $data);
    }

    /**
     * Model disabled info.
     *
     * @param \stdClass $insightinfo
     * @return string HTML
     */
    public function render_model_disabled($insightinfo) {

        // We don't want to disclose the name of the model if it has not been enabled.
        $this->page->set_title($insightinfo->contextname);
        $this->page->set_heading($insightinfo->contextname);

        $output = $this->output->header();
        $output .= $this->output->notification(get_string('disabledmodel', 'report_insights'),
                \core\output\notification::NOTIFY_INFO);
        $output .= $this->output->footer();

        return $output;
    }

    /**
     * Model without insights info.
     *
     * @param \context $context
     * @return string HTML
     */
    public function render_no_insights(\context $context) {

        // We don't want to disclose the name of the model if it has not been enabled.
        $this->page->set_title($context->get_context_name());
        $this->page->set_heading($context->get_context_name());

        $output = $this->output->header();
        $output .= $this->output->notification(get_string('noinsights', 'analytics'),
                \core\output\notification::NOTIFY_INFO);
        $output .= $this->output->footer();

        return $output;
    }

    /**
     * Model which target does not generate insights.
     *
     * @param \context $context
     * @return string HTML
     */
    public function render_no_insights_model(\context $context) {

        // We don't want to disclose the name of the model if it has not been enabled.
        $this->page->set_title($context->get_context_name());
        $this->page->set_heading($context->get_context_name());

        $output = $this->output->header();
        $output .= $this->output->notification(get_string('noinsightsmodel', 'analytics'),
                \core\output\notification::NOTIFY_INFO);
        $output .= $this->output->footer();

        return $output;
    }

    /**
     * Renders an analytics disabled notification.
     *
     * @return string HTML
     */
    public function render_analytics_disabled() {
        global $FULLME;

        $this->page->set_url($FULLME);
        $this->page->set_title(get_string('pluginname', 'report_insights'));
        $this->page->set_heading(get_string('pluginname', 'report_insights'));

        $output = $this->output->header();
        $output .= $this->output->notification(get_string('analyticsdisabled', 'analytics'),
                \core\output\notification::NOTIFY_INFO);
        $output .= \html_writer::tag('a', get_string('continue'), ['class' => 'btn btn-primary',
            'href' => (new \agpu_url('/'))->out()]);
        $output .= $this->output->footer();

        return $output;
    }
}
