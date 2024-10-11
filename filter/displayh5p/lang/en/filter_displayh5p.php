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
 * Strings for filter_displayh5p
 *
 * @package    filter_displayh5p
 * @copyright  2019 Victor Deniz <victor@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die;

$string['allowedsourceslist'] = 'Allowed sources';
$string['allowedsourceslistdesc'] = 'A list of URLs from which users can embed H5P content. If none are specified, all URLs will remain as links and not be displayed as embedded H5P content.

\'[id]\' is a placeholder for the H5P content ID in the external source.
For example:

- H5P.com: https://[xxxxxx].h5p.com/content/[id]
- Wordpress: http://myserver/wp-admin/admin-ajax.php?action=h5p_embed&id=[id]';
$string['filtername'] = 'Display H5P';
$string['privacy:metadata'] = 'The display H5P filter does not store any personal data.';
