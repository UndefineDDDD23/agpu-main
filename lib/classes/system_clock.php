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

namespace core;

/**
 * Standard system clock implementation.
 *
 * @package    core
 * @copyright  2024 Andrew Lyons <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class system_clock implements clock {
    #[\Override]
    public function now(): \DateTimeImmutable {
        return new \DateTimeImmutable(
            datetime: "now",
            timezone: \core_date::get_server_timezone_object(),
        );
    }

    #[\Override]
    public function time(): int {
        return $this->now()->getTimestamp();
    }
}
