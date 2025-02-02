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
 * REST web service entry point. The authentication is done via tokens.
 *
 * @package    webservice_rest
 * @copyright  2009 Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * NO_DEBUG_DISPLAY - disable agpu specific debug messages and any errors in output
 */
define('NO_DEBUG_DISPLAY', true);

define('WS_SERVER', true);

require('../../config.php');
require_once("$CFG->dirroot/webservice/rest/locallib.php");

if (!webservice_protocol_is_enabled('rest')) {
    header("HTTP/1.0 403 Forbidden");
    debugging('The server died because the web services or the REST protocol are not enable',
        DEBUG_DEVELOPER);
    die;
}

$server = new webservice_rest_server(WEBSERVICE_AUTHMETHOD_PERMANENT_TOKEN);
$server->run();
die;

/**
 * Raises Early WS Exception in REST format.
 *
 * @param  Exception $ex Raised exception.
 */
function raise_early_ws_exception(Exception $ex): void {
    global $CFG;
    require_once("$CFG->dirroot/webservice/rest/locallib.php");
    $server = new webservice_rest_server(WEBSERVICE_AUTHMETHOD_PERMANENT_TOKEN);
    $server->set_rest_format();
    $server->exception_handler($ex);
}
