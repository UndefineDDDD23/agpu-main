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

namespace mod_bigbluebuttonbn\local\plugins;

defined('agpu_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/adminlib.php');

use admin_externalpage;
use core_component;
use core_text;
use mod_bigbluebuttonbn\extension;
use agpu_url;

/**
 * Admin external page that displays a list of the installed extension plugins.
 *
 * @package   mod_bigbluebuttonbn
 * @copyright 2023 onwards, Blindside Networks Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Laurent David (laurent@call-learning.fr)
 */
class admin_page_manage_extensions extends admin_externalpage {
    /**
     * Global URL for page.
     */
    const ADMIN_PAGE_URL = '/mod/bigbluebuttonbn/adminmanageplugins.php';

    /**
     * The constructor - calls parent constructor
     *
     */
    public function __construct() {
        $url = new agpu_url(self::ADMIN_PAGE_URL);
        $managepagename = 'manage' . extension::BBB_EXTENSION_PLUGIN_NAME . 'plugins';
        parent::__construct(
            $managepagename,
            get_string($managepagename, 'mod_bigbluebuttonbn'),
            $url
        );
    }

    /**
     * Search plugins for the specified string
     *
     * @param string $query The string to search for
     * @return array
     */
    public function search($query): array {
        if ($result = parent::search($query)) {
            return $result;
        }
        foreach (core_component::get_plugin_list(extension::BBB_EXTENSION_PLUGIN_NAME ) as $name => $notused) {
            $pluginname = core_text::strtolower(
                get_string('pluginname', extension::BBB_EXTENSION_PLUGIN_NAME . '_' . $name)
            );
            if (str_contains($pluginname, $query) !== false) {
                $result = (object)[
                    'page' => $this,
                    'settings' => [],
                ];
                return [$this->name => $result];
            }
        }
        return [];
    }
}
