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
 * Strings for component 'subcourse', language 'ru', version '4.5'.
 *
 * @package     subcourse
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['blankwindow'] = 'Открыть в новом окне';
$string['blankwindow_help'] = 'Если выбрано, ссылка будет открывать связанный курс в новом окне браузера.';
$string['completioncourse'] = 'Необходимо завершить связанный курс';
$string['completioncourse_help'] = 'При включенном параметре элемент считается выполненным,  если студент завершит связанный курс.';
$string['completioncourse_text'] = 'Студент должен завершить связанный курс для выполнения этого элемента';
$string['currentgrade'] = 'Текущая оценка: {$a}';
$string['currentprogress'] = 'Прогресс: {$a}%';
$string['displayoption:coursepageprintgrade'] = 'Отображать оценки из связанного курса на странице курса';
$string['displayoption:coursepageprintprogress'] = 'Отображать прогресс по связанному курсу на странице курса';
$string['errfetch'] = 'Не удалось получить оценки: код ошибки {$a}';
$string['errlocalremotescale'] = 'Не удалось получить оценки: итоговая оценка в связанном курсе использует локальную шкалу оценок.';
$string['eventgradesfetched'] = 'Оценки получены';
$string['fetchgradesmode'] = 'Получать оценки как';
$string['fetchgradesmode0'] = 'Значения в баллах';
$string['fetchgradesmode1'] = 'Значения в процентах';
$string['fetchgradesmode_help'] = 'В зависимости от настройки журнала оценок в связанном курсе, «сырое» значение (в баллах) и значение в процентах итоговой оценки курса могут не всегда совпадать со значениями, отображаемыми в этом элементе «Субкурс». Этот параметр определяет, какие из значений будут совпадать.

* Значения в баллах — фактическое значение итоговой оценки в связанном курсе передаётся как оценка в этот элемент «Субкурс». Если в связанном курсе есть исключенные оценки, то итоговая оценка в процентах, вычисленная по связанному курсу, может не совпадать с процентным значением, указанным в элементе «Субкурс».
* Значения в процентах — итоговая оценка, полученная из связанного курса, пересчитывается так, чтобы значение в процентах, показываемое в связанном курсе, совпадало с значением в процентах, показываемым в данном элементе «Субкурс». Если в данном связанном курсе есть некоторые исключенные оценки, значения оценок в баллах могут не совпадать.';
$string['fetchnow'] = 'Получить оценки сейчас';
$string['gotocoursename'] = 'Перейти к курсу <a href="{$a->href}">{$a->name}</a>';
$string['gotorefcourse'] = 'Перейти к {$a}';
$string['gotorefcoursegrader'] = 'Все оценки в {$a}';
$string['gotorefcoursemygrades'] = 'Мои оценки в {$a}';
$string['gradesfetching'] = 'Получение оценок';
$string['hiddencourse'] = '*скрытый*';
$string['instantredirect'] = 'Перенаправлять в связанный курс';
$string['instantredirect_help'] = 'При включенном параметре пользователи будут перенаправлены в связанный курс при попытке посмотреть страницу модуля «Субкурс». Не влияет на пользователей, которым разрешено вручную получать оценки.';
$string['lastfetchnever'] = 'Оценки еще не были получены';
$string['lastfetchtime'] = 'Последнее обновление: {$a}';
$string['linkcontrol'] = 'Ссылка элемента «Субкурс»';
$string['modulename'] = 'Субкурс';
$string['modulename_help'] = 'Модуль выполняет очень простую, но полезную функцию. При добавлении в курс, он ведет себя как элемент курса. Оценка для каждого студента берется из итоговой оценки другого курса. В сочетании с метакурсами, это позволяет разработчикам организовывать курсы в виде набора отдельных модулей.';
$string['modulenameplural'] = 'Субкурсы';
$string['nocoursesavailable'] = 'Нет курсов, из которых вы могли бы получить оценки';
$string['nosubcourses'] = 'В данном курсе отсутствуют субкурсы';
$string['pluginadministration'] = 'Управление субкурсом';
$string['pluginname'] = 'Субкурс';
$string['privacy:metadata'] = 'Субкурс не хранит никаких персональных данных';
$string['refcourse'] = 'Связанный курс';
$string['refcourse_help'] = 'Связанный курс — курс, из которого берется оценка для данного элемента курса. Студенты должны быть записаны на связанный курс.

В этом списке отображаются только курсы, для которых вы являетесь учителем. Вы можете попросить администратора сайта настроить этот субкурс для получения оценок из других курсов.';
$string['refcoursecurrent'] = 'Сохранить текущую связь';
$string['refcourselabel'] = 'Получить оценки из';
$string['refcoursenull'] = 'Связанный курс не задан';
$string['settings:coursepageprintgrade'] = 'Оценка на странице курса';
$string['settings:coursepageprintgrade_desc'] = 'Отображать оценки из связанного курса на странице курса';
$string['settings:coursepageprintprogress'] = 'Прогресс на странице курса';
$string['settings:coursepageprintprogress_desc'] = 'Отображать прогресс по связанному курсу на странице курса';
$string['subcourse:addinstance'] = 'Добавлять новый субкурс';
$string['subcourse:begraded'] = 'Получать оценку из связанного курса';
$string['subcourse:fetchgrades'] = 'Получать оценки вручную из связанного курса';
$string['subcourse:view'] = 'Просматривать элемент «Субкурс»';
$string['subcoursename'] = 'Название субкурса';
$string['taskcheckcompletedrefcourses'] = 'Проверка завершения связанных курсов';
$string['taskfetchgrades'] = 'Получить оценки субкурса';
