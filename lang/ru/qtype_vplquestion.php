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
 * Strings for component 'qtype_vplquestion', language 'ru', version '4.5'.
 *
 * @package     qtype_vplquestion
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['allornothing'] = 'Все или ничего';
$string['answertemplate'] = 'Шаблон ответа';
$string['answertemplate_help'] = 'Напишите здесь, какой код будет предварительно введен в поле для ответов учащегося';
$string['cannotimportquestionvplnotfound'] = 'Предупреждение об импорте: идентификатор модуля VPL, указанный в вопросе VPL "{$a}", неверен.';
$string['cannotimportquestionvplunreachable'] = 'Предупреждение об импорте: VPL, указанный в вопросе VPL "{$a}", отсутствует в этом курсе';
$string['cfg:deletevplsubmissions'] = 'Удалить отправленные данные VPL';
$string['cfg:deletevplsubmissions_help'] = 'Следует ли отбрасывать отправленные Вопросы VPL, поданные в VPL, при оценке вопросов.';
$string['cfg:generalsettings'] = 'Общие настройки';
$string['choose'] = 'Выберите ...';
$string['compilation'] = 'Компиляция:';
$string['correction'] = 'Исправление';
$string['evaluation'] = 'Оценка:';
$string['evaluationdetails'] = 'Детали оценки:';
$string['evaluationerror'] = 'Ошибка оценки:';
$string['execerror'] = 'Ошибка выполнения:';
$string['execfiles'] = 'Исполняемые файлы';
$string['execfiles_help'] = 'Здесь вы можете редактировать исполняемые файлы. Они отправляются только во время оценки (и предварительной проверки, совпадают ли файлы), а не во время запуска (за исключением файлов, указанных как "сохранять при запуске" в VPL).<br>
Чтобы добавить файлы, добавьте их в VPL в качестве исполняемых файлов.<br>
Если есть файл, который вы не хотите использовать, напишите "UNUSED" (НЕИСПОЛЬЗУЕМЫЙ) в его первой строке, и он будет опущен.';
$string['execfilesevalsettings'] = 'Исполняемые файлы и параметры оценки';
$string['execution'] = 'Ошибка выполнения:';
$string['gradetypeerror'] = 'Похоже, что в результате оценки была получена нечисловая оценка.';
$string['gradingmethod'] = 'Оценивание';
$string['gradingmethod_help'] = 'Определяет метод оценки для этого вопроса.
<ul><li>Если выбрано "Все или ничего", учащийся получит либо 100%, либо 0% от оценки за этот вопрос, в зависимости от того, получил ли он высшую оценку VPL или нет.</li>
<li>Если выбрано значение "Масштабирование", оценка учащегося за этот вопрос будет соответствовать его баллу VPL.</li></ul>';
$string['informationtext'] = 'Вопрос VPL';
$string['lastservermessage'] = 'Последнее полученное сообщение сервера выполнения: {$a}';
$string['merge'] = 'Слияние';
