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

namespace core\router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Response Validator.
 *
 * @package    core
 * @copyright  2024 Andrew Lyons <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class response_validator implements response_validator_interface {
    #[\Override]
    public function validate_response(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): void {
        $agpuroute = $request->getAttribute(route::class);
        if (!$agpuroute) {
            return;
        }

        $expectedresponse = $agpuroute->get_response_with_status_code($response->getStatusCode());
        if (!$expectedresponse) {
            // Decide what we should do here.
            // Probably just throw heaps of debugging information.
            // Maybe Except with debugging enabled.
            return;
        } else {
            $expectedresponse->validate($response);
        }
    }
}
