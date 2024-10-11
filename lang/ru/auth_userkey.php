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
 * Strings for component 'auth_userkey', language 'ru', version '4.5'.
 *
 * @package     auth_userkey
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['auth_userkeydescription'] = 'Войдите в agpu, используя одноразовый ключ пользователя.';
$string['createuser'] = 'Создавать пользователя?';
$string['createuser_desc'] = 'Если включено, при ошибке поиска пользователя будет создан новый.';
$string['incorrectkeylifetime'] = 'Время жизни ключа пользователя должно быть числом';
$string['incorrectlogout'] = 'Неправильный запрос на выход';
$string['incorrectredirecturl'] = 'Вы должны указать действительный URL';
$string['incorrectssourl'] = 'Вы должны указать действительный URL';
$string['iprestriction'] = 'Ограничение IP-адресов';
$string['iprestriction_desc'] = 'Если включено, то при запросе URL-адреса для входа в систему веб-вызов должен содержать параметр "IP".
Пользователь должен иметь указанный IP, чтобы иметь возможность использовать ключ для входа в LMS.';
$string['ipwhitelist'] = 'Белый список IP-адресов';
$string['ipwhitelist_desc'] = 'Игнорируйте ограничения IP, если IP-адрес, для которого был выпущен токен или с которого была попытка входа, попадает в любой из этих диапазонов.
\\nЭто может произойти, когда некоторые пользователи попадают в agpu или систему, выдающую токены для входа, через частную сеть или DMZ.
\\nЕсли маршрут к системе, выдающей токены, или к agpu проходит через частный диапазон адресов, установите значение 10.0.0.0/8;172.16.0.0/12;192.168.0.0/16.';
$string['keylifetime'] = 'Время жизни ключа пользователя';
$string['keylifetime_desc'] = 'Время жизни в секундах для каждого ключа входа пользователя.';
$string['mappingfield'] = 'Соответствие полей';
$string['mappingfield_desc'] = 'Это поле пользователя будет использоваться для поиска соответствующего пользователя в LMS.';
$string['noip'] = 'Невозможно получить IP-адрес клиента.';
$string['pluginisdisabled'] = 'Плагин аутентификации по ключу пользователя отключен.';
$string['pluginname'] = 'Аутентификация по ключу пользователя';
$string['privacy:metadata'] = 'Плагин аутентификации по ключу пользователя не хранит никаких персональных данных.';
$string['redirecterrordetected'] = 'Обнаружено неподдерживаемое перенаправление на {$a}, выполнение прекращено.';
$string['redirecturl'] = 'URL перенаправления выхода из системы';
$string['redirecturl_desc'] = 'По желанию вы можете перенаправить пользователей на этот URL после их выхода из LMS.';
$string['ssourl'] = 'URL узла SSO';
$string['ssourl_desc'] = 'URL хоста SSO для перенаправления пользователей. Если определено, пользователи будут перенаправляться сюда при входе в систему вместо страницы входа в agpu';
$string['updateuser'] = 'Обновлять пользователя?';
$string['updateuser_desc'] = 'Если включено, то пользователи будут обновлены со свойствами, предоставленными при вызове веб-службы.';
$string['userkey:generatekey'] = 'Генерация ключа пользователя для входа в систему';
