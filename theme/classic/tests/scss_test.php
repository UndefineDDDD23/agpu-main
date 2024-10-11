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

namespace theme_classic;

/**
 * Unit tests for scss compilation.
 *
 * @package   theme_classic
 * @category  test
 * @copyright 2019 Michael Hawkins
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class scss_test extends \advanced_testcase {
    /**
     * Test that classic can be compiled using SassC (the defacto implemention).
     */
    public function test_scss_compilation_with_sassc(): void {
        if (!defined('PHPUNIT_PATH_TO_SASSC')) {
            $this->markTestSkipped('Path to SassC not provided');
        }

        $this->resetAfterTest();
        set_config('pathtosassc', PHPUNIT_PATH_TO_SASSC);

        $this->assertNotEmpty(
            \theme_config::load('classic')->get_css_content_debug('scss', null, null)
        );
    }
}