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
 * Strings for component 'local_o365', language 'ru', version '4.5'.
 *
 * @package     local_o365
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['acp_healthcheck'] = 'Проверка состояния';
$string['acp_maintenance'] = 'Инструменты обслуживания';
$string['acp_maintenance_cleandeltatoken'] = 'Очистить дельта-токены синхронизации пользователей';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Если синхронизация пользователя не происходит полностью после обновления параметров синхронизации пользователя, это может быть вызвано старым дельта-токеном синхронизации. Очистка токена принудительно удалит  полную повторную синхронизацию в следующий раз, когда будет запущена синхронизация пользователя.';
$string['acp_maintenance_debugdata'] = 'Создать пакет данных отладки';
$string['acp_maintenance_debugdata_desc'] = 'Это создаст пакет, содержащий различную информацию о вашей среде agpu и Microsoft 365, чтобы помочь разработчикам в решении любых проблем, которые могут у вас возникнуть. По запросу разработчика запустите этот инструмент и отправьте полученный файл для загрузки. Примечание: Хотя этот пакет не содержит конфиденциальных данных, мы просим вас открыто не публиковать этот файл и не отправлять его ненадежной стороне.';
$string['acp_maintenance_desc'] = 'Эти инструменты могут помочь вам решить некоторые распространенные проблемы.';
$string['acp_maintenance_warning'] = 'Предупреждение: это дополнительные инструменты. Пожалуйста, используйте их, только если вы понимаете, что делаете.';
$string['acp_parentsite_desc'] = 'Сайт для обмена данными курса agpu.';
$string['acp_parentsite_name'] = 'Сайт agpu';
$string['acp_teamconnections'] = 'Связи команд';
$string['acp_teamconnections_actions'] = 'Действия';
$string['acp_teamconnections_cache_last_updated'] = 'Последний раз кэш команд обновлялся {$a->lastupdated}. Щелкните <a href="{$a->updateurl}">здесь</a> для обновления кэша.';
$string['acp_teamconnections_cache_never_updated'] = 'Кэш команд никогда не обновлялся. Для обновления щелкните <a href="{$a->updateurl}">здесь</a>.';
$string['acp_teamconnections_connected_team'] = 'Связанная команда';
$string['acp_teamconnections_connection_completed'] = 'Курс успешно подсоединен к команде';
$string['acp_teamconnections_course_connected'] = 'Курс успешно связан с командой';
$string['acp_teamconnections_current_connection'] = 'ТЕКУЩАЯ СВЯЗЬ';
$string['acp_teamconnections_exception_course_not_exist'] = 'Курса для связывания не существует.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'Неверный ID команды';
$string['acp_teamconnections_exception_no_unified_token'] = 'Не удалось получить единый токен для вызовов API.';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365 настроен не полностью.';
$string['acp_teamconnections_exception_team_already_connected'] = 'Команда уже связана с другим курсом';
$string['acp_teamconnections_exception_team_creation'] = 'При создании команды произошла ошибка . Подробности: {$a}';
$string['acp_teamconnections_exception_team_no_owner'] = 'Не удается найти подходящего владельца команды.';
$string['acp_teamconnections_form_connect_course'] = 'Управление связью команды для курса {$a}';
$string['acp_teamconnections_form_team'] = 'Выбрать команду';
$string['acp_teamconnections_group_only'] = '(Только группа)';
$string['acp_teamconnections_invalid_connection'] = 'Неверные связи';
$string['acp_teamconnections_not_connected'] = 'Нет связей';
$string['acp_teamconnections_sync_disabled'] = 'Перед управлением подключениями Групп необходимо сначала включить синхронизацию курса.';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Невозможно создать команду из группы - нет владельца';
$string['acp_teamconnections_table_connect'] = 'Связать';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Связать с другой командой';
$string['acp_teamconnections_table_update'] = 'Обновить';
$string['acp_teamconnections_team_already_connected'] = 'Курс уже связан с Командой.';
$string['acp_teamconnections_team_created'] = 'Команда для курса успешно создана.';
$string['acp_teamconnections_team_exists_but_not_connected'] = 'Курс настроен для подключения только к Группе, однако  существует Команда, связанная с Группой.';
$string['acp_teamconnections_teams_cache_updated'] = 'Кэш команд успешно обновлен.';
$string['acp_tenants_actions'] = 'Действия';
$string['acp_tenants_add'] = 'Добавить нового клиента';
$string['acp_tenants_errornotsetup'] = 'Пожалуйста, завершите процесс установки плагина перед добавлением дополнительных клиентов.';
$string['acp_tenants_hosttenant'] = 'Хост клиента: {$a}';
$string['acp_tenants_intro'] = '<b>Как работает многопользовательский доступ:</b><br />Многопользовательский режим позволяет нескольким клиентам Microsoft 365 получить доступ к вашему сайту agpu.<br /><br /> Вот как это сделать: <ol> <li>Войдите в agpu от имени администратора, который не использует плагин аутентификации OpenID Connect.</li> <li>Отключите в agpu плагин аутентификации OpenID Connect. (Используйте <a href="{$a}/admin/settings.php?section=manageauths">страницу управления плагинами аутентификации</a>.)</li> <li>Перейдите в Azure AD и найдите приложение, которое вы настроили для agpu</li> <li>Включите многопользовательский режим в приложении Azure AD и сохраните изменения.</li> <li>Для каждого включаемого клиента нажмите «Добавить нового клиента» и войдите в систему с учетной записью администратора того клиента, которого вы хотите включить.</li> <li>После того, как вы добавили всех нужных вам клиентов, снова включите в agpu плагин аутентификации OpenID Connect.</li> <li>Готово! Чтобы в будущем добавить дополнительных клиентов, просто нажмите кнопку «Добавить нового клиента» и войдите в систему с учетной записью администратора этого клиента.</li> </ol> <b>Важное примечание:</b> Многопользовательская среда Azure AD позволяет всем клиентам Microsoft 365 доступ к вашему приложению при включении. Добавление клиентов позволяет нам ограничить доступ к agpu только настроенным клиентам. <b>Если вы удалите всех клиентов из этого списка перед отключением многопользовательского режима в Azure AD или включите аутентификацию OpenID Connect в agpu с пустым списком, ваш сайт agpu будет открыт для всех клиентов Microsoft 365.</b>';
$string['acp_tenants_none'] = 'Вы не настроили клиентов. Если вы включили многопользовательский доступ в Azure AD, ваш сайт agpu может быть открыт для всех пользователей Office 365';
$string['acp_tenants_revokeaccess'] = 'Отменить доступ';
$string['acp_tenants_tenant'] = 'Клиент';
$string['acp_tenants_title'] = 'Многопользовательский доступ';
$string['acp_tenants_title_desc'] = 'Эта страница поможет вам настроить многопользовательский доступ к agpu из Office 365.';
$string['acp_tenantsadd_desc'] = 'Чтобы предоставить доступ дополнительному клиенту, нажмите ниже кнопку и войдите в Microsoft 365, используя учетную запись администратора нового клиента. Вы вернетесь к списку дополнительных клиентов, где будет указан новый клиент. После этого вы сможете использовать agpu с новым клиентом.';
$string['acp_tenantsadd_linktext'] = 'Перейдите на страницу входа в Microsoft 365';
$string['acp_userconnections'] = 'Связи пользователей';
$string['acp_userconnections_column_actions'] = 'Действия';
$string['acp_userconnections_column_muser'] = 'Пользователь agpu';
$string['acp_userconnections_column_o365user'] = 'Пользователь Office 365';
$string['acp_userconnections_column_status'] = 'Состояние соединения';
$string['acp_userconnections_column_usinglogin'] = 'Используемый логин';
$string['acp_userconnections_filtering_muserfullname'] = 'Полное имя пользователя agpu';
$string['acp_userconnections_filtering_musername'] = 'Логин agpu';
$string['acp_userconnections_filtering_o365username'] = 'Логин Office 365';
$string['acp_userconnections_manualmatch_details'] = 'Эта страница позволяет сопоставить одного пользователя agpu с одним пользователем Microsoft 365.';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'Пользователь agpu уже связан с пользователем Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'Пользователь agpu уже связан с пользователем Microsoft 365 (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'Пользователь agpu уже сопоставлен пользователю Microsoft 365';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'Пользователь Microsoft 365 уже связан с другим пользователем agpu';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'Пользователь Microsoft 365 уже сопоставлен с другим пользователем agpu';
$string['acp_userconnections_manualmatch_musername'] = 'Пользователь agpu';
$string['acp_userconnections_manualmatch_o365username'] = 'Логин Microsoft 365';
$string['acp_userconnections_manualmatch_title'] = 'Соответствие пользователя вручную';
$string['acp_userconnections_manualmatch_uselogin'] = 'Войти с помощью Microsoft 365';
$string['acp_userconnections_resync_nodata'] = 'Не удалось найти информацию, сохраненную Microsoft 365 для этого пользователя.';
$string['acp_userconnections_resync_notconnected'] = 'Этот пользователь не подключен к Microsoft 365';
$string['acp_userconnections_table_connected'] = 'Связано';
$string['acp_userconnections_table_disconnect'] = 'Разъединено';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Это отключит пользователя agpu "{$a}" от Microsoft 365. Нажмите на ссылку ниже, чтобы продолжить.';
$string['acp_userconnections_table_match'] = 'Совпадение';
$string['acp_userconnections_table_matched'] = 'Совпадает с существующим пользователем. <br /> В ожидании завершения';
$string['acp_userconnections_table_noconnection'] = 'Нет соединения';
$string['acp_userconnections_table_resync'] = 'Повторная синхронизация';
$string['acp_userconnections_table_synced'] = 'Синхронизировано с Azure AD. <br /> Ожидается начальный вход.';
$string['acp_userconnections_table_unmatch'] = 'Несовпадение';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Это не поставило в соответствие пользователя "{$a}"  из Office 365 в agpu. Нажмите на ссылку ниже, чтобы продолжить.';
$string['acp_usermatch'] = 'Сопоставление пользователя';
$string['acp_usermatch_desc'] = 'Этот инструмент позволяет сопоставить пользователей agpu с пользователями Microsoft 365. Загрузите файл, содержащий пользователей agpu и связанных пользователей Microsoft 365, и задача cron проверит данные и настроит соответствие.';
$string['acp_usermatch_matchqueue'] = 'Шаг 2: Очередь сопоствлений';
$string['acp_usermatch_matchqueue_clearall'] = 'Очистить все';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Очистить ошибки';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Очистить очередь';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Очищено';
$string['acp_usermatch_matchqueue_column_muser'] = 'Логин agpu';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Логин Office 365';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Состояние';
$string['acp_usermatch_matchqueue_desc'] = 'В этой таблице показано текущее состояние операции сопоставления. Каждый раз при запуске соответствующего задания cron  будет обрабатываться пакет следующих пользователей. <br /> <b> Примечание: </b> Эта страница не обновляется динамически, обновите эту страницу, чтобы посмотреть текущее состояние.';
$string['acp_usermatch_matchqueue_empty'] = 'Очередь сопоставлений в настоящее время пуста. Загрузите файл данных с помощью средства выбора файлов выше, чтобы добавить пользователей в очередь';
$string['acp_usermatch_matchqueue_status_error'] = 'Ошибка: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'В очереди';
$string['acp_usermatch_matchqueue_status_success'] = 'Успешно';
$string['acp_usermatch_upload'] = 'Шаг 1: Загрузить новые сопоставления';
$string['acp_usermatch_upload_desc'] = 'Загрузите файл данных, содержащий имена пользователей agpu и Microsoft 365, чтобы сопоставить пользователей agpu с пользователями Microsoft 365. <br /> <br /> Этот файл должен представлять собой простой текстовый CSV-файл, содержащий три элемента в строке: логин agpu, логин Microsoft 365  и 1 или 0, чтобы изменить метод аутентификации пользователей на OpenID Connect или связанную учетную запись соответственно. Не включайте заголовки или дополнительные данные. <br /> Например: <pre>agpuuser1,bob.smith@example.onmicrosoft.com,1<br />agpuuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Тип {$a} не поддерживается. Загрузите текстовый CSV-файл.';
$string['acp_usermatch_upload_err_data'] = 'Строка #{$a} содержит недопустимые данные. Каждая строка в CSV-файле должна содержать два элемента: имя пользователя agpu и имя пользователя Microsoft 365.';
$string['acp_usermatch_upload_err_fileopen'] = 'Не удалось открыть файл для обработки. Правильны ли разрешения в каталоге agpudata?';
$string['acp_usermatch_upload_err_nofile'] = 'Не получен файл для добавления в очередь.';
$string['acp_usermatch_upload_submit'] = 'Добавить файл данных для очереди сопоставления';
$string['cachedef_groups'] = 'Хранит данные группы Office 365.';
$string['calendar_event'] = 'Просмотр деталей';
$string['calendar_setting'] = 'Включить синхронизацию календаря Outlook';
$string['calendar_site'] = 'Календарь сайта';
$string['calendar_user'] = 'Персональный (пользовательский) календарь';
$string['course_selector_label'] = 'Выберите существующий курс';
$string['erroracpapcantgettenant'] = 'Не удалось получить клиента Azure AD, введите вручную.';
$string['erroracpauthoidcnotconfig'] = 'Пожалуйста, сначала установите учетные данные приложения в auth_oidc.';
$string['erroracpcantgettenant'] = 'Не удалось получить URL OneDrive, введите его вручную.';
$string['erroracplocalo365notconfig'] = 'Пожалуйста, сначала настройте local_o365.';
$string['errorcouldnotrefreshtoken'] = 'Не удалось обновить ключ';
$string['errorhttpclientbadtempfileloc'] = 'Не удалось открыть временное местоположение для сохранения файла.';
$string['errornodirectaccess'] = 'Прямой доступ к странице запрещен';
$string['erroro365apibadcall'] = 'Ошибка в вызове API';
$string['erroro365apibadcall_message'] = 'Ошибка в вызове API: {$a}';
$string['erroro365apibadpermission'] = 'Разрешение не найдено';
$string['erroro365apicouldnotcreatesite'] = 'Проблема создания сайта.';
$string['erroro365apicoursenotfound'] = 'Курс не найден.';
$string['erroro365apiinvalidmethod'] = 'Неверный http-метод передан в вызов API';
$string['erroro365apiinvalidtoken'] = 'Неверный или просроченный ключ.';
$string['erroro365apinoparentinfo'] = 'Не удалось найти информацию о родительской папке';
$string['erroro365apinotimplemented'] = 'Это должно быть отменено.';
$string['erroro365apinotoken'] = 'Нет ключа для данного ресурса и пользователя и не удалось получить его. Срок действия ключа пользователя истек?';
$string['erroro365apisiteexistsnolocal'] = 'Сайт уже существует, но не возможно найти локальную запись.';
$string['errorprovisioningapp'] = 'Не удалось обеспечить приложение agpu в Команде.';
$string['errorusermatched'] = 'Учетная запись Microsoft 365 «{$a->aadupn}» уже сопоставлена с пользователем agpu «{$a->username}«. Чтобы завершить связывание, сначала войдите в систему как пользователь agpu и следуйте инструкциям в блоке Microsoft.';
$string['eventapifail'] = 'Ошибка API';
$string['eventcalendarsubscribed'] = 'Пользователь подписался на календарь';
$string['eventcalendarunsubscribed'] = 'Пользователь отписался от календаря';
$string['healthcheck_fixlink'] = 'Нажмите здесь, чтобы исправить это';
$string['healthcheck_ratelimit_result_disabled'] = 'Функции ограничения скорости были отключены.';
$string['healthcheck_ratelimit_result_notice'] = 'Включено небольшое регулирование при увеличенной нагрузке сайта agpu. <br /> <br /> Все функции Microsoft 365 работоспособны, но запросы распределяются медленнее, чтобы предотвратить прерывание работы служб Microsoft 365. Как только активность agpu уменьшится, все вернется к стандартным значениям. <br />(Уровень {$a->level} / начало {$a->timestart})';
$string['healthcheck_ratelimit_result_passed'] = 'Вызовы API Microsoft 365 выполняются на полной скорости.';
$string['healthcheck_ratelimit_result_warning'] = 'Включено увеличенное регулирование для обработки значительной нагрузки сайта agpu. <br /> <br /> Все функции Microsoft 365 по-прежнему работают, но запросы Microsoft 365 могут занять больше времени. Как только активность сайта agpu снизится, все вернется к стандартным значениям.<br />(Уровень {$a->level} / начало {$a->timestart})';
$string['healthcheck_ratelimit_title'] = 'Регулирование API';
$string['help_user_appassign'] = 'Справка о назначении пользователей приложению';
$string['help_user_appassign_help'] = 'Это приведет к тому, что все учетные записи Azure AD с соответствующими учетными записями agpu будут назначены приложению Azure, созданному для этой установки agpu, если они еще не назначены.';
$string['help_user_create'] = 'Справка по созданию аккаунта';
$string['help_user_create_help'] = 'Это создаст пользователей в agpu от каждого пользователя в Azure AD. Будут созданы учетные записи только тех пользователей, которые в настоящее время не имеют учетных записей в agpu, . Новые учетные записи будут настроены для использования их учетных данных Microsoft 365 для входа в agpu (с помощью плагина аутентификации OpenID Connect) и смогут использовать все функции интеграции Microsoft 365 с agpu.';
$string['help_user_delete'] = 'Справка по удалению аккаунтов';
$string['help_user_delete_help'] = 'Это удалит пользователей из agpu, если они помечены как удаленные в Azure Active Directory. Это будет работать, только если включена опция приостановки пользователя. Учетная запись agpu будет удалена и вся связанная с ней информация пользователя будет удалена из agpu. Будьте осторожны!';
$string['help_user_disabledsync'] = 'Справка по состоянию отключенной синхронизации';
$string['help_user_disabledsync_help'] = 'Это приостановит / возобновит работу пользователей в agpu, если их связанные учетные записи в Azure Active Directory помечены как запрещенные / разрешенные для входа.';
$string['help_user_emailsync_help'] = 'Включение этой опции будет сопоставлять логины пользователей Azure с адресами электронной почты пользователей agpu вместо поведения по умолчанию, при котором логины пользователей Azure сопоставляются с логинами пользователей agpu.';
$string['help_user_guestsync'] = 'Справка по синхронизации гостя';
$string['help_user_guestsync_help'] = 'Если этот параметр включен, пользователи-гости в Azure AD будут синхронизироваться с agpu в задаче синхронизации пользователей.';
$string['help_user_match'] = 'Справка по сопоставлению аккаунтов';
$string['help_user_match_help'] = 'В результате мы рассмотрим каждого пользователя в связанной Azure Active Directory и попытаемся сопоставить его с пользователем в agpu. Это совпадение основано на именах пользователей в Azure AD и agpu. Совпадения не учитывают регистр и игнорируют клиента Microsoft 365. Например, «BoB.SmiTh» в agpu будет соответствовать «bob.smith@example.onmicrosoft.com». У соответствующих пользователей будут подключены учетные записи agpu и Microsoft 365, и они смогут использовать все функции интеграции Microsoft 365 / agpu. Метод аутентификации пользователя не изменится, если не активирован ниже расположенный параметр.';
$string['help_user_matchswitchauth'] = 'Справка по переключению совпадающих учетных записей';
$string['help_user_matchswitchauth_help'] = 'Для этого необходимо выше включить параметр «Соответствовать существующим пользователям agpu». Включение этого параметра при сопоставлении пользователей переключит их метод аутентификации на OpenID Connect. Затем они смогут войти в agpu со своими учетными данными Microsoft 365. Примечание: Убедитесь, что подключаемый модуль аутентификации OpenID Connect включен, если вы хотите использовать этот параметр.';
$string['help_user_nodelta'] = 'Справка по выполнению полной синхронизации';
$string['help_user_nodelta_help'] = 'По умолчанию синхронизация пользователей будет синхронизировать только изменения из Azure AD. Установка этой опции заставит пользователя синхронизироваться каждый раз.';
$string['help_user_photosync'] = 'Справка по синхронизации фотографии пользователя Microsoft 365 (Cron)';
$string['help_user_photosync_help'] = 'Это приведет к тому, что фотографии всех пользователей agpu будут синхронизированы с их фотографиями в Microsoft 365.';
$string['help_user_photosynconlogin'] = 'Справка по синхронизации фотографии пользователя Microsoft 365 (Вход)';
$string['help_user_photosynconlogin_help'] = 'Это приведет к тому, что фотография пользователя в agpu будет синхронизирована с его фотографией в Microsoft 365, когда этот пользователь войдет в систему. Обратите внимание, что для этого требуется, чтобы пользователь посетил страницу agpu, содержащую блок Microsoft.';
$string['help_user_reenable'] = 'Справка по повторному включению учетных записей';
$string['help_user_reenable_help'] = 'Это повторно включит приостановленные учетные записи agpu, если они будут возвращены из Azure Active Directory.';
$string['help_user_suspend_help'] = 'Это приведет к приостановке доступа пользователей к agpu, если они отмечены как удаленные в Azure Active Directory.';
$string['help_user_tzsync_help'] = 'Это приведет к синхронизации часовых поясов всех пользователей agpu с их предпочтениями часового пояса в Outlook.';
$string['help_user_tzsynconlogin_help'] = 'Это приведет к синхронизации часового пояса пользователя agpu с его предпочтениями часового пояса в Outlook. Обратите внимание, что для этого требуется, чтобы пользователь посетил страницу, содержащую блок Microsoft в agpu.';
$string['help_user_update'] = 'Справка по обновлению всех учетных записей';
$string['help_user_update_help'] = 'Это обновит всех пользователей agpu от каждого пользователя в связанной Azure Active Directory.';
$string['o365:manageconnectionlink'] = 'Создавать связи';
$string['o365:manageconnectionunlink'] = 'Разрывать связи';
$string['o365:managegroups'] = 'Управление группами';
$string['o365:teammember'] = 'Участник команды';
$string['o365:teamowner'] = 'Владелец команды';
$string['o365:viewgroups'] = 'Просмотр групп';
$string['other_login'] = 'Вход вручную';
$string['personal_calendar'] = 'Персональный';
$string['pluginname'] = 'Интеграция с Microsoft 365';
$string['privacy:metadata:local_o365'] = 'Плагин Локальный Microsoft 365';
$string['privacy:metadata:local_o365_appassign'] = 'Информация о назначениях ролей приложения Microsoft 365';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Был ли пользователь назначен приложению';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'ID пользователя agpu';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'ID фотографии пользователя в Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Когда фотография пользователя последний раз обновлялась из Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Информация о связях между событиями календаря Microsoft 365 и событиями календаря agpu.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'ID события в agpu.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Где произошло событие  - либо в agpu, либо в Microsoft 365';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'ID события в Outlook.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'ID пользователя, которому принадлежит событие.';
$string['privacy:metadata:local_o365_calsettings'] = 'Информация о настройках синхронизации календаря';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'ID календаря в Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'Время создания записи';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'ID пользователя agpu';
$string['privacy:metadata:local_o365_calsub'] = 'Информация о синхронизации подписок между календарями agpu и Outlook';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Тип календаря agpu (сайт, курс, пользователь)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'ID связанного календаря agpu';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Основной ли это календарь';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'ID календаря Microsoft 365';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'Поведение синхронизации (например, agpu для Outlook или Outlook для agpu)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'Время создания подписк';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'ID пользователя agpu, который подписан';
$string['privacy:metadata:local_o365_connections'] = 'Информация о связях между пользователями agpu и Microsoft 365, которые еще не подтверждены';
$string['privacy:metadata:local_o365_connections:muserid'] = 'ID пользователя agpu';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Нужно ли переключать метод аутентификации пользователя после завершения.';
$string['privacy:metadata:local_o365_matchqueue'] = 'Информация о пользователе agpu для сопоставления пользователю Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Была ли запись обработана';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'Сообщение об ошибке (если есть)';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'Логин пользователя agpu.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'Логин пользователя Microsoft 365.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Нужно ли переключать пользователя на аутентификацию OpenID Connect, когда соответствие выполнено';
$string['privacy:metadata:local_o365_objects'] = 'MicrosoftИнформация о связях между объектами agpu и Office 365';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Любые связанные метаданные';
$string['privacy:metadata:local_o365_objects:agpuid'] = 'ID объекта в agpu';
$string['privacy:metadata:local_o365_objects:o365name'] = 'Удобочитаемое имя объекта в Microsoft 365';
$string['privacy:metadata:local_o365_objects:objectid'] = 'ID объекта Microsoft 365';
$string['privacy:metadata:local_o365_objects:subtype'] = 'Подтип объекта.';
$string['privacy:metadata:local_o365_objects:tenant'] = 'Клиент, которому принадлежит объект (в многопользовательской среде)';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'Время создания записи.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'Время изменения записи.';
$string['privacy:metadata:local_o365_objects:type'] = 'Тип объекта (группа, пользователь, курс и т.д.)';
$string['privacy:metadata:local_o365_token'] = 'Информация о ключах API Microsoft 365 для пользователей';
$string['privacy:metadata:local_o365_token:expiry'] = 'Время истечения ключа';
$string['privacy:metadata:local_o365_token:token'] = 'Токен';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'Ресурс токена.';
$string['privacy:metadata:local_o365_token:user_id'] = 'ID пользователя agpu';
$string['settings_addsync_tzsync'] = 'Синхронизировать часовой пояс Outlook и agpu при выполнении cron.';
$string['settings_addsync_tzsynconlogin'] = 'Синхронизировать часовой пояс Outlook и agpu при входе.';
$string['settings_adminconsent'] = 'Согласие администратора';
$string['settings_adminconsent_btn'] = 'Предоставить согласие администратора';
$string['settings_adminconsent_details'] = 'Чтобы разрешить доступ к некоторым необходимым разрешениям, необходимо предоставить согласие администратора. Нажмите эту кнопку, затем войдите в систему с учетной записью администратора Azure, чтобы дать согласие. Это необходимо делать всякий раз, когда вы меняете разрешения «Администратор» в Azure.';
$string['settings_check_agpu_settings'] = 'Проверить настройки agpu';
$string['settings_course_reset_teams_details'] = 'Действия, которые должны быть выполнены в связанной с курсом Команде или Группе при очистке курса.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Ничего не делать. <br/> Команда или группа все еще связаны с курсом. Отчисление пользователя приведет к его удалению из Команды или Группы.';
$string['settings_course_reset_teams_option_force_archive'] = 'Отключить Команду или Группу от курса и создать новую. <br/> Существующая Команда или Группа, связанная с курсом, будет переименована в соответствии с настройками. Если команда связана с курсом, то она будет заархивирована. Будет создана новая команда или группа, которая подключится к курсу.';
$string['settings_course_reset_teams_option_per_course'] = 'Разрешить настройки для курса. <br/> Для этого необходимо добавить в курс блок Microsoft. Пользователи с правом очистки курса в блоке могут выбрать, что делать при очистке курса.';
$string['settings_customtheme'] = 'Пользовательская тема (Продвинутая)';
$string['settings_customtheme_desc'] = 'Рекомендуемая тема - «boost_o365teams». Однако вы можете выбрать другую имеющуюся настраиваемую тему, адаптированную для использования на вкладке «Команды». <br/>
Обратите внимание, что настраиваемая тема, установленная на уровне курса или категории, будет иметь приоритет над этими настройками. То есть курс будет  по умолчанию использовать тему курса или категории в приложении agpu в Teams. Это можно изменить, обновив $CFG->themeorder в config.php на «array (\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');».';
$string['settings_debugmode'] = 'Запись сообщений об отладке';
$string['settings_debugmode_details'] = 'Если этот параметр включен, в журнал agpu будет заноситься информация, которая может помочь в выявлении проблем. <a href="{$a}">Просмотр сообщений журнала.</a>';
$string['settings_detectoidc'] = 'Учетные данные приложения';
$string['settings_detectoidc_credsinvalid'] = 'Учетные данные не были установлены или являются неполными.';
$string['settings_detectoidc_credsvalid'] = 'Учетные данные были установлены.';
$string['settings_detectoidc_details'] = 'agpu нужны учетные данные, чтобы идентифицировать себя при взаимодействии с Microsoft 365. Они устанавливаются в плагине аутентификации OpenID Connect.';
$string['settings_detectperms'] = 'Разрешения приложений';
$string['settings_detectperms_details'] = 'При использовании функций плагина в Azure AD для приложения должны быть установлены правильные разрешения.';
$string['settings_detectperms_errorfix'] = 'Произошла ошибка при попытке исправить разрешения. Пожалуйста, установите вручную в Azure AD.';
$string['settings_detectperms_fixperms'] = 'Исправить разрешения';
$string['settings_detectperms_invalid'] = 'Проверить разрешения в Azure AD';
$string['settings_detectperms_missing'] = 'Отсутствуют:';
$string['settings_detectperms_nocreds'] = 'Учетные данные приложения должны быть установлены в первую очередь. См. настройки  выше.';
$string['settings_detectperms_nounified'] = 'Microsoft Graph API отсутствует, некоторые новые функции могут не работать.';
$string['settings_detectperms_unifiednomissing'] = 'Все унифицированные разрешения присутствуют.';
$string['settings_detectperms_update'] = 'Обновить';
$string['settings_detectperms_valid'] = 'Разрешения были установлены.';
$string['settings_download_teams_tab_app_manifest'] = 'Загрузить файл манифеста';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Сохраните все ваши изменения перед загрузкой манифеста.';
$string['settings_fieldmap'] = 'Сопоставление полей пользователя';
$string['settings_fieldmap_details'] = 'Доступно в <a href="{$a}">плагине аутентификации OpenID Connect</a>.';
$string['settings_group_mail_alias_course'] = 'Атрибут курса в почтовом псевдониме группы';
$string['settings_group_mail_alias_suffix'] = 'Суффикс почтового псевдонима группы';
$string['settings_header_advanced'] = 'Расширенные настройки';
$string['settings_header_agpu_app'] = 'Приложение Teams agpu';
$string['settings_header_sds'] = 'Синхронизации сведений о школе (предварительный просмотр)';
$string['settings_header_setup'] = 'Установка';
$string['settings_header_syncsettings'] = 'Настройки синхронизации';
$string['settings_header_teams'] = 'Настройки Teams';
$string['settings_header_tools'] = 'Инструменты';
$string['settings_healthcheck'] = 'Проверка работоспособности';
$string['settings_healthcheck_details'] = 'Если что-то не работает должным образом, проверка работоспособности обычно позволяет определить проблему и предложить решения.';
$string['settings_healthcheck_linktext'] = 'Выполнить проверку работоспособности';
$string['settings_main_name_option_full_name'] = 'Полное название';
$string['settings_main_name_option_id'] = 'Созданный agpu ID';
$string['settings_main_name_option_id_number'] = 'Номер ID';
$string['settings_main_name_option_short_name'] = 'Краткое название';
$string['settings_maintenance'] = 'Обслуживание';
$string['settings_maintenance_details'] = 'Различные задачи обслуживания доступны для решения некоторых распространенных проблем.';
$string['settings_maintenance_linktext'] = 'Просмотр инструментов обслуживания';
$string['settings_agpu_app_id'] = 'ID приложения agpu';
$string['settings_agpu_app_id_desc'] = 'Идентификатор загруженного приложения agpu в каталогах приложений Teams. <br/>
Если настроено, agpu попытается создать вкладку agpu со ссылкой на курс agpu в канале «Общие» созданной (связанной) команды.';
$string['settings_agpu_app_id_desc_auto_id'] = '<br/>
Автоматически определяемое значение: «<span class="local_o365_settings_agpu_app_id">{$a}</span>».';
$string['settings_agpusettingssetup'] = 'Настройка agpu';
$string['settings_agpusettingssetup_details'] = 'Это обеспечит следующее:
<ul class = "local_o365_settings_teams_horizontal_spacer">
<li> Open ID включен. </li>
<li> Встраивание фрейма включено. </li>
<li> Веб-службы включены. </li>
<li> Rest-протокол включен. </li>
<li> Веб-службы Microsoft 365 включены. </li>
<li> У аутентифицированного пользователя есть разрешение на создание токена веб-службы. </li>
<li> У аутентифицированного пользователя есть разрешение на использование Rest-протокола. </li>
</ul>';
$string['settings_agpusetup_checking'] = 'Проверяется ...';
$string['settings_notice_createtokenallowed'] = 'Разрешение на создание токена веб-службы предоставлено';
$string['settings_notice_createtokenalreadyallowed'] = 'Разрешение на создание токена веб-службы уже предоставлено';
$string['settings_notice_createtokennotallowed'] = 'Возникла проблема с предоставлением разрешения на создание токена веб-службы.';
$string['settings_notice_o365servicealreadyenabled'] = 'Веб-службы O365 уже были включены';
$string['settings_notice_o365serviceenabled'] = 'Веб-службы O365 успешно включены';
$string['settings_notice_oidcalreadyenabled'] = 'Open ID Connect уже был включен';
$string['settings_notice_oidcenabled'] = 'Open ID Connect успешно включен';
$string['settings_notice_oidcnotenabled'] = 'Open ID Connect не может быть включен';
$string['settings_notice_restalreadyenabled'] = 'Протокол REST уже был включен';
$string['settings_notice_restenabled'] = 'Протокол REST успешно включен';
$string['settings_notice_restnotenabled'] = 'Протокол REST не может быть включен';
$string['settings_notice_restusageallowed'] = 'Разрешение на использование протокола REST предоставлено';
$string['settings_notice_restusagealreadyallowed'] = 'Разрешение на использование протокола REST уже было предоставлено';
$string['settings_notice_restusagenotallowed'] = 'Не удалось разрешить использование протокола REST.';
$string['settings_notice_webservicesframealreadyenabled'] = 'Веб-службы уже были включены, также разрешено и встраивание фреймов.';
$string['settings_notice_webservicesframeenabled'] = 'Веб-сервисы успешно включены, теперь также разрешено встраивание фреймов';
$string['settings_o365china'] = 'Microsoft 365 для Китая.';
$string['settings_o365china_details'] = 'Отметьте, если вы используете Microsoft 365 для Китая.';
$string['settings_odburl'] = 'URL OneDrive для бизнеса';
$string['settings_odburl_details'] = 'URL-адрес, используемый для доступа к OneDrive для бизнеса. Обычно это может быть определено вашим клиентом Azure AD. Например, если ваш клиент Azure AD - «contoso.onmicrosoft.com», это, скорее всего, «contoso-my.sharepoint.com». Введите только доменное имя, НЕ включайте http:// или https://';
$string['settings_odburl_error'] = 'Не удалось определить URL-адрес OneDrive для бизнеса. <br /> Убедитесь, что «Microsoft 365 SharePoint Online» добавлено в зарегистрированное приложение в Azure AD.';
$string['settings_odburl_error_graph'] = 'Не удалось определить URL-адрес OneDrive для бизнеса, введите его вручную. Обычно он совпадает с URL-адресом, который вы используете для доступа к OneDrive.';
$string['settings_options_usersync'] = 'Синхронизация пользователя';
$string['settings_options_usersync_desc'] = 'Следующие параметры управляют синхронизацией пользователей между Microsoft 365 и agpu.';
$string['settings_photoexpire'] = 'Время обновления фото пользователя';
$string['settings_photoexpire_details'] = 'Количество часов ожидания перед обновлением фотографий профиля. Более продолжительное время поможет увеличить производительность.';
$string['settings_publish_manifest_instruction'] = '<a href="https://docs.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Щелкните здесь, </a>чтобы узнать, как опубликовать загруженный файл манифеста приложения agpu для всех пользователей в Teams.';
$string['settings_reset_group_name_prefix'] = 'Префикс сброса имени группы';
$string['settings_reset_group_name_prefix_details'] = 'При очистке курса, связанного с группой, к имени существующей группы будет добавлен этот префикс.';
$string['settings_reset_team_name_prefix'] = 'Префикс сброса имени команды';
$string['settings_reset_team_name_prefix_details'] = 'При очистке курса, связанного с командой, к имени существующей связанной команды будет добавлен этот префикс.';
$string['settings_sds_coursecreation'] = 'Создание курса';
$string['settings_sds_coursecreation_desc'] = 'Эти параметры управляют созданием курса в agpu на основе информации в SDS.';
$string['settings_sds_coursecreation_enabled'] = 'Создать курсы';
$string['settings_sds_coursecreation_enabled_desc'] = 'Создать курсы для этих школ.';
$string['settings_sds_enrolment_enabled'] = 'Записать пользователей.';
$string['settings_sds_enrolment_enabled_desc'] = 'Записывать студентов и преподавателей на курсы, созданные из SDS.';
$string['settings_sds_intro_desc'] = 'Инструмент синхронизации сведений о школе («SDS») позволяет синхронизировать информацию, импортированную в Azure AD из внешних систем в agpu.<a href="https://sis.microsoft.com/" target="_blank">Подробнее ... </a><br /><br />Процесс синхронизации школьных данных происходит в Cron agpu в 3 часа ночи по местному серверному времени. Чтобы изменить это расписание, перейдите на <a href="{$a}"> страницу управления запланированными задачами..</a><br /><br />';
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Это функция предварительного просмотра </b> <br /> Функции предварительного просмотра могут работать не так, как задумано, или могут работать без предупреждения. Пожалуйста, используйте с осторожностью.</div>';
$string['settings_sds_noschools'] = '<div class="alert alert-info">У вас нет доступных школ в синхронизации сведений о школе.</div>';
$string['settings_sds_profilesync'] = 'Синхронизация данных профиля';
$string['settings_sds_profilesync_desc'] = 'Эти параметры управляют синхронизацией данных профиля между данными SDS и agpu.';
$string['settings_secthead_advanced'] = 'Расширенные настройки';
$string['settings_secthead_advanced_desc'] = 'Эти настройки управляют другими функциями пакета плагинов. Будьте осторожны! Это может привести к непредвиденным последствиям.';
$string['settings_secthead_coursesync'] = 'Синхронизация курса';
$string['settings_secthead_coursesync_desc'] = 'Нижеследующие настройки управляют синхронизацией курса между agpu и командой/группой Microsoft 365.';
$string['settings_serviceresourceabstract_detect'] = 'Определить';
$string['settings_serviceresourceabstract_detecting'] = 'Определяется...';
$string['settings_serviceresourceabstract_empty'] = 'Пожалуйста, введите значение или нажмите «Определить», чтобы попытаться определить правильное значение.';
$string['settings_serviceresourceabstract_error'] = 'Произошла ошибка при определении настройки. Пожалуйста, установите вручную.';
$string['settings_serviceresourceabstract_invalid'] = 'Это значение не может использоваться.';
$string['settings_serviceresourceabstract_nocreds'] = 'Сначала установите учетные данные приложения.';
$string['settings_serviceresourceabstract_valid'] = '{$a} можно использовать.';
$string['settings_set_agpu_app_id_instruction'] = 'Чтобы найти ID приложения agpu вручную, выполните следующие действия:
<ol>
<li> Загрузите загруженный файл манифеста в каталог приложений Teams вашего клиента. </li>
<li> Найдите приложение в каталоге приложений Teams. </li>
<li> Щелкните значок параметра приложения, расположенный в правом верхнем углу изображения приложения. </li>
<li> Нажмите "Копировать ссылку". </li>
<li> В текстовом редакторе вставьте скопированный контент. Он должен содержать URL-адрес, например https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff. </li>
</ol>
Последняя часть URL-адреса, то есть <span class="local_o365_settings_agpu_app_id">00112233-4455-6677-8899-aabbccddeeff</span> является идентификатором приложения.';
$string['settings_setup_step1'] = 'Шаг 1/3: Регистрация agpu в Azure AD';
$string['settings_setup_step1_continue'] = '<b>После ввода идентификатора приложения и ключа для продолжения нажмите внизу страницы «Сохранить изменения». </b><br /><br /><br /><br /><br />';
$string['settings_setup_step1_credentials_end'] = 'Если вы не можете настроить приложение AzureAD через PowerShell, <a href="https://aka.ms/agpuTeamsManualSetup" target="_blank">щелкните здесь</a> для получения инструкций по ручной настройке. Примечание: Эти настройки сохраняются в плагине аутентификации OpenID Connect. Чтобы настроить дополнительные параметры входа в систему, перейдите на  <a href="{$a->oidcsettings}"> страницу настроек OpenID Connect</a><br /><br />';
$string['settings_setup_step1_desc'] = 'Зарегистрируйте новое приложение Azure AD для своего клиента Microsoft 365 с помощью Windows PowerShell:

 <a href="{$a}/local/o365/scripts/agpu-AzureAD-Powershell.zip" class="btn btn-primary" target="_blank">Download PowerShell Script</a>

 <p style="margin-top:10px"><a href="https://aka.ms/agpuTeamsPowerShellReadMe" target="_blank">Щелкните здесь</a>, чтобы прочитать инструкцию по запуску скрипта. Используйте следующую ссылку в качестве URL agpu:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />После успешного выполнения сценария скопируйте возвращенные сценарием идентификатор приложения и ключ приложения в ниже расположенные поля:';
$string['settings_setup_step2'] = 'Шаг 2/3: Выбор способа подключения';
$string['settings_setup_step2_desc'] = 'В этом разделе вы можете выбрать способ подключения пакета интеграции Microsoft 365 к службам Microsoft 365.<br />
Исторически интеграция могла подключаться к службам Microsoft 365 с помощью «Доступ приложения» или от имени пользователя, которого вы назначили «системным» пользователем.<br />
<b>С марта 2022 г. поддерживается только "Доступ приложения". Все будущие новые функции будут реализовываться и тестироваться только с использованием метода подключения "Доступ приложения".</b>';
$string['settings_setup_step3'] = 'Шаг 3/3: Согласие администратора и дополнительная информация';
$string['settings_setup_step3_desc'] = 'Этот последний шаг позволяет администратору дать согласие на использование некоторых разрешений Azure и собрать дополнительную информацию о вашей среде Microsoft 365. <br /> <br />';
$string['settings_switchauthminupnsplit0'] = 'Минимальная длина не совпадающего имени пользователя Microsoft 365 для изменения';
$string['settings_switchauthminupnsplit0_details'] = 'При включенной настройке «Изменять сопоставляемых пользователей Microsoft 365» этот параметр устанавливает минимальную длину для имен пользователей без домена клиента (часть @ example.onmicrosoft.com), которая будет меняться. Это помогает избежать изменения учетных записей с общими именами, такими как «admin», которые не обязательно совпадают в agpu и Azure AD.';
$string['settings_team_name_course'] = 'Атрибут курса в названии команды';
$string['settings_team_name_prefix'] = 'Префикс названия команд';
$string['settings_team_name_sample'] = 'Предположим, что у курса есть:
<ul>
<li>Полное имя: <b>Образец курса</b>
<li>Краткое имя: <b>образец 15</b></li>
<li>Созданный agpu ID: <b>2</b></li>
<li>Номер ID: <b>ID образца 15</b></li>
</ul>
В ваших текущих настройках для создания команды будет использоваться имя "<b>{$a}</b>". Нажмите ниже кнопку «Сохранить изменения», чтобы увидеть, как ваши настройки изменят его.';
$string['settings_team_name_suffix'] = 'Суффикс названия команд';
$string['settings_team_name_sync'] = 'Обновить названия команд при обновлении курса';
$string['settings_team_name_sync_desc'] = 'Если этот параметр включен, то при обновлении курса agpu название команды будет обновлено в соответствии с последними настройками названия команд.';
$string['settings_teamconnections'] = 'Связи команд';
$string['settings_teamconnections_details'] = 'Просматривайте и управляйте связями между курсом agpu и Microsoft Teams.';
$string['settings_teamconnections_linktext'] = 'Управление связями команд';
$string['settings_teams_agpu_app_external_id'] = 'ID приложения Microsoft для приложения agpu Teams';
$string['settings_teams_agpu_app_external_id_desc'] = 'Следует установить значение по умолчанию, если вашему клиенту не требуется несколько приложений agpu Teams для подключения к разным сайтам agpu.';
$string['settings_teams_agpu_app_short_name'] = 'Название приложения Teams';
$string['settings_teams_agpu_app_short_name_desc'] = 'Можно установить значение по умолчанию, если вашему клиенту не требуется несколько приложений agpu Teams для подключения к разным сайтам agpu.';
$string['settings_teams_agpu_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer"> Настройте свое приложение agpu для Microsoft Teams </h4>';
$string['settings_tools_tenants'] = 'Клиенты';
$string['settings_tools_tenants_details'] = 'Управление доступом к дополнительным клиентам Microsoft 365.';
$string['settings_tools_tenants_linktext'] = 'Настройки дополнительных клиентов';
$string['settings_userconnections'] = 'Связи пользователей';
$string['settings_userconnections_details'] = 'Просмотр и управление связями между пользователями agpu и Microsoft 365.';
$string['settings_userconnections_linktext'] = 'Управление связями пользователей';
$string['settings_usermatch'] = 'Сопоставление пользователя';
$string['settings_usermatch_details'] = 'Этот инструмент позволяет сопоставлять пользователей agpu с пользователями Microsoft 365 на основе загруженного файла с данными пользователей.';
$string['settings_usersynccreationrestriction'] = 'Ограничения создания пользователя';
$string['settings_usersynccreationrestriction_details'] = 'Если этот параметр включен, то во время синхронизации пользователей будут создаваться только пользователи, имеющие указанное значение для указанного поля Azure AD.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Значение поля';
$string['settings_usersynccreationrestriction_o365group'] = 'Членство в группе Microsoft 365';
$string['settings_usersynccreationrestriction_regex'] = 'Значение является регулярным выражением';
$string['spsite_group_contributors_desc'] = 'Все пользователи, которые имеют доступ к управлению файлами для курса {$a}';
$string['sso_login'] = 'Вход в Microsoft 365';
$string['tab_name'] = 'Название вкладки';
$string['task_calendarsyncin'] = 'Синхронизировать события Office 365 в agpu';
$string['task_coursesync'] = 'Синхронизировать курсы agpu с Microsoft Teams';
$string['task_processmatchqueue'] = 'Процесс очередности сопоставлений';
$string['task_processmatchqueue_err_museralreadymatched'] = 'Пользователь agpu уже сопоставлен пользователю Microsoft 365.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'Пользователь agpu уже связан с Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'Пользователь agpu с таким логином не найден.';
$string['task_processmatchqueue_err_noo365user'] = 'Пользователь Microsoft 365 с таким логином не найден.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'Пользователь Microsoft 365 уже связан с пользователем agpu.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'Пользователь Microsoft 365 уже сопоставлен с пользователем agpu.';
$string['task_sds_sync'] = 'Синхронизация с SDS';
$string['task_syncusers'] = 'Синхронизация пользователей с Azure AD';
$string['teams_no_course'] = 'Нет курсов для добавления';
$string['ucp_calsync_availcal'] = 'Доступные календари agpu';
$string['ucp_calsync_desc'] = 'Выбранные календари будут синхронизироваться из agpu с вашим календарем Outlook.';
$string['ucp_calsync_title'] = 'Настройки синхронизации календаря Outlook';
$string['ucp_connection_desc'] = 'Здесь вы можете настроить способ подключения к Microsoft 365. Для использования функций Microsoft 365 необходимо подключиться к учетной записи Microsoft 365.  Ниже указано, как это может быть достигнуто.';
$string['ucp_connection_disconnected'] = 'Вы не подключены к Microsoft 365.';
$string['ucp_connection_linked'] = 'Свяжите свои учетные записи agpu и Microsoft 365';
$string['ucp_connection_linked_active'] = 'Вы связаны с учетной записью Microsoft 365 «{$a}».';
$string['ucp_connection_linked_desc'] = 'Связывание учетных записей agpu и Microsoft 365 позволит вам использовать в agpu функции Microsoft 365 без изменения способа входа в agpu. <br /> Нажав ниже на ссылку, вы отправитесь в Microsoft 365 для одноразового входа, после чего вернетесь сюда. Вы сможете использовать все функции Microsoft 365, не внося никаких других изменений в свою учетную запись agpu - вы будете входить в agpu как всегда.';
$string['ucp_connection_linked_migrate'] = 'Переключиться на связанный аккаунт';
$string['ucp_connection_linked_start'] = 'Связать свою учетную запись agpu с учетной записью Microsoft 365.';
$string['ucp_connection_linked_stop'] = 'Отменить связь своей учетной записи agpu с учетной записью Microsoft 365.';
$string['ucp_connection_options'] = 'Параметры подключения:';
$string['ucp_connection_start'] = 'Подключиться к Microsoft 365';
$string['ucp_connection_status'] = 'Подключение к Microsoft 365:';
$string['ucp_connection_stop'] = 'Отключиться от Microsoft 365';
$string['ucp_connectionstatus'] = 'Состояние подключения';
$string['ucp_features'] = 'Возможности Microsoft 365';
$string['ucp_features_intro'] = 'Ниже приведен список возможностей Microsoft 365, которые можно использовать для улучшения agpu.';
$string['ucp_features_intro_notconnected'] = 'Некоторые из них могут быть недоступны, пока вы не подключитесь к Microsoft 365.';
$string['ucp_general_intro'] = 'Здесь вы можете управлять своим подключением к Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Чтобы подключиться к Microsoft 365, вам необходимо связаться с администратором сайта.';
$string['ucp_index_calendar_desc'] = 'Здесь вы можете настроить синхронизацию между календарями agpu и Outlook. Вы можете экспортировать события календаря agpu в Outlook и переносить события Outlook в agpu.';
$string['ucp_index_calendar_title'] = 'Настройки синхронизации календаря Outlook';
$string['ucp_index_connection_desc'] = 'Настроить подключение к Microsoft 365.';
$string['ucp_index_connection_title'] = 'Настройки подключения к Microsoft 365';
$string['ucp_index_connectionstatus_connect'] = 'Нажмите здесь для подключения.';
$string['ucp_index_connectionstatus_connected'] = 'В настоящее время вы подключены к Microsoft 365';
$string['ucp_index_connectionstatus_disconnect'] = 'Отключить';
$string['ucp_index_connectionstatus_login'] = 'Нажмите здесь для входа.';
$string['ucp_index_connectionstatus_manage'] = 'Управление подключением';
$string['ucp_index_connectionstatus_matched'] = 'Вы сопоставлены с пользователем Microsoft 365 <small> "{$a}" </small>. Чтобы завершить подключение, перейдите по ссылке ниже и войдите в Microsoft 365.';
$string['ucp_index_connectionstatus_notconnected'] = 'В данный момент вы не подключены к Microsoft 365';
$string['ucp_index_connectionstatus_reconnect'] = 'Обновить подключение';
$string['ucp_index_connectionstatus_title'] = 'Состояние подключения';
$string['ucp_index_connectionstatus_usinglinked'] = 'Вы связаны с учетной записью Microsoft 365.';
$string['ucp_index_connectionstatus_usinglogin'] = 'В настоящее время вы используете Microsoft 365 для входа в agpu.';
$string['ucp_index_onenote_desc'] = 'Интеграция OneNote позволяет использовать OneNote Microsoft 365 в agpu. Вы можете выполнять задания с помощью OneNote и легко делать заметки для своих курсов.';
$string['ucp_index_onenote_title'] = 'OneNote';
$string['ucp_notconnected'] = 'Перед посещением подключитесь к Microsoft 365.';
$string['ucp_o365accountconnected'] = 'Эта учетная запись Microsoft 365 уже связана с другой учетной записью agpu.';
$string['ucp_options'] = 'Опции';
$string['ucp_status_disabled'] = 'Нет подключено';
$string['ucp_status_enabled'] = 'Активно';
$string['ucp_syncdir_both'] = 'Обновить Outlook и agpu';
$string['ucp_syncdir_in'] = 'Из Outlook в agpu';
$string['ucp_syncdir_out'] = 'Из agpu в Outlook';
$string['ucp_syncdir_title'] = 'Поведение синхронизации:';
$string['ucp_syncwith_title'] = 'Название календаря Outlook для синхронизации:';
$string['ucp_title'] = 'Microsoft 365 / Панель управления agpu';
$string['webservices_error_assignnotfound'] = 'Запись о задании не найдена.';
$string['webservices_error_couldnotsavegrade'] = 'Не удалось сохранить оценку.';
$string['webservices_error_invalidassignment'] = 'Задание с полученным ID нельзя использовать с этой функцией веб-сервисов.';
$string['webservices_error_modulenotfound'] = 'Модуль с полученным ID  не найден';
$string['webservices_error_sectionnotfound'] = 'Раздел курса не может быть найден.';
