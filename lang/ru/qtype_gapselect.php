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
 * Strings for component 'qtype_gapselect', language 'ru', version '4.5'.
 *
 * @package     qtype_gapselect
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['addmorechoiceblanks'] = 'Шаблоны для еще {no} вариантов';
$string['answer'] = 'Ответ';
$string['choices'] = 'Варианты выбора';
$string['choicex'] = 'Вариант [[{no}]]';
$string['combinedcontrolnamegapselect'] = 'раскрывающийся список';
$string['combinedcontrolnamegapselectplural'] = 'раскрывающихся списков';
$string['correctansweris'] = 'Верный ответ: {$a}';
$string['errorblankchoice'] = 'Пожалуйста, проверьте варианты выбора: вариант {$a} пуст.';
$string['errormissingchoice'] = 'Пожалуйста, проверьте текст вопроса: вариант «{$a}» не найден среди вариантов выбора! Только номера ответов, которые указаны в вариантах выбора, могут быть использованы в качестве заполнителей.';
$string['errornoslots'] = 'Текст вопроса должен содержать метки-заполнители, например [[1]], для обозначения местонахождения пропущенных слов.';
$string['errorquestiontextblank'] = 'Вы должны ввести какой-либо текст.';
$string['group'] = 'Группа';
$string['pleaseputananswerineachbox'] = 'Пожалуйста, добавьте ответ в каждую ячейку';
$string['pluginname'] = 'Выбор пропущенных слов';
$string['pluginname_help'] = 'Вопросы с выбором пропущенных слов требуют от респондента выбрать правильные ответы из выпадающих меню. [[1]], [[2]], [[3]], ... используются в качестве заполнителей в тексте вопроса, с правильными ответами, заданными в качестве вариантов выбора 1, 2, 3 соответственно. Дополнительные варианты выбора могут быть добавлены, чтобы усложнить вопрос. Варианты выбора могут быть сгруппированы, чтобы ограничить возможные ответы в каждом выпадающем меню.';
$string['pluginname_link'] = 'question/type/gapselect';
$string['pluginnameadding'] = 'Добавить вопрос «Выбор пропущенных слов»';
$string['pluginnameediting'] = 'Редактировать вопрос «Выбор пропущенных слов»';
$string['pluginnamesummary'] = 'Пропущенные слова в тексте вопроса заполняются с помощью выпадающих меню.';
$string['privacy:metadata'] = 'Плагин «Тип вопроса Выбор пропущенных слов» позволяет авторам вопросов устанавливать параметры по умолчанию как пользовательские настройки.';
$string['privacy:preference:defaultmark'] = 'Оценка по умолчанию, установленная для данного вопроса.';
$string['privacy:preference:penalty'] = 'Штраф за каждую неправильную попытку, когда вопросы задаются с использованием режимов поведения «Интерактивный с несколькими попытками» или «Адаптивный».';
$string['privacy:preference:shuffleanswers'] = 'Следует ли автоматически перемешивать ответы.';
$string['regradeissuenumchoiceschanged'] = 'Изменено количество вариантов в группе {$a}.';
$string['regradeissuenumgroupsschanged'] = 'Изменено количество групп вариантов.';
$string['shuffle'] = 'Перемешать';
$string['tagsnotallowed'] = '{$a->tag} запрещен. (Можно использовать только {$a->allowed}.)';
$string['tagsnotallowedatall'] = '{$a->tag} запрещен. (Здесь нельзя использовать HTML.)';
