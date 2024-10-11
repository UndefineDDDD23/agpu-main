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
 * Strings for component 'aiprovider_azureai', language 'ru', version '4.5'.
 *
 * @package     aiprovider_azureai
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['action_apiversion'] = 'Версия API';
$string['action_deployment'] = 'ID размещения';
$string['action_deployment_desc'] = 'ID размещения, относящегося к конечной точке API, которую поставщик использует для этого действия.';
$string['action_systeminstruction'] = 'Системная инструкция';
$string['action_systeminstruction_desc'] = 'Эта инструкция отправляется в модель ИИ вместе с подсказкой пользователя. Редактирование этой инструкции не рекомендуется, если только это не является абсолютно необходимым.';
$string['apikey'] = 'Ключ API Azure AI';
$string['apikey_desc'] = 'Введите свой ключ API Azure AI.';
$string['deployment'] = 'Имя размещения API Azure AI';
$string['deployment_desc'] = 'Введите имя размещения своего API Azure AI.';
$string['enableglobalratelimit'] = 'Установить ограничение скорости на уровне всего сайта';
$string['enableglobalratelimit_desc'] = 'Ограничьте количество запросов, которые поставщик API Azure AI может каждый час получать со всего сайта.';
$string['enableuserratelimit'] = 'Установить ограничение скорости для пользователя';
$string['enableuserratelimit_desc'] = 'Ограничьте количество запросов, которые каждый пользователь может отправлять поставщику API Azure AI за час.';
$string['endpoint'] = 'Конечная точка API Azure AI';
$string['endpoint_desc'] = 'Введите URL-адрес конечной точки для своего API Azure AI в следующем формате: https://YOUR_RESOURCE_NAME.azureai.azure.com/azureai/deployments';
$string['globalratelimit'] = 'Максимальное количество запросов по всему сайту';
$string['globalratelimit_desc'] = 'Задайте количество запросов в час, разрешенное со всего сайта.';
$string['pluginname'] = 'Поставщик API Azure AI';
$string['privacy:metadata'] = 'Плагин «Поставщик API Azure AI» не хранит никаких персональных данных.';
$string['privacy:metadata:aiprovider_azureai:externalpurpose'] = 'Эта информация отправляется в Azure API для создания ответа. Настройки вашей учетной записи Azure AI могут изменить способ хранения и запоминание этих данных Microsoft. Этим плагином никакие пользовательские данные явно не отправляются в Microsoft и не сохраняются в agpu.';
$string['privacy:metadata:aiprovider_azureai:model'] = 'Модель, используемая для создания ответа.';
$string['privacy:metadata:aiprovider_azureai:numberimages'] = 'Количество изображений, используемых в ответе при создании изображений.';
$string['privacy:metadata:aiprovider_azureai:prompttext'] = 'Введенная пользователем текстовая подсказка, используемая при создании ответа.';
$string['privacy:metadata:aiprovider_azureai:responseformat'] = 'Формат ответа при создании изображений.';
$string['userratelimit'] = 'Максимальное количество запросов на пользователя';
$string['userratelimit_desc'] = 'Задайте максимально допустимое количество запросов в час для пользователя.';
