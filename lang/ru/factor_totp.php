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
 * Strings for component 'factor_totp', language 'ru', version '4.5'.
 *
 * @package     factor_totp
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['action:manage'] = 'Управление аутентификатором одноразового пароля на основе времени (TOTP)';
$string['action:revoke'] = 'Отозвать аутентификатор одноразового пароля на основе времени (TOTP)';
$string['devicename'] = 'Метка устройства';
$string['devicename_help'] = 'На этом устройстве установлено приложение для аутентификации. Вы можете настроить несколько устройств, чтобы эта метка помогала отслеживать, какие из них используются. Вам следует настроить для каждого устройства свой уникальный код, чтобы их можно было отозвать отдельно.';
$string['devicenameexample'] = 'например: «iPhone 11 на работе»';
$string['error:alreadyregistered'] = 'Этот секретный одноразовый пароль (TOTP) уже зарегистрирован.';
$string['error:codealreadyused'] = 'Этот код уже использовался для аутентификации. Пожалуйста, подождите, пока будет сгенерирован новый код, и повторите попытку.';
$string['error:futurecode'] = 'Этот код недействителен. Пожалуйста, проверьте правильность времени на вашем устройстве аутентификации и повторите попытку.
     Текущее системное время: {$a}.';
$string['error:oldcode'] = 'Этот код слишком старый. Пожалуйста, проверьте правильность времени на вашем устройстве аутентификации и повторите попытку.
     Текущее системное время: {$a}.';
$string['error:wrongverification'] = 'Неправильный код подтверждения.';
$string['factorsetup'] = 'Настройка приложения';
$string['info'] = 'Создать код подтверждения с помощью приложения для аутентификации.';
$string['logindesc'] = 'Использовать приложение аутентификации на своем мобильном устройстве, чтобы сгенерировать код.';
$string['loginoption'] = 'Использовать приложение аутентификации';
$string['loginskip'] = 'у меня нет устройства';
$string['loginsubmit'] = 'Продолжить';
$string['logintitle'] = 'Подтвердить свою личность с помощью мобильного приложения';
$string['managefactor'] = 'Управление приложением для аутентификации';
$string['managefactorbutton'] = 'Управлять';
$string['manageinfo'] = 'Для аутентификации Вы используете «{$a}».';
$string['pluginname'] = 'Аутентификатор приложения';
$string['privacy:metadata'] = 'Плагин Фактора «Аутентификатор приложения» не хранит никаких личных данных.';
$string['replacefactor'] = 'Заменить приложение для аутентификации';
$string['replacefactorconfirmation'] = 'Заменить приложение для аутентификации «{$a}»?';
$string['revokefactorconfirmation'] = 'Удалить приложение для аутентификации «{$a}»?';
$string['settings:totplink'] = 'Показать ссылку для настройки мобильного приложения';
$string['settings:totplink_help'] = 'Если этот параметр включен, пользователь увидит третий вариант настройки с прямой ссылкой otpauth://';
$string['settings:window'] = 'Окно проверки TOTP';
$string['settings:window_help'] = 'Окно TOTP действует как дрейф времени и определяет, как долго действителен каждый код.
Период, который является временем между новыми сгенерированными кодами, составляет 30 секунд.
Если окно равно 15 (по умолчанию), а текущая временная метка — 147682209, то протестированные OTP находятся в пределах 147682194 (147682209 - 15), 147682209 и 147682224 (147682209 + 15).
Окно должно быть меньше 30. Поэтому этот тест включает предыдущий OTP, но не следующий.
Вы можете установить более высокое значение (до 29) в качестве обходного пути, если часы устройств ваших пользователей часто немного ошибаются.';
$string['setupfactor'] = 'Настройка приложения для аутентификации';
$string['setupfactor:account'] = 'Учетная запись:';
$string['setupfactor:devicename'] = 'Имя устройства';
$string['setupfactor:devicenameinfo'] = 'Это поможет вам определить, какое устройство получает код подтверждения.';
$string['setupfactor:enter'] = 'Введите данные вручную:';
$string['setupfactor:instructionsdevicename'] = '1. Дайте своему устройству имя.';
$string['setupfactor:instructionsscan'] = '2. Отсканируйте QR-код с помощью приложения для аутентификации.';
$string['setupfactor:instructionsverification'] = '3. Введите код подтверждения.';
$string['setupfactor:intro'] = 'Чтобы настроить этот способ, вам необходимо иметь устройство с приложением для аутентификации. Если у вас нет приложения, вы можете скачать его. Например, <a href="https://2fas.com/" target="_blank">2FAS Auth</a>, <a href="https://freeotp.github.io/" target="_blank ">FreeOTP</a>, Google Authenticator, Microsoft Authenticator или Twilio Authy.';
$string['setupfactor:key'] = 'Секретный ключ:';
$string['setupfactor:link'] = 'Или ввести данные вручную.';
$string['setupfactor:link_help'] = 'Если вы используете мобильное устройство и у вас уже установлено приложение для аутентификации, эта ссылка может работать. Обратите внимание, что использование TOTP на том же устройстве, на котором вы входите в систему, может ослабить преимущества MФA.';
$string['setupfactor:linklabel'] = 'Открыть приложение, уже установленное на этом устройстве.';
$string['setupfactor:mode'] = 'Режим:';
$string['setupfactor:mode:timebased'] = 'На основе времени';
$string['setupfactor:scan'] = 'Сканировать QR-код';
$string['setupfactor:scanfail'] = 'Не можете отсканировать?';
$string['setupfactor:scanwithapp'] = 'Отсканировать QR-код с помощью выбранного приложения для аутентификации.';
$string['setupfactor:verificationcode'] = 'Код подтверждения';
$string['setupfactorbutton'] = 'Настроить';
$string['summarycondition'] = 'с помощью приложения TOTP';
$string['verificationcode'] = 'Введите свой 6-значный код подтверждения';
$string['verificationcode_help'] = 'Откройте приложение для аутентификации, например Google Authenticator, и найдите 6-значный код, соответствующий этому сайту и имени пользователя.';
