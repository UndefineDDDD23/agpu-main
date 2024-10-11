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
 * Strings for component 'quizaccess_proctoring', language 'ru', version '4.5'.
 *
 * @package     quizaccess_proctoring
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['actions'] = 'Действия';
$string['additionalsettingspagetitle'] = 'Все отчеты прокторинга';
$string['buttonlabel:deletebutton'] = 'Удалить рисунки';
$string['camhtml'] = '<div class="camera"> <video id="video">Видеопоток не доступен.</video></div> <canvas id="canvas" style="display:none;"> </canvas> <img style="display:none;" id="photo" alt="В этом окне появится снимок экрана."/>';
$string['cancel_image_upload'] = 'Отмена загрузки изображений';
$string['coursenameheader'] = 'Название курса';
$string['dateverified'] = 'Дата и время';
$string['eprotroringreports'] = 'Отчет по прокторингу для:';
$string['eprotroringreportsdesc'] = 'В этом отчёте вы найдёте все фотографии студентов, которые были сделаны во время экзамена. Теперь вы можете подтвердить их личности, сравнивая фотографии их профиля и фотографии с веб-камеры.';
$string['event:screenshotcreated'] = 'Новый снимок сделан';
$string['event:screenshotupdated'] = 'Снимок обновлен';
$string['event:takescreenshot'] = 'Сделан снимок';
$string['mainsettingspagebtn'] = 'Настройки прокторинга';
$string['modal:validateface'] = 'Проверка распознавания лиц';
$string['name'] = 'Имя студента';
$string['no_permission'] = 'У вас нет разрешения для просмотра этой страницы';
$string['notpermissionreport'] = 'Отчеты о прохождении прокторинга для вас отключены.';
$string['notrequired'] = 'не обязательный';
$string['openwebcam'] = 'Разрешить веб-камеру и общий экран для продолжения работы';
$string['picturesreport'] = 'Посмотреть отчет о прокторинге';
$string['picturesusedreport'] = 'Есть фотографии, снятые во время тестирования.';
$string['pluginname'] = 'Прокторинг';
$string['privacy:core_files'] = 'Изображения с веб-камеры QuizAccess Proctoring';
$string['privacy:metadata'] = 'Мы не передаем никакие личные данные третьим лицам.';
$string['privacy:metadata:core_files'] = 'Quiz Access сохраняет изображение пользователя, которое было снято веб-камерой во время попытки прохождения теста.';
$string['privacy:metadata:courseid'] = 'ID курса, в котором используется прокторинг.';
$string['proctoring:viewreport'] = 'Просмотр отчета прокторинга';
$string['proctoringheader'] = '<strong>Чтобы продолжить эту попытку теста, вы должны использовать веб-камеру для контроля хода экзамена.</strong>';
$string['proctoringlabel'] = 'Я согласен с процессом проверки.';
$string['proctoringrequired'] = 'Проверка подлинности веб-камерой';
$string['proctoringrequired_help'] = 'Если вы включите этот параметр, студенты не смогут начать попытку, пока не отметят галочкой опцию, подтверждающую, что они осведомлены о политике использования веб-камеры.';
$string['proctoringrequiredoption'] = 'должно быть принято перед началом попытки';
$string['proctoringstatement'] = 'Этот экзамен требует совместного доступа к экрану и веб-камере.<br /> (Пожалуйста, поделитесь экраном и разрешите доступ к веб-камере).';
$string['provide_image'] = 'Вы должны предоставить изображение выбранного студента';
$string['quizaccess_proctoring'] = 'Прокторинг доступа к тесту';
$string['quiznameheader'] = 'Название теста';
$string['reportidheader'] = 'ID отчета';
$string['setting:camshotdelay'] = 'Задержка между снимками в секундах';
$string['setting:camshotdelay_desc'] = 'Данное значение будет задержкой в секундах между снимками.';
$string['setting:camshotwidth'] = 'Ширина снимка в пикселях.';
$string['setting:camshotwidth_desc'] = 'Заданное значение будет шириной снимка. Высота изображения будет масштабирована в соответствии с этим значением';
$string['setting:externalpage'] = 'Внешняя страница';
$string['setting:proctoringreconfigureproctoring'] = 'Автонастройка прокторинга';
$string['setting:proctoringreconfigureproctoring_desc'] = 'При включенном параметре  веб-камерой автоматически делаются снимки пользователей, которые переходят к тесту.';
$string['settings:deleteallconfirm'] = 'Вы действительно хотите УДАЛИТЬ ВСЕ ИЗОБРАЖЕНИЯ ВСЕХ ТЕСТОВ.';
$string['settings:deleteallformlabel'] = 'Нажав кнопку «Удалить все изображения» вы удалите все изображения для всех тестов.';
$string['settings:deleteallsuccess'] = 'Все изображения удалены.';
$string['settings:deleteuserimagesuccess'] = 'Изображения студента удалены.';
$string['settings:updatesuccess'] = 'Настройки прокторинга успешно обновлены';
$string['settingscontroll:deleteall'] = 'Очистить все данные прокторинга';
$string['settingscontroll:save'] = 'Сохранить настройки';
$string['settingserror:formcancelled'] = 'Вы отменили отправку формы.';
$string['settingserror:imagedelay'] = 'Значение задержки между снимками может быть только целым числом';
$string['settingserror:imagewidth'] = 'Значение ширины изображения может быть только целым числом';
$string['status'] = 'Статус проверки';
$string['summarypagedesc'] = 'В этом отчете вы найдете сводный отчет о прохождении тестирования по курсу и тестам. Вы можете удалить все данные, относящиеся к тестам и курсам. При этом будет удален файл изображения, а также журналы.';
$string['timemodified'] = 'Последнее изменение';
$string['warning:cameraallowwarning'] = 'Разрешите доступ к камере.';
$string['webcampicture'] = 'Захваченные изображения';
$string['youmustagree'] = 'Перед продолжением Вы должны согласиться на подтверждение своей личности.';
