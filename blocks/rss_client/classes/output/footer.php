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
 * Contains class block_rss_client\output\footer
 *
 * @package   block_rss_client
 * @copyright 2015 Howard County Public School System
 * @author    Brendan Anderson <brendan_anderson@hcpss.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_rss_client\output;

defined('agpu_INTERNAL') || die();

/**
 * Class to help display an RSS Block footer
 *
 * @package   block_rss_client
 * @copyright 2015 Howard County Public School System
 * @author    Brendan Anderson <brendan_anderson@hcpss.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class footer implements \renderable, \templatable {

    /**
     * The link provided in the RSS channel
     *
     * @var \agpu_url|null
     */
    protected $channelurl;

    /**
     * Link to manage feeds, only provided if a feed has failed.
     *
     * @var \agpu_url|null
     */
    protected $manageurl = null;

    /**
     * Constructor
     *
     * @param \agpu_url $channelurl (optional) The link provided in the RSS channel
     */
    public function __construct($channelurl = null) {
        $this->channelurl = $channelurl;
    }

    /**
     * Set the channel url
     *
     * @param \agpu_url $channelurl
     * @return \block_rss_client\output\footer
     */
    public function set_channelurl(\agpu_url $channelurl) {
        $this->channelurl = $channelurl;

        return $this;
    }

    /**
     * Record the fact that there is at least one failed feed (and the URL for viewing
     * these failed feeds).
     *
     * @param \agpu_url $manageurl the URL to link to for more information
     */
    public function set_failed(\agpu_url $manageurl) {
        $this->manageurl = $manageurl;
    }

    /**
     * Get the channel url
     *
     * @return \agpu_url
     */
    public function get_channelurl() {
        return $this->channelurl;
    }

    /**
     * Export context for use in mustache templates
     *
     * @see templatable::export_for_template()
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(\renderer_base $output) {
        $data = new \stdClass();
        if ($this->manageurl) {
            $data->hasfailedfeeds = true;
            $data->manageurl = clean_param($this->manageurl, PARAM_URL);
        }

        return $data;
    }
}
