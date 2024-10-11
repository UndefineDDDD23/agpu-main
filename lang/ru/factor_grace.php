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
 * Strings for component 'factor_grace', language 'ru', version '4.5'.
 *
 * @package     factor_grace
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['info'] = 'Позволяет войти в систему без других факторов в заданный период времени.';
$string['pluginname'] = 'Льготный период';
$string['preferences'] = 'Настройки пользователя';
$string['privacy:metadata'] = 'Плагин Фактор «Льготный период» не хранит никаких личных данных.';
$string['redirectsetup'] = 'Прежде чем продолжить, вам необходимо завершить настройку многофакторной аутентификации.';
$string['revokeexpiredfactors'] = 'Отменить факторы истекших льготных периодов';
$string['settings:customwarning'] = 'Содержимое баннера с предупреждением';
$string['settings:customwarning_help'] = 'Добавьте сюда содержимое, чтобы заменить уведомление о льготном периоде пользовательским HTML-контентом. Добавление {timeremaining} в текст заменит для пользователя его текущую продолжительность льготного периода, а {setuplink} заменит URL-адрес страницы настройки.';
$string['settings:forcesetup'] = 'Принудительная настройка фактора';
$string['settings:forcesetup_help'] = 'Принуждает пользователя перейти на страницу настроек для настройки многофакторной аутентификации по истечении льготного периода. Если флажок снят, то пользователи не смогут пройти аутентификацию по истечении льготного периода.';
$string['settings:graceperiod'] = 'Льготный период';
$string['settings:graceperiod_help'] = 'Период времени, в течение которого пользователи могут получить доступ к сайту без настроенных и включенных факторов.';
$string['settings:ignorelist'] = 'Игнорируемые факторы';
$string['settings:ignorelist_help'] = 'Льготный период не дает баллов, если имеются другие факторы, которые пользователи могут использовать для аутентификации с помощью многофакторной аутентификации. Любые факторы не учитываются в льготный период при принятии решения о начислении баллов. Это может предоставить льготный период для аутентификации, если другой фактор, например электронная почта, имеет проблемы с настройкой в системе.';
$string['setupfactors'] = 'В настоящее время вы находитесь в льготном периоде и, возможно, у вас недостаточно настроенных факторов для входа в систему после истечения льготного периода. Перейдите по адресу {$a->url}, чтобы проверить состояние аутентификации и настроить дополнительные факторы аутентификации. Ваш льготный период истекает через {$a->time}.';
$string['summarycondition'] = 'в пределах льготного периода';
