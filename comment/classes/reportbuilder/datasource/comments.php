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

declare(strict_types=1);

namespace core_comment\reportbuilder\datasource;

use core\reportbuilder\local\entities\context;
use core_reportbuilder\datasource;
use core_reportbuilder\local\entities\user;
use core_comment\reportbuilder\local\entities\comment;

/**
 * Comments datasource
 *
 * @package     core_comment
 * @copyright   2022 Paul Holden <paulh@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class comments extends datasource {

    /**
     * Return user friendly name of the report source
     *
     * @return string
     */
    public static function get_name(): string {
        return get_string('comments', 'core_comment');
    }

    /**
     * Initialise report
     */
    protected function initialise(): void {
        $commententity = new comment();
        $commentalias = $commententity->get_table_alias('comments');

        $this->set_main_table('comments', $commentalias);
        $this->add_entity($commententity);

        // Join the context entity.
        $contextentity = (new context())
            ->set_table_alias('context', $commententity->get_table_alias('context'));
        $this->add_entity($contextentity
            ->add_join($commententity->get_context_join())
        );

        // Join the user entity to the comment userid (author).
        $userentity = new user();
        $useralias = $userentity->get_table_alias('user');
        $this->add_entity($userentity
            ->add_join("LEFT JOIN {user} {$useralias} ON {$useralias}.id = {$commentalias}.userid"));

        // Add report elements from each of the entities we added to the report.
        $this->add_all_from_entities();
    }

    /**
     * Return the columns that will be added to the report upon creation
     *
     * @return string[]
     */
    public function get_default_columns(): array {
        return [
            'user:fullname',
            'context:name',
            'comment:content',
            'comment:timecreated',
        ];
    }

    /**
     * Return the column sorting that will be added to the report upon creation
     *
     * @return int[]
     */
    public function get_default_column_sorting(): array {
        return [
            'user:fullname' => SORT_ASC,
            'comment:timecreated' => SORT_ASC,
        ];
    }

    /**
     * Return the filters that will be added to the report upon creation
     *
     * @return string[]
     */
    public function get_default_filters(): array {
        return [
            'comment:content',
        ];
    }

    /**
     * Return the conditions that will be added to the report upon creation
     *
     * @return string[]
     */
    public function get_default_conditions(): array {
        return [
            'user:fullname',
        ];
    }
}
