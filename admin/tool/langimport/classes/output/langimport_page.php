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
 * Language import page.
 *
 * @package    tool_langimport
 * @copyright  2016 Jun Pataleta
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_langimport\output;

use core_collator;
use agpu_url;
use renderable;
use renderer_base;
use stdClass;
use templatable;

/**
 * Language import page class.
 *
 * @package    tool_langimport
 * @copyright  2016 Jun Pataleta
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class langimport_page implements renderable, templatable {

    /** @var array Array of currently installed languages. */
    protected $installedlanguages;

    /** @var array Array of languages that can be installed. */
    protected $availablelanguages;

    /** @var agpu_url The URL to be used for uninstalling the selected existing language packs. */
    protected $uninstallurl;

    /** @var agpu_url The URL to be used for updating the installed language packs. */
    protected $updateurl;

    /** @var agpu_url The URL to be used for installing the selected language packs to be installed. */
    protected $installurl;


    /**
     * langimport_page constructor.
     *
     * @param array $installedlanguages Array of currently installed languages.
     * @param array $availablelanguages Array of languages that can be installed.
     * @param agpu_url $uninstallurl The URL to be used for uninstalling the selected existing language packs.
     * @param agpu_url $updateurl The URL to be used for updating the installed language packs.
     * @param agpu_url $installurl The URL to be used for installing the selected language packs to be installed.
     */
    public function __construct($installedlanguages, $availablelanguages, $uninstallurl, $updateurl, $installurl) {
        $this->installedlanguages = $installedlanguages;
        $this->availablelanguages = $availablelanguages;
        $this->uninstallurl = $uninstallurl;
        $this->updateurl = $updateurl;
        $this->installurl = $installurl;
    }

    /**
     * Export the data.
     *
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        $data = new stdClass();
        $data->uninstallurl = $this->uninstallurl;
        $data->sesskey = sesskey();

        $data->installedoptions = [];
        foreach ($this->installedlanguages as $code => $language) {
            $option = new stdClass();
            $option->value = $code;
            $option->text = $language;
            $data->installedoptions[] = $option;
        }

        $data->updateurl = $this->updateurl;

        if (!empty($this->availablelanguages)) {
            $data->toinstalloptions = [];

            core_collator::asort($this->availablelanguages);
            foreach ($this->availablelanguages as $code => $language) {
                $option = new stdClass();
                $option->value = $code;
                $option->text = $language;
                $data->toinstalloptions[] = $option;
            }
            $data->installurl = $this->installurl;
            $data->caninstall = true;
        }

        if (count($this->installedlanguages) > 3) {
            $data->hasmanyinstalledlanguages = true;
            $data->updatelangstaskname = get_string('updatelangs', 'tool_langimport');
        }

        return $data;
    }
}
