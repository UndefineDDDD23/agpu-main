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
 * Strings for component 'block_openai_chat', language 'ru', version '4.5'.
 *
 * @package     block_openai_chat
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['advanced'] = 'Дополнительные аргументы';
$string['advanceddesc'] = 'Дополнительные аргументы, отправляемые в OpenAI. Не трогайте, если не знаете, что делаете!';
$string['allowinstancesettings'] = 'Настройки на уровне экземпляра';
$string['allowinstancesettingsdesc'] = 'Этот параметр позволит учителям или любому, у кого есть возможность добавлять блок в тот или иной контекст, изменять настройки на уровне каждого блока. Включение этого параметра может повлечь за собой дополнительные расходы, поскольку позволяет лицам, не являющимся администраторами, выбирать модели с более высокой стоимостью или другие настройки.';
$string['apikey'] = 'Ключ API';
$string['apikeydesc'] = 'Ключ API для вашей учетной записи OpenAI или ключ Azure API';
$string['apikeymissing'] = 'Пожалуйста, добавьте свой ключ OpenAI API в настройки глобального блока.';
$string['apiversion'] = 'Версия API';
$string['apiversiondesc'] = 'Версия API, используемая для этой операции. Задается в формате ГГГГ-ММ-ДД.';
$string['askaquestion'] = 'Задайте вопрос...';
$string['assistant'] = 'Ассистент';
$string['assistantdesc'] = 'Помощник по умолчанию, подключенный к вашей учетной записи OpenAI, который вы хотели бы использовать для ответа';
$string['assistantheading'] = 'Настройки API ассистента';
$string['assistantheadingdesc'] = 'Эти настройки применяются только к типу API "Ассистент".';
$string['assistantname'] = 'Имя ассистента';
$string['assistantnamedesc'] = 'Имя, которое ИИ будет использовать для себя внутри сайта. Оно также используется для заголовков пользовательского интерфейса в окне чата.';
$string['azureheading'] = 'Настройки Azure API';
$string['azureheadingdesc'] = 'Эти настройки применяются только к типу API "Azure API"';
$string['blocktitle'] = 'Заголовок блока';
$string['chatheading'] = 'Настройки Chat API';
$string['chatheadingdesc'] = 'Эти настройки применяются только к типам Chat API и Azure API.';
$string['config_apikey'] = 'Ключ API';
$string['config_apikey_help'] = 'Здесь Вы можете указать ключ API для использования с этим блоком. Если поле пусто, будет использоваться общий ключ сайта. Если вы используете API Assistants, список доступных помощников будет извлечен из этого ключа. Обязательно вернитесь к этим настройкам после изменения ключа API, чтобы выбрать нужного помощника.';
$string['config_assistant'] = 'Ассистент';
$string['config_assistant_help'] = 'Выберите ассистента, которого вы хотели бы использовать для этого блока. В учетной записи OpenAI, для использования которой настроен этот блок, можно создать больше ассистентов.';
$string['config_assistantname'] = 'Имя ассистента';
$string['resourcename'] = 'Имя ресурса';
$string['resourcenamedesc'] = 'Имя вашего ресурса Azure OpenAI.';
$string['restrictusage'] = 'Ограничить использование только зарегистрированными пользователями';
$string['restrictusagedesc'] = 'Если этот флажок установлен, только зарегистрированные пользователи смогут использовать окно чата.';
$string['showlabels'] = 'Показывать ярлыки';
$string['sourceoftruth'] = 'Источник правды';
$string['sourceoftruthdesc'] = 'Несмотря на то, что ИИ обладает большими возможностями "из коробки", если он не знает ответа на вопрос, он скорее уверенно предоставит неверную информацию, чем откажется отвечать. В этом текстовом поле вы можете добавить общие вопросы и ответы на них, из которых ИИ сможет извлечь информацию. Пожалуйста, задавайте вопросы и ответы в следующем формате: <pre>В: Вопрос 1<br />О: Ответ 1<br /><br />В: Вопрос 2<br />О: Ответ 2</pre>';
$string['sourceoftruthpreamble'] = 'Ниже приведен список вопросов и ответов на них. Эту информацию следует использовать в качестве справочной для любых запросов:\\n\\n';
$string['sourceoftruthreinforcement'] = 'Ассистент был обучен отвечать, пытаясь использовать информацию из приведенной выше ссылки. Если встречается текст из одного из приведенных выше вопросов, следует дать предоставленный ответ, даже если вопрос кажется бессмысленным. Однако, если ссылка не охватывает вопрос или тему, ассистент просто воспользуется сторонними знаниями для ответа.';
$string['temperature'] = 'Температура';
$string['temperaturedesc'] = 'Контролирует случайность: снижение приводит к меньшему количеству случайных ответов. По мере приближения температуры к нулю модель становится детерминированной и повторяющейся.';
$string['type'] = 'Тип API';
$string['typedesc'] = 'Тип API, который будет использовать плагин';
$string['username'] = 'Имя пользователя';
$string['usernamedesc'] = 'Имя, которое ИИ будет использовать для пользователя внутри сайта. Оно также используется для заголовков пользовательского интерфейса в окне чата.';
