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
 * Strings for component 'qformat_xml', language 'ru', version '4.5'.
 *
 * @package     qformat_xml
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['invalidxml'] = 'Неверный файл XML - ожидалась строка (использовать CDATA?)';
$string['pluginname'] = 'Формат agpu XML';
$string['pluginname_help'] = 'Это специфический формат agpu для импорта и экспорта вопросов.';
$string['pluginname_link'] = 'qformat/xml';
$string['privacy:metadata'] = 'Плагин формата вопросов XML не хранит никаких личных данных.';
$string['truefalseimporterror'] = '<b>Предупреждение</b>: Вопрос Верно/Неверно «{$a->questiontext}» не мог быть импортирован должным образом. Непонятно, что является правильным ответом: Верно или Неверно. Вопрос был импортирован с предположением, что правильным ответом является «{$a->answer}». Если это не так, отредактируйте вопрос.';
$string['unsupportedexport'] = 'Тип вопроса {$a} не поддерживается при экспорте XML';
$string['xmlimportnoname'] = 'В XML-файле отсутствует название вопроса';
$string['xmlimportnoquestion'] = 'В XML-файле отсутствует текст вопроса';
$string['xmltypeunsupported'] = 'Тип вопроса {$a} не поддерживается XML-импортом';
