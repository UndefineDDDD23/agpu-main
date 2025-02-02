<?php
// This file is part of agpu - https://agpu.org/
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
// along with agpu.  If not, see <https://www.gnu.org/licenses/>.

namespace test_plugin\hook;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Fixture for testing of hooks.
 *
 * @package   core
 * @author    Petr Skoda
 * @copyright 2022 Open LMS
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class stoppablehook implements
    StoppableEventInterface,
    \core\hook\described_hook {

    /** @var bool stoppable flag */
    private $stopped = false;

    /**
     * Hook description.
     */
    public static function get_hook_description(): string {
        return 'Test hook 2.';
    }

    /**
     * Stop other callbacks.
     */
    public function stop(): void {
        $this->stopped = true;
    }

    /**
     * Indicates if callback propagation should stop.
     */
    public function isPropagationStopped(): bool {
        return $this->stopped;
    }

    /**
     * List of tags that describe this hook.
     *
     * @return string[]
     */
    public static function get_hook_tags(): array {
        return ['test'];
    }
}
