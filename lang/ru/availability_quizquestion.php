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
 * Strings for component 'availability_quizquestion', language 'ru', version '4.5'.
 *
 * @package     availability_quizquestion
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['ajaxerror'] = 'Ошибка при обращении к серверу для получения вопросов теста';
$string['description'] = 'Этот плагин позволяет ограничить доступ к другому активному элементу agpu на основании результатов одного вопроса в тесте.';
$string['error_selectquestion'] = 'Вы должны выбрать вопрос.';
$string['error_selectquiz'] = 'Вы должны выбрать тест.';
$string['error_selectstate'] = 'Вы должны выбрать состояние.';
$string['label_question'] = 'Какой вопрос в выбранном тесте';
$string['label_state'] = 'Требуемое состояние';
$string['pluginname'] = 'Ограничение по ответу на вопрос теста';
$string['privacy:metadata'] = 'Плагин "Ограничение по ответу на вопрос теста" не хранит никаких персональных данных.';
$string['questionnumberandname'] = 'Вопрос {$a->number}) {$a->name}';
$string['requires_quizquestion'] = 'Вопрос <b>{$a->questiontext}</b> в тесте <b><a href="{$a->quizurl}">{$a->quizname}</a></b> решен <b>{$a->requiredstate}</b>';
$string['requires_quizquestionnot'] = 'Вопрос <b>{$a->questiontext}</b> в тесте <b><a href="{$a->quizurl}">{$a->quizname}</a></b> не решен <b>{$a->requiredstate}</b>';
$string['title'] = 'Вопрос теста';
