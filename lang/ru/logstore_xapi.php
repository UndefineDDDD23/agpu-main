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
 * Strings for component 'logstore_xapi', language 'ru', version '4.5'.
 *
 * @package     logstore_xapi
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['autherror'] = 'Сервер возвращает ошибку 401. Убедитесь, что конечная точка (endpoint), имя пользователя и секретный ключ/пароль для xAPI указаны правильно в настройках Журнала событий xAPI.';
$string['backgroundmode'] = 'Отправлять логи в фоновом режиме?';
$string['backgroundmode_desc'] = 'Это заставит agpu отправлять логи в LRS в фоновом режиме через задачу cron, чтобы избежать блокировки ответов страницы. Это сделает процесс менее приближенным к реальному времени, но поможет предотвратить ухудшение производительности agpu, связанное с производительностью LRS.';
$string['cohorts'] = 'Глобальные группы';
$string['cohorts_help'] = 'Подключить глобальные группы к уведомлениям';
$string['confirmresendevents'] = 'Вы собираетесь отправить записи ({$a->count})  в очередь на повторную обработку.<br>Вы хотите продолжить?';
$string['confirmresendeventsheader'] = 'Повторно отправить события';
$string['confirmsendevents'] = 'Вы собираетесь отправить записи ({$a->count})  в очередь на повторную обработку.<br>Вы хотите продолжить?';
$string['confirmsendeventsheader'] = 'Отправить события';
$string['contextidnolongerexists'] = 'ID контекста {$a} больше не существует';
$string['count'] = 'Количество';
$string['datetimegmt'] = 'Дата/Время (GMT)';
$string['datetovalidation'] = 'Дата «До» не может быть раньше даты «От»';
$string['enablesendingnotifications'] = 'Отправлять уведомления?';
$string['enablesendingnotifications_desc'] = 'Контролируйте, следует ли отправлять уведомления указанным получателям.';
$string['endpoint'] = 'Конечная точка (endpoint) вашей LRS для xAPI';
$string['errorlogpage'] = 'Страница журнала ошибок';
$string['errornotificationtrigger'] = 'Триггер уведомления об ошибке';
$string['errornotificationtrigger_desc'] = 'Пороговое значение, при достижении которого будут срабатывать уведомления. Когда генерируется количество ошибок, превышающее это значение, отправляется уведомление.';
$string['errortype'] = 'Тип ошибки';
$string['eventcontext'] = 'Контекст события';
$string['eventname'] = 'Название события';
$string['failed'] = 'Не удалось';
$string['failed_events'] = 'событие(я) не удалось отправить в LRS.';
$string['failedsubject'] = 'Журнал событий XAPI: не удалось отправить отчет о сообщениях';
$string['failedtosend'] = 'Следующие логи не были отправлены в LDH.';
$string['failedtransformresponse'] = 'Событие: «{$a}» не преобразовано';
$string['failurelog'] = 'Журнал ошибок';
$string['filters'] = 'Фильтрация журналов';
$string['filters_help'] = 'Включить фильтры, которые ВКЛЮЧАЮТ регистрацию некоторых действий.';
$string['includecohorts'] = 'Включить эти глобальные группы в уведомления';
$string['info'] = 'Информация';
$string['insendfailednotificationstask'] = 'Выполнение задачи отправки уведомлений о неудачных попытках отправки логов';
$string['lmsinstance'] = 'Экземпляр LMS, на котором произошла ошибка(и)';
$string['logguests'] = 'Регистрировать действия гостей';
$string['logstorexapierrorlog'] = 'Журнал ошибок Журнала событий xAPI';
$string['logstorexapihistoriclog'] = 'Журнал истории Журнала событий xAPI';
$string['lrserror'] = 'Возникла проблема с LDH. LDH ответил ошибкой 500.';
$string['maxbatchsize'] = 'Максимальный размер пакета';
$string['maxbatchsize_desc'] = 'Логи отправляются в LRS пакетами. Этот параметр управляет максимальным количеством записей логов, которые будут отправлены за одну операцию. Установка этого параметра на ноль приведет к тому, что все доступные логи будут отправлены одновременно, хотя это не рекомендуется.';
$string['maxbatchsizeforfailed'] = 'Максимальный размер пакета для невыполненных запросов';
$string['maxbatchsizeforfailed_desc'] = 'Логи отправляются в LRS пакетами. Этот параметр управляет максимальным количеством записей логов, которые будут отправлены за одну операцию. Установка этого параметра на ноль приведет к тому, что все доступные логи будут отправлены одновременно, хотя это не рекомендуется.';
$string['maxbatchsizeforhistorical'] = 'Максимальный размер пакета для запросов истории';
$string['maxbatchsizeforhistorical_desc'] = 'Логи отправляются в LRS пакетами. Этот параметр управляет максимальным количеством записей логов, которые будут отправлены за одну операцию. Установка этого параметра на ноль приведет к тому, что все доступные логи будут отправлены одновременно, хотя это не рекомендуется.';
$string['mbox'] = 'Идентификация пользователей по электронной почте';
$string['mbox_desc'] = 'При установленном флажке пользователи будут идентифицироваться по их адресу электронной почты (mbox).';
$string['networkerror'] = 'При отправке ответа произошла ошибка сети.';
$string['noerrorsfound'] = 'Ошибок не обнаружено';
$string['norows'] = 'Нет строк для отчета';
$string['notificationsnotenabled'] = 'Уведомления не включены';
$string['notificationtriggerlimitnotreached'] = 'Лимит срабатывания уведомлений не достигнут';
$string['password'] = 'Базовый секретный ключ аутентификации LRS/пароль для xAPI';
$string['pluginadministration'] = 'Управление Журналом событий xAPI';
$string['pluginname'] = 'Журнал событий xAPI';
$string['privacy:metadata:logstore_xapi_failed_log'] = 'Таблица для логов, отправка которых завершилась неудачей';
$string['privacy:metadata:logstore_xapi_failed_log:userid'] = 'ID пользователя в таблице для логов, отправка которых завершилась неудачей';
$string['privacy:metadata:logstore_xapi_log'] = 'Таблица для логов, ожидающих обработки в запланированной задаче cron';
$string['privacy:metadata:logstore_xapi_log:userid'] = 'ID пользователя в таблице для логов, ожидающих обработки в запланированной задаче cron';
$string['recipeerror'] = 'LDH ответил ошибкой 400, это может быть связано с проблемой в пути.';
$string['replayevent'] = 'Повторить событие';
$string['resendevents'] = 'Повторно отправить ({$a->count})';
$string['resendevents:failed'] = 'События не удалось отправить на повторную обработку.';
$string['resendevents:success'] = 'События успешно отправлены на повторную обработку.';
$string['resendfailedbatches'] = 'Размер пакета при повторной отправке в случае неудачи';
$string['resendfailedbatches_desc'] = 'Если при пакетной обработке событий отправка пакета не удалась, попробовать повторно отправить события меньшими партиями. Если этот флажок не установлен, то весь пакет не будет отправлен в случае сбоя события.';
$string['response'] = 'Ответ';
$string['routes'] = 'Включить действия с этими маршрутами';
$string['send_additional_email_addresses'] = 'Дополнительные адреса электронной почты';
$string['send_additional_email_addresses_desc'] = 'Отправлять уведомления на список адресов электронной почты. Значения должны разделяться запятыми.';
$string['send_jisc_data'] = 'Добавляет данные JISC в отчеты';
$string['send_jisc_data_desc'] = 'Отчеты будут содержать данные, требуемые JISC.';
$string['send_response_choices'] = 'Отправить варианты ответа';
$string['send_response_choices_desc'] = 'Логи для вопросов множественного выбора и ответов на вопросы последовательности будут отправлены в LRS с правильным ответом и возможными вариантами ответов.';
$string['send_username'] = 'Идентификация пользователей по имени пользователя';
$string['send_username_desc'] = 'Если этот флажок установлен, то логи будут идентифицировать пользователей по их имени пользователя в случае, если идентификация пользователей по электронной почте отключена.';
$string['sendevents'] = 'Отправить ({$a->count})';
$string['sendidnumber'] = 'Отправить номер ID курса и элемента курса';
$string['sendidnumber_desc'] = 'В отчетах будет указан ID номер для курсов и элементов (определяется администратором) в расширениях объектов.';
$string['settings'] = 'Общие настройки';
$string['shortcourseid'] = 'Отправить краткое название курса';
$string['shortcourseid_desc'] = 'Отчеты будут содержать сокращенное название курса в виде расширения ID краткого названия курса.';
$string['submit'] = 'Отправить';
$string['successful_events'] = 'событие(я) были успешно обработаны.';
$string['taskemit'] = 'Передать записи в LRS';
$string['taskfailed'] = 'Передать неудачные записи в LRS';
$string['taskhistorical'] = 'Передать записи истории в LRS';
$string['tasksendfailednotifications'] = 'Отправлять уведомления о неудачных попытках';
$string['type'] = 'Тип';
$string['unknownerror'] = 'Код ошибки: «{$a}»';
$string['unknownverb'] = 'Запрошен неизвестный verb. Он должен быть задан разработчиком.';
$string['user'] = 'Пользователь';
$string['user_help'] = 'Поиск по полному имени пользователя';
$string['username'] = 'Имя пользователя';
$string['xapi'] = 'xAPI';
$string['xapi:manageerrors'] = 'Повторно отправлять логи, отправка которых завершилась ошибкой';
$string['xapi:managehistoric'] = 'Управлять данными истории';
$string['xapi:viewerrorlog'] = 'Просматривать журнал ошибок xAPI';
$string['xapifieldset'] = 'Пример набора пользовательских полей';
$string['xapisettingstitle'] = 'Настройки xAPI Журнала событий';
