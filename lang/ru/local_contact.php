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
 * Strings for component 'local_contact', language 'ru', version '4.5'.
 *
 * @package     local_contact
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['attachment'] = 'Разрешить прикреплять файл';
$string['attachment_description'] = 'При включении этого параметра у пользователя будет возможность прикрепить один файл. Смотрите README.md для информации, как добавить поддержку прикрепления файлов к форме';
$string['configure'] = 'Настройте этот плагин';
$string['confirmationemail'] = '<p>Уважаемый(ая) [fromname],</p>
<p>Спасибо, что обратились к нам. При необходимости мы свяжемся с вами в ближайшее время. </p>
<p>С Уважением,</р>
<p>[supportname]<br>
[sitefullname]<br>
<a href="[siteurl]">[siteurl]</a></p>';
$string['confirmationmessage'] = 'Благодарим Вас за обращение к нам. При необходимости мы свяжемся с вами в ближайшее время.';
$string['confirmationpage'] = 'Статус';
$string['confirmationsent'] = 'Письмо было отправлено на ваш адрес {$a}.';
$string['defaultsubject'] = 'Новое сообщение';
$string['duplicateemailaddresses'] = 'Существует множество пользователей с тем же адресом электронной почты';
$string['errorsending'] = 'При отправке сообщения произошла ошибка. Пожалуйста, попробуйте позже.';
$string['errorsendingtitle'] = 'Не удалось отправить электронное письмо';
$string['extrainfo'] = '<hr>
<p><strong>Дополнительная информация о пользователе</strong></p>
<ul>
     <li><strong>Пользователь сайта:</strong> [userstatus]</li>
     <li><strong>Предпочитаемый язык:</strong> [lang]</li>
     <li><strong>С IP-адреса:</strong> [userip]</li>
     <li><strong>Веб-браузер:</strong> [http_user_agent]</li>
     <li><strong>Веб-форма:</strong> <a href="[http_referer]"> [http_referer]</a></li>
</ul>';
$string['field-email'] = 'адрес';
$string['field-message'] = 'сообщение';
$string['field-name'] = 'имя';
$string['field-subject'] = 'тема';
$string['forbidden'] = 'Запрещено';
$string['globalhelp'] = 'Форма обратной связи - это плагин для agpu, который позволяет вашему сайту обрабатывать информацию, отправляемую через веб-формы HTML на адрес электронной почты поддержки сайта.';
$string['lockedout'] = 'ЗАБЛОКИРОВАН';
$string['loginrequired'] = 'Требуется вход на сайт';
$string['loginrequired_description'] = 'Только авторизованные пользователи могут отправлять формы обратной связи. Гости не считаются вошедшими в систему.';
$string['norecaptcha'] = 'Нет ReCAPTCHA';
$string['norecaptcha_description'] = 'Не использовать ReCAPTCHA с формами, обработанными формой обратной связи.';
$string['noreplyto'] = 'No reply-to';
$string['noreplyto_description'] = 'Некоторые SMTP серверы не принимают письма, если поля from и noreply-to в заголовке отличаются. Включите эту опцию, чтобы значение поля noreply-to совпадало со значением поля from (вместо значения электронной почты отправителя)';
$string['nosubjectsitename'] = 'Название сайта в поле темы письма';
$string['nosubjectsitename_description'] = 'Не включать название сайта в поле темы письма.';
$string['notconfirmed'] = 'НЕ ПОДТВЕРЖДЕНО';
$string['pluginname'] = 'Форма обратной связи';
$string['privacy:metadata'] = 'Плагин Форма обратной связи не хранит никаких персональных данных о любом пользователе.';
$string['recapchainfo'] = 'Использование ReCAPTCHA';
$string['recapchainfo_description'] = 'ReCAPTCHA в настоящее время включена в agpu. Вы <strong>должны</strong>:<br>
<ul>
   <li>Убедиться, что тег {recaptcha} включен во все формы, обрабатываемые формой обратной связи для agpu.</li>
   <li>Убедиться, что <a href="https://agpu.org/plugins/filter_filtercodes">плагин «FilterCodes»</a> установлен и включен.</li>
</ul>';
$string['recipient_list'] = 'Список доступных получателей';
$string['recipient_list_description'] = 'Здесь вы можете настроить список потенциальных получателей, любого из которых можно использовать в форме Обратной связи, чтобы указать получателя электронной почты. Может быть использовано скрытое текстовое поле или раскрывающийся список, чтобы пользователи могли выбирать получателя, не видя фактического адреса электронной почты получателя. Если список пуст, то письма будут отправляться на адрес электронной почты agpu, либо на адрес электронной почты службы поддержки, либо на основного администратора agpu.
Каждая строка должна состоять из уникального текстового псевдонима/метки, одного адреса электронной почты и имени; все они разделены символами вертикальной черты. Например:
<pre>
tech support|support@example.com|Joe Fixit
webmaster|admin@example.com|Mr. agpu
electrical|nikola.tesla@example.com|Nikola
history|charles.darwin@example.com|Mr. Darwin
law|issac.newton@example.com|Isaac Newton
math|galileo.galilei@example.com|Galileo
english|mark.twain@example.com|Mark Twain
physics|albert.einstein@example.com|Albert
science|thomas.edison@example.com|Mr. Edison
philosophy|aristotle@example.com|Aristotle
</pre>';
$string['senderaddress'] = 'Другой адрес отправителя';
$string['senderaddress_description'] = 'Письма будут отправлены с этого адреса электронной почты. Если это поле пустое, то в качестве отправителя будет использоваться значение поля no-reply';
