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
 * Strings for component 'local_reminders', language 'ru', version '4.5'.
 *
 * @package     local_reminders
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['activityconfduein'] = 'Срок истекает';
$string['activityconfexplicitenable'] = 'Активация явного напоминания';
$string['activityconfexplicitenabledesc'] = 'Если включено, учителя должны в курсе должны <strong>явно</strong> включить напоминания для каждого элемента курса на странице настроек напоминаний. При этом все напоминания об элементах курса будут по умолчанию отключены независимо от заданного ниже расписания. Эта конфигурация никак не повлияет на напоминания, срок по которым уже прошёл.';
$string['activityconfexplicitenablehint'] = 'Администратор сайта по умолчанию отключил отправку напоминаний об элементах курса. Это означает, что учителя должны в этом курсе <em>явно</em> включить необходимые напоминания об элементах курса.';
$string['activityconfnoupcomingactivities'] = 'Нет предстоящих элементов курса в этом курсе.';
$string['activityconfupcomingactivities'] = 'Предстоящие элементы курса';
$string['activityconfupcomingactivitiesdesc'] = 'Напоминания будут отправлены только по отмеченным флажками элементам курса.';
$string['activitydueopenahead'] = 'Напоминать об открытии элементов курса за:';
$string['activitydueopenaheaddesc'] = 'За сколько дней необходимо отправлять напоминания об открытии элементов курса. Этот параметр применяется только в том случае, если в настройках выше разрешена отправка напоминаний об открытии элементов.';
$string['activityignoreincompletes'] = 'Не отправлять напоминания по выполненным элементам:';
$string['activityignoreincompletesdetails'] = 'Если включено, то никакие напоминания не будут отправляться, если элемент курса уже выполнен пользователем <strong>до</strong> срока его сдачи.';
$string['activityopeningseparation'] = 'Отдельно показывать открытия для элементов курса:';
$string['activityopeningseparationdesc'] = 'Показывать открытия элементов курса как отдельные записи на странице настроек напоминаний в курсе.';
$string['activityremindersboth'] = 'Для открытий и закрытий элементов курса';
$string['activityremindersonlyclosings'] = 'Только для закрытий элементов курса';
$string['activityremindersonlyopenings'] = 'Только для открытий элементов курса';
$string['admintreelabel'] = 'Напоминания';
$string['calendareventcreatedprefix'] = 'ДОБАВЛЕНО';
$string['calendareventoverdueprefix'] = 'ПРОСРОЧЕНО';
$string['calendareventremovedprefix'] = 'УДАЛЕНО';
$string['calendareventupdatedprefix'] = 'ОБНОВЛЕНО';
$string['caleventchangedheading'] = 'Напоминания об изменениях событий в календаре';
$string['caleventchangedheadingdetails'] = 'Эти настройки будут проверены <strong> перед</strong> рассмотрением отдельного типа события.';
$string['categoryheading'] = 'Напоминания о событиях категории курса';
$string['categorynosendforended'] = 'Не отправлять напоминания по завершённым курсам:';
$string['categorynosendforendeddescription'] = 'Если включено, то напоминания о завершённых курсах отправляться не будут.';
$string['contentdescription'] = 'Описание';
$string['contenttypeactivity'] = 'Элемент курса';
$string['contenttypecategory'] = 'Категория';
$string['contenttypecourse'] = 'Курс';
$string['contenttypegroup'] = 'Группа';
$string['contenttypelocation'] = 'Где';
$string['contenttypeuser'] = 'Пользователь';
$string['contentwhen'] = 'Когда';
$string['courseheading'] = 'Напоминания о событиях курса';
$string['days1'] = '1 день';
$string['days3'] = '3 дня';
$string['days7'] = '7 дней';
$string['dueheading'] = 'Напоминания о событиях';
$string['emailconfigsheading'] = 'Настройка напоминания по электронной почте';
$string['emailfootercustomname'] = 'Пользовательский нижний колонтитул письма электронной почты';
$string['emailfootercustomnamedesc'] = 'Задайте содержимое нижнего колонтитула, которое будет вставляться в каждое электронное письмо с напоминанием. Если это содержимое пустое и нижний колонтитул по умолчанию отключен, то нижний колонтитул будет полностью удален из напоминаний.';
$string['emailfooterdefaultname'] = 'Использовать нижний колонтитул письма электронной почты по умолчанию';
$string['emailfooterdefaultnamedesc'] = 'Если включено, то нижний колонтитул электронного письма с напоминанием по умолчанию будет содержать ссылку на календарь agpu. В противном случае будет использоваться содержимое, предоставленное в пользовательском нижнем колонтитуле.';
$string['emailheadercustomname'] = 'Пользовательский верхний колонтитул письма электронной почты';
$string['emailheadercustomnamedesc'] = 'Задайте содержимое верхнего колонтитула, которое будет вставляться в каждое электронное письмо с напоминанием. Этот колонтитул можно использовать для брендирования этих электронных писем на вашем сайте.';
$string['enabled'] = 'Включено';
$string['enabledaddedevents'] = 'Отправлять при создании события:';
$string['enabledaddedeventsdescription'] = 'Указывает, следует ли отправлять напоминания при создании события в календаре.';
$string['enabledchangedevents'] = 'Отправлять при обновлении события:';
$string['enabledchangedeventsdescription'] = 'Указывает, следует ли отправлять напоминания при обновлении события в календаре.';
$string['enableddescription'] = 'Включить/отключить плагин напоминания';
$string['enabledforcalevents'] = 'Включить для изменения событий в календаре:';
$string['enabledforcaleventsdescription'] = 'Разрешить отправку напоминаний для этого типа при создании, удалении или обновлении события в календаре.';
$string['enabledoverdue'] = 'Разрешено «Просрочено»';
$string['enabledremovedevents'] = 'Отправлять при удалении события:';
$string['enabledremovedeventsdescription'] = 'Указывает, следует ли отправлять напоминания при удалении события в календаре.';
$string['eventtypeclose'] = 'Элемент курса закрывается';
$string['eventtypeexpectcompletionon'] = 'Завершение ожидается';
$string['eventtypegradingdue'] = 'Оценить до';
$string['eventtypeopen'] = 'Элемент курса открывается';
$string['excludedmodules'] = 'Исключенные модули:';
$string['excludedmodulesdesc'] = 'Напоминания не будут отправляться, если событие сгенерировано одним из выбранных выше модулей. Этот параметр является глобальным и применим для любого типа событий.';
$string['explaincategoryheading'] = 'Настройки напоминания для событий категории курса.';
$string['explaincourseheading'] = 'Настройки напоминания для событий курса. Эти события поступают от курса.';
$string['explaindueheading'] = 'Настройки напоминания для событий элемента курса. Эти события поступают от элементов/модулей внутри курса.';
$string['explaingroupheading'] = 'Настройки напоминаний для событий группы. Эти события относятся только к определенной группе.';
$string['explaingroupshowname'] = 'Указывает, следует ли включать название группы в отправляемое сообщение или нет.';
$string['explainrolesallowedfor'] = 'Выберите, какие пользователи с вышеуказанными ролями могут получать напоминания.';
$string['explainsendactivityreminders'] = 'Указывает, в каком состоянии элемента следует отправлять напоминания.';
$string['explainsiteheading'] = 'Настройки напоминания для событий сайта. Эти события актуальны для всех пользователей сайта.';
$string['explainuserheading'] = 'Настройки напоминания для событий пользователя. Эти события индивидуальны для каждого пользователя.';
$string['filterevents'] = 'Фильтровать события календаря:';
$string['filtereventsdescription'] = 'Какие события календаря следует фильтровать и отправлять напоминания для них.';
$string['filtereventsonlyhidden'] = 'Только события, скрытые в календаре';
$string['filtereventsonlyvisible'] = 'Только события, видимые в календаре';
$string['filtereventssendall'] = 'Все события';
$string['groupheading'] = 'Напоминания о групповых событиях';
$string['groupshowname'] = 'Показать название группы в сообщении:';
$string['messageprovider:reminders_course'] = 'Уведомления с напоминаниями о событиях курса';
$string['messageprovider:reminders_coursecategory'] = 'Уведомления с напоминаниями о событиях категории курса';
$string['messageprovider:reminders_due'] = 'Уведомления с напоминаниями о событиях элемента курса';
$string['messageprovider:reminders_group'] = 'Уведомления с напоминаниями о событиях группы';
$string['messageprovider:reminders_site'] = 'Уведомления с напоминаниями о событиях на сайте';
$string['messageprovider:reminders_user'] = 'Уведомления с напоминаниями о событиях пользователя';
$string['messagetitleprefix'] = 'Префикс заголовка сообщения:';
$string['messagetitleprefixdescription'] = 'Этот текст будет вставлен в виде префикса (в квадратных скобках) к заголовку каждого отправляемого сообщения-напоминания.';
$string['agpucalendarname'] = 'Календарь agpu';
$string['overdueactivityreminders'] = 'Напоминания о просроченных элементах курса:';
$string['overdueactivityremindersdescription'] = 'Если включено, то напоминания будут отправляться пользователям, которые просрочили выполнение элемента курса.';
$string['overduemessage'] = 'Этот элемент курса просрочен!';
$string['overduewarnmessage'] = 'Предупреждающее сообщение о просроченных элементах курса:';
$string['overduewarnmessagedescription'] = 'Введите <strong>простой текст</strong>, который будет выделен красным цветом внутри электронных писем о «просроченных» элементах . Если это поле пустое, то сообщение отображаться не будет. Это будет работать только в том случае, если разрешены электронные письма о просроченных элементах курса.';
$string['overduewarnprefix'] = 'Префикс темы о просроченных элементах курса:';
$string['overduewarnprefixdescription'] = 'Введите <strong> простой префикс</strong>, который будет встроен в заголовок электронных писем о «просроченных» элементах курса. Если это поле пустое, то ничего добавляться не будет. Это будет работать только в том случае, если разрешены электронные письма о просроченных элементах курса.';
$string['pluginname'] = 'Напоминания о событиях';
$string['privacy:metadata'] = 'Плагин «Напоминания о событиях» не хранит никаких личных данных.';
$string['reminderdaysahead'] = 'Отправить до:';
$string['reminderdaysaheadcustom'] = 'Пользовательское расписание:';
$string['reminderdaysaheadcustomdetails'] = 'Дополнительно укажите желаемое расписание, чтобы заранее отправлять напоминания о событии.';
$string['reminderdaysaheadschedule'] = 'Расписание';
$string['reminderfrom'] = 'Напоминание от';
$string['reminderstask'] = 'Локальные напоминания';
$string['reminderstaskclean'] = 'Очистить журналы локальных напоминаний';
$string['rolesallowedfor'] = 'Разрешенные роли:';
$string['sendactivityreminders'] = 'Напоминания об элементе курса:';
$string['sendas'] = 'Отправить как:';
$string['sendasadmin'] = 'Как администратор сайта';
$string['sendasdescription'] = 'Укажите, кому эти письма-напоминания следует отправлять.';
$string['sendasnamedescription'] = 'Укажите отображаемое имя пользователя для писем с напоминанием, когда они отправляются от имени пользователя «Без ответа» (no reply).';
$string['sendasnametitle'] = 'Имя пользователя («Без ответа»):';
$string['sendasnoreply'] = 'Адрес электронной почты («Без ответа»)';
$string['showmodnameintitle'] = 'Показывать название модуля в теме письма';
$string['showmodnameintitledesc'] = 'Если включено, к теме письма с напоминанием будет добавлено название соответствующего модуля.';
$string['siteheading'] = 'Напоминания о событиях на сайте';
$string['taskreminder'] = 'Задача напоминания';
$string['titlesubjectprefix'] = 'Напоминание';
$string['userheading'] = 'Напоминания о событиях пользователя';
$string['useservertimezone'] = 'Использовать часовой пояс сервера';
