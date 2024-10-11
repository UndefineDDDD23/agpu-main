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
 * Strings for component 'factor_capability', language 'ru', version '4.5'.
 *
 * @package     factor_capability
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['capability:cannotpassfactor'] = 'ОСТАНАВЛИВАЕТ для роли передачу фактора возможностей пользователя MФA.';
$string['pluginname'] = 'Возможности пользователя';
$string['privacy:metadata'] = 'Плагин Фактор «Возможности пользователя» не хранит никаких личных данных.';
$string['settings:adminpasses'] = 'Администраторы сайта могут пропустить этот фактор';
$string['settings:adminpasses_help'] = 'По умолчанию администраторы проходят проверки всех возможностей, включая ту, которая использует «фактор/возможность: cannotpassfactor», что означает, что они не пройдут этот фактор.
     Если этот флажок установлен, все администраторы сайта будут проходить этот фактор, если у них нет такой возможности из другой роли.
     Если флажок не установлен, администраторы сайта не пройдут этот фактор.';
$string['summarycondition'] = 'НЕ имеет возможности «фактор/возможность: cannotpassfactor» в любой роли, включая администратора сайта.';
