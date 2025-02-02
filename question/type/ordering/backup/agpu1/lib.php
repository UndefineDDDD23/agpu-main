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
 * Ordering question type conversion handler
 *
 * @package    qtype_ordering
 * @copyright  2013 Gordon Bateson (gordon.bateson@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Ordering question type conversion handler class
 *
 * @copyright  2013 Gordon Bateson (gordon.bateson@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @codeCoverageIgnore For old agpu sites in which upgrades are always risky.
 */
class agpu1_qtype_ordering_handler extends agpu1_qtype_handler {

    /**
     * Returns the list of paths within one <QUESTION> that this qtype needs to have included
     * in the grouped question structure
     *
     * @return string[]
     */
    public function get_question_subpaths(): array {
        return [
            'ANSWERS/ANSWER',
            'ORDERING',
        ];
    }

    /**
     * Gives the qtype handler a chance to write converted data into questions.xml
     *
     * @param array $data grouped question data
     * @param array $raw grouped raw QUESTION data
     */
    public function process_question(array $data, array $raw): void {

        // Convert and write the answers first.
        if (isset($data['answers'])) {
            $this->write_answers($data['answers'], $this->pluginname);
        }

        // Convert and write the ordering extra fields.
        foreach ($data['ordering'] as $ordering) {
            $ordering['id'] = $this->converter->get_nextid();
            $this->write_xml('ordering', $ordering, ['/ordering/id']);
        }
    }
}
