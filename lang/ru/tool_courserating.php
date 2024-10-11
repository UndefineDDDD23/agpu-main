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
 * Strings for component 'tool_courserating', language 'ru', version '4.5'.
 *
 * @package     tool_courserating
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['addrating'] = 'Оценить';
$string['barwithrating'] = '{$a->rating} звездочка представляет {$a->percent} рейтинга';
$string['cannotrate'] = 'У вас нет разрешения поставить оценку этому курсу';
$string['cannotview'] = 'У вас недостаточно прав для просмотра оценок этого курса.';
$string['cfielddescription'] = 'Не редактируйте, содержимое будет заполняться автоматически каждый раз, когда кто-то поставит оценку этому курсу';
$string['colorrating'] = 'Цвет рейтинга';
$string['colorratingconfig'] = 'Обычно он немного темнее цвета звезды для лучшего визуального восприятия.';
$string['colorstar'] = 'Цвет звезд';
$string['courserating:delete'] = 'Удалять рейтинги и обзоры курса, просматривать отмеченные отзывы';
$string['courserating:rate'] = 'Оценить курс';
$string['courserating:reports'] = 'Просматривать отчеты о рейтингах курса';
$string['coursereviews'] = 'Отзыв о курсе';
$string['datasource_courseratings'] = 'Рейтинг курса';
$string['deleterating'] = 'Удалить навсегда';
$string['deletereason'] = 'Причина для удаления';
$string['displayempty'] = 'Не отображать рейтинг с серыми звездочками';
$string['displayemptyconfig'] = 'Для курсов, где рейтинг включен, но еще нет оценок, отображаются серые звездочки. Если параметр не выбран, рейтинг таких курсов вообще не будет отображаться.';
$string['editrating'] = 'Изменить оценку';
$string['entity_rating'] = 'Оценка курса пользователем';
$string['entity_summary'] = 'Общий рейтинг курса';
$string['event:flag_created'] = 'Рейтинг курса помечен';
$string['event:flag_deleted'] = 'Пометка рейтинга курса снята';
$string['event:rating_created'] = 'Оценка курса создана';
$string['event:rating_deleted'] = 'Оценка курса удалена';
$string['event:rating_updated'] = 'Оценка курса обновлена';
$string['flagrating'] = 'Флаг';
$string['parentcss'] = 'Селектор CSS для родительского элемента';
$string['parentcssconfig'] = 'Рейтинг курса будет отображаться на странице курса как последний дочерний элемент DOM, соответствующий этому селектору. Возможно, вам придется переопределить его, если на сайте используется пользовательская тема и вы хотите указать собственный родительский элемент. Если оставить пустым, будет использоваться значение по умолчанию. Для agpu 4.0 по умолчанию используется "#page-header", для agpu 3.11 по умолчанию используется "#page-header .card-body, #page-header #course-header, #page-header".';
$string['percourseoverride'] = 'Переопределение курса';
$string['percourseoverrideconfig'] = 'Если включено, будет создано пользовательское поле курса, которое позволит установить, когда каждый отдельный курс может быть оценен. Значение параметра «Когда можно оценивать курсы» будет считаться значением по умолчанию.';
$string['pluginname'] = 'Оценка курса';
$string['privacy:metadata:tool_courserating:reason'] = 'Причина';
$string['privacy:metadata:tool_courserating:reasoncode'] = 'Код причины';
$string['privacy:metadata:tool_courserating:timecreated'] = 'Время создания';
$string['privacy:metadata:tool_courserating:timemodified'] = 'Время изменения';
$string['privacy:metadata:tool_courserating_flag'] = 'Помеченные рейтинги';
$string['privacy:metadata:tool_courserating_flag:id'] = 'Id';
$string['privacy:metadata:tool_courserating_flag:ratingid'] = 'Id оценки';
$string['privacy:metadata:tool_courserating_flag:userid'] = 'Id пользователя';
$string['privacy:metadata:tool_courserating_rating'] = 'Оценки курса';
$string['privacy:metadata:tool_courserating_rating:cohortid'] = 'Id курса';
$string['privacy:metadata:tool_courserating_rating:hasreview'] = 'Есть отзыв';
$string['privacy:metadata:tool_courserating_rating:id'] = 'Id';
$string['privacy:metadata:tool_courserating_rating:rating'] = 'Оценка';
$string['privacy:metadata:tool_courserating_rating:review'] = 'Отзыв';
$string['privacy:metadata:tool_courserating_rating:timecreated'] = 'Время создания';
$string['privacy:metadata:tool_courserating_rating:timemodified'] = 'Время изменения';
$string['privacy:metadata:tool_courserating_rating:userid'] = 'Пользователь';
$string['ratebyanybody'] = 'Студент может оценить курс в любое время';
$string['ratebycompleted'] = 'Студент может оценить только после завершения курса';
$string['ratebydefault'] = 'Значение по умолчанию: "{$a}"';
$string['ratebynoone'] = 'Оценивание курса выключено';
$string['ratedcategory'] = 'Категории, в которых разрешено оценивание курсов';
$string['rating'] = 'Оценка';
$string['rating_actions'] = 'Действия';
$string['rating_hasreview'] = 'Есть обзор';
$string['rating_nofflags'] = 'Количество флагов';
$string['rating_rating'] = 'Рейтинг курса';
$string['rating_review'] = 'Обзор';
$string['rating_timecreated'] = 'Время создания';
$string['rating_timemodified'] = 'Время изменения';
$string['ratingasstars'] = 'Рейтинг курса в виде звезд';
$string['ratingdeleted'] = 'Рейтинг удален';
$string['ratinglabel'] = 'Оценка курса';
$string['ratingmode'] = 'Когда курсы могут быть оценены';
$string['ratingmodeconfig'] = 'Дополнительно проверяется возможность оценивать курсы';
$string['reindextask'] = 'Переиндексировать оценки курса';
$string['review'] = 'Отзыв (не обязательно)';
$string['revokeratingflag'] = 'Отозвать';
$string['settingsdescription'] = 'Изменение некоторых настроек может потребовать переиндексации всех курсов и рейтингов курсов. Это произойдет автоматически при следующем запуске cron.';
$string['showallratings'] = 'Показать все';
$string['showmorereviews'] = 'Показать больше';
$string['summary_avgrating'] = 'Рейтинг курса';
$string['summary_cnt01'] = 'Доля 1-звездочных оценок';
$string['summary_cnt02'] = 'Доля 2-звездочных оценок';
$string['summary_cnt03'] = 'Доля 3-звездочных оценок';
$string['summary_cnt04'] = 'Доля 4-звездочных оценок';
$string['summary_cnt05'] = 'Доля 5-звездочных оценок';
$string['summary_cntall'] = 'Количество оценок';
$string['summary_cntreviews'] = 'Количество отзывов';
$string['summary_ratingmode'] = 'Режим рейтинга курса';
$string['summary_sumrating'] = 'Итоговый рейтинг';
$string['usehtml'] = 'Использовать текстовый редактор с форматированием для обзоров';
$string['usehtmlconfig'] = 'Разрешить студентам использовать редактор форматированного текста для обзоров, включать ссылки и прикреплять файлы.';
$string['usersflagged'] = 'Пользователи ({$a}) пометили этот отзыв как неприемлемый/оскорбительный.';
$string['viewallreviews'] = 'Показать все отзывы';
$string['youflagged'] = 'Вы отметили этот отзыв как неприемлемый/оскорбительный.';
