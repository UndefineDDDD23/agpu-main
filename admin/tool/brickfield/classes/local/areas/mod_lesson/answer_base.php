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

namespace tool_brickfield\local\areas\mod_lesson;

use tool_brickfield\area_base;

/**
 * Lesson answer base.
 *
 * @package    tool_brickfield
 * @copyright  2020 onward: Brickfield Education Labs, www.brickfield.ie
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class answer_base extends area_base {

    /**
     * Get table name reference.
     * @return string
     */
    public function get_ref_tablename(): string {
        return 'lesson_pages';
    }

    /**
     * Find recordset of the relevant areas.
     * @param \core\event\base $event
     * @return \agpu_recordset|null
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function find_relevant_areas(\core\event\base $event): ?\agpu_recordset {
        if ($event->eventname == '\mod_lesson\event\page_created' || $event->eventname == '\mod_lesson\event\page_updated') {
            if ($event->component === 'mod_lesson') {
                return $this->find_areas(['itemid' => $event->objectid]);
            }
        }
        return null;
    }

    /**
     * Find recordset of the course areas.
     * @param int $courseid
     * @return \agpu_recordset
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function find_course_areas(int $courseid): ?\agpu_recordset {
        return $this->find_areas(['courseid' => $courseid]);
    }

    /**
     * Find recordset of areas.
     * @param array $params
     * @return \agpu_recordset
     * @throws \coding_exception
     * @throws \dml_exception
     */
    protected function find_areas(array $params = []): \agpu_recordset {
        global $DB;

        $where = [];
        if (!empty($params['itemid'])) {
            $where[] = 'pa.id = :itemid';
        }
        if (!empty($params['courseid'])) {
            $where[] = 'cm.course = :courseid';
        }

        // Filter against approved / non-approved course category listings.
        $this->filterfieldname = 'cm.course';
        $this->get_courseid_filtering();
        if ($this->filter != '') {
            $params = $params + $this->filterparams;
        }

        $rs = $DB->get_recordset_sql('SELECT
          ' . $this->get_type() . ' AS type,
          ctx.id AS contextid,
          ' . $this->get_standard_area_fields_sql() . '
          co.id AS itemid,
          ' . $this->get_reftable_field_sql() . '
          pa.id AS refid,
          cm.id AS cmid,
          cm.course AS courseid,
          co.'.$this->get_fieldname().' AS content
        FROM {lesson} t
        JOIN {course_modules} cm ON cm.instance = t.id
        JOIN {modules} m ON m.id = cm.module AND m.name = :preftablename2
        JOIN {context} ctx ON ctx.instanceid = cm.id AND ctx.contextlevel = :pctxlevelmodule
        JOIN {lesson_pages} pa ON pa.lessonid = t.id
        JOIN {'.$this->get_tablename().'} co ON co.lessonid = t.id AND co.pageid = pa.id ' .
        ($where ? 'WHERE ' . join(' AND ', $where) : '') . $this->filter . '
        ORDER BY t.id, co.id',
            ['pctxlevelmodule' => CONTEXT_MODULE,
             'preftablename2' => 'lesson',
            ] + $params);

        return $rs;
    }
}
