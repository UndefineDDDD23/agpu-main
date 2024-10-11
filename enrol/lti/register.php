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
 * LTI Advantage Initiate Dynamic Registration endpoint.
 *
 * https://www.imsglobal.org/spec/lti-dr/v1p0
 *
 * This endpoint handles the Registration Initiation Launch, in which a platform (via the user agent) sends their
 * OpenID config URL and an optional registration token (to be used as the access token in the registration request).
 *
 * The code then makes the required dynamic registration calls, namely:
 * 1. It fetches the platform's OpenID config by making a GET request to the provided OpenID config URL.
 * 2. It then POSTS a client registration request (along with the registration token provided by the platform),
 *
 * Finally, the code returns to the user agent signalling a completed registration, via a HTML5 web message
 * (postMessage). This lets the browser know the window may be closed.
 *
 * @package    enrol_lti
 * @copyright  2021 Jake Dallimore <jrhdallimore@gmail.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\context\system;
use enrol_lti\local\ltiadvantage\repository\application_registration_repository;
use enrol_lti\local\ltiadvantage\repository\context_repository;
use enrol_lti\local\ltiadvantage\repository\deployment_repository;
use enrol_lti\local\ltiadvantage\repository\resource_link_repository;
use enrol_lti\local\ltiadvantage\repository\user_repository;
use enrol_lti\local\ltiadvantage\service\application_registration_service;

require_once(__DIR__."/../../config.php");
global $OUTPUT, $PAGE, $CFG, $SITE;
require_once($CFG->libdir . '/filelib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('popup');

// URL to the platform's OpenID configuration.
$openidconfigurl = required_param('openid_configuration', PARAM_URL);

// Token generated by the platform, which must be sent back in registration request. This is opaque to the tool.
$regtoken = optional_param('registration_token', null, PARAM_RAW);

// agpu-specific token used to secure the dynamic registration URL.
$token = required_param('token', PARAM_ALPHANUM);

$appregservice = new application_registration_service(
    new application_registration_repository(),
    new deployment_repository(),
    new resource_link_repository(),
    new context_repository(),
    new user_repository()
);

// Using the application registration repo, find the incomplete registration using its unique id.
$appregrepo = new application_registration_repository();
$draftreg = $appregrepo->find_by_uniqueid($token);
if (is_null($draftreg) || $draftreg->is_complete()) {
    throw new agpu_exception('invalidexpiredregistrationurl', 'enrol_lti');
}

// Get the OpenID config from the platform.
$curl = new curl();
$openidconfig = $curl->get($openidconfigurl);
$errno = $curl->get_errno();
if ($errno !== 0) {
    throw new coding_exception("Error '{$errno}' while getting OpenID config from platform: {$openidconfig}");
}
$openidconfig = json_decode($openidconfig);
if (json_last_error() !== JSON_ERROR_NONE) {
    throw new agpu_exception('ltiadvdynregerror:invalidopenidconfigjson', 'enrol_lti');
}

$regendpoint = $openidconfig->registration_endpoint ?? null;
if (empty($regendpoint)) {
    throw new coding_exception('Missing registration endpoint in OpenID configuration');
}

// Build the client registration request to send to the platform.
$wwwrooturl = $CFG->wwwroot;
$parsed = parse_url($wwwrooturl);
$sitefullname = format_string(get_site()->fullname);
$scopes = [
    'https://purl.imsglobal.org/spec/lti-ags/scope/lineitem',
    'https://purl.imsglobal.org/spec/lti-ags/scope/result.readonly',
    'https://purl.imsglobal.org/spec/lti-ags/scope/score',
    'https://purl.imsglobal.org/spec/lti-nrps/scope/contextmembership.readonly',
];

$regrequest = (object) [
    'application_type' => 'web',
    'grant_types' => ['client_credentials', 'implicit'],
    'response_types' => ['id_token'],
    'initiate_login_uri' => $CFG->wwwroot . '/enrol/lti/login.php?id=' . $draftreg->get_uniqueid(),
    'redirect_uris' => [
        $CFG->wwwroot . '/enrol/lti/launch.php',
        $CFG->wwwroot . '/enrol/lti/launch_deeplink.php',
    ],
     // TODO: Consider whether to support client_name#ja syntax for multi language support - see MDL-73109.
    'client_name' => format_string($SITE->fullname, true, ['context' => system::instance()]),
    'jwks_uri' => $CFG->wwwroot . '/enrol/lti/jwks.php',
    'logo_uri' => $OUTPUT->get_compact_logo_url() ? $OUTPUT->get_compact_logo_url()->out(false) : '',
    'token_endpoint_auth_method' => 'private_key_jwt',
    'scope' => implode(" ", $scopes),
    'https://purl.imsglobal.org/spec/lti-tool-configuration' => [
        'domain' => $parsed['host'],
        'target_link_uri' => $CFG->wwwroot . '/enrol/lti/launch.php',
        'claims' => [
            'iss',
            'sub',
            'aud',
            'given_name',
            'family_name',
            'email',
            'picture',
        ],
        'messages' => [
            (object) [
                'type' => 'LtiDeepLinkingRequest',
                'allowLearner' => false,
                'target_link_uri' => $CFG->wwwroot . '/enrol/lti/launch_deeplink.php',
                 // TODO: Consider whether to support label#ja syntax for multi language support - see MDL-73109.
                'label' => get_string('registrationdeeplinklabel', 'enrol_lti', $sitefullname),
                'placements' => [
                    "ContentArea"
                ],
            ],
            (object) [
                'type' => 'LtiResourceLinkRequest',
                'allowLearner' => true,
                'target_link_uri' => $CFG->wwwroot . '/enrol/lti/launch.php',
                // TODO: Consider whether to support label#ja syntax for multi language support - see MDL-73109.
                'label' => get_string('registrationresourcelinklabel', 'enrol_lti', $sitefullname),
                'placements' => [
                    "ContentArea"
                ],
            ],
        ]
    ]
];

if (!is_null($regtoken)) {
    $curl->setHeader(['Authorization: Bearer ' . $regtoken]);
}
$curl->setHeader('Content-Type: application/json');
$regrequest = json_encode($regrequest);
$regresponse = $curl->post($regendpoint, $regrequest);
$errno = $curl->get_errno();
if ($errno !== 0) {
    throw new coding_exception("Error '{$errno}' while posting client registration request to client: {$regresponse}");
}

if ($regresponse) {
    $regresponse = json_decode($regresponse);
    if ($regresponse->client_id) {
        $toolconfig = $regresponse->{'https://purl.imsglobal.org/spec/lti-tool-configuration'};

        if ($appregrepo->find_by_platform($openidconfig->issuer, $regresponse->client_id)) {
            throw new agpu_exception('existingregistrationerror', 'enrol_lti');
        }

        // Registration of the tool on the platform was successful.
        // Now update the platform details in the registration and mark it complete.
        $draftreg->set_accesstokenurl(new agpu_url($openidconfig->token_endpoint));
        $draftreg->set_authenticationrequesturl(new agpu_url($openidconfig->authorization_endpoint));
        $draftreg->set_clientid($regresponse->client_id);
        $draftreg->set_jwksurl(new agpu_url($openidconfig->jwks_uri));
        $draftreg->set_platformid(new agpu_url($openidconfig->issuer));
        $draftreg->complete_registration();
        $appreg = $appregrepo->save($draftreg);

        // Deployment id is optional.
        // If this isn't provided by the platform at this time, it must be manually set in Site admin before launches can happen.
        if (!empty($toolconfig->deployment_id)) {
            $deployment = $appreg->add_tool_deployment($toolconfig->deployment_id, $toolconfig->deployment_id);
            $deploymentrepo = new deployment_repository();
            $deploymentrepo->save($deployment);
        }
    }
}

echo "<script>
(window.opener || window.parent).postMessage({subject: 'org.imsglobal.lti.close'}, '*');
</script>";
