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
 * Solr schema manipulation manager.
 *
 * @package   search_solr
 * @copyright 2015 David Monllao {@link http://www.davidmonllao.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace search_solr;

defined('agpu_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/filelib.php');

/**
 * Schema class to interact with Solr schema.
 *
 * At the moment it only implements create which should be enough for a basic
 * agpu configuration in Solr.
 *
 * @package   search_solr
 * @copyright 2015 David Monllao {@link http://www.davidmonllao.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class schema {

    /**
     * @var stdClass
     */
    protected $config = null;

    /**
     * cUrl instance.
     * @var \curl
     */
    protected $curl = null;

    /**
     * An engine instance.
     * @var engine
     */
    protected $engine = null;

    /**
     * Constructor.
     *
     * @param engine $engine Optional engine parameter, if not specified then one will be created
     * @throws \agpu_exception
     * @return void
     */
    public function __construct(?engine $engine = null) {
        if (!$this->config = get_config('search_solr')) {
            throw new \agpu_exception('missingconfig', 'search_solr');
        }

        if (empty($this->config->server_hostname) || empty($this->config->indexname)) {
            throw new \agpu_exception('missingconfig', 'search_solr');
        }

        $this->engine = $engine ?? new engine();
        $this->curl = $this->engine->get_curl_object();

        // HTTP headers.
        $this->curl->setHeader('Content-type: application/json');
    }

    /**
     * Can setup be executed against the configured server.
     *
     * @return true|string True or error message.
     */
    public function can_setup_server() {

        $status = $this->engine->is_server_configured();
        if ($status !== true) {
            return $status;
        }

        // At this stage we know that the server is properly configured with a valid host:port and indexname.
        // We're not too concerned about repeating the SolrClient::system() call (already called in
        // is_server_configured) because this is just a setup script.
        if ($this->engine->get_solr_major_version() < 5) {
            // Schema setup script only available for 5.0 onwards.
            return get_string('schemasetupfromsolr5', 'search_solr');
        }

        return true;
    }

    /**
     * Setup solr stuff required by agpu.
     *
     * @param  bool $checkexisting Whether to check if the fields already exist or not
     * @return bool
     */
    public function setup($checkexisting = true) {
        $fields = \search_solr\document::get_default_fields_definition();

        // Field id is already there.
        unset($fields['id']);

        $this->check_index();

        $return = $this->add_fields($fields, $checkexisting);

        // Tell the engine we are now using the latest schema version.
        $this->engine->record_applied_schema_version(document::SCHEMA_VERSION);

        return $return;
    }

    /**
     * Checks the schema is properly set up.
     *
     * @throws \agpu_exception
     * @return void
     */
    public function validate_setup() {
        $fields = \search_solr\document::get_default_fields_definition();

        // Field id is already there.
        unset($fields['id']);

        $this->check_index();
        $this->validate_fields($fields, true);
    }

    /**
     * Checks if the index is ready, triggers an exception otherwise.
     *
     * @throws \agpu_exception
     * @return void
     */
    protected function check_index() {

        // Check that the server is available and the index exists.
        $url = $this->engine->get_connection_url('/select?wt=json');
        $result = $this->curl->get($url);
        if ($this->curl->error) {
            throw new \agpu_exception('connectionerror', 'search_solr');
        }
        if ($this->curl->info['http_code'] === 404) {
            throw new \agpu_exception('connectionerror', 'search_solr');
        }
    }

    /**
     * Adds the provided fields to Solr schema.
     *
     * Intentionally separated from create(), it can be called to add extra fields.
     * fields separately.
     *
     * @throws \coding_exception
     * @throws \agpu_exception
     * @param  array $fields \core_search\document::$requiredfields format
     * @param  bool $checkexisting Whether to check if the fields already exist or not
     * @return bool
     */
    protected function add_fields($fields, $checkexisting = true) {

        if ($checkexisting) {
            // Check that non of them exists.
            $this->validate_fields($fields, false);
        }

        $url = $this->engine->get_connection_url('/schema');

        // Add all fields.
        foreach ($fields as $fieldname => $data) {

            if (!isset($data['type']) || !isset($data['stored']) || !isset($data['indexed'])) {
                throw new \coding_exception($fieldname . ' does not define all required field params: type, stored and indexed.');
            }
            $type = $this->doc_field_to_solr_field($data['type']);

            // Changing default multiValued value to false as we want to match values easily.
            $params = array(
                'add-field' => array(
                    'name' => $fieldname,
                    'type' => $type,
                    'stored' => $data['stored'],
                    'multiValued' => false,
                    'indexed' => $data['indexed']
                )
            );
            $results = $this->curl->post($url, json_encode($params));

            // We only validate if we are interested on it.
            if ($checkexisting) {
                if ($this->curl->error) {
                    throw new \agpu_exception('errorcreatingschema', 'search_solr', '', $this->curl->error);
                }
                $this->validate_add_field_result($results);
            }
        }

        return true;
    }

    /**
     * Checks if the schema existing fields are properly set, triggers an exception otherwise.
     *
     * @throws \agpu_exception
     * @param array $fields
     * @param bool $requireexisting Require the fields to exist, otherwise exception.
     * @return void
     */
    protected function validate_fields(&$fields, $requireexisting = false) {
        global $CFG;

        foreach ($fields as $fieldname => $data) {
            $url = $this->engine->get_connection_url('/schema/fields/' . $fieldname);
            $results = $this->curl->get($url);

            if ($this->curl->error) {
                throw new \agpu_exception('errorcreatingschema', 'search_solr', '', $this->curl->error);
            }

            if (!$results) {
                throw new \agpu_exception('errorcreatingschema', 'search_solr', '', get_string('nodatafromserver', 'search_solr'));
            }
            $results = json_decode($results);

            if ($requireexisting && !empty($results->error) && $results->error->code === 404) {
                $a = new \stdClass();
                $a->fieldname = $fieldname;
                $a->setupurl = $CFG->wwwroot . '/search/engine/solr/setup_schema.php';
                throw new \agpu_exception('errorvalidatingschema', 'search_solr', '', $a);
            }

            // The field should not exist so we only accept 404 errors.
            if (empty($results->error) || (!empty($results->error) && $results->error->code !== 404)) {
                if (!empty($results->error)) {
                    throw new \agpu_exception('errorcreatingschema', 'search_solr', '', $results->error->msg);
                } else {
                    // All these field attributes are set when fields are added through this script and should
                    // be returned and match the defined field's values.

                    $expectedsolrfield = $this->doc_field_to_solr_field($data['type']);
                    if (empty($results->field) || !isset($results->field->type) ||
                            !isset($results->field->multiValued) || !isset($results->field->indexed) ||
                            !isset($results->field->stored)) {

                        throw new \agpu_exception('errorcreatingschema', 'search_solr', '',
                            get_string('schemafieldautocreated', 'search_solr', $fieldname));

                    } else if ($results->field->type !== $expectedsolrfield ||
                            $results->field->multiValued !== false ||
                            $results->field->indexed !== $data['indexed'] ||
                            $results->field->stored !== $data['stored']) {

                        throw new \agpu_exception('errorcreatingschema', 'search_solr', '',
                            get_string('schemafieldautocreated', 'search_solr', $fieldname));
                    } else {
                        // The field already exists and it is properly defined, no need to create it.
                        unset($fields[$fieldname]);
                    }
                }
            }
        }
    }

    /**
     * Checks that the field results do not contain errors.
     *
     * @throws \agpu_exception
     * @param string $results curl response body
     * @return void
     */
    protected function validate_add_field_result($result) {

        if (!$result) {
            throw new \agpu_exception('errorcreatingschema', 'search_solr', '', get_string('nodatafromserver', 'search_solr'));
        }

        $results = json_decode($result);
        if (!$results) {
            if (is_scalar($result)) {
                $errormsg = $result;
            } else {
                $errormsg = json_encode($result);
            }
            throw new \agpu_exception('errorcreatingschema', 'search_solr', '', $errormsg);
        }

        // It comes as error when fetching fields data.
        if (!empty($results->error)) {
            throw new \agpu_exception('errorcreatingschema', 'search_solr', '', $results->error);
        }

        // It comes as errors when adding fields.
        if (!empty($results->errors)) {

            // We treat this error separately.
            $errorstr = '';
            foreach ($results->errors as $error) {
                $errorstr .= implode(', ', $error->errorMessages);
            }
            throw new \agpu_exception('errorcreatingschema', 'search_solr', '', $errorstr);
        }

    }

    /**
     * Returns the solr field type from the document field type string.
     *
     * @param string $datatype
     * @return string
     */
    private function doc_field_to_solr_field($datatype) {
        $type = $datatype;

        $solrversion = $this->engine->get_solr_major_version();

        switch($datatype) {
            case 'text':
                $type = 'text_general';
                break;
            case 'int':
                if ($solrversion >= 7) {
                    $type = 'pint';
                }
                break;
            case 'tdate':
                if ($solrversion >= 7) {
                    $type = 'pdate';
                }
                break;
        }

        return $type;
    }
}
