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
 * Strings for component 'coursecertificate', language 'ru', version '4.5'.
 *
 * @package     coursecertificate
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['activityhiddenwarning'] = 'Этот элемент курса на данный момент скрыт. Если вы включите его отображение, студенты, соответствующие требованиям доступа автоматически получат PDF-версию сертификата.';
$string['archivecertificates'] = 'Архивировать выданные сертификаты';
$string['archivecertificates_help'] = 'Архивированные сертификаты все еще могут быть проверены и по-прежнему отображаются на странице профиля пользователя. Однако, когда существующий сертификат курса архивируется, пользователю может быть выдан новый сертификат, как только он выполнит условия для его получения.';
$string['automaticsend_helptitle'] = 'Помощь с автоматической отправкой';
$string['automaticsenddisabled'] = 'Автоматическая отправка сертификатов выключена.';
$string['automaticsenddisabled_help'] = 'Если оставить параметр выключенным, студенты будут должны переходить по ссылке «Сертификат» на странице курса , чтобы получить сертификат, как только они будут соответствовать требованиям доступа.<br/><br/>
При включенном параметре студенты будут получать PDF-версию сертификата автоматически, как только они будут соответствовать требованиям доступа. Обратите внимание, что все такие студенты получат сертификат, как только вы включите этот параметр.';
$string['automaticsenddisabledalert'] = 'Студенты, которые соответствуют требованиям доступа получат сертификат сразу после перехода к этому элементу курса.';
$string['automaticsendenabled'] = 'Автоматическая отправка сертификатов включена.';
$string['automaticsendenabled_help'] = 'Если оставить параметр включённым, студенты будут автоматически получать PDF-версию сертификата, как только они будут соответствовать требованиям доступа.<br/><br/>
Если выключить параметр, студенты на странице курса должны будут  переходить по ссылке к этому элементу, чтобы получить сертификат, как только они будут соответствовать требованиям доступа.';
$string['certificateissues'] = 'Выдачи сертификатов';
$string['certificatesarchived'] = 'Сертификаты архивированы';
$string['certifiedusers'] = 'Пользователи, получившие сертификат';
$string['chooseatemplate'] = 'Выберите шаблон...';
$string['code'] = 'Код';
$string['coursecertificate:addinstance'] = 'Добавлять новый элемент «Сертификат курса»';
$string['coursecertificate:receive'] = 'Получать выданные сертификаты';
$string['coursecertificate:view'] = 'Смотреть сертификаты курса';
$string['coursecertificate:viewreport'] = 'Смотреть отчёт о выданных сертификатах курса';
$string['coursecompletiondate'] = 'Дата выполнения';
$string['courseinternalid'] = 'Внутренний ID курса, используемый в URL-ах';
$string['courseurl'] = 'URL курса';
$string['disableautomaticsend'] = 'Студенты больше не будут автоматически получать PDF-версию сертификата при условии соответствия требованиям доступа. Вместо этого они будут должны нажать на ссылку «Сертификат» на странице курса, чтобы получить сертификат, как только они будут соответствовать требованиям доступа.';
$string['enableautomaticsendpopup'] = 'Все студенты автоматически получат PDF-версию сертификата, как только они будут соответствовать требованиям доступа к этому элементу курса.<br/><br/>
Студенты, которые соответствуют этим требованиям, но ещё не получали сертификат, также получат его автоматически.<br/><br/>
Студенты, уже получившие сертификат, повторно его не получат.';
$string['expirydate'] = 'Дата окончания';
$string['filterswarning'] = 'Фильтры, определенные в контексте элемента курса, используются только для заголовка и описания элемента.';
$string['filterswarninglist'] = 'При создании PDF-файлов сертификатов будут использоваться только фильтры "{$a->list}" и только в том случае, если они включены на <a href="{$a->link}">уровне курса</a>.';
$string['filterswarningnone'] = 'При создании PDF-файлов сертификатов фильтры использоваться не будут.';
$string['issueddate'] = 'Дата выдачи';
$string['managetemplates'] = 'Управление шаблонами сертификатов';
$string['modulename'] = 'Сертификат курса';
$string['modulename_help'] = 'Модуль «Сертификаты курса» предоставляет возможность  отмечать новые достижения обучающихся выдачей сертификата.<br/><br/> Он позволяет вам выбирать из нескольких шаблонов сертификат, в котором будут автоматически отображаться пользовательские данные (например: полное имя, пройденный курс и так далее).<br/><br/> Пользователи могут самостоятельно скачать PDF-версию сертификата через этот элемент курса, а также есть возможность автоматически высылать копию на email. <br/><br/>Если в шаблоне будет содержаться QR-код, то можно отсканировать его и проверить действительность сертификата.';
$string['modulename_link'] = 'mod/certificate/view';
$string['modulenameplural'] = 'Сертификаты курса';
$string['notemplateselected'] = 'Выбранный вами шаблон не может быть найден. Пожалуйста, перейдите к настройкам элемента и выберите новый.';
$string['notemplateselecteduser'] = 'Сертификат более недоступен. Пожалуйста, обратитесь к учителю курса.';
$string['notemplateswarning'] = 'Нет доступных шаблонов. Пожалуйста, обратитесь к администратрору сайта.';
$string['notemplateswarningwithlink'] = 'Нет доступных шаблонов. Пожалуйста, создайте новый на <a href="{$a}">странице управления шаблонами сертификатов</a>.';
$string['nouserscertified'] = 'Никто не получил сертификат.';
$string['open'] = 'Открыть';
$string['page-mod-coursecertificate-x'] = 'Страница модуля любого сертификата курса';
$string['pluginadministration'] = 'Администрирование сертификатов курса';
$string['pluginname'] = 'Сертификат курса';
$string['previewcoursefullname'] = 'Полное название курса';
$string['previewcourseshortname'] = 'Краткое название курса';
$string['privacy:metadata'] = 'Элемент «Сертификаты курса» не хранит персональные данные';
$string['revoke'] = 'Аннулировать';
$string['revokeissue'] = 'Вы действительно хотите аннулировать сертификат этого пользователя?';
$string['selectdate'] = 'Выберите дату';
$string['selecttemplatewarning'] = 'Как только будет выдан хоть один сертификат, это поле будет заблокировано и его будет нельзя редактировать.';
$string['status'] = 'Статус';
$string['taskissuecertificates'] = 'Выпуск сертификатов курса';
$string['template'] = 'Шаблон';
