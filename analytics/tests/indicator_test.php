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

namespace core_analytics;

defined('agpu_INTERNAL') || die();

require_once(__DIR__ . '/fixtures/test_indicator_max.php');
require_once(__DIR__ . '/fixtures/test_indicator_discrete.php');
require_once(__DIR__ . '/fixtures/test_indicator_min.php');

/**
 * Unit tests for the model.
 *
 * @package   core_analytics
 * @copyright 2017 David Monllaó {@link http://www.davidmonllao.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class indicator_test extends \advanced_testcase {

    /**
     * test_validate_calculated_value
     *
     * @param string $indicatorclass
     * @param array $returnedvalue
     * @dataProvider validate_calculated_value
     * @return null
     */
    public function test_validate_calculated_value($indicatorclass, $returnedvalue): void {
        $indicator = new $indicatorclass();
        list($values, $unused) = $indicator->calculate([1], 'notrelevanthere');
        $this->assertEquals($returnedvalue, $values[0]);
    }

    /**
     * Data provider for test_validate_calculated_value
     *
     * @return array
     */
    public function validate_calculated_value() {
        return [
            'max' => ['test_indicator_max', [1]],
            'min' => ['test_indicator_min', [-1]],
            'discrete' => ['test_indicator_discrete', [0, 0, 0, 0, 1]],
        ];
    }

    /**
     * test_validate_calculated_value_exceptions
     *
     * @param string $indicatorclass
     * @param string $willreturn
     * @dataProvider validate_calculated_value_exceptions
     * @return null
     */
    public function test_validate_calculated_value_exceptions($indicatorclass, $willreturn): void {

        $indicator = new $indicatorclass();
        $indicatormock = $this->getMockBuilder(get_class($indicator))
            ->onlyMethods(['calculate_sample'])
            ->getMock();
        $indicatormock->method('calculate_sample')->willReturn($willreturn);
        $this->expectException(\coding_exception::class);
        list($values, $unused) = $indicatormock->calculate([1], 'notrelevanthere');

    }

    /**
     * Data provider for test_validate_calculated_value_exceptions
     *
     * @return array
     */
    public function validate_calculated_value_exceptions() {
        return [
            'max' => ['test_indicator_max', 2],
            'min' => ['test_indicator_min', -2],
            'discrete' => ['test_indicator_discrete', 7],
        ];
    }
}
