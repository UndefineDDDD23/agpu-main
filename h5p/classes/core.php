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

namespace core_h5p;

defined('agpu_INTERNAL') || die();

require_once("$CFG->libdir/filelib.php");

use agpu\H5PCore;
use agpu\H5PFrameworkInterface;
use agpu\H5PHubEndpoints;
use stdClass;
use agpu_url;
use core_h5p\local\library\autoloader;

// phpcs:disable agpu.NamingConventions.ValidFunctionName.LowercaseMethod
// phpcs:disable agpu.NamingConventions.ValidVariableName.VariableNameLowerCase

/**
 * H5P core class, containing functions and storage shared by the other H5P classes.
 *
 * @package    core_h5p
 * @copyright  2019 Sara Arjona <sara@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core extends H5PCore {

    /** @var array The array containing all the present libraries */
    protected $libraries;

    /**
     * Constructor for core_h5p/core.
     *
     * @param H5PFrameworkInterface $framework The frameworks implementation of the H5PFrameworkInterface
     * @param string|H5PFileStorage $path The H5P file storage directory or class
     * @param string $url The URL to the file storage directory
     * @param string $language The language code. Defaults to english
     * @param boolean $export Whether export is enabled
     */
    public function __construct(H5PFrameworkInterface $framework, $path, string $url, string $language = 'en',
            bool $export = false) {

        parent::__construct($framework, $path, $url, $language, $export);

        // Aggregate the assets by default.
        $this->aggregateAssets = true;
    }

    /**
     * Get the path to the dependency.
     *
     * @param array $dependency An array containing the information of the requested dependency library
     * @return string The path to the dependency library
     */
    protected function getDependencyPath(array $dependency): string {
        $library = $this->find_library($dependency);

        return "libraries/{$library->id}/" . H5PCore::libraryToFolderName($dependency);
    }

    /**
     * Get the paths to the content dependencies.
     *
     * @param int $id The H5P content ID
     * @return array An array containing the path of each content dependency
     */
    public function get_dependency_roots(int $id): array {
        $roots = [];
        $dependencies = $this->h5pF->loadContentDependencies($id);
        $context = \context_system::instance();
        foreach ($dependencies as $dependency) {
            $library = $this->find_library($dependency);
            $roots[self::libraryToFolderName($dependency)] = (agpu_url::make_pluginfile_url(
                $context->id,
                'core_h5p',
                'libraries',
                $library->id,
                "/" . self::libraryToFolderName($dependency),
                ''
            ))->out(false);
        }

        return $roots;
    }

    /**
     * Get a particular dependency library.
     *
     * @param array $dependency An array containing information of the dependency library
     * @return stdClass|null The library object if the library dependency exists, null otherwise
     */
    protected function find_library(array $dependency): ?\stdClass {
        global $DB;
        if (null === $this->libraries) {
            $this->libraries = $DB->get_records('h5p_libraries');
        }

        $major = $dependency['majorVersion'];
        $minor = $dependency['minorVersion'];
        $patch = $dependency['patchVersion'];

        foreach ($this->libraries as $library) {
            if ($library->machinename !== $dependency['machineName']) {
                continue;
            }

            if ($library->majorversion != $major) {
                continue;
            }
            if ($library->minorversion != $minor) {
                continue;
            }
            if ($library->patchversion != $patch) {
                continue;
            }

            return $library;
        }

        return null;
    }

    /**
     * Get the list of JS scripts to include on the page.
     *
     * @return array The array containg urls of the core JavaScript files
     */
    public static function get_scripts(): array {
        global $PAGE;

        $jsrev = $PAGE->requires->get_jsrev();
        $urls = [];
        foreach (self::$scripts as $script) {
            $urls[] = autoloader::get_h5p_core_library_url($script, [
                'ver' => $jsrev,
            ]);
        }
        $urls[] = new agpu_url("/h5p/js/h5p_overrides.js", [
            'ver' => $jsrev,
        ]);

        return $urls;
    }

    /**
     * Fetch and install the latest H5P content types libraries from the official H5P repository.
     * If the latest version of a content type library is present in the system, nothing is done for that content type.
     *
     * @return stdClass
     */
    public function fetch_latest_content_types(): ?\stdClass {

        $contenttypes = $this->get_latest_content_types();
        if (!empty($contenttypes->error)) {
            return $contenttypes;
        }

        $typesinstalled = [];

        $factory = new factory();
        $framework = $factory->get_framework();

        foreach ($contenttypes->contentTypes as $type) {
            // Don't fetch content types if any of the versions is disabled.
            $librarydata = (object) ['machinename' => $type->id];
            if (!api::is_library_enabled($librarydata)) {
                continue;
            }
            // Don't fetch content types that require a higher H5P core API version.
            if (!$this->is_required_core_api($type->coreApiVersionNeeded)) {
                continue;
            }

            $library = [
                'machineName' => $type->id,
                'majorVersion' => $type->version->major,
                'minorVersion' => $type->version->minor,
                'patchVersion' => $type->version->patch,
            ];
            // Add example and tutorial to the library, to store this information too.
            if (isset($type->example)) {
                $library['example'] = $type->example;
            }
            if (isset($type->tutorial)) {
                $library['tutorial'] = $type->tutorial;
            }

            $shoulddownload = true;
            if ($framework->getLibraryId($type->id, $type->version->major, $type->version->minor)) {
                if (!$framework->isPatchedLibrary($library)) {
                    $shoulddownload = false;
                }
            }

            if ($shoulddownload) {
                $installed['id'] = $this->fetch_content_type($library);
                if ($installed['id']) {
                    $installed['name'] = H5PCore::libraryToString($library);
                    $typesinstalled[] = $installed;
                }
            }
        }

        $result = new stdClass();
        $result->error = '';
        $result->typesinstalled = $typesinstalled;

        return $result;
    }

    /**
     * Given an H5P content type machine name, fetch and install the required library from the official H5P repository.
     *
     * @param array $library Library machineName, majorversion and minorversion.
     * @return int|null Returns the id of the content type library installed, null otherwise.
     */
    public function fetch_content_type(array $library): ?int {
        global $DB;

        $factory = new factory();

        $fs = get_file_storage();

        // Delete any existing file, if it was not deleted during a previous download.
        $existing = $fs->get_file(
            (\context_system::instance())->id,
            'core_h5p',
            'library_sources',
            0,
            '/',
            $library['machineName']
        );
        if ($existing) {
            $existing->delete();
        }

        // Download the latest content type from the H5P official repository.
        $file = $fs->create_file_from_url(
            (object) [
                'component' => 'core_h5p',
                'filearea' => 'library_sources',
                'itemid' => 0,
                'contextid' => (\context_system::instance())->id,
                'filepath' => '/',
                'filename' => $library['machineName'],
            ],
            $this->get_api_endpoint($library['machineName']),
            null,
            true
        );

        if (!$file) {
            return null;
        }

        helper::save_h5p($factory, $file, (object) [], false, true);

        $file->delete();

        $librarykey = static::libraryToString($library);

        if (is_null($factory->get_storage()->h5pC->librariesJsonData)) {
            // There was an error fetching the content type.
            debugging('Error fetching content type: ' . $librarykey);
            return null;
        }

        $libraryjson = $factory->get_storage()->h5pC->librariesJsonData[$librarykey];
        if (is_null($libraryjson) || !array_key_exists('libraryId', $libraryjson)) {
            // There was an error fetching the content type.
            debugging('Error fetching content type: ' . $librarykey);
            return null;
        }

        $libraryid = $libraryjson['libraryId'];

        // Update example and tutorial (if any of them are defined in $library).
        $params = ['id' => $libraryid];
        if (array_key_exists('example', $library)) {
            $params['example'] = $library['example'];
        }
        if (array_key_exists('tutorial', $library)) {
            $params['tutorial'] = $library['tutorial'];
        }
        if (count($params) > 1) {
            $DB->update_record('h5p_libraries', $params);
        }

        return $libraryid;
    }

    /**
     * Get H5P endpoints.
     *
     * If $endpoint = 'content' and $library is null, agpu_url is the endpoint of the latest version of the H5P content
     * types; however, if $library is the machine name of a content type, agpu_url is the endpoint to download the content type.
     * The SITES endpoint ($endpoint = 'site') may be use to get a site UUID or send site data.
     *
     * @param string|null $library The machineName of the library whose endpoint is requested.
     * @param string $endpoint The endpoint required. Valid values: "site", "content".
     * @return agpu_url The endpoint agpu_url object.
     */
    public function get_api_endpoint(?string $library = null, string $endpoint = 'content'): agpu_url {
        if ($endpoint == 'site') {
            $h5purl = H5PHubEndpoints::createURL(H5PHubEndpoints::SITES );
        } else if ($endpoint == 'content') {
            $h5purl = H5PHubEndpoints::createURL(H5PHubEndpoints::CONTENT_TYPES ) . $library;
        }

        return new agpu_url($h5purl);
    }

    /**
     * Get the latest version of the H5P content types available in the official repository.
     *
     * @return stdClass An object with 2 properties:
     *     - string error: error message when there is any problem, empty otherwise
     *     - array contentTypes: an object for each H5P content type with its information
     */
    public function get_latest_content_types(): \stdClass {
        global $CFG;

        $siteuuid = $this->get_site_uuid() ?? md5($CFG->wwwroot);
        $postdata = ['uuid' => $siteuuid];

        // Get the latest content-types json.
        $endpoint = $this->get_api_endpoint();
        $request = download_file_content($endpoint, null, $postdata, true);

        if (!empty($request->error) || $request->status != '200' || empty($request->results)) {
            if (empty($request->error)) {
                $request->error = get_string('fetchtypesfailure', 'core_h5p');
            }
            return $request;
        }

        $contenttypes = json_decode($request->results);
        $contenttypes->error = '';

        return $contenttypes;
    }

    /**
     * Get the site UUID. If site UUID is not defined, try to register the site.
     *
     * return $string The site UUID, null if it is not set.
     */
    public function get_site_uuid(): ?string {
        // Check if the site_uuid is already set.
        $siteuuid = get_config('core_h5p', 'site_uuid');

        if (!$siteuuid) {
            $siteuuid = $this->register_site();
        }

        return $siteuuid;
    }

    /**
     * Get H5P generated site UUID.
     *
     * return ?string Returns H5P generated site UUID, null if can't get it.
     */
    private function register_site(): ?string {
        $endpoint = $this->get_api_endpoint(null, 'site');
        $siteuuid = download_file_content($endpoint, null, '');

        // Successful UUID retrieval from H5P.
        if ($siteuuid) {
            $json = json_decode($siteuuid);
            if (isset($json->uuid)) {
                set_config('site_uuid', $json->uuid, 'core_h5p');
                return $json->uuid;
            }
        }

        return null;
    }

    /**
     * Checks that the required H5P core API version or higher is installed.
     *
     * @param stdClass $coreapi Object with properties major and minor for the core API version required.
     * @return bool True if the required H5P core API version is installed. False if not.
     */
    public function is_required_core_api($coreapi): bool {
        if (isset($coreapi) && !empty($coreapi)) {
            if (($coreapi->major > H5PCore::$coreApi['majorVersion']) ||
                (($coreapi->major == H5PCore::$coreApi['majorVersion']) && ($coreapi->minor > H5PCore::$coreApi['minorVersion']))) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the library string from a DB library record.
     *
     * @param  stdClass $record The DB library record.
     * @param  bool $foldername If true, use hyphen instead of space in returned string.
     * @return string The string name on the form {machineName} {majorVersion}.{minorVersion}.
     */
    public static function record_to_string(stdClass $record, bool $foldername = false): string {
        if ($foldername) {
            return static::libraryToFolderName([
                'machineName' => $record->machinename,
                'majorVersion' => $record->majorversion,
                'minorVersion' => $record->minorversion,
            ]);
        } else {
            return static::libraryToString([
                'machineName' => $record->machinename,
                'majorVersion' => $record->majorversion,
                'minorVersion' => $record->minorversion,
            ]);
        }

    }

    /**
     * Small helper for getting the library's ID.
     * This method is rewritten to use MUC (instead of an static variable which causes some problems with PHPUnit).
     *
     * @param array $library
     * @param string $libString
     * @return int Identifier, or FALSE if non-existent
     */
    public function getLibraryId($library, $libString = null) {
        if (!$libString) {
            $libString = self::libraryToString($library);
        }

        // Check if this information has been saved previously into the cache.
        $libcache = \cache::make('core', 'h5p_libraries');
        $librarykey = helper::get_cache_librarykey($libString);
        $libraryId = $libcache->get($librarykey);
        if ($libraryId === false) {
            $libraryId = $this->h5pF->getLibraryId($library['machineName'], $library['majorVersion'], $library['minorVersion']);
            $libcache->set($librarykey, $libraryId);
        }

        return $libraryId;
    }

}
