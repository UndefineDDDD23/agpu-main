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
 * Strings for component 'atto_styles', language 'ru', version '4.5'.
 *
 * @package     atto_styles
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['config'] = 'Конфигурация';
$string['config_desc'] = 'Настройка виджета стилей для Atto в формате JSON. <br /> Вы можете найти хороший пример в README.md в разделе <a href="https://github.com/agpuuulm/agpu-atto_styles/blob/master/README.md#usage--settings">"Usage & Settings"</a>.
<hr />
Например:<br />
{$a->code_example}
<hr />
Атрибут <em>title</em> (заголовок) определяет название стиля в виджете Atto styles.<br />
<br />
Заголовок также может поддерживать фильтр agpu multilang (если он включен), но дополнительные двойные кавычки придется экранировать обратной косой чертой.<br />
Пожалуйста, взгляните на файл README плагина для примера.<br />
<hr />
Атрибут <em>type</em> может содержать одно из двух значений: "block" или "inline".<br />
<br />
"block" создаст тег div с заданным классом (классами) и будет действовать как стандартный блочный элемент. Эта настройка изменит текущий блочный элемент и может применяться не только к выделенному в данный момент тексту.<br />
<br />
"inline" создаст тег span с заданным классом (классами) и будет действовать как стандартный строчный элемент. Это будет применяться только к текущему выделенному тексту.
<hr />
В атрибуте <em>classes</em> указывается имя класса CSS, которое будет применено к блоку / строчному элементу.<br />
<br />
Для каждого элемента может быть определено несколько классов, разделенных пробелом. Все они будут применены к блочному / строчному элементу.<br />
<br />
В этом плагине нельзя создать определения классов CSS. Вам нужно будет добавить определения классов CSS в свою тему или в дополнительные настройки HTML agpu.
<hr />
Атрибут <em>preview</em> (предварительный просмотр) принимает логические значения true или false (по умолчанию). Если установлено true, то настройки стиля применяются и к самому названию стиля в меню выбора стиля. В противном случае элемент стиля будет просто отображать свой заголовок в виде обычного текста.<br />
<br />
Если вы решите показывать предварительный просмотр элемента стиля, этот класс должен быть определен в CSS таким образом, чтобы его можно было применять к тегам span, даже если сам элемент стиля является элементом уровня блока.
<hr />
В установках agpu с темами на основе bootstrap (особенно <em>Boost</em>) вы также можете создавать стили с помощью классов bootstrap CSS вместо определения собственных классов.
<br /><br />
Например:<br />
{$a->code_example_bootstrap}
<br/><br/>
Дополнительная информация о классах начальной загрузки доступна по ссылкам в документации Bootstrap 4:
<ul>
<li><a href="https://getbootstrap.com/docs/4.3/components/badge/">Bootstrap badges</a></li>
<li><a href="https://getbootstrap.com/docs/4.3/components/alerts/">Bootstrap alerts</a></li>
<li><a href="https://getbootstrap.com/docs/4.3/utilities/">Bootstrap utilities</a></li>
</ul>
<hr />
Обратите внимание, что несколько определений должны быть заключены в квадратные скобки.
<br /><br />
Пример:<br />
{$a->code_example_bootstrap_multiple}';
$string['inlinehint'] = 'Для применения этого стиля сначала выделите текст.';
$string['jsondecodemessage'] = 'Введен недопустимый код JSON.';
$string['nostyle'] = 'Без стиля';
$string['pluginname'] = 'Стили';
$string['settings'] = 'Настройки стилей';
