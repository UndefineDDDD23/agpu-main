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
 * Strings for component 'tool_coursedates', language 'ru', version '4.5'.
 *
 * @package     tool_coursedates
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['atleastonedate'] = 'Вы должны задать хотя бы одну дату для обновления';
$string['autoenddate'] = 'Рассчитать дату окончания?';
$string['autoenddate_default'] = 'Не изменять';
$string['autoenddate_help'] = 'agpu может рассчитать дату окончания, опираясь на число разделов в курсах, которые используют формат «Разделы по неделям». Вы можете выбрать, задать ли это принудительно на уровне категории.';
$string['autoenddate_off'] = 'Отключить автоматические даты окончания';
$string['autoenddate_on'] = 'Принудительно задать автоматические даты окончания';
$string['coursedates:setdates'] = 'Задавать даты начала/окончания для всех курсов в категории.';
$string['keependdates'] = 'Сохранить существующие даты окончания';
$string['pluginname'] = 'Задание дат курса';
$string['privacy:metadata'] = 'Плагин «Задание дат курса» не хранит никаких персональных данных.';
$string['setdates'] = 'Задать даты курса';
$string['setdatesinstruction'] = 'Задайте даты начала и окончания для всех курсов в категории, включая подкатегории. Выберите свои значения и нажмите «Подтвердить». После подтверждения agpu создаст задачу для задания всех дат в фоновом режиме. Для этого необходимо, чтобы cron был включен.';
$string['updatequeued'] = 'Задача по обновлению всех курсов в категории <strong>«{$a}»</strong> была добавлена в очередь. Она будет запущена при следующем выполнении cron.';
