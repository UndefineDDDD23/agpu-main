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
 * Behat data generator for core_question.
 *
 * @package   core_question
 * @category  test
 * @copyright 2020 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();


/**
 * Behat data generator for core_question.
 */
class behat_core_question_generator extends behat_generator_base {

    protected function get_creatable_entities(): array {
        // Note, for historical reasons, questions and question categories
        // are generated by behat_core_generator.
        return [
            'Tags' => [
                'singular' => 'Tag',
                'datagenerator' => 'question_tag',
                'required' => ['question', 'tag'],
                'switchids' => ['question' => 'questionid'],
            ],
            'updated questions' => [
                'singular' => 'question',
                'datagenerator' => 'updated_question',
                'required' => ['question', 'questioncategory'],
                'switchids' => ['question' => 'id', 'questioncategory' => 'category'],
            ],
        ];
    }

    /**
     * Look up the id of a question from its name.
     *
     * @param string $questionname the question name, for example 'Question 1'.
     * @return int corresponding id.
     */
    protected function get_question_id(string $questionname): int {
        global $DB;

        if (!$id = $DB->get_field('question', 'id', ['name' => $questionname])) {
            throw new Exception('There is no question with name "' . $questionname . '".');
        }
        return $id;
    }

    /**
     * Update a question
     *
     * This will update a question matching the supplied name with the provided data, creating a new version in the process.
     *
     * @param array $data the row of data from the behat script.
     * @return void
     */
    protected function process_updated_question(array $data): void {
        global $DB;
        $question = $DB->get_record('question', ['id' => $data['id']], '*', MUST_EXIST);
        foreach ($data as $key => $value) {
            $question->{$key} = $value;
        }

        $this->datagenerator->get_plugin_generator('core_question')->update_question($question);
    }
}
