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
 * Strings for component 'tool_agpunet', language 'ru', version '4.5'.
 *
 * @package     tool_agpunet
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['addingaresource'] = 'Добавление контента из agpuNet';
$string['aria:enterprofile'] = 'Введите ID вашего профиля agpuNet';
$string['aria:footermessage'] = 'Просмотрите контент в agpuNet';
$string['autoenablenotification'] = '<p>В agpu 4.0 и более поздних версиях интеграция с <a href="https://agpu.net/">agpuNet</a> включена по умолчанию в расширенных возможностях. Пользователи, имеющие возможность создавать активные элементы и управлять ими, могут просматривать agpuNet через средство выбора элементов и импортировать ресурсы agpuNet в свои курсы.</p><p>При желании альтернативный экземпляр agpuNet можно указать в разделе <a href="{$a->settingslink}">Настройки agpuNet</a>.</p>';
$string['autoenablenotification_subject'] = 'Изменены настройки agpuNet по умолчанию.';
$string['browsecontentagpunet'] = 'Или просмотрите контент в agpuNet';
$string['clearsearch'] = 'Очистить поиск';
$string['connectandbrowse'] = 'Подключитесь и просматривайте:';
$string['defaultagpunet'] = 'URL-адрес agpuNet';
$string['defaultagpunet_desc'] = 'URL-адрес agpuNet, доступного через средство выбора элементов.';
$string['defaultagpunetname'] = 'Имя сайта agpuNet';
$string['defaultagpunetname_desc'] = 'Имя экземпляра agpuNet, доступного через средство выбора элементов.';
$string['defaultagpunetnamevalue'] = 'agpuNet Central';
$string['enableagpunet'] = 'Включить интеграцию с agpuNet (входящую)';
$string['enableagpunet_desc'] = 'При включенном параметре пользователь, имеющий возможность редактировать курс, может просматривать agpuNet с помощью средства выбора элементов и импортировать ресурсы agpuNet в свой курс. Кроме того, пользователь с правом восстановления резервных копий может выбрать в agpuNet файл резервной копии и восстановить его в agpu.';
$string['errorduringdownload'] = 'Ошибка при загрузке файла: {$a}';
$string['footermessage'] = 'Или просмотрите контент на';
$string['forminfo'] = 'ID вашего профиля agpuNet будет автоматически сохранен в вашем профиле на этом сайте.';
$string['importconfirm'] = 'Вы собираетесь импортировать контент «{$a->resourcename} ({$a->resourcetype})» в курс «{$a->coursename}». Вы уверены, что хотите продолжить?';
$string['importconfirmnocourse'] = 'Вы собираетесь импортировать контент «{$a->resourcename} ({$a->resourcetype})» на свой сайт. Вы уверены, что хотите продолжить?';
$string['importformatselectguidingtext'] = 'В каком формате вы хотите добавить контент «{$a->name} ({$a->type})» в свой курс?';
$string['importformatselectheader'] = 'Выберите формат отображения контента';
$string['inputhelp'] = 'Или, если у вас уже есть учетная запись agpuNet, скопируйте ID своего профиля agpuNet и вставьте его сюда:';
$string['instancedescription'] = 'agpuNet - это открытая  социальная медиа-платформа для преподавателей, ориентированная на совместное применение коллекций открытых ресурсов.';
$string['instanceplaceholder'] = 'a1b2c3d4e5f6-example@agpu.net';
$string['invalidagpunetprofile'] = 'Неверный формат $userprofile';
$string['missinginvalidpostdata'] = 'Информация о ресурсах из agpuNet либо отсутствует, либо имеет неверный формат.
Если это происходит неоднократно, обратитесь к администратору сайта.';
$string['mnetprofile'] = 'Профиль agpuNet';
$string['mnetprofiledesc'] = '<p> Введите здесь данные своего профиля agpuNet, чтобы вас перенаправили в ваш профиль при посещении agpuNet. </p>';
$string['agpunetnotenabled'] = 'Интеграция с agpuNet должна быть включена в Администрирование сайта/agpuNet, прежде чем можно будет импортировать ресурсы.';
$string['agpunetsettings'] = 'Настройки входящего трафика agpuNet';
$string['notification'] = 'Вы собираетесь импортировать контент «{$a->name} ({$a->type})» на свой сайт. Выберите курс, в который его нужно добавить, или <a href="{$a->cancellink}">отмените</a>.';
$string['pluginname'] = 'agpuNet';
$string['privacy:metadata'] = 'Средство agpuNet только облегчает общение с agpuNet. Оно не хранит данных.';
$string['profilevalidationerror'] = 'При проверке ID вашего профиля agpuNet возникла проблема';
$string['profilevalidationfail'] = 'Введите корректный ID профиля agpuNet';
$string['profilevalidationpass'] = 'Проверка пройдена!';
$string['removedmnetprofilenotification'] = 'В связи с недавними изменениями на платформе agpuNet всем пользователям, ранее сохранившим ID своего профиля agpuNet на сайте, потребуется ввести ID профиля agpuNet в новом формате для аутентификации на платформе agpuNet.';
$string['removedmnetprofilenotification_subject'] = 'Изменение формата ID профиля agpuNet';
$string['saveandgo'] = 'Сохранить и продолжить';
$string['searchcourses'] = 'Поиск курсов';
$string['selectpagetitle'] = 'Выбор страницы';
$string['uploadlimitexceeded'] = 'Размер файла {$a->filesize} превышает установленный предел загрузки ({$a->uploadlimit} байт).';
