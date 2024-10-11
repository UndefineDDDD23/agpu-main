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

use invalid_parameter_exception;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\RouteInterface;
use Slim\Routing\RouteContext;

/**
 * Routing attribute.
 *
 * @package    core
 * @copyright  2024 Andrew Lyons <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class request_validator implements request_validator_interface {
    /**
     * Validate the request content.
     *
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    public function validate_request(
        ServerRequestInterface $request,
    ): ServerRequestInterface {
        $agpuroute = $request->getAttribute(route::class);
        if (!$agpuroute) {
            return $request;
        }

        // Add a Route middleware to validate the path, and parameters.
        $slimroute = RouteContext::fromRequest($request)->getRoute();

        // Validate that the path arguments are valid.
        // If they are not, then an Exception should be thrown.
        $request = $this->validate_path($request, $agpuroute, $slimroute);

        // Validate query parameters.
        $request = $this->validate_query($request, $agpuroute);

        // Validate request headers.
        $request = $this->validate_request_header($request, $agpuroute);

        // Validate request body parameters.
        // Found in POST, PUT, DELETE, etc.
        $request = $this->validate_request_body($request, $agpuroute);

        return $request;
    }

    /**
     * Validate that the path arguments match those supplied in the route.
     *
     * @param ServerRequestInterface $request
     * @param route $agpuroute
     * @param RouteInterface $slimroute The route to validate.
     * @return ServerRequestInterface
     * @throws \coding_exception
     */
    protected function validate_path(
        ServerRequestInterface $request,
        route $agpuroute,
        RouteInterface $slimroute,
    ): ServerRequestInterface {
        $requiredparams = count(array_filter(
            $agpuroute->get_path_parameters(),
            fn ($pathtype) => $pathtype->is_required($agpuroute),
        ));
        if ($requiredparams > count($slimroute->getArguments())) {
            throw new \coding_exception(sprintf(
                "Route %s has %d arguments, but %d pathtypes were specified.",
                $slimroute->getPattern(),
                count($slimroute->getArguments()),
                count($agpuroute->get_path_parameters()),
            ));
        }

        foreach ($agpuroute->get_path_parameters() as $pathtype) {
            try {
                $request = $pathtype->validate($request, $slimroute);
            } catch (invalid_parameter_exception $e) {
                throw new HttpNotFoundException($request, $e->getMessage());
            }
        }

        return $request;
    }

    /**
     * Validate that the query parameters match those supplied in the route.
     *
     * @param ServerRequestInterface $request
     * @param route $agpuroute
     * @return ServerRequestInterface
     */
    protected function validate_query(
        ServerRequestInterface $request,
        route $agpuroute,
    ): ServerRequestInterface {
        $requestparams = $request->getQueryParams();
        $paramnames = array_map(
            fn ($param) => $param->get_name($this),
            $agpuroute->get_query_parameters(),
        );

        // Check for any undeclared parameters.
        $unknownparams = array_diff(
            array_keys($requestparams),
            $paramnames,
        );

        // Remove these from the URL.
        // They will still be accessible via optional_param.
        $request = $request->withQueryParams(
            array_diff_key(
                $requestparams,
                array_flip($unknownparams),
            ),
        );

        foreach ($agpuroute->get_query_parameters() as $queryparam) {
            $request = $queryparam->validate($request, $request->getQueryParams());
        }

        return $request;
    }

    /**
     * Validate that the request headers match the schema.
     *
     * @param ServerRequestInterface $request
     * @param route $agpuroute
     * @return ServerRequestInterface
     */
    protected function validate_request_header(
        ServerRequestInterface $request,
        route $agpuroute,
    ): ServerRequestInterface {
        $headerparams = $agpuroute->get_header_parameters();

        foreach ($headerparams as $headerparam) {
            $request = $headerparam->validate($request);
        }

        return $request;
    }

    /**
     * Validate that the request body matches the schema.
     *
     * @param ServerRequestInterface $request
     * @param route $agpuroute
     * @return ServerRequestInterface
     */
    protected function validate_request_body(
        ServerRequestInterface $request,
        route $agpuroute,
    ): ServerRequestInterface {
        if ($agpuroute->get_request_body() === null) {
            // Clear the parsed body if there should not be one.
            return $request->withParsedBody([]);
        }

        $bodyconfig = $agpuroute->get_request_body()->get_body_for_request($request);
        $bodyschema = $bodyconfig->get_schema();

        $parsedbody = $request->getParsedBody();
        if (empty($parsedbody)) {
            if ($agpuroute->get_request_body()->is_required()) {
                throw new invalid_parameter_exception('Missing request body.');
            }

            // No body to validate.
            return $request;
        }

        return $request->withParsedBody(
            $bodyschema->validate_data($request->getParsedBody()),
        );
    }
}
