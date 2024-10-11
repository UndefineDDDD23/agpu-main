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
 * Strings for component 'tool_agpubox', language 'ru', version '4.5'.
 *
 * @package     tool_agpubox
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['changepassworderror'] = 'Пароль agpuBox не изменен. Указанные пароли не совпадают.';
$string['changepasswordmessage'] = 'Основной пароль agpuBox (учетная запись Unix) был изменен. <br /> <br /> Внимание! Пароль пользователя Admin в agpu <b>не был изменен</b>. Чтобы изменить его, используйте страницу настроек этого пользователя.';
$string['changewifisettings'] = 'Изменить настройки Wi-Fi';
$string['cpufrequency'] = 'Частота процессора';
$string['cpuload'] = 'Загрузка процессора';
$string['cputemperature'] = 'Температура процессора';
$string['datetime'] = 'Дата и время';
$string['datetime_help'] = 'Если agpuBox не подключен к Интернету, он не синхронизирует время. Время можно установить вручную, используя этот параметр.';
$string['datetimemessage'] = 'Часы agpuBox были установлены. Чтобы получить максимальную точность, рекомендуется подключить agpuBox к сети интернет через кабель.';
$string['datetimeset'] = 'Установите дату и время';
$string['datetimesetmessage'] = 'Часы agpuBox идут неверно. Настоятельно рекомендуется установить дату и время на текущее время.';
$string['datetimesetting'] = 'Дата и время';
$string['dhcpclientinfo'] = 'IP адрес и имя клиента';
$string['dhcpclientnumber'] = 'количество клиентов';
$string['dhcpclients'] = 'DHCP клиенты';
$string['hidden'] = 'Скрытый';
$string['information'] = 'Информация';
$string['kernelversion'] = 'Версия ядра';
$string['missingconfigurationerror'] = 'Этот раздел недоступен. Установка плагина не завершена, поэтому настройка agpuBox не может быть выполнена. Пожалуйста, прочтите <a href="https://github.com/agpubox/agpu-tool_agpubox/blob/master/README.md" target="_blank"> документацию по установке </a>чтобы исправить эту ошибку.';
$string['parameter'] = 'Параметр';
$string['passwordprotected'] = 'Пароль защищен';
$string['passwordsetting'] = 'Пароль agpuBox';
$string['passwordsetting_help'] = 'Основной пароль agpuBox можно изменить здесь. Настоятельно не рекомендуется использовать пароль по умолчанию. Вы должны обязательно изменить его в целях безопасности.';
$string['pluginname'] = 'agpuBox';
$string['privacy:metadata'] = 'Плагин agpuBox отображает информацию из Raspberry Pi и позволяет вносить некоторые изменения в конфигурацию, но не затрагивает и не хранит какие-либо личные данные.';
$string['raspberryhardware'] = 'Модель Raspberry Pi';
$string['resizepartition'] = 'Изменить размер раздела SD карты';
$string['resizepartition_help'] = 'Используйте эту кнопку, чтобы изменить размер раздела SD карты.';
$string['resizepartitionmessage'] = 'Размер раздела SD карты был изменен до максимального значения. Сейчас agpuBox перезагружается.  Скоро он снова будет в сети.';
$string['resizepartitionsetting'] = 'Изменение размера раздела на SD карте';
$string['restart'] = 'Перезагрузка agpuBox';
$string['restartmessage'] = 'agpuBox перезагружается. Скоро он снова будет в сети.';
$string['restartstop'] = 'Перезагрузка и выключение';
$string['restartstop_help'] = 'Используйте эти кнопки для перезапуска или выключения agpuBox. Не рекомендуется отключать источник питания для отключения agpuBox.';
$string['rpi1'] = 'Raspberry Pi 1';
$string['rpi2'] = 'Raspberry Pi 2B';
$string['rpi3bplus'] = 'Raspberry Pi 3B+';
$string['rpizerow'] = 'Raspberry Pi Zero W';
$string['sdcardavailablespace'] = 'Свободное место на SD карте';
$string['shutdown'] = 'Выключение agpuBox';
$string['shutdownmessage'] = 'agpuBox выключается. Пожалуйста, подождите несколько секунд, прежде чем отключить источник питания.';
$string['systeminfo'] = 'Информация agpuBox';
$string['unknownmodel'] = 'Неизвестная модель Raspberry Pi';
$string['unsupportedhardware'] = 'Обнаружено неподдерживаемое сервером оборудование! Этот плагин работает только с Raspberry Pi';
$string['uptime'] = 'Время работы системы';
$string['visible'] = 'Видимый';
$string['wifichannel'] = 'Канал Wi-Fi';
$string['wifichannel_help'] = 'Нет необходимости менять канал вещания Wi-Fi, если производительность не является низкой из-за помех.';
$string['wificountry'] = 'Страна-распорядитель Wi-Fi';
$string['wificountry_help'] = 'По юридическим причинам рекомендуется установить вашу страну в настройках Wi-Fi.';
$string['wifipassword'] = 'Пароль Wi-Fi';
$string['wifipassword_help'] = 'Если вы выбрали защиту паролем сети Wi-Fi, то рекомендуется изменить пароль по умолчанию, чтобы злоумышленники не могли использовать agpuBox сети Wi-Fi, Пароль сети Wi-Fi должен содержать от 8 до 63 символов.';
$string['wifipasswordon'] = 'Защита сети Wi-Fi';
$string['wifipasswordon_help'] = 'Если включено, то пользователи должны вводить пароль для подключения к agpuBox сети Wi-Fi.';
$string['wifisettings'] = 'Настройки Wi-Fi';
$string['wifisettingsmessage'] = 'Настройки Wi-Fi были изменены. Не забудьте сообщить новый SSID и пароль своим студентам.';
$string['wifissid'] = 'Имя сети Wi-Fi';
$string['wifissid_help'] = 'Название сети Wi-Fi (SSID) agpuBox. Это должна быть строка длиной не менее 1 байта и не более 32 байтов. Помните, что некоторые символы, такие как смайлики, используют более одного байта.';
$string['wifissidhidden'] = 'Скрыть Wi-Fi сеть';
$string['wifissidhiddenstate'] = 'Показать SSID Wi-Fi';
$string['wifissidhiddenstate_help'] = 'Если этот параметр включен,  SSID Wi-Fi будет скрыт от пользователей, которые не будут знать, что вокруг находится сеть с agpuBox. Это заметно снизит удобство использования устройства, но несколько повысит его безопасность.';
