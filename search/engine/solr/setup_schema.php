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
 * Adds agpu fields to solr schema.
 *
 * Schema REST API write actions are only available from Solr 4.4 onwards.
 *
 * The schema should be managed and mutable to allow this script
 * to add new fields to the schema.
 *
 * @link      https://cwiki.apache.org/confluence/display/solr/Managed+Schema+Definition+in+SolrConfig
 * @package   search_solr
 * @copyright 2015 David Monllao {@link http://www.davidmonllao.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

require_login(null, false);
require_capability('agpu/site:config', context_system::instance());

$returnurl = new agpu_url('/admin/settings.php', array('section' => 'manageglobalsearch'));

$schema = new \search_solr\schema();

$status = $schema->can_setup_server();
if ($status !== true) {

    $PAGE->set_context(context_system::instance());
    $PAGE->set_url(new agpu_url('/search/engine/solr/setup_schema.php'));

    echo $OUTPUT->header();
    echo $OUTPUT->notification($status, \core\output\notification::NOTIFY_ERROR);
    echo $OUTPUT->box($OUTPUT->action_link($returnurl, get_string('continue')), 'generalbox centerpara');
    echo $OUTPUT->footer();

    exit(1);
}

$schema->setup();

redirect($returnurl, get_string('setupok', 'search_solr'), 4);
