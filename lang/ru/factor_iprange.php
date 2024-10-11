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
 * Strings for component 'factor_iprange', language 'ru', version '4.5'.
 *
 * @package     factor_iprange
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['allowedipsempty'] = 'Этот фактор на данный момент никто не пройдет! Вы можете добавить свой собственный IP-адрес Этот фактор на данный момент никто не пройдет! Вы можете добавить свой собственный IP-адрес(<i>{$a->ip}</i>)';
$string['allowedipshasmyip'] = 'Ваш IP-адрес (<i>{$a->ip}</i>) есть в списке, и вы пройдете этот фактор.';
$string['allowedipshasntmyip'] = 'Вашего IP (<i>{$a->ip}</i>) нет в списке, и вы не пройдете этот фактор.';
$string['pluginname'] = 'Диапазон IP-адресов';
$string['privacy:metadata'] = 'Плагин Фактор «Диапазон IP-адресов» не хранит никаких личных данных.';
$string['settings:safeips'] = 'Диапазоны безопасных IP-адресов';
$string['settings:safeips_help'] = 'Введите список IP-адресов или подсетей, которые будут учитываться как пройденный фактор. Если пусто, никто не пройдет этот фактор. {$a->info} {$a->syntax}';
$string['summarycondition'] = 'находится в защищенной сети';
