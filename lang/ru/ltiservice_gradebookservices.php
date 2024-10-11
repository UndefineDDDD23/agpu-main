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
 * Strings for component 'ltiservice_gradebookservices', language 'ru', version '4.5'.
 *
 * @package     ltiservice_gradebookservices
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['alwaysgs'] = 'Использовать эту службу для синхронизации оценок и управления столбцами';
$string['grade_synchronization'] = 'Службы заданий и оценок IMS LTI';
$string['grade_synchronization_help'] = 'Использовать ли Службы заданий и оценок IMS LTI для синхронизации оценок вместо службы Основных результатов.

* ** Не использовать эту службу ** - будут использоваться функции и настройки основных результатов
* ** Использовать эту службу только для синхронизации оценок ** - служба заполняет оценки в уже существующем столбце задания журнала оценок, но не сможет создавать новые задания
* ** Использовать эту службу для синхронизации оценок и управления столбцами заданий ** - Служба сможет создавать и обновлять столбцы заданий журнала оценок и управлять оценками.';
$string['ltiservice_gradebookservices'] = 'Службы заданий и оценок IMS LTI';
$string['modulename'] = 'Оценки LTI';
$string['nevergs'] = 'Не использовать эту службу';
$string['partialgs'] = 'Использовать эту службу только для синхронизации оценок';
$string['pluginname'] = 'Службы заданий и оценок IMS LTI';
$string['privacy:metadata:externalpurpose'] = 'Эта информация отправляется внешнему поставщику LTI.';
$string['privacy:metadata:feedback'] = 'Отзыв, полученный пользователем от этого LTI.';
$string['privacy:metadata:grade'] = 'Оценка, полученнаяй пользователем от этого LTI.';
$string['privacy:metadata:maxgrade'] = 'Максимальная оценка, которую можно получить от этого LTI.';
$string['privacy:metadata:timemodified'] = 'Последнее время, когда обновлялась оценка';
$string['privacy:metadata:userid'] = 'ID пользователя, использующего LTI.';
$string['taskcleanup'] = 'Очистка таблицы Службы заданий и оценок IMS LTI';
