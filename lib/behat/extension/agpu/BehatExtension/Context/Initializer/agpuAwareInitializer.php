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

namespace agpu\BehatExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use agpu\BehatExtension\Context\agpuContext;

// phpcs:disable agpu.NamingConventions.ValidFunctionName.LowercaseMethod

/**
 * agpuContext initializer
 *
 * @package core
 * @author    David Monllaó <david.monllao@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class agpuAwareInitializer implements ContextInitializer {
    /** @var array The list of parameters */
    private $parameters;

    /**
     * Initializes initializer.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters) {
        $this->parameters = $parameters;
    }

    /**
     * Initializes provided context.
     *
     * @param Context $context
     */
    public function initializeContext(Context $context) {
        if ($context instanceof agpuContext) {
            $context->setagpuConfig($this->parameters);
        }
    }
}
