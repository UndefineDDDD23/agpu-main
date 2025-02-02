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
 * Book external API
 *
 * @package    mod_book
 * @category   external
 * @copyright  2015 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      agpu 3.0
 */

use core_course\external\helper_for_get_mods_by_courses;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use core_external\external_warnings;
use core_external\util;

/**
 * Book external functions
 *
 * @package    mod_book
 * @category   external
 * @copyright  2015 Juan Leyva <juan@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      agpu 3.0
 */
class mod_book_external extends external_api {

    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     * @since agpu 3.0
     */
    public static function view_book_parameters() {
        return new external_function_parameters(
            array(
                'bookid' => new external_value(PARAM_INT, 'book instance id'),
                'chapterid' => new external_value(PARAM_INT, 'chapter id', VALUE_DEFAULT, 0)
            )
        );
    }

    /**
     * Simulate the book/view.php web interface page: trigger events, completion, etc...
     *
     * @param int $bookid the book instance id
     * @param int $chapterid the book chapter id
     * @return array of warnings and status result
     * @since agpu 3.0
     * @throws agpu_exception
     */
    public static function view_book($bookid, $chapterid = 0) {
        global $DB, $CFG;
        require_once($CFG->dirroot . "/mod/book/lib.php");
        require_once($CFG->dirroot . "/mod/book/locallib.php");

        $params = self::validate_parameters(self::view_book_parameters(),
                                            array(
                                                'bookid' => $bookid,
                                                'chapterid' => $chapterid
                                            ));
        $bookid = $params['bookid'];
        $chapterid = $params['chapterid'];

        $warnings = array();

        // Request and permission validation.
        $book = $DB->get_record('book', array('id' => $bookid), '*', MUST_EXIST);
        list($course, $cm) = get_course_and_cm_from_instance($book, 'book');

        $context = context_module::instance($cm->id);
        self::validate_context($context);

        require_capability('mod/book:read', $context);

        $chapters = book_preload_chapters($book);
        $firstchapterid = 0;

        foreach ($chapters as $ch) {
            if ($ch->hidden) {
                continue;
            }
            if (!$firstchapterid) {
                $firstchapterid = $ch->id;
            }
        }

        if (!$chapterid) {
            // Trigger the module viewed events since we are displaying the book.
            book_view($book, null, false, $course, $cm, $context);
            $chapterid = $firstchapterid;
        }

        // Check if book is empty (warning).
        if (!$chapterid) {
            $warnings[] = array(
                'item' => 'book',
                'itemid' => $book->id,
                'warningcode' => '1',
                'message' => get_string('nocontent', 'mod_book')
            );
        } else {
            $chapter = $DB->get_record('book_chapters', array('id' => $chapterid, 'bookid' => $book->id));
            $viewhidden = has_capability('mod/book:viewhiddenchapters', $context);

            if (!$chapter or ($chapter->hidden and !$viewhidden)) {
                throw new agpu_exception('errorchapter', 'mod_book');
            }

            // Trigger the chapter viewed event.
            book_view($book, $chapter, \mod_book\helper::is_last_visible_chapter($chapterid, $chapters), $course, $cm, $context);
        }

        $result = array();
        $result['status'] = true;
        $result['warnings'] = $warnings;
        return $result;
    }

    /**
     * Returns description of method result value
     *
     * @return \core_external\external_description
     * @since agpu 3.0
     */
    public static function view_book_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_BOOL, 'status: true if success'),
                'warnings' => new external_warnings()
            )
        );
    }

    /**
     * Describes the parameters for get_books_by_courses.
     *
     * @return external_function_parameters
     * @since agpu 3.0
     */
    public static function get_books_by_courses_parameters() {
        return new external_function_parameters (
            array(
                'courseids' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'course id'), 'Array of course ids', VALUE_DEFAULT, array()
                ),
            )
        );
    }

    /**
     * Returns a list of books in a provided list of courses,
     * if no list is provided all books that the user can view will be returned.
     *
     * @param array $courseids the course ids
     * @return array of books details
     * @since agpu 3.0
     */
    public static function get_books_by_courses($courseids = array()) {

        $returnedbooks = array();
        $warnings = array();

        $params = self::validate_parameters(self::get_books_by_courses_parameters(), array('courseids' => $courseids));

        $courses = array();
        if (empty($params['courseids'])) {
            $courses = enrol_get_my_courses();
            $params['courseids'] = array_keys($courses);
        }

        // Ensure there are courseids to loop through.
        if (!empty($params['courseids'])) {

            list($courses, $warnings) = util::validate_courses($params['courseids'], $courses);

            // Get the books in this course, this function checks users visibility permissions.
            // We can avoid then additional validate_context calls.
            $books = get_all_instances_in_courses("book", $courses);
            foreach ($books as $book) {
                // Entry to return.
                $bookdetails = helper_for_get_mods_by_courses::standard_coursemodule_element_values($book, 'mod_book');
                $bookdetails['numbering']         = $book->numbering;
                $bookdetails['navstyle']          = $book->navstyle;
                $bookdetails['customtitles']      = $book->customtitles;

                if (has_capability('agpu/course:manageactivities', context_module::instance($book->coursemodule))) {
                    $bookdetails['revision']      = $book->revision;
                    $bookdetails['timecreated']   = $book->timecreated;
                    $bookdetails['timemodified']  = $book->timemodified;
                }
                $returnedbooks[] = $bookdetails;
            }
        }
        $result = array();
        $result['books'] = $returnedbooks;
        $result['warnings'] = $warnings;
        return $result;
    }

    /**
     * Describes the get_books_by_courses return value.
     *
     * @return external_single_structure
     * @since agpu 3.0
     */
    public static function get_books_by_courses_returns() {
        return new external_single_structure(
            array(
                'books' => new external_multiple_structure(
                    new external_single_structure(array_merge(
                        helper_for_get_mods_by_courses::standard_coursemodule_elements_returns(),
                        [
                            'numbering' => new external_value(PARAM_INT, 'Book numbering configuration'),
                            'navstyle' => new external_value(PARAM_INT, 'Book navigation style configuration'),
                            'customtitles' => new external_value(PARAM_INT, 'Book custom titles type'),
                            'revision' => new external_value(PARAM_INT, 'Book revision', VALUE_OPTIONAL),
                            'timecreated' => new external_value(PARAM_INT, 'Time of creation', VALUE_OPTIONAL),
                            'timemodified' => new external_value(PARAM_INT, 'Time of last modification', VALUE_OPTIONAL),
                        ]
                    ), 'Books')
                ),
                'warnings' => new external_warnings(),
            )
        );
    }
}
