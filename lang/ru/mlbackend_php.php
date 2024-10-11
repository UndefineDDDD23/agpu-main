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
 * Strings for component 'mlbackend_php', language 'ru', version '4.5'.
 *
 * @package     mlbackend_php
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['datasetsizelimited'] = 'Из-за большого размера была оценена только часть набора данных. Установите $CFG->mlbackend_php_no_memory_limit, если вы уверены, что система может справиться с набором данных {$a}.';
$string['errorcantloadmodel'] = 'Файл модели {$a} не существует. Модель должна быть обучена, прежде чем использовать её для прогнозирования.';
$string['errorlowscore'] = 'Точность предсказания оценивающей модели не очень высока, поэтому некоторые прогнозы могут быть неточными. Оценка модели = {$a->score}, минимальная оценка = {$a->minscore}';
$string['errornotenoughdata'] = 'Недостаточно данных для оценки этой модели с использованием метода разделения по времени.';
$string['errornotenoughdatadev'] = 'Результаты оценивания слишком сильно изменились. Рекомендуется собрать больше данных, чтобы убедиться, что модель действительно работает. Стандартное отклонение результатов оценки  = {$a->deviation}, максимальное рекомендуемое стандартное отклонение = {$a->accepteddeviation}';
$string['errorphp7required'] = 'PHP-механизму машинного обучения требуется PHP 7';
$string['pluginname'] = 'PHP-механизм машинного обучения';
$string['privacy:metadata'] = 'Плагин PHP машинного обучения не хранит никаких личных данных.';
