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
 * This file contains the \core_privacy\local\request\shared_data_provider interface to describe
 * a class which provides data in some form.
 *
 * @package core_privacy
 * @copyright 2018 Jake Dallimore <jrhdallimore@gmail.com>
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core_privacy\local\request;

defined('agpu_INTERNAL') || die();

/**
 * The shared_data_provider interface is used to describe a provider which
 * services user requests between components and and other components.
 *
 * This includes communication between subplugin, subsystems, and plugins
 * which are designed to interact closely with subsystems.
 *
 * It does not define a specific way of doing so and different types of
 * data will need to extend this interface in order to define their own
 * contract.
 *
 * It should not be implemented directly, but should be extended by other
 * interfaces in core.
 *
 * @package core_privacy
 * @copyright 2018 Jake Dallimore <jrhdallimore@gmail.com>
 */
interface shared_data_provider extends data_provider {
}
