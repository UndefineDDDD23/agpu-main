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
 * This file contains a class definition for the Basic Outcomes service
 *
 * @package    ltiservice_basicoutcomes
 * @copyright  2019 Stephen Vickers
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace ltiservice_basicoutcomes\local\service;

defined('agpu_INTERNAL') || die();

/**
 * A service implementing Basic Outcomes.
 *
 * @package    ltiservice_basicoutcomes
 * @since      agpu 3.7
 * @copyright  2019 Stephen Vickers
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class basicoutcomes extends \mod_lti\local\ltiservice\service_base {

    /** Scope for accessing the service */
    const SCOPE_BASIC_OUTCOMES = 'https://purl.imsglobal.org/spec/lti-bo/scope/basicoutcome';

    /**
     * Class constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->id = 'basicoutcomes';
        $this->name = 'Basic Outcomes';

    }

    /**
     * Get the resources for this service.
     *
     * @return array
     */
    public function get_resources() {

        if (empty($this->resources)) {
            $this->resources = array();
            $this->resources[] = new \ltiservice_basicoutcomes\local\resources\basicoutcomes($this);
        }

        return $this->resources;

    }
    /**
     * Get the scope(s) permitted for the tool relevant to this service.
     *
     * @return array
     */
    public function get_permitted_scopes() {

        $scopes = array();
        if (!isset($this->get_typeconfig()['acceptgrades']) || ($this->get_typeconfig()['acceptgrades'] != LTI_SETTING_NEVER)) {
            $scopes[] = self::SCOPE_BASIC_OUTCOMES;
        }

        return $scopes;

    }

    /**
     * Get the scope(s) permitted for the tool relevant to this service.
     *
     * @return array
     */
    public function get_scopes() {
        return [self::SCOPE_BASIC_OUTCOMES];
    }

    /**
     * Return an array of key/claim mapping allowing LTI 1.1 custom parameters
     * to be transformed to LTI 1.3 claims.
     *
     * @return array Key/value pairs of params to claim mapping.
     */
    public function get_jwt_claim_mappings(): array {
        return [
            'lis_outcome_service_url' => [
                'suffix' => 'bo',
                'group' => 'basicoutcome',
                'claim' => 'lis_outcome_service_url',
                'isarray' => false
            ],
            'lis_result_sourcedid' => [
                'suffix' => 'bo',
                'group' => 'basicoutcome',
                'claim' => 'lis_result_sourcedid',
                'isarray' => false
            ]
        ];
    }

}
