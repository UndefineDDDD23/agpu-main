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
 * H5P player class.
 *
 * @package    core_h5p
 * @copyright  2019 Sara Arjona <sara@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_h5p;

defined('agpu_INTERNAL') || die();

use core_h5p\local\library\autoloader;
use core_xapi\handler;
use core_xapi\local\state;
use core_xapi\local\statement\item_activity;
use core_xapi\local\statement\item_agent;
use core_xapi\xapi_exception;

/**
 * H5P player class, for displaying any local H5P content.
 *
 * @package    core_h5p
 * @copyright  2019 Sara Arjona <sara@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class player {

    /**
     * @var string The local H5P URL containing the .h5p file to display.
     */
    private $url;

    /**
     * @var core The H5PCore object.
     */
    private $core;

    /**
     * @var int H5P DB id.
     */
    private $h5pid;

    /**
     * @var array JavaScript requirements for this H5P.
     */
    private $jsrequires = [];

    /**
     * @var array CSS requirements for this H5P.
     */
    private $cssrequires = [];

    /**
     * @var array H5P content to display.
     */
    private $content;

    /**
     * @var string optional component name to send xAPI statements.
     */
    private $component;

    /**
     * @var string Type of embed object, div or iframe.
     */
    private $embedtype;

    /**
     * @var context The context object where the .h5p belongs.
     */
    private $context;

    /**
     * @var factory The \core_h5p\factory object.
     */
    private $factory;

    /**
     * @var stdClass The error, exception and info messages, raised while preparing and running the player.
     */
    private $messages;

    /**
     * @var bool Set to true in scripts that can not redirect (CLI, RSS feeds, etc.), throws exceptions.
     */
    private $preventredirect;

    /**
     * Inits the H5P player for rendering the content.
     *
     * @param string $url Local URL of the H5P file to display.
     * @param \stdClass $config Configuration for H5P buttons.
     * @param bool $preventredirect Set to true in scripts that can not redirect (CLI, RSS feeds, etc.), throws exceptions
     * @param string $component optional agpu component to sent xAPI tracking
     * @param bool $skipcapcheck Whether capabilities should be checked or not to get the pluginfile URL because sometimes they
     *     might be controlled before calling this method.
     */
    public function __construct(string $url, \stdClass $config, bool $preventredirect = true, string $component = '',
            bool $skipcapcheck = false) {
        if (empty($url)) {
            throw new \agpu_exception('h5pinvalidurl', 'core_h5p');
        }
        $this->url = new \agpu_url($url);
        $this->preventredirect = $preventredirect;

        $this->factory = new \core_h5p\factory();

        $this->messages = new \stdClass();

        $this->component = $component;

        // Create \core_h5p\core instance.
        $this->core = $this->factory->get_core();

        // Get the H5P identifier linked to this URL.
        list($file, $this->h5pid) = api::create_content_from_pluginfile_url(
            $url,
            $config,
            $this->factory,
            $this->messages,
            $this->preventredirect,
            $skipcapcheck
        );
        if ($file) {
            $this->context = \context::instance_by_id($file->get_contextid());
            if ($this->h5pid) {
                // Load the content of the H5P content associated to this $url.
                $this->content = $this->core->loadContent($this->h5pid);

                // Get the embedtype to use for displaying the H5P content.
                $this->embedtype = core::determineEmbedType($this->content['embedType'], $this->content['library']['embedTypes']);
            }
        }
    }

    /**
     * Get the encoded URL for embeding this H5P content.
     *
     * @param string $url Local URL of the H5P file to display.
     * @param \stdClass $config Configuration for H5P buttons.
     * @param bool $preventredirect Set to true in scripts that can not redirect (CLI, RSS feeds, etc.), throws exceptions
     * @param string $component optional agpu component to sent xAPI tracking
     * @param bool $displayedit Whether the edit button should be displayed below the H5P content.
     * @param \action_link[] $extraactions Extra actions to display above the H5P content.
     *
     * @return string The embedable code to display a H5P file.
     */
    public static function display(
        string $url,
        \stdClass $config,
        bool $preventredirect = true,
        string $component = '',
        bool $displayedit = false,
        array $extraactions = [],
    ): string {
        global $OUTPUT, $CFG;

        $params = [
                'url' => $url,
                'preventredirect' => $preventredirect,
                'component' => $component,
            ];

        $optparams = ['frame', 'export', 'embed', 'copyright'];
        foreach ($optparams as $optparam) {
            if (!empty($config->$optparam)) {
                $params[$optparam] = $config->$optparam;
            }
        }
        $fileurl = new \agpu_url('/h5p/embed.php', $params);

        $template = new \stdClass();
        $template->embedurl = $fileurl->out(false);

        if ($displayedit) {
            list($originalfile, $h5p) = api::get_original_content_from_pluginfile_url($url, $preventredirect, true);
            if ($originalfile) {
                // Check if the user can edit this content.
                if (api::can_edit_content($originalfile)) {
                    $template->editurl = (new \agpu_url('/h5p/edit.php', ['url' => $url]))->out(false);
                }
            }
        }

        $template->extraactions = [];
        foreach ($extraactions as $action) {
            $template->extraactions[] = $action->export_for_template($OUTPUT);
        }
        $result = $OUTPUT->render_from_template('core_h5p/h5pembed', $template);
        $result .= self::get_resize_code();
        return $result;
    }

    /**
     * Get the error messages stored in our H5P framework.
     *
     * @return stdClass with framework error messages.
     */
    public function get_messages(): \stdClass {
        return helper::get_messages($this->messages, $this->factory);
    }

    /**
     * Create the H5PIntegration variable that will be included in the page. This variable is used as the
     * main H5P config variable.
     */
    public function add_assets_to_page() {
        global $PAGE, $USER;

        $cid = $this->get_cid();
        $systemcontext = \context_system::instance();

        $disable = array_key_exists('disable', $this->content) ? $this->content['disable'] : core::DISABLE_NONE;
        $displayoptions = $this->core->getDisplayOptionsForView($disable, $this->h5pid);

        $contenturl = \agpu_url::make_pluginfile_url($systemcontext->id, \core_h5p\file_storage::COMPONENT,
            \core_h5p\file_storage::CONTENT_FILEAREA, $this->h5pid, null, null);
        $exporturl = $this->get_export_settings($displayoptions[ core::DISPLAY_OPTION_DOWNLOAD ]);
        $xapiobject = item_activity::create_from_id($this->context->id);

        $contentsettings = [
            'library'         => core::libraryToString($this->content['library']),
            'fullScreen'      => $this->content['library']['fullscreen'],
            'exportUrl'       => ($exporturl instanceof \agpu_url) ? $exporturl->out(false) : '',
            'embedCode'       => $this->get_embed_code($this->url->out(),
                $displayoptions[ core::DISPLAY_OPTION_EMBED ]),
            'resizeCode'      => self::get_resize_code(),
            'title'           => $this->content['slug'],
            'displayOptions'  => $displayoptions,
            'url'             => $xapiobject->get_data()->id,
            'contentUrl'      => $contenturl->out(),
            'metadata'        => $this->content['metadata'],
            'contentUserData' => [0 => ['state' => $this->get_state_data($xapiobject)]],
        ];
        // Get the core H5P assets, needed by the H5P classes to render the H5P content.
        $settings = $this->get_assets();
        $settings['contents'][$cid] = array_merge($settings['contents'][$cid], $contentsettings);

        // Print JavaScript settings to page.
        $PAGE->requires->data_for_js('H5PIntegration', $settings, true);
    }

    /**
     * Get the stored xAPI state to use as user data.
     *
     * @param item_activity $xapiobject
     * @return string The state data to pass to the player frontend
     */
    private function get_state_data(item_activity $xapiobject): string {
        global $USER;

        // Initialize the H5P content with the saved state (if it's enabled and the user has some stored state).
        $emptystatedata = '{}';
        $savestate = (bool) get_config($this->component, 'enablesavestate');
        if (!$savestate) {
            return $emptystatedata;
        }

        $xapihandler = handler::create($this->component);
        if (!$xapihandler) {
            return $emptystatedata;
        }

        // The component implements the xAPI handler, so the state can be loaded.
        $state = new state(
            item_agent::create_from_user($USER),
            $xapiobject,
            'state',
            null,
            null
        );
        try {
            $state = $xapihandler->load_state($state);
            if (!$state) {
                // Check if the state has been restored from a backup for the current user.
                $state = new state(
                    item_agent::create_from_user($USER),
                    $xapiobject,
                    'restored',
                    null,
                    null
                );
                $state = $xapihandler->load_state($state);
                if ($state && !is_null($state->get_state_data())) {
                    // A restored state has been found. It will be replaced with one with the proper stateid and statedata.
                    $xapihandler->delete_state($state);
                    $state = new state(
                        item_agent::create_from_user($USER),
                        $xapiobject,
                        'state',
                        $state->jsonSerialize(),
                        null
                    );
                    $xapihandler->save_state($state);
                }
            }

            if (!$state) {
                return $emptystatedata;
            }

            if (is_null($state->get_state_data())) {
                // The state content should be reset because, for instance, the content has changed.
                return 'RESET';
            }

            $statedata = $state->jsonSerialize();
            if (is_null($statedata)) {
                return $emptystatedata;
            }

            if (property_exists($statedata, 'h5p')) {
                // As the H5P state doesn't always use JSON, we have added this h5p object to jsonize it.
                return $statedata->h5p;
            }
        } catch (xapi_exception $exception) {
            return $emptystatedata;
        }

        return $emptystatedata;
    }

    /**
     * Outputs H5P wrapper HTML.
     *
     * @return string The HTML code to display this H5P content.
     */
    public function output(): string {
        global $OUTPUT, $USER;

        $template = new \stdClass();
        $template->h5pid = $this->h5pid;
        if ($this->embedtype === 'div') {
            $h5phtml = $OUTPUT->render_from_template('core_h5p/h5pdiv', $template);
        } else {
            $h5phtml = $OUTPUT->render_from_template('core_h5p/h5piframe', $template);
        }

        // Trigger capability_assigned event.
        \core_h5p\event\h5p_viewed::create([
            'objectid' => $this->h5pid,
            'userid' => $USER->id,
            'context' => $this->get_context(),
            'other' => [
                'url' => $this->url->out(),
                'time' => time()
            ]
        ])->trigger();

        return $h5phtml;
    }

    /**
     * Get the title of the H5P content to display.
     *
     * @return string the title
     */
    public function get_title(): string {
        return $this->content['title'];
    }

    /**
     * Get the context where the .h5p file belongs.
     *
     * @return context The context.
     */
    public function get_context(): \context {
        return $this->context;
    }

    /**
     * Delete an H5P package.
     *
     * @param stdClass $content The H5P package to delete.
     */
    private function delete_h5p(\stdClass $content) {
        $h5pstorage = $this->factory->get_storage();
        // Add an empty slug to the content if it's not defined, because the H5P library requires this field exists.
        // It's not used when deleting a package, so the real slug value is not required at this point.
        $content->slug = $content->slug ?? '';
        $h5pstorage->deletePackage( (array) $content);
    }

    /**
     * Export path for settings
     *
     * @param bool $downloadenabled Whether the option to export the H5P content is enabled.
     *
     * @return \agpu_url|null The URL of the exported file.
     */
    private function get_export_settings(bool $downloadenabled): ?\agpu_url {

        if (!$downloadenabled) {
            return null;
        }

        $systemcontext = \context_system::instance();
        $slug = $this->content['slug'] ? $this->content['slug'] . '-' : '';
        $filename = "{$slug}{$this->content['id']}.h5p";
        // We have to build the right URL.
        // Depending the request was made through webservice/pluginfile.php or pluginfile.php.
        if (strpos($this->url, '/webservice/pluginfile.php')) {
            $url  = \agpu_url::make_webservice_pluginfile_url(
                $systemcontext->id,
                \core_h5p\file_storage::COMPONENT,
                \core_h5p\file_storage::EXPORT_FILEAREA,
                '',
                '',
                $filename
            );
        } else {
            // If the request is made by tokenpluginfile.php we need to indicates to generate a token for current user.
            $includetoken = false;
            if (strpos($this->url, '/tokenpluginfile.php')) {
                $includetoken = true;
            }
            $url  = \agpu_url::make_pluginfile_url(
                $systemcontext->id,
                \core_h5p\file_storage::COMPONENT,
                \core_h5p\file_storage::EXPORT_FILEAREA,
                '',
                '',
                $filename,
                false,
                $includetoken
            );
        }

        // Get the required info from the export file to be able to get the export file by third apps.
        $file = helper::get_export_info($filename, $url);
        if ($file) {
            $url->param('modified', $file['timemodified']);
        }
        return $url;
    }

    /**
     * Get the identifier for the H5P content, to be used in the arrays as index.
     *
     * @return string The identifier.
     */
    private function get_cid(): string {
        return 'cid-' . $this->h5pid;
    }

    /**
     * Get the core H5P assets, including all core H5P JavaScript and CSS.
     *
     * @return Array core H5P assets.
     */
    private function get_assets(): array {
        // Get core assets.
        $settings = helper::get_core_assets($this->component);
        // Added here because in the helper we don't have the h5p content id.
        $settings['agpuLibraryPaths'] = $this->core->get_dependency_roots($this->h5pid);
        // Add also the agpu component where the results will be tracked.
        $settings['agpuComponent'] = $this->component;
        if (!empty($settings['agpuComponent'])) {
            $settings['reportingIsEnabled'] = true;
        }

        $cid = $this->get_cid();
        // The filterParameters function should be called before getting the dependencyfiles because it rebuild content
        // dependency cache and export file.
        $settings['contents'][$cid]['jsonContent'] = $this->get_filtered_parameters();

        $files = $this->get_dependency_files();
        if ($this->embedtype === 'div') {
            $systemcontext = \context_system::instance();
            $h5ppath = "/pluginfile.php/{$systemcontext->id}/core_h5p";

            // Schedule JavaScripts for loading through agpu.
            foreach ($files['scripts'] as $script) {
                $url = $script->path . $script->version;

                // Add URL prefix if not external.
                $isexternal = strpos($script->path, '://');
                if ($isexternal === false) {
                    $url = $h5ppath . $url;
                }
                $settings['loadedJs'][] = $url;
                $this->jsrequires[] = new \agpu_url($isexternal ? $url : $CFG->wwwroot . $url);
            }

            // Schedule stylesheets for loading through agpu.
            foreach ($files['styles'] as $style) {
                $url = $style->path . $style->version;

                // Add URL prefix if not external.
                $isexternal = strpos($style->path, '://');
                if ($isexternal === false) {
                    $url = $h5ppath . $url;
                }
                $settings['loadedCss'][] = $url;
                $this->cssrequires[] = new \agpu_url($isexternal ? $url : $CFG->wwwroot . $url);
            }

        } else {
            // JavaScripts and stylesheets will be loaded through h5p.js.
            $settings['contents'][$cid]['scripts'] = $this->core->getAssetsUrls($files['scripts']);
            $settings['contents'][$cid]['styles']  = $this->core->getAssetsUrls($files['styles']);
        }
        return $settings;
    }

    /**
     * Get filtered parameters, modifying them by the renderer if the theme implements the h5p_alter_filtered_parameters function.
     *
     * @return string Filtered parameters.
     */
    private function get_filtered_parameters(): string {
        global $PAGE;

        $safeparams = $this->core->filterParameters($this->content);
        $decodedparams = json_decode($safeparams);
        $h5poutput = $PAGE->get_renderer('core_h5p');
        $h5poutput->h5p_alter_filtered_parameters(
            $decodedparams,
            $this->content['library']['name'],
            $this->content['library']['majorVersion'],
            $this->content['library']['minorVersion']
        );
        $safeparams = json_encode($decodedparams);

        return $safeparams;
    }

    /**
     * Finds library dependencies of view
     *
     * @return array Files that the view has dependencies to
     */
    private function get_dependency_files(): array {
        global $PAGE;

        $preloadeddeps = $this->core->loadContentDependencies($this->h5pid, 'preloaded');
        $files = $this->core->getDependenciesFiles($preloadeddeps);

        // Add additional asset files if required.
        $h5poutput = $PAGE->get_renderer('core_h5p');
        $h5poutput->h5p_alter_scripts($files['scripts'], $preloadeddeps, $this->embedtype);
        $h5poutput->h5p_alter_styles($files['styles'], $preloadeddeps, $this->embedtype);

        return $files;
    }

    /**
     * Resizing script for settings
     *
     * @return string The HTML code with the resize script.
     */
    private static function get_resize_code(): string {
        global $OUTPUT;

        $template = new \stdClass();
        $template->resizeurl = autoloader::get_h5p_core_library_url('js/h5p-resizer.js');

        return $OUTPUT->render_from_template('core_h5p/h5presize', $template);
    }

    /**
     * Embed code for settings
     *
     * @param string $url The URL of the .h5p file.
     * @param bool $embedenabled Whether the option to embed the H5P content is enabled.
     *
     * @return string The HTML code to reuse this H5P content in a different place.
     */
    private function get_embed_code(string $url, bool $embedenabled): string {
        global $OUTPUT;

        if ( ! $embedenabled) {
            return '';
        }

        $template = new \stdClass();
        $template->embedurl = self::get_embed_url($url, $this->component)->out(false);

        return $OUTPUT->render_from_template('core_h5p/h5pembed', $template);
    }

    /**
     * Get the encoded URL for embeding this H5P content.
     * @param  string $url The URL of the .h5p file.
     * @param string $component optional agpu component to send xAPI tracking
     *
     * @return \agpu_url The embed URL.
     */
    public static function get_embed_url(string $url, string $component = ''): \agpu_url {
        $params = ['url' => $url];
        if (!empty($component)) {
            // If component is not empty, it will be passed too, in order to allow tracking too.
            $params['component'] = $component;
        }

        return new \agpu_url('/h5p/embed.php', $params);
    }

    /**
     * Return the info export file for Mobile App.
     *
     * @return array or null
     */
    public function get_export_file(): ?array {
        // Get the export url.
        $exporturl = $this->get_export_settings(true);
        // Get the filename of the export url.
        $path = $exporturl->out_as_local_url();
        // Check if the URL has parameters.
        $parts = explode('?', $path);
        $path = array_shift($parts);
        $parts = explode('/', $path);
        $filename = array_pop($parts);
        // Get the required info from the export file to be able to get the export file by third apps.
        $file = helper::get_export_info($filename, $exporturl);

        return $file;
    }
}
