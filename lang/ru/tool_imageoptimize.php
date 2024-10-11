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
 * Strings for component 'tool_imageoptimize', language 'ru', version '4.5'.
 *
 * @package     tool_imageoptimize
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['backgroundoptimizingheading'] = 'Параметры фоновой оптимизации';
$string['cantcopyfile'] = 'Файл не может быть сохранен';
$string['cantfindfile'] = 'Файл не найден в файловом хранилище';
$string['create_desc'] = 'Применять оптимизацию при первой загрузке файла';
$string['enablebackgroundoptimizing'] = 'Включить фоновую оптимизацию';
$string['enablebackgroundoptimizing_desc'] = 'При включенной фоновой оптимизации не будет выполняться оптимизация при загрузке файла';
$string['exec_warning'] = 'Для функционирования этого плагина необходимо выполнить ряд настроек на сервере
 <ol>
                            <li>Включите функцию ядра PHP <strong>
                            <a href="https://www.php.net/manual/en/function.exec.php"
                            target="_blank">exec()</a></strong>
                                <ol>
                                    <li>найдите путь к файлу конфигурации <strong>php.ini</strong></li>
                                    <li>отредактируйте список отключенных функций <strong>
                                    <a href="https://www.php.net/manual/en/ini.core.php#ini.disable-functions"
                                    target="_blank">disable_functions</a></strong> в этом файле, удалите функцию
                                    <strong>exec</strong> из списка и сохраните изменения</li>
                                    <li>перезапустите php</li>
                                </ol>
                            </li>
                            <li>Установите на сервере пакеты, необходимые для сжатия каждого из форматов изображений</li>
                        </ol>';
$string['filecheckfailed'] = 'Проверка файла завершилась с ошибкой';
$string['filehasnofilesize'] = 'Размер файла не определен или равен 0. Отмена!';
$string['files_types'] = 'Типы файлов';
$string['files_types_desc'] = 'Выберите типы файлов, к которым будет применяться оптимизация';
$string['filesortorder'] = 'Выберите порядок сортировки файлов';
$string['filesortorder_id_asc'] = 'Начинать с более старых файлов';
$string['filesortorder_id_desc'] = 'Начинать с более новых файлов';
$string['gifsicle'] = '<strong><a href="http://www.lcdf.org/gifsicle/" target="_blank">Gifsicle</a></strong>
                        <ul>
                            <li><strong>Debian/Ubuntu</strong>: <code>sudo apt-get install gifsicle</code></li>
                            <li><strong>Fedora/RHEL/CentOS</strong>: <code>sudo dnf install gifsicle</code></li>
                        </ul>';
$string['info_title'] = 'Чтобы расширить функцию компрессии <strong>{$a}</strong>, вы можете установить дополнительные пакеты для сжатия';
$string['jpegoptim'] = '<strong><a href="http://freshmeat.sourceforge.net/projects/jpegoptim" target="_blank">JpegOptim</a></strong>
                        <ul>
                            <li><strong>Debian/Ubuntu</strong>: <code>sudo apt-get install jpegoptim</code></li>
                            <li><strong>Fedora/RHEL/CentOS</strong>: <code>sudo dnf install jpegoptim</code></li>
                        </ul>';
$string['maxchunksize'] = 'Максимальное число файлов, обрабатываемых при каждом запуске задания';
$string['maxchunksizeimport'] = 'Максимальное число файлов, записываемых в таблицу обработки при каждом запуске задания';
$string['more_than'] = 'Оптимизировать файлы размером более указанного значения, Kb';
$string['optipng'] = '<strong><a href="http://optipng.sourceforge.net/" target="_blank">OptiPNG</a></strong>
                        <ul>
                            <li><strong>Debian/Ubuntu</strong>: <code>sudo apt-get install optipng</code></li>
                            <li><strong>Fedora/RHEL/CentOS</strong>: <code>sudo dnf install optipng</code></li>
                        </ul>';
$string['os_warning'] = 'В данный момент плагин не поддерживает работу с операционной системой вашего сервера: <strong>{$a}</strong>';
$string['pathnamehashchanged'] = 'Изменился хэш файла Pathnamehash. Отмена!';
$string['pluginname'] = 'Оптимизация изображений';
$string['privacy:metadata'] = 'Плагин «Оптимизация изображений» не хранит никаких персональных данных';
$string['taskoptimize'] = 'Фоновая задача оптимизации изображений';
$string['taskoptimize_fill_table'] = 'Заполнение таблицы tool_imageoptimize_files';
$string['update_desc'] = 'Применять оптимизацию при обновлении файла';
$string['warning_title'] = 'Для активации этой опции установите на своем сервере один или все из указанных пакетов';
$string['webp'] = '<strong><a href="https://developers.google.com/speed/webp" target="_blank">WebP</a></strong>
                        <ul>
                            <li><strong>Debian/Ubuntu</strong>: <code>sudo apt-get install webp</code></li>
                            <li><strong>Fedora/RHEL/CentOS</strong>: <code>sudo dnf install libwebp-tools</code></li>
                        </ul>';
