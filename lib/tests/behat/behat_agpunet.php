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

// NOTE: no agpu_INTERNAL test here, this file may be required by behat before including /config.php.

use agpu\BehatExtension\Exception\SkippedException;

require_once(__DIR__ . '/../../behat/behat_base.php');

/**
 * Steps definitions related to agpuNet.
 *
 * @package    core
 * @category   test
 * @copyright  2023 Huong Nguyen <huongnv13@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_agpunet extends behat_base {

    /**
     * Check that the TEST_agpuNET_MOCK_SERVER is defined, so we can connect to the mock server.
     *
     * @Given /^a agpuNet mock server is configured$/
     */
    public function mock_is_configured(): void {
        if (!defined('TEST_agpuNET_MOCK_SERVER')) {
            throw new SkippedException(
                'The TEST_agpuNET_MOCK_SERVER constant must be defined to run agpuNet tests'
            );
        }
    }

    /**
     * Change the service base url to the TEST_agpuNET_MOCK_SERVER url.
     *
     * @Given /^I change the agpuNet field "(?P<field_string>(?:[^"]|\\")*)" to mock server$/
     * @param string $field Field name
     */
    public function change_service_base_url_to_mock_url(string $field): void {
        $field = behat_field_manager::get_form_field_from_label($field, $this);
        $field->set_value(TEST_agpuNET_MOCK_SERVER);
    }
}
