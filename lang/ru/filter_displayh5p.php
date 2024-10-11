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
 * Strings for component 'filter_displayh5p', language 'ru', version '4.5'.
 *
 * @package     filter_displayh5p
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['allowedsourceslist'] = 'Разрешенные источники';
$string['allowedsourceslistdesc'] = 'Список URL-адресов, с которых пользователи могут встраивать контент H5P. Если ничего не указано, все URL-адреса останутся ссылками и не будут отображаться как встроенное содержимое H5P.

«[id]» - это заполнитель для идентификатора контента H5P во внешнем источнике.
Например:

- H5P.com: https://[xxxxxx].h5p.com/content/[id]
- Wordpress: http://myserver/wp-admin/admin-ajax.php?action=h5p_embed&id=[id]';
$string['filtername'] = 'Отображение H5P';
$string['privacy:metadata'] = 'Фильтр H5P не хранит никаких личных данных.';
