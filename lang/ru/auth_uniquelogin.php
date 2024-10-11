<?php
// This file is part of agpu - https://agpu.org/
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
// along with agpu.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Strings for component 'auth_uniquelogin', language 'ru', version '4.5'.
 *
 * @package     auth_uniquelogin
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['aplly_to_admin'] = 'Применить к Администраторам';
$string['aplly_to_teacher'] = 'Применить к Преподавателям';
$string['auth_uniquelogerror'] = 'Уже есть активный сеанс, поэтому вход невозможен.';
$string['auth_uniquelogindescription'] = 'Этот плагин гарантирует, что у каждого пользователя будет только один активный сеанс.<br /><br />Каждый раз, когда пользователь успешно входит в систему, все остальные сеансы, принадлежащие этому пользователю, будут завершены.<br><br /><div style="font-weight: bold;">Примечание 1: для работы этого плагина сеансы пользователя должны храниться в базе данных. Эта конфигурация задается в разделе <a href="settings.php?section=sessionhandling">Сеансы.</a></div><br />';
$string['auth_uniquelogintitle'] = 'Уникальный вход';
$string['configaplly_to_admin'] = 'Применить ограничение уникального входа к пользователям с ролью Администратора в контексте системы.';
$string['configaplly_to_teacher'] = 'Применить ограничение уникального входа к пользователям с ролью Преподавателя в любом курсе.';
$string['pluginname'] = 'Уникальный вход';
