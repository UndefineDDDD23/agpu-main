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
 * Strings for component 'message_airnotifier', language 'ru', version '4.5'.
 *
 * @package     message_airnotifier
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['airnotifier:managedevice'] = 'Управлять устройствами';
$string['airnotifieraccesskey'] = 'Ключ доступа к Airnotifier';
$string['airnotifierappname'] = 'Название приложения Airnotifier';
$string['airnotifierfielderror'] = 'Удалите все пустые пробелы или ненужные символы из следующего поля: {$a}';
$string['airnotifiermobileappname'] = 'Название мобильного приложения';
$string['airnotifierport'] = 'Порт Airnotifier';
$string['airnotifierurl'] = 'URL-адрес Airnotifier';
$string['checkconfiguration'] = 'Проверить и протестировать конфигурацию уведомлений';
$string['configairnotifieraccesskey'] = 'Ключ доступа для подключения к серверу Airnotifier. Вы можете получить ключ доступа, щелкнув ниже ссылку «Запросить ключ доступа»  (только для зарегистрированных сайтов) или создав учетную запись на <a href="https://apps.agpu.com"> Портале приложений agpu </a >.';
$string['configairnotifierappname'] = 'Идентификатор имени приложения в Airnotifier.';
$string['configairnotifiermobileappname'] = 'Уникальный идентификатор Мобильного приложения  (напр. com.agpu.agpumobile).';
$string['configairnotifierport'] = 'Порт для подключения к серверу airnotifier.';
$string['configairnotifierurl'] = 'URL-адрес сервера для подключения к отправке уведомления.';
$string['configured'] = 'Настроено';
$string['deletecheckdevicename'] = 'Удаление устройства: {$a->name}';
$string['deletedevice'] = 'Устройство удалено. Обратите внимание, что приложение может зарегистрировать устройство еще раз. Если устройство продолжает появляться - отключите его.';
$string['devicetoken'] = 'Токен устройства';
$string['donotsendnotification'] = 'Вообще не отправлять уведомления';
$string['enableprocessor'] = 'Включить мобильные уведомления';
$string['encryptnotifications'] = 'Шифровать уведомления';
$string['encryptnotifications_help'] = 'Включите сквозное шифрование уведомлений приложений. Некоторые данные могут быть удалены из уведомлений, если они не могут быть зашифрованы.';
$string['encryptprocessing'] = 'Для устройств, не поддерживающих шифрование';
$string['encryptprocessing_desc'] = 'Для шифрования уведомлений требуется как минимум Android 8 или iOS 13 и приложение agpu 4.2 или более поздней версии.';
$string['errorretrievingkey'] = 'Ошибка при получении ключа доступа. Ваш сайт должен быть зарегистрирован, чтобы пользоваться этой услугой. Если ваш сайт уже зарегистрирован, попробуйте обновить регистрацию. Кроме того, вы можете получить ключ доступа, создав учетную запись на <a href="https://apps.agpu.com"> Портале приложений agpu </a>.';
$string['keyretrievedsuccessfully'] = 'Ключ доступа успешно получен. Чтобы получить доступ к статистике использования приложения agpu, создайте учетную запись на <a href="https://apps.agpu.com"> Портале приложений agpu </a>.';
$string['messageprovidersempty'] = 'В настройках уведомлений по умолчанию нет мобильных уведомлений.';
$string['messageproviderslow'] = 'В настройках уведомлений по умолчанию включены только несколько мобильных уведомлений.';
$string['agpuappsportallimitswarning'] = 'Обратите внимание, что количество пользовательских устройств, которым разрешено получать уведомления, зависит от вашей подписки на приложение agpu. Для получения дополнительной информации посетите <a href="{$a}" target="_blank"> Портал приложений agpu </a>.';
$string['nodevices'] = 'Нет зарегистрированных устройств. Устройства будут автоматически появляться после того, как Вы установите приложение agpu Mobile и добавите этот сайт.';
$string['noemailevernotset'] = '$CFG->noemailever запрещен';
$string['noemaileverset'] = '$CFG->noemailever включен в config.php. Вам необходимо установить значение false или удалить этот параметр.';
$string['nopermissiontomanagedevices'] = 'Вы не имеете разрешения на управление устройствами.';
$string['notconfigured'] = 'Сервер Airnotifier не был настроен - сообщения Airnotifier не могут быть отправлены';
$string['notificationsserverconfiguration'] = 'Конфигурация сервера уведомлений (Airnotifier)';
$string['pluginname'] = 'Мобильные уведомления';
$string['privacy:appiddescription'] = 'Это идентификатор используемого приложения.';
$string['privacy:enableddescription'] = 'Если это устройство включено для уведомителя.';
$string['privacy:metadata:date'] = 'Дата отправки сообщения.';
$string['privacy:metadata:enabled'] = 'Включено ли устройство уведомителя.';
$string['privacy:metadata:externalpurpose'] = 'Эта информация отправляется на внешний сайт, чтобы в конечном итоге быть доставленной на мобильное устройство пользователя.';
$string['privacy:metadata:fullmessage'] = 'Полное сообщение.';
$string['privacy:metadata:notification'] = 'Если это сообщение является уведомлением.';
$string['privacy:metadata:smallmessage'] = 'Раздел сообщения.';
$string['privacy:metadata:subject'] = 'Тема сообщения.';
$string['privacy:metadata:tableexplanation'] = 'Здесь хранится информация об устройстве уведомителя.';
$string['privacy:metadata:userdeviceid'] = 'Идентификатор, связанный с мобильным устройством пользователя.';
$string['privacy:metadata:userfromfullname'] = 'Полное имя пользователя, отправившего сообщение.';
$string['privacy:metadata:userfromid'] = 'ID пользователя - автора сообщения.';
$string['privacy:metadata:userid'] = 'ID пользователя, отправившего сообщение.';
$string['privacy:metadata:username'] = 'Логин пользователя.';
$string['privacy:metadata:usersubsystem'] = 'Этот плагин подключен к пользовательской подсистеме.';
$string['privacy:subcontext'] = 'Сообщения Airnotifier';
$string['requestaccesskey'] = 'Запрос ключа доступа';
$string['sendnotificationnotenc'] = 'Отправлять уведомления без шифрования';
$string['sendtest'] = 'Отправить тестовое push-уведомление на мои устройства';
$string['sendtestconfirmation'] = 'На устройства, которые вы используете для подключения к этому сайту, будет отправлено тестовое push-уведомление. Убедитесь, что ваши устройства подключены к Интернету и мобильное приложение не открыто (поскольку push-уведомления отображаются только при получении в фоновом режиме).';
$string['serverconnectivityerror'] = 'Этот сайт не может подключиться к серверу уведомлений {$a}';
$string['showhide'] = 'Включить/отключить устройство.';
$string['sitemustberegistered'] = 'Для использования общественного Airnotifier ваш сайт должен быть зарегистрирован. Кроме того, вы можете получить ключ доступа, создав учетную запись на <a href="https://apps.agpu.com"> Портале приложений agpu </a>.';
$string['unknowndevice'] = 'Неизвестное устройство';
$string['userdevices'] = 'Пользовательские устройства';
$string['view_notification'] = 'Нажмите для просмотра';
