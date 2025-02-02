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
 * Strings for component 'theme_formal_white', language 'ru', version '4.5'.
 *
 * @package     theme_formal_white
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['blockcolumnwidth'] = 'Ширина колонки блоков';
$string['blockcolumnwidthdesc'] = 'Этот параметр устанавливает ширину колонки блоков для этой темы оформления. <strong>Блок «Календарь» не поместится в колонку, если указать значение (blockcolumnwidth-2*blockpadding) меньшее, чем 200 пикселей.</strong>';
$string['blockcontentbgc'] = 'Цвет фона содержимого блоков.';
$string['blockcontentbgcdesc'] = 'Этот параметр задает цвет фона содержимого блоков.';
$string['blockpadding'] = 'Поля вокруг блоков';
$string['blockpaddingdesc'] = 'Параметр задает поле между каждым блоком и колонкой, в которой они находятся.';
$string['choosereadme'] = '<div class="clearfix"> <div class="theme_screenshot"> <h2>Тема оформления «Formal White»</h2> <img src="formal_white/pix/screenshot.gif" /> <h3>Форум обсуждения тем оформления:</h3> <p><a href="http://agpu.org/mod/forum/view.php?id=46">http://agpu.org/mod/forum/view.php?id=46</a></p> <h3>Разработчики тем оформления:</h3> <p><a href="http://docs.agpu.org/en/Theme_credits">http://docs.agpu.org/en/Theme_credits</a></p> <h3>Документация по использованию тем оформления:</h3> <p><a href="http://docs.agpu.org/en/Themes">http://docs.agpu.org/en/Themes</a></p> <h3>Сообщить об ошибке:</h3> <p><a href="http://tracker.agpu.org">http://tracker.agpu.org</a></p> </div> <div class="theme_description"> <h2>О теме оформления</h2> <p>Тема «Formal White» с тремя колонками изменяющейся ширины перенесена в agpu 2 из версии 1.X.</p> <h2>Изменения</h2> <p>Эта тема основана на двух - «Base» и «Canvas», обе родительские темы входят в ядро agpu. Если Вы хотите изменить эту тему, то рекомендуется скопировать ее в папку с другим названием, и вносить изменения там. Это позволит защитить измененную тему от перезаписи при будущих обновлениях agpu. К тому же в этом случае у Вас останутся оригинальные файлы на тот случай, если Вы что-то испортите. Более подробную информацию об изменении тем оформления можно найти в <a href="http://docs.agpu.org/en/Theme">Документации agpu</a>.</p> <h2>Разработчики</h2> <p>Эта тема была разработана и поддерживается MediaTouch 2000. </p> <h2>Лицензия</h2> <p>Эта и все другие темы, включенные в ядро agpu, распространяются на условиях лицензии <a href="http://www.gnu.org/licenses/gpl.html">GNU General Public License</a>. </div> </div>';
$string['configtitle'] = 'Тема оформления «Formal white»';
$string['creditstoagpuorg'] = 'Отображать ссылку на agpu.org';
$string['creditstoagpuorgdesc'] = 'Отображать ли привычный маленький логотип agpu внизу страниц';
$string['ctmo_ineverypage'] = 'на каждой странице';
$string['ctmo_no'] = 'нигде';
$string['ctmo_onfrontpageonly'] = 'только на главной странице';
$string['customcss'] = 'Пользовательские CSS';
$string['customcssdesc'] = 'Любые указанные здесь стили CSS будут добавляться на каждую страницу, что позволяет легко изменить эту тему. Например, можно изменить цвет ссылки добавлением одного или нескольких из приведенного:
<pre>a:link, a:visited, a:hover, a:active, a:focus {color:blue;}</pre>. Измените примеры цвета и правила CSS на те, которые соответствуют Вашим желаниям.';
$string['customlogourl'] = 'Пользовательский логотип';
$string['customlogourldesc'] = 'Можно изменить логотип, используемый в этой теме, указав полный или относительный URL-адрес нового (например: http://www.yoursite.tld/mylogo.png или ../path/to/your/logo.png). По умолчанию используется логотип шириной 200 и высотой 50 пикселей. Лучше использовать PNG-файл c прозрачным фоном.';
$string['displayheading'] = 'Отображать заголовок страницы';
$string['displaylogo'] = 'Показать логотип';
$string['fontsizereference'] = 'Размер шрифта';
$string['fontsizereferencedesc'] = 'Этот параметр позволяет установить размер шрифта по умолчанию для этой темы. Не рекомендуется задавать размер более 13px, поскольку известны случаи, когда это приводило к проблемам отображения некоторых блоков.';
$string['footnote'] = 'Сноска';
$string['footnotedesc'] = 'Этот текст будет отображаться в нижней части каждой страницы.';
$string['framemargin'] = 'Поля фрейма';
$string['framemargindesc'] = 'Пространство между фреймом и краем окна браузера. (Этот параметр будет игнорироваться, если запрашивается «{$a}»).';
$string['frontpagelogourl'] = 'Собственный логотип главной страницы';
$string['frontpagelogourldesc'] = 'Можно изменить логотип, отображаемый на главной странице сайта, указав полный или относительный URL-адрес нового (например: http://www.yoursite.tld/myfrontpagelogo.png или ../path/to/your/logo.png). По умолчанию используется логотип шириной 300 и высотой 80 пикселей. Лучше использовать PNG-файл c прозрачным фоном.';
$string['headerbgc'] = 'Цвет фона заголовков блоков';
$string['headerbgcdesc'] = 'Параметр задает цвет фона заголовков блоков для этой темы.';
$string['headercontent'] = 'Содержимое заголовка';
$string['headercontentdesc'] = 'Выберите, что отображать в заголовке страницы - логотип agpu или текст заголовка.';
$string['lblockcolumnbgc'] = 'Цвет фона левой колонки';
$string['lblockcolumnbgcdesc'] = 'Параметр задает цвет фона левой колонки для этой темы.';
$string['lemon'] = 'лимонный';
$string['lime'] = 'цвет лайма';
$string['mink'] = 'кофе с молоком';
$string['noframe'] = 'Внешний вид как в «Formal white 1.9»';
$string['noframedesc'] = 'Выберите эту параметр, чтобы страницы agpu выглядели как в agpu 1.*, без рамки.';
$string['orange'] = 'оранжевый';
$string['peach'] = 'персиковый';
$string['pluginname'] = 'Formal white';
$string['rblockcolumnbgc'] = 'Цвет фона правой колонки';
$string['rblockcolumnbgcdesc'] = 'Параметр задает цвет фона правой колонки этой темы оформления. Если оставить поле пустым, то будет использоваться цвет фона левой колонки.';
$string['region-side-post'] = 'Справа';
$string['region-side-pre'] = 'Слева';
$string['silver'] = 'серебряный';
$string['trendcolor'] = 'Предпочтительный цвет';
$string['trendcolordesc'] = 'Выберите предпочитаемый основной цвет темы.';
