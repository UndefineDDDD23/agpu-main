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
 * Strings for component 'factor_webauthn', language 'ru', version '4.5'.
 *
 * @package     factor_webauthn
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['action:manage'] = 'Управлять ключом безопасности';
$string['action:revoke'] = 'Удалить ключ безопасности';
$string['authenticator:ble'] = 'BLE';
$string['authenticator:hybrid'] = 'Гибридный';
$string['authenticator:internal'] = 'Внутренний';
$string['authenticator:nfc'] = 'NFC';
$string['authenticator:usb'] = 'USB';
$string['authenticatorname'] = 'Имя ключа безопасности';
$string['error'] = 'Не удалось пройти аутентификацию';
$string['error:alreadyregistered'] = 'Этот секретный ключ безопасности уже зарегистрирован.';
$string['info'] = 'Использовать физический ключ безопасности или сканер отпечатков пальцев.';
$string['logindesc'] = 'Нажмите «Продолжить», чтобы использовать свой ключ безопасности.';
$string['loginoption'] = 'Использовать ключ безопасности';
$string['loginskip'] = 'У меня нет ключа безопасности';
$string['loginsubmit'] = 'Продолжить';
$string['logintitle'] = 'Подтвердите свою личность с помощью ключа безопасности';
$string['managefactor'] = 'Управление ключом безопасности';
$string['managefactorbutton'] = 'Управлять';
$string['manageinfo'] = 'Для аутентификации Вы используете «{$a}».';
$string['pluginname'] = 'Ключ безопасности';
$string['privacy:metadata'] = 'Плагин Фактор «Ключ безопасности» не хранит никаких личных данных.';
$string['register'] = 'Зарегистрировать ключ безопасности';
$string['replacefactor'] = 'Заменить ключ безопасности';
$string['replacefactorconfirmation'] = 'Заменить ключ безопасности «{$a}»?';
$string['revokefactorconfirmation'] = 'Удалить ключ безопасности «{$a}»?';
$string['settings:authenticatortypes'] = 'Типы аутентификаторов';
$string['settings:authenticatortypes_help'] = 'Переключите на надежные типы аутентификаторов';
$string['settings:userverification'] = 'Проверка пользователей';
$string['settings:userverification_help'] = 'Служит для того, чтобы убедиться, что аутентифицирующийся человек действительно является тем, кем он себя называет. Проверка пользователя может принимать различные виды, такие как пароль, PIN-код, отпечаток пальца и т. д.';
$string['setupfactor'] = 'Настройка ключа безопасности';
$string['setupfactor:instructionsregistersecuritykey'] = '2. Зарегистрируйте ключ безопасности.';
$string['setupfactor:instructionssecuritykeyname'] = '1. Дайте своему ключу имя.';
$string['setupfactor:intro'] = 'Ключ безопасности — это физическое устройство, которое вы можете использовать для аутентификации. Ключами безопасности могут быть USB-токены, устройства Bluetooth или встроенные сканеры отпечатков пальцев на вашем телефоне или компьютере.';
$string['setupfactor:securitykeyinfo'] = 'Это поможет вам определить, какой ключ безопасности вы используете.';
$string['setupfactorbutton'] = 'Настроить';
$string['summarycondition'] = 'использование аутентификатора, поддерживаемого WebAuthn';
$string['userverification:discouraged'] = 'Не использовать проверку пользователя, например, чтобы свести к минимуму взаимодействие с пользователем.';
$string['userverification:preferred'] = 'Проверка пользователя предпочтительна; аутентификация не завершится неудачей, если проверка пользователя отсутствует.';
$string['userverification:required'] = 'Проверка пользователя обязательна (например, по PIN-коду). Аутентификация не пройдена, если ключ  пользователя не прошел проверку';
