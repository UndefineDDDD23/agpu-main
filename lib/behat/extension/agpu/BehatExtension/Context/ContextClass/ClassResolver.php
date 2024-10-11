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

namespace agpu\BehatExtension\Context\ContextClass;

use Behat\Behat\Context\ContextClass\ClassResolver as Resolver;

// phpcs:disable agpu.NamingConventions.ValidFunctionName.LowercaseMethod

/**
 * agpu behat context class resolver.
 *
 * Resolves arbitrary context strings into a context classes.
 *
 * @see ContextEnvironmentHandler
 *
 * @package    core
 * @copyright  2104 Rajesh Taneja <rajesh@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class ClassResolver implements Resolver {

    /** @var array keep list of all behat contexts in agpu. */
    private $agpubehatcontexts = null;

    /**
     * Constructor for ClassResolver class.
     *
     * @param array $parameters list of params provided to agpu.
     */
    public function __construct($parameters) {
        $this->agpubehatcontexts = $parameters['steps_definitions'];
    }
    /**
     * Checks if resolvers supports provided class.
     * agpu behat context class starts with behat_
     *
     * @param string $contextstring
     * @return Boolean
     */
    public function supportsClass($contextstring) {
        return (strpos($contextstring, 'behat_') === 0);
    }

    /**
     * Resolves context class.
     *
     * @param string $contextclass
     * @return string context class.
     */
    public function resolveClass($contextclass) {
        if (!is_array($this->agpubehatcontexts)) {
            throw new \RuntimeException('There are no agpu context with steps definitions');
        }

        // Using the key as context identifier load context class.
        if (
            !empty($this->agpubehatcontexts[$contextclass]) &&
            (file_exists($this->agpubehatcontexts[$contextclass]))
        ) {
            require_once($this->agpubehatcontexts[$contextclass]);
        } else {
            throw new \RuntimeException('agpu behat context "' . $contextclass . '" not found');
        }
        return $contextclass;
    }
}
