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

namespace core_reportbuilder\local\filters;

use agpuQuickForm;
use core_reportbuilder\local\helpers\database;

/**
 * Course selector filter class implementation
 *
 * @package     core_reportbuilder
 * @copyright   2021 David Matamoros <davidmc@agpu.com>.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_selector extends base {

    /**
     * Setup form
     *
     * @param agpuQuickForm $mform
     */
    public function setup_form(agpuQuickForm $mform): void {
        $operatorlabel = get_string('filterfieldvalue', 'core_reportbuilder', $this->get_header());
        $options = [
            'multiple' => true,
        ];

        $mform->addElement('course', $this->name . '_values', $operatorlabel, $options)
            ->setHiddenLabel(true);
    }

    /**
     * Return filter SQL
     *
     * @param array $values
     * @return array
     */
    public function get_sql_filter(array $values): array {
        global $DB;

        $fieldsql = $this->filter->get_field_sql();
        $params = $this->filter->get_field_params();

        $courseids = $values["{$this->name}_values"] ?? [];
        if (empty($courseids)) {
            return ['', []];
        }

        [$courseselect, $courseparams] = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED, database::generate_param_name('_'));

        return ["{$fieldsql} $courseselect", array_merge($params, $courseparams)];
    }

    /**
     * Return sample filter values
     *
     * @return array
     */
    public function get_sample_values(): array {
        return [
            "{$this->name}_values" => [1],
        ];
    }
}
