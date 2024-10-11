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
 * Strings for component 'logstore_lanalytics', language 'ru', version '4.5'.
 *
 * @package     logstore_lanalytics
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['buffersize'] = 'Размер буфера';
$string['configloglifetime_descr'] = 'Определяет срок хранения событий журнала активности курса. События старше срока автоматически удаляются. Если они вам нужны, лучше хранить события так долго, как это возможно. Однако если у вас очень загруженный сервер или вы испытываете проблемы с производительностью – вы можете снизить срок хранения событий. Значения ниже 6 месяцев не рекомендуются, так как статистика может работать некорректно.';
$string['loglifetime'] = 'Срок хранения событий';
$string['pluginname'] = 'Журнал аналитики обучения';
$string['privacy:metadata'] = 'Плагин не хранит персональную информацию. Все данные журналируются и хранятся обезличено.';
$string['setting_course_ids'] = 'ID курсов';
$string['setting_course_ids_descr'] = 'Используется совместно с опциями "ТОЛЬКО" и "КРОМЕ" области журналирования для отслеживания только определённых курсов. Пример: <code>10,153,102</code>.';
$string['setting_log_scope'] = 'Область журналирования';
$string['setting_log_scope_all'] = 'Все события';
$string['setting_log_scope_descr'] = 'Определяет границы процесса журналирования. По умолчанию, все события сохраняются.';
$string['setting_log_scope_exclude'] = 'Обрабатывать события курсов, КРОМЕ указанных ниже в поле «ID курсов».';
$string['setting_log_scope_include'] = 'Обрабатывать события ТОЛЬКО курсов, указанных ниже в поле «ID курсов».';
$string['setting_nontracking_roles'] = 'Не отслеживаемые роли';
$string['setting_nontracking_roles_descr'] = 'Определяет, какие роли <strong>НЕ</strong> должны отслеживаться (чёрный список). Это полезно, если вы не хотите отслеживать определённые роли (например управляющих или преподавателей). Укажите роли, используя их краткое название (может быть найдено в <em>Администрирование</em> -> <em>Пользователи</em> -> <em>Права</em> -> <em>Определить роли</em>). По умолчанию все роли отслеживаются. Пример: <code>teacher,editingteacher,manager</code>. Эта настройка имеет приоритет выше, чем у <code>Отслеживаемые роли</code>.';
$string['setting_tracking_roles'] = 'Отслеживаемые роли';
$string['setting_tracking_roles_descr'] = 'Определяет, какие роли должны отслеживаться (белый список). Это полезно, если вы хотите отслеживать только определённые роли (например, студентов или гостей). Укажите роли, используя их краткое название (может быть найдено в <em>Администрирование</em> -> <em>Пользователи</em> -> <em>Права</em> -> <em>Определить роли</em>). По умолчанию все роли отслеживаются. Пример: <code>student,guest</code>.';
$string['taskcleanup'] = 'Очистка таблицы журнала';
