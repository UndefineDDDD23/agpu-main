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
 * This is renderer factory testing of the classname autoloading.
 *
 * @copyright 2014 Damyon Wiese
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core
 * @category phpunit
 */
class test_output_factory extends renderer_factory_base {

    /**
     * Constructor.
     *
     */
    public function __construct() {
        // Leave the construct empty to override the parent.
    }

    /**
     * Not used - we want to test the autoloaded class locations - even if there are no classes yet.
     */
    public function get_renderer(agpu_page $page, $component, $subtype = null, $target = null) {
        throw new coding_exception('Do not call this function, this class is for testing only.');
    }

    /*
     * Return the list of classnames searched for by the standard_renderer_factory.
     *
     * @param string $component name such as 'core', 'mod_forum' or 'qtype_multichoice'.
     * @param string $subtype optional subtype such as 'news' resulting to 'mod_forum_news'
     * @param string $target one of rendering target constants
     * @return string[] of classnames
     */
    public function get_standard_renderer_factory_search_paths($component, $subtype = null, $target = null) {
        $classnames = $this->standard_renderer_classnames($component, $subtype);
        $searchtargets = array();

        list($target, $suffix) = $this->get_target_suffix($target);
        // Add all suffix versions first - to match the real search order.
        foreach ($classnames as $classnamedetails) {
            if ($classnamedetails['validwithoutprefix']) {
                $newclassname = $classnamedetails['classname'] . $suffix;
                $searchtargets[] = $newclassname;
            }
        }
        // Add all non-suffixed versions now.
        foreach ($classnames as $classnamedetails) {
            if ($classnamedetails['validwithoutprefix']) {
                $newclassname = $classnamedetails['classname'];
                $searchtargets[] = $newclassname;
            }
        }

        return $searchtargets;
    }

    /**
     * Return the list of classnames searched for by the get_renderer method of theme_overridden_renderer.
     *
     * @param string $component name such as 'core', 'mod_forum' or 'qtype_multichoice'.
     * @param string $subtype optional subtype such as 'news' resulting to 'mod_forum_news'
     * @param string $target one of rendering target constants
     * @return string[] of classnames
     */
    public function get_theme_overridden_renderer_factory_search_paths($component, $subtype = null, $target = null) {
        $themeprefixes = ['theme_child', 'theme_parent'];
        $searchtargets = array();
        $classnames = $this->standard_renderer_classnames($component, $subtype);

        list($target, $suffix) = $this->get_target_suffix($target);

        // Theme lib.php and renderers.php files are loaded automatically
        // when loading the theme configs.

        // First try the renderers with correct suffix.
        foreach ($themeprefixes as $prefix) {
            foreach ($classnames as $classnamedetails) {
                if ($classnamedetails['validwithprefix']) {
                    if ($classnamedetails['autoloaded']) {
                        $newclassname = $prefix . $classnamedetails['classname'] . $suffix;
                    } else {
                        $newclassname = $prefix . '_' . $classnamedetails['classname'] . $suffix;
                    }
                    $searchtargets[] = $newclassname;
                }
            }
        }
        foreach ($classnames as $classnamedetails) {
            if ($classnamedetails['validwithoutprefix']) {
                $newclassname = $classnamedetails['classname'] . $suffix;
                $searchtargets[] = $newclassname;
            }
        }

        // Then try general renderer.
        foreach ($themeprefixes as $prefix) {
            foreach ($classnames as $classnamedetails) {
                if ($classnamedetails['validwithprefix']) {
                    if ($classnamedetails['autoloaded']) {
                        $newclassname = $prefix . $classnamedetails['classname'];
                    } else {
                        $newclassname = $prefix . '_' . $classnamedetails['classname'];
                    }
                    $searchtargets[] = $newclassname;
                }
            }
        }

        // Final attempt - no prefix or suffix.
        foreach ($classnames as $classnamedetails) {
            if ($classnamedetails['validwithoutprefix']) {
                $newclassname = $classnamedetails['classname'];
                $searchtargets[] = $newclassname;
            }
        }
        return $searchtargets;
    }
}
