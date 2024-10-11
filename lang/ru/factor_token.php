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
 * Strings for component 'factor_token', language 'ru', version '4.5'.
 *
 * @package     factor_token
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['event:token_created'] = 'Токен MФA создан.';
$string['form:trust'] = 'Доверие этому устройству для {$a}.';
$string['pluginname'] = 'Доверие этому устройству';
$string['privacy:metadata'] = 'Плагин Фактор «Доверие этому устройству» не хранит никаких личных данных.';
$string['settings:expireovernight'] = 'Срок действия доверия истекает ночью';
$string['settings:expireovernight_help'] = 'Это приводит к тому, что срок действия токенов истекает ночью, предотвращая перерывы в работе пользователей среди дня. Им будет предложено пройти многофакторную аутентификацию в начале дня после истечения срока действия.';
$string['settings:expiry'] = 'Продолжительность доверия';
$string['settings:expiry_help'] = 'Время, в течение которого этому устройству доверяют, прежде чем потребуется новая многофакторная аутентификация.';
$string['summarycondition'] = 'пользователь ранее доверял этому устройству';
$string['tokenstoredindevice'] = 'Пользователь с ID {$a->userid} имеет токен многофакторной аутентификации, хранящийся на его устройстве. <br> Информация: {$a->string}.';
