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
 * Strings for component 'customcertelement_daterange', language 'ru', version '4.5'.
 *
 * @package     customcertelement_daterange
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['addrange'] = 'Добавьте другой диапазон';
$string['completiondate'] = 'Дата завершения';
$string['courseenddate'] = 'Дата окончания курса';
$string['coursegradedate'] = 'Дата оценки за курс';
$string['coursestartdate'] = 'Дата начала курса';
$string['currentdate'] = 'Текущая дата';
$string['dateitem'] = 'Элемент Дата';
$string['dateitem_help'] = 'Это дата, которая будет напечатана на сертификате';
$string['dateranges'] = 'Диапазон дат';
$string['datestring'] = 'Строчка';
$string['end'] = 'Конец';
$string['error:atleastone'] = 'Должен быть определен хотя бы один диапазон';
$string['error:datestring'] = 'Необходимо задать текстовое представление диапазона дат';
$string['error:enddate'] = 'Дата окончания должна быть позже даты начала';
$string['error:recurring'] = 'Повторяющийся диапазон дат не может быть больше 12 месяцев';
$string['fallbackstring'] = 'Строка для дат вне диапазонов';
$string['fallbackstring_help'] = 'Эта строка будет отображаться, если к дате не применяется диапазон дат. Если резервная строка не задана, то выходных данных вообще не будет.';
$string['help'] = 'Настройте строковое представление для ваших диапазонов дат.<br /><br />Если ваши диапазоны перекрываются, будет применен первый совпадающий диапазон дат.';
$string['issueddate'] = 'Дата выдачи';
$string['placeholders'] = 'Следующие заполнители могут быть использованы в строковом представлении или резервной строке. <br/><br /> {{range_first_year}} - первый год сопоставленного диапазона,<br/> {{range_last_year}} - последний год сопоставленного диапазона,<br/> {{recurring_range_first_year}} - первый год сопоставленного повторяющегося периода,<br/> {{recurring_range_last_year}} - последний год соответствующего повторяющегося периода,<br/> {{current_year}} - текущий год,<br/> {{date_year}} - год от даты пользователя.';
$string['pluginname'] = 'Диапазон дат';
$string['preview'] = 'Предварительный просмотр {$a}';
$string['privacy:metadata'] = 'Плагин диапазона дат не хранит никаких личных данных.';
$string['recurring'] = 'Повторяющийся';
$string['recurring_help'] = 'Если Вы отметите диапазон дат как повторяющийся, то настроенный год учитываться не будет.';
$string['setdeleted'] = 'Удалить';
$string['start'] = 'Начало';
