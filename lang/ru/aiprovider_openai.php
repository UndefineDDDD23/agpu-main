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
 * Strings for component 'aiprovider_openai', language 'ru', version '4.5'.
 *
 * @package     aiprovider_openai
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['action:generate_image:endpoint'] = 'Конечная точка API';
$string['action:generate_image:model'] = 'Модель ИИ';
$string['action:generate_image:model_desc'] = 'Модель, используемая для создания изображений на основе пользовательских подсказок.';
$string['action:generate_text:endpoint'] = 'Конечная точка API';
$string['action:generate_text:model'] = 'Модель ИИ';
$string['action:generate_text:model_desc'] = 'Модель, используемая для создания текстового ответа.';
$string['action:generate_text:systeminstruction'] = 'Системная инструкция';
$string['action:generate_text:systeminstruction_desc'] = 'Эта инструкция отправляется в модель ИИ вместе с подсказкой пользователя. Редактирование этой инструкции не рекомендуется, если только это не является абсолютно необходимым.';
$string['action:summarise_text:endpoint'] = 'Конечная точка API';
$string['action:summarise_text:model'] = 'Модель ИИ';
$string['action:summarise_text:model_desc'] = 'Модель, используемая для резюмирования предоставленного текста.';
$string['action:summarise_text:systeminstruction'] = 'Системная инструкция';
$string['action:summarise_text:systeminstruction_desc'] = 'Эта инструкция отправляется в модель ИИ вместе с подсказкой пользователя. Редактирование этой инструкции не рекомендуется, если только это не является абсолютно необходимым.';
$string['apikey'] = 'Ключ API OpenAI.';
$string['apikey_desc'] = 'Получите ключ из своих <a href="https://platform.openai.com/account/api-keys" target="_blank">ключей API OpenAI</a>.';
$string['enableglobalratelimit'] = 'Установить ограничение скорости на уровне всего сайта';
$string['enableglobalratelimit_desc'] = 'Ограничьте количество запросов, которые поставщик API OpenAI может каждый час получать со всего сайта.';
$string['enableuserratelimit'] = 'Установить ограничение скорости для пользователя';
$string['enableuserratelimit_desc'] = 'Ограничьте количество запросов, которые каждый пользователь может сделать поставщику API OpenAI за час.';
$string['globalratelimit'] = 'Максимальное количество запросов по всему сайту';
$string['globalratelimit_desc'] = 'Количество разрешенных запросов по всему сайту за час.';
$string['orgid'] = 'ID организации OpenAI';
$string['orgid_desc'] = 'Получите ID своей организации OpenAI из своей <a href="https://platform.openai.com/account/org-settings" target="_blank">учетной записи OpenAI</a>.';
$string['pluginname'] = 'Поставщик API OpenAI';
$string['privacy:metadata'] = 'Плагин «Поставщик API OpenAI» не хранит никаких персональных данных.';
$string['privacy:metadata:aiprovider_openai:externalpurpose'] = 'Эта информация отправляется в API OpenAI для создания ответа. Настройки вашей учетной записи OpenAI могут изменить способ хранения и запоминание этих данных в OpenAI.  Этим плагином никакие пользовательские данные явно не отправляются в OpenAI и не сохраняются в LMS agpu.';
$string['privacy:metadata:aiprovider_openai:model'] = 'Модель, используемая для создания ответа.';
$string['privacy:metadata:aiprovider_openai:numberimages'] = 'Количество изображений, используемых в ответе при создании изображений.';
$string['privacy:metadata:aiprovider_openai:prompttext'] = 'Введенная пользователем текстовая подсказка, используемая при создании ответа.';
$string['privacy:metadata:aiprovider_openai:responseformat'] = 'Формат ответа при создании изображений.';
$string['userratelimit'] = 'Максимальное количество запросов для пользователя';
$string['userratelimit_desc'] = 'Задайте максимально допустимое количество запросов за час для пользователя.';
