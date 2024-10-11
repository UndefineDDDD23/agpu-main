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
 * Strings for component 'tool_uploadenrolmentmethods', language 'ru', version '4.5'.
 *
 * @package     tool_uploadenrolmentmethods
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['attributesnotfound'] = 'Метод зачисления не найден: «{$a}».';
$string['attributesnotinstalled'] = 'Метод зачисления не установлен: «{$a}».';
$string['cohortnotfound'] = 'Глобальная группа не найдена.';
$string['csvfile_help'] = 'Формат файла CSV должен быть следующим:

* Каждая строка файла содержит одну запись.
* Каждая запись представляет собой набор данных в любом порядке, разделенных запятыми или другими стандартными разделителями.
* Поля: operation, enrolment method, target course shortname, parent course shortname или cohort idnumber, disabled status[, group name, role].
* Все поля обязательны для заполнения, кроме group и role.
* Операции — add, del(ete) и upd(ate).
* Поддерживаемые методы зачисления — meta и cohort.
* Значения статуса отключения — 1 (отключено) или 0 (включено).
* Студенты, зачисленные с помощью метода, будут помещены в группу, указанную в поле group name.
  Группа будет создана, если она еще не существует.
* Поле role должно быть корректным именем роли, таким как editingteacher, student и т.д.';
$string['heading'] = 'Загрузка методов зачисления на курсы из файла CSV';
$string['invalidmethod'] = 'Неправильный метод.';
$string['invalidop'] = 'Неправильная операция.';
$string['method'] = 'Метод';
$string['methoddisabledwarning'] = 'Метод зачисления «{$a}» отключен.';
$string['methodscreated'] = 'Создано: {$a}';
$string['methodsdeleted'] = 'Удалено: {$a}';
$string['methodserrors'] = 'Ошибки: {$a}';
$string['methodstotal'] = 'Всего: {$a}';
$string['methodsupdated'] = 'Обновлено: {$a}';
$string['operation'] = 'Операция';
$string['parentnotfound'] = 'Ссылка на метакурс не найдена.';
$string['pluginname'] = 'Загрузка методов зачисления';
$string['pluginname_help'] = 'Загрузить методы зачисления из файла CSV для задания методов зачисления в целом ряде курсов за одну операцию.';
$string['privacy:metadata'] = 'Плагин «Загрузка методов зачисления» не хранит никаких персональных данных.';
$string['reladderror'] = 'Ошибка связывания метода с курсом.';
$string['relalreadyexists'] = 'Метод уже добавлен в курс.';
$string['reldoesntexist'] = 'Метод не существует.';
$string['result'] = 'Результат';
$string['results'] = 'Результаты загрузки методов зачисления';
$string['targetisparent'] = 'Метод является родителем курса, поэтому он не может быть добавлен в качестве его целевого курса.';
$string['targetnotfound'] = 'Неизвестный курс.';
$string['uploadenrolmentmethods:add'] = 'Добавлять/Загружать методы зачисления';
$string['uploadenrolmentmethods:delete'] = 'Удалять методы зачисления';
