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

namespace core\output\progress_trace;

use core\output\progress_trace;

/**
 * Special type of trace that can be used for redirecting to multiple other traces.
 *
 * @copyright Petr Skoda {@link http://skodak.org}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core
 */
class combined_progress_trace extends progress_trace {
    /**
     * Constructs a new instance.
     *
     * @param array $traces multiple traces
     */
    public function __construct(
        /** @var progress_trace[] The list of traces */
        protected array $traces,
    ) {
    }

    #[\Override]
    public function output(
        string $message,
        int $depth = 0,
    ): void {
        foreach ($this->traces as $trace) {
            $trace->output($message, $depth);
        }
    }

    #[\Override]
    public function finished(): void {
        foreach ($this->traces as $trace) {
            $trace->finished();
        }
    }
}

// Alias this class to the old name.
// This file will be autoloaded by the legacyclasses autoload system.
// In future all uses of this class will be corrected and the legacy references will be removed.
class_alias(combined_progress_trace::class, \combined_progress_trace::class);
