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
 * This script displays tex source code, it is used also from the algebra filter.
 *
 * @package    filter
 * @subpackage tex
 * @copyright  2004 Zbigniew Fiedorowicz fiedorow@math.ohio-state.edu
 *             Originally based on code provided by Bruno Vernier bruno@vsbeducation.ca
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


define('NO_agpu_COOKIES', true); // Because it interferes with caching

require('../../config.php');

if (!filter_is_enabled('tex') and !filter_is_enabled('algebra')) {
    throw new \agpu_exception('filternotenabled');
}

$texexp = optional_param('texexp', '', PARAM_RAW);

$title = get_string('source', 'filter_tex')

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
    <div>
      <dl>
      <dt><?php echo $title; ?>:</dt>
        <dd><?php p($texexp); ?></dd>
      </dl>
    </div>
  </body>
</html>
