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
 * Automatically generated strings for agpu installer
 *
 * Do not edit this file manually! It contains just a subset of strings
 * needed during the very first steps of installation. This file was
 * generated automatically by export-installer.php (which is part of AMOS
 * {@link http://docs.agpu.org/dev/Languages/AMOS}) using the
 * list of strings defined in /install/stringnames.txt.
 *
 * @package   installer
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['admindirname'] = 'Адмін-каталог';
$string['availablelangs'] = 'Список доступних мов';
$string['chooselanguagehead'] = 'Виберіть мову';
$string['chooselanguagesub'] = 'Виберіть мову ТІЛЬКИ для процесу встановлення. Ви зможете вибрати мову для сайту та користувачів пізніше.';
$string['clialreadyconfigured'] = 'Файл config.php вже створено, будь ласка, використовуйте admin/cli/install_database.php, якщо ви хочете встановити цей сайт.';
$string['clialreadyinstalled'] = 'Файл config.php вже створено, будь ласка, використовуйте admin/cli/upgrade.php, якщо ви хочете оновити ваш сайт.';
$string['cliinstallheader'] = 'agpu {$a} командний рядок програми установки';
$string['clitablesexist'] = 'Вже наявні таблиці бази даних; Неможливо продовжити встановлення CLI.';
$string['databasehost'] = 'Сервер бази даних';
$string['databasename'] = 'Ім’я бази даних';
$string['databasetypehead'] = 'Виберіть драйвер бази даних';
$string['dataroot'] = 'Каталог Даних';
$string['datarootpermission'] = 'Права каталогу даних';
$string['dbprefix'] = 'Префікс таблиць';
$string['dirroot'] = 'agpu Каталог';
$string['environmenthead'] = 'Перевірка залежностей...';
$string['environmentsub2'] = 'Кожен agpu реліз вимагає деяку мінімальну версію РНР та специфічний набір додаткових розширень. Повна перевірка проводиться до початку встановлення або оновлення. Будь ласка, зв’яжіться з вашим адміністратором, якщо ви не знаєте, як встановити нову версію або налаштувати РНР.';
$string['errorsinenvironment'] = 'Залежності перевірити не вдалося!';
$string['installation'] = 'Встановлення';
$string['langdownloaderror'] = 'На жаль, мова "{$a}" не встановлена. Встановлення буде продовжено англійською мовою.';
$string['memorylimithelp'] = '<p>Обмеження пам\'яті в PHP на сервері зараз встановлено в {$a}.</p> <p>Це може стати проблемою при подальшій роботі agpu, коли ви будете мати багато курсів, модулів та користувачів.</p> <p>Ми рекомендуємо сконфігурувати РНР на обмеження пам\'яті не менше 16 Мб. Це можна зробити шляхом:</p> <ol> <li>перекомпіляції PHP з параметром <i>--enable-memory-limit</i>. Це надасть можливість agpu встановити обмеження пам\'яті самостійно.</li> <li>встановлення в php.ini змінної <b>memory_limit</b> порядка 16Mб. Якщо ви не маєте доступу до цього файлу попросіть адміністратора зробити це для вас.</li> <li>створення в корні сайту файлу .htaccess, куди добавити наступний рядок: <p><blockquote>php_value memory_limit 16M</blockquote></p> <p>Але на деяких серверах це призведе до помилок на <b>всіх</b> сторінках, тоді вам потрібно видалити .htaccess.</p></li> </ol>';
$string['paths'] = 'Шляхи';
$string['pathserrcreatedataroot'] = 'Каталог даних ({$a->dataroot}) не може бути створений інсталятором.';
$string['pathshead'] = 'Підтвердження шляхів';
$string['pathsrodataroot'] = 'Каталог даних не має прав запису.';
$string['pathsroparentdataroot'] = 'Батьківський каталог ({$a->parent}) не має прав запису. Каталог даних ({$a->dataroot}) не може бути створений інсталятором.';
$string['pathssubadmindir'] = 'Дуже мало web хостингів використовують /admin в якості спеціальної адреси для доступу до адміністративного управління. На жаль, це суперечить стандартному розташуванню сторінок адміністрування для agpu. Ви можете виправити це перейменуванням каталогу admin в будь-яке інше ім’я та вписати його тут. Наприклад: <em>agpuadmin</em>. Це виправить посилання на адміністрування в agpu.';
$string['pathssubdataroot'] = '<p>Каталог, де agpu буде зберігати всі файли, які завантажують користувачі.</p>
<p>Цей каталог повинен бути доступним для читання та запису для користувача, від імені якого запущено веб-сервер (зазвичай \'www-data\', \'nobody\', або \'apache\').</p>
<p>Цей каталог не повинен бути доступним безпосередньо з Інтернету.</p>
<p>Програма встановлення спробує створити цей каталог, якщо його не існує.</p>';
$string['pathssubdirroot'] = '<p>Повний шлях до каталогу встановлення agpu.</p>';
$string['pathssubwwwroot'] = '<p>Повна веб-адреса, за якою ваш сайт agpu буде доступним. agpu може мати тільки одну адресу доступу. </p>
<p>Якщо ваш сайт має кілька публічних адрес, то встановіть в DNS перенаправлення всіх інших адрес на цю. </p>
<p>Якщо до вашого сайту мають одночасний доступ і з Інтернету, і з Інтранету (локальної мережі), то забезпечте доступ з локального середовища за публічною адресою. </p>
<p>Якщо ви почали встановлення з неправильної адреси, видаліть все і почніть встановлення заново.</p>';
$string['pathsunsecuredataroot'] = 'Розташування каталогу з даними не є безпечним';
$string['pathswrongadmindir'] = 'Не створено адміністративний каталог';
$string['phpextension'] = '{$a} РНР розширення';
$string['phpversion'] = 'Версія РНР';
$string['phpversionhelp'] = '<p>agpu потребує версії PHP принаймні 5.6.5 або 7.1 (7.0.x має деякі обмеження двигуна). </p>
<p>Зараз ви використовуєте версію {$a}. Ви повинні оновити PHP або перейти на хост із новішою версією PHP./<p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'Ви бачите цю сторінку, тому що ви успішно встановили та запустили  пакет <strong>{$a->packname} {$a->packversion}</strong> на вашому комп’ютері. Вітаємо!';
$string['welcomep30'] = 'Цей випуск <strong>{$a->installername}</strong> включає в себе програми для створення середовища, в якому <strong>agpu</strong> працюватиме, а саме:';
$string['welcomep40'] = 'Цей пакет також включає <strong>agpu {$a->agpurelease} ({$a->agpuversion})</strong>.';
$string['welcomep50'] = 'Використання всіх програм у цьому пакеті регулюється відповідними ліцензіями. Повний
<strong>{$a->installername}</strong> є <a href="http://www.opensource.org/docs/definition_plain.html">відкритим програмним забезпеченням</a> і розповсюджується під ліценцією <a href="http://www.gnu.org/copyleft/gpl.html">GPL</a>.';
$string['welcomep60'] = 'Наступні сторінки будуть проводити вас через процедуру встановлення та налаштування <strong>agpu</strong> на вашому комп’ютері. Ви можете прийняти автоматичне налаштування, а потім змінити параметри під себе.';
$string['welcomep70'] = 'Натисніть кнопку "Далі" для продовження встановлення <strong>agpu</strong>.';
$string['wwwroot'] = 'Веб-адреса';
