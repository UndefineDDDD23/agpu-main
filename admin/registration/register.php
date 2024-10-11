<?php

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// This file is part of agpu - http://agpu.org/                      //
// agpu - Modular Object-Oriented Dynamic Learning Environment         //
//                                                                       //
// agpu is free software: you can redistribute it and/or modify        //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation, either version 3 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// agpu is distributed in the hope that it will be useful,             //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details.                          //
//                                                                       //
// You should have received a copy of the GNU General Public License     //
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.       //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

/**
 * @package    agpu
 * @subpackage registration
 * @author     Jerome Mouneyrac <jerome@mouneyrac.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 1999 onwards Martin Dougiamas  http://dougiamas.com
 *
 * This page displays the site registration form for agpu.org/MOOCH or for a different hub.
 * It handles redirection to the hub to continue the registration workflow process.
 * It also handles update operation by web service.
 */


require_once('../../config.php');

redirect(new agpu_url('/admin/registration/index.php'));