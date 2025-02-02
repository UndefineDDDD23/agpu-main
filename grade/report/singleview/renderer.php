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
 * Renderer for the grade single view report.
 *
 * @package   gradereport_singleview
 * @copyright 2022 Mihail Geshoski <mihail@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\output\comboboxsearch;
use gradereport_singleview\report\singleview;

/**
 * Custom renderer for the single view report.
 *
 * To get an instance of this use the following code:
 * $renderer = $PAGE->get_renderer('gradereport_singleview');
 *
 * @copyright 2022 Mihail Geshoski <mihail@agpu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gradereport_singleview_renderer extends plugin_renderer_base {

    /**
     * Renders the user selector trigger element.
     *
     * @param object $course The course object.
     * @param int|null $userid The user ID.
     * @param int|null $groupid The group ID.
     * @return string The raw HTML to render.
     */
    public function users_selector(object $course, ?int $userid = null, ?int $groupid = null): string {
        $courserenderer = $this->page->get_renderer('core', 'course');
        $resetlink = new agpu_url('/grade/report/singleview/index.php', ['id' => $course->id, 'group' => $groupid ?? 0]);
        $usersearch = '';

        if ($userid) {
            $user = core_user::get_user($userid);
            $usersearch = fullname($user);
        }

        return $courserenderer->render(
            new \core_course\output\actionbar\user_selector(
                course: $course,
                resetlink: $resetlink,
                userid: $userid,
                groupid: $groupid,
                usersearch: $usersearch
            )
        );
    }

    /**
     * Renders the grade items selector trigger element.
     *
     * @param object $course The course object.
     * @param int|null $gradeitemid The grade item ID.
     * @return string The raw HTML to render.
     */
    public function grade_items_selector(object $course, ?int $gradeitemid = null): string {

        $data = [
            'name' => 'itemid',
            'courseid' => $course->id,
            'instance' => rand(),
        ];

        // If a particular grade item option is selected (not in zero state).
        if ($gradeitemid) {
            $gradeitemname = grade_item::fetch(['id' => $gradeitemid])->get_name(true);
            $data['selectedoption'] = [
                'text' => $gradeitemname,
            ];
            $data['itemid'] = $gradeitemid;
        }

        $sbody = $this->render_from_template('core/local/comboboxsearch/searchbody', [
            'courseid' => $course->id,
            'currentvalue' => optional_param('gradesearchvalue', '', PARAM_NOTAGS),
            'instance' => $data['instance'],
        ]);
        $dropdown = new comboboxsearch(
            false,
            $this->render_from_template('gradereport_singleview/grade_item_selector', $data),
            $sbody,
            'grade-search h-100',
            'gradesearchwidget h-100',
            'gradesearchdropdown overflow-auto',
            null,
            true,
            get_string('selectagrade', 'gradereport_singleview'),
            'itemid',
            $gradeitemid
        );
        return $this->render($dropdown);
    }

    /**
     * Creates and renders previous/next user/grade item navigation.
     *
     * @param object $gpr grade plugin return tracking object
     * @param int $courseid The course ID.
     * @param \context_course $context Context of the report.
     * @param singleview $report The single view report class.
     * @param int|null $groupid Group ID
     * @param string $itemtype User or Grade item type
     * @param int $itemid Either User ID or Grade item ID
     * @return string The raw HTML to render.
     * @throws agpu_exception
     */
    public function report_navigation(object $gpr, int $courseid, \context_course $context, singleview $report,
                                      ?int $groupid, string $itemtype, int $itemid): string {

        $navigation = '';
        $options = $report->screen->options();

        $optionkeys = array_keys($options);
        $optionitemid = array_shift($optionkeys);

        $relreport = new gradereport_singleview\report\singleview(
            $courseid, $gpr, $context,
            $report->screen->item_type(), $optionitemid
        );
        $reloptions = $relreport->screen->options();
        $reloptionssorting = array_keys($relreport->screen->options());

        $i = array_search($itemid, $reloptionssorting);
        $navparams = ['item' => $itemtype, 'id' => $courseid, 'group' => $groupid];

        // Determine directionality so that icons can be modified to suit language.
        $previousarrow = right_to_left() ? 'right' : 'left';
        $nextarrow = right_to_left() ? 'left' : 'right';

        if ($i > 0) {
            $navparams['itemid'] = $reloptionssorting[$i - 1];
            $link = (new agpu_url('/grade/report/singleview/index.php', $navparams))
                ->out(false);
            $navigationdata['previoususer'] = [
                'name' => $reloptions[$navparams['itemid']],
                'url' => $link,
                'previousarrow' => $previousarrow
            ];
        }
        if ($i < count($reloptionssorting) - 1) {
            $navparams['itemid'] = $reloptionssorting[$i + 1];
            $link = (new agpu_url('/grade/report/singleview/index.php', $navparams))
                ->out(false);
            $navigationdata['nextuser'] = [
                'name' => $reloptions[$navparams['itemid']],
                'url' => $link,
                'nextarrow' => $nextarrow
            ];
        }

        if ($report->screen->supports_paging()) {
            $navigationdata['perpageselect'] = $report->screen->perpage_select();
        }

        if (isset($navigationdata)) {
            $navigation = $this->render_from_template('gradereport_singleview/report_navigation', $navigationdata);
        }
        return $navigation;
    }

}
