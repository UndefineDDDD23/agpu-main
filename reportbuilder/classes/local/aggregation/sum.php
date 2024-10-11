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

namespace core_reportbuilder\local\aggregation;

use lang_string;
use core_reportbuilder\local\report\column;

/**
 * Column sum aggregation type
 *
 * @package     core_reportbuilder
 * @copyright   2021 Paul Holden <paulh@agpu.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class sum extends base {

    /**
     * Return aggregation name
     *
     * @return lang_string
     */
    public static function get_name(): lang_string {
        return new lang_string('aggregationsum', 'core_reportbuilder');
    }

    /**
     * This aggregation can be performed on all numeric and boolean columns
     *
     * @param int $columntype
     * @return bool
     */
    public static function compatible(int $columntype): bool {
        return in_array($columntype, [
            column::TYPE_INTEGER,
            column::TYPE_FLOAT,
            column::TYPE_BOOLEAN,
        ]);
    }

    /**
     * Return the aggregated field SQL
     *
     * @param string $field
     * @param int $columntype
     * @return string
     */
    public static function get_field_sql(string $field, int $columntype): string {
        return "SUM({$field})";
    }

    /**
     * Return formatted value for column when applying aggregation
     *
     * For boolean columns we return the sum of the true values, numeric columns execute original callbacks if present
     *
     * @param mixed $value
     * @param array $values
     * @param array $callbacks
     * @param int $columntype
     * @return mixed
     */
    public static function format_value($value, array $values, array $callbacks, int $columntype) {
        $firstvalue = reset($values);
        if ($firstvalue === null) {
            return null;
        }
        if ($columntype === column::TYPE_BOOLEAN || empty($callbacks)) {
            $decimalpoints = (int) ($columntype === column::TYPE_FLOAT);
            return format_float((float) $firstvalue, $decimalpoints);
        }

        return parent::format_value($value, $values, $callbacks, $columntype);
    }
}
