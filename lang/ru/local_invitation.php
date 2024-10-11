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
 * Strings for component 'local_invitation', language 'ru', version '4.5'.
 *
 * @package     local_invitation
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['available_from'] = 'Доступно с:';
$string['available_to'] = 'Доступно до:';
$string['back_to_course'] = 'Вернуться к своему курсу';
$string['clipboard'] = 'Буфер обмена';
$string['consent'] = 'Согласие (необязательно)';
$string['consent_help'] = 'Если вы определяете текст согласия, приглашенным пользователям отображается флажок, который они должны установить.';
$string['consent_title'] = 'Подтверждение';
$string['current_invitation'] = 'Текущее приглашение';
$string['current_invitation_note'] = 'Если вы создадите новое приглашение, старое автоматически станет недействительным.';
$string['delete_after_logout'] = 'Удалить после выхода из системы';
$string['delete_after_logout_help'] = 'Удалить пользователя сразу после выхода из системы. Если этот параметр активен, вы не сможете увидеть этого пользователя в отчетах своих курсов.';
$string['delete_confirmation'] = 'Вы хотите удалить это приглашение? После этого ссылка на приглашение больше не может быть использована.';
$string['delete_invitation'] = 'Удалить приглашение';
$string['edit_invitation'] = 'Редактировать приглашение для временного доступа к курсу';
$string['error_could_not_create_and_enrol'] = 'Ошибка: Не удалось создать и зарегистрировать нового пользователя!';
$string['error_invalid_invitation'] = 'Ошибка: Это приглашение недействительно!';
$string['error_invitation_not_active'] = 'Ошибка: Функция приглашения не активирована в этой системе.';
$string['error_timeend_can_not_be_before_timestart'] = 'Приглашение не может закончиться до его начала.';
$string['error_timeend_can_not_be_in_past'] = 'Приглашение не может заканчиваться в прошлом.';
$string['error_userrole_not_defined'] = 'Роль пользователя не определена в конфигурации. Пожалуйста, свяжитесь с вашим администратором!';
$string['expiration_time'] = 'Срок действия (дни)';
$string['expiration_time_help'] = 'Учетная запись пользователя, созданная этим плагином, истекает через определенное количество дней. Учетная запись с истекшим сроком действия будет анонимизирована и впоследствии удалена.';
$string['free_slots'] = 'Свободные места:';
$string['guestuser_suffix'] = '(Гость)';
$string['info_already_loggedin'] = 'Вы уже вошли в систему. Если вы продолжите, вы выйдете из системы.';
$string['invitation'] = 'Приглашение';
$string['invitation:manage'] = 'Управлять приглашениями';
$string['invitation_created'] = 'Приглашение успешно создано.';
$string['invitation_delete_note_timeandlogout'] = 'Временная учетная запись и связанные с ней данные автоматически удаляются, как только пользователь выходит из системы, но не позднее, чем после {$a}.';
$string['invitation_delete_note_timeonly'] = 'Временный доступ и связанные с ним данные автоматически удаляются после {$a}.';
$string['invitation_deleted'] = 'Приглашение успешно удалено.';
$string['invitation_note'] = 'Вы можете использовать функцию приглашения, чтобы предоставить временный доступ к этому курсу. Созданная ссылка-приглашение позволяет пользователям без постоянной учетной записи получить доступ к этому курсу.';
$string['invitation_updated'] = 'Приглашение успешно обновлено.';
$string['invite_participants'] = 'Новое приглашение для временного доступа к курсу';
$string['join'] = 'Присоединиться';
$string['link_copied'] = 'Ссылка была скопирована.';
$string['max_users'] = 'Максимальное количество пользователей';
$string['max_users_per_invitation'] = 'Максимальное количество пользователей на приглашение';
$string['nameinfo'] = 'Информация об имени';
$string['nameinfo_help'] = 'С помощью этого текста вы можете задать краткое объяснение того, как использовать поле «Имя» при присоединении.';
$string['note'] = 'Примечание:';
$string['pluginname'] = 'Приглашение';
$string['preventactions'] = 'Предотвращать действия';
$string['preventactions_help'] = '<strong>Примечание:</strong> Вы можете определить URL-адреса или части URL-адресов, по которым приглашенные пользователи не должны иметь возможности обращаться.<br>
Если приглашенный пользователь вызывает такой URL, он перенаправляется на его курс или на главную страницу agpu.<br>
Вы не должны включать в этот список Личный кабинет или главную страницу!';
$string['qrcode'] = 'QR-код';
$string['remove_old_invitations'] = 'Удалить старых пользователей';
$string['showqrcode'] = 'Показать QR-код';
$string['single_name_field'] = 'Одно поле имени';
$string['single_name_field_help'] = 'Когда установлен флажок «Одно поле имени», пользователю нужно указать только одно имя, а не имя и фамилию. Кроме того, к имени добавляется суффикс.';
$string['systemrole'] = 'Системная роль';
$string['systemrole_help'] = 'Если системная роль определена, приглашенный пользователь будет соответствовать этому. Это может быть использовано для ограничения приглашенного пользователя на системном уровне.';
$string['timeend'] = 'Время окончания';
$string['timestart'] = 'Время начала';
$string['usedslots'] = 'Используется:';
$string['userrole'] = 'Роль пользователя';
$string['welcome_note'] = 'Добро пожаловать, {$a->firstname} {$a->lastname}!';
