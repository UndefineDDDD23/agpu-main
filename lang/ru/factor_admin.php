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
 * Strings for component 'factor_admin', language 'ru', version '4.5'.
 *
 * @package     factor_admin
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['info'] = 'Это позволяет параметру «НЕ администратор» считаться за фактор. Его предполагаемое использование — обеспечение для администратора более строгих  требований безопасности, поэтому обычные пользователи получают вес свободно, в то время как администраторы должны использовать другие факторы.';
$string['pluginname'] = 'Не администратор';
$string['privacy:metadata'] = 'Плагин Фактор «НЕ администратор» не хранит никаких личных данных.';
$string['settings:weight_help'] = 'Вес этого фактора присваивается обычным пользователям, поэтому для прохождения администраторам необходимо иметь больше факторов, чем обычному пользователю.';
$string['summarycondition'] = 'не администратор';
