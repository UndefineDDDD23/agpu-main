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
 * Template library webservice definitions.
 *
 *
 * @package    tool_templatelibrary
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = array(

    'tool_templatelibrary_list_templates' => array(
        'classname'   => 'tool_templatelibrary\external',
        'methodname'  => 'list_templates',
        'classpath'   => '',
        'description' => 'List/search templates by component.',
        'type'        => 'read',
        'capabilities'=> '',
        'ajax'        => true,
        'loginrequired' => false,
    ),
    'tool_templatelibrary_load_canonical_template' => array(
        'classname'   => 'tool_templatelibrary\external',
        'methodname'  => 'load_canonical_template',
        'description' => 'Load a canonical template by name (not the theme overidden one).',
        'type'        => 'read',
        'ajax'        => true,
        'loginrequired' => false,
    ),

);

