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
 * Strings for component 'qtype_essayautograde', language 'ru', version '4.5'.
 *
 * @package     qtype_essayautograde
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['addmultiplebands'] = 'Добавить еще диапазоны оценок - {$a}';
$string['addmultiplephrases'] = 'Добавить еще целевые фразы - {$a}';
$string['addpartialgrades'] = 'Присуждать неполные оценки?';
$string['addpartialgrades_help'] = 'Если этот параметр включен, оценки будут добавлены для частично заполненных диапазонов оценок.';
$string['addsingleband'] = 'Добавить еще 1 диапазон оценок';
$string['addsinglephrase'] = 'Добавить еще 1 целевую фразу';
$string['autograding'] = 'Автоматическая оценка';
$string['bandcount'] = 'Для';
$string['chars'] = 'Символы';
$string['charspersentence'] = 'Символов на предложение';
$string['commonerror'] = 'Распространенная ошибка';
$string['commonerrors'] = 'Распространенные ошибки';
$string['commonerrors_help'] = 'Распространенные ошибки определены в "Глоссарии ошибок", связанном с этим вопросом.';
$string['correctresponse'] = 'Чтобы получить полную оценку за этот вопрос, вы должны соответствовать следующим критериям:';
$string['countwordslabel'] = 'Текущее количество слов';
$string['enableautograde'] = 'Включить автоматическую оценку';
$string['enableautograde_help'] = 'Включить или отключить автоматическую оценку';
$string['errorbehavior'] = 'Поведение при согласовании ошибок';
$string['errorbehavior_help'] = 'Эти настройки уточняют поведение сопоставления для записей в Глоссарии распространенных ошибок.';
$string['errorcmid'] = 'Глоссарий ошибок';
$string['errorcmid_help'] = 'Выберите глоссарий, содержащий список распространенных ошибок.

Каждый раз, когда в ответе на эссе будет обнаружена одна из ошибок, указанный штраф будет вычтен из оценки студента за этот вопрос.';
$string['errorpercent'] = 'Штраф за ошибку';
$string['errorpercent_help'] = 'Выберите процент от общей оценки, который должен быть вычтен за каждую ошибку, обнаруженную в ответе.';
$string['excludecommonerrors'] = 'Не допускайте ни одной из распространенных ошибок в <a href="{$a->href}" target="_blank">{$a->name}</a>';
$string['explanationautopercent'] = 'Это выходит за рамки обычного процентного диапазона, поэтому он был скорректирован до {$a->autopercent}%.';
$string['explanationcommonerror'] = '{$a->percent}% за то, что он включает "{$a->error}", что является распространенной ошибкой';
$string['explanationcompleteband'] = '{$a->percent}% для завершения группы классов [{$a->gradeband}]';
$string['explanationdatetime'] = '%Y %b %d (%a) в %H:%M';
$string['explanationfiles'] = '{$a->percent}% за представление {$a->filecount} / {$a->itemcount} файлов';
$string['explanationfirstitems'] = '{$a->percent}% за первый {$a->count} {$a->itemtype}';
$string['explanationgrade'] = 'Таким образом, компьютерная оценка за это эссе была выставлена в размере {$a->finalgrade} = ({$a->finalpercent}% из {$a->maxgrade}).';
$string['explanationitems'] = '{$a->percent}% за {$a->count} {$a->itemtype}';
$string['explanationmaxgrade'] = 'Максимальная оценка за этот вопрос составляет {$a->maxgrade}.';
$string['explanationnotenough'] = '{$a->count} {$a->itemtype} меньше минимальной суммы, необходимой для получения оценки.';
$string['explanationoverride'] = 'Позже, {$a->datetime}, оценка за это эссе была выставлена вручную {$a->manualgrade}.';
$string['explanationpartialband'] = '{$a->percent}% за неполное заполнение группы классов [{$a->gradeband}]';
$string['explanationpenalty'] = '{$a->penaltytext} был вычтен за проверку ответа перед отправкой.';
$string['explanationrawpercent'] = 'Предварительная процентная оценка за это эссе равна {$a->rawpercent}% <br /> = ({$a->details}).';
$string['explanationremainingitems'] = '{$a->percent}% за остальные {$a->count} {$a->itemtype}';
$string['explanationseecomment'] = '(см. комментарий ниже)';
$string['explanationtargetphrase'] = '{$a->percent}% за использование фразы "{$a->phrase}"';
$string['feedback'] = 'Отзыв';
$string['feedbackhintbreaks'] = 'Вы использовали слишком много переносов строк?';
$string['feedbackhintchars'] = 'Написали ли вы необходимое количество символов?';
$string['feedbackhinterrors'] = 'Допускали ли вы какие-либо распространенные ошибки?';
$string['feedbackhintfiles'] = 'Приложили ли вы необходимое количество файлов?';
$string['feedbackhintparagraphs'] = 'Написали ли вы необходимое количество абзацев?';
$string['feedbackhintphrases'] = 'Включили ли вы все целевые фразы?';
$string['feedbackhints'] = 'Подсказки для улучшения вашей оценки';
$string['feedbackhintsentences'] = 'Написали ли вы необходимое количество предложений?';
$string['feedbackhintwords'] = 'Достигли ли вы цели по количеству слов?';
$string['files'] = 'Файлы';
$string['fogindex'] = 'Индекс тумана';
$string['fogindex_help'] = 'Индекс тумана Ганнинга - это показатель удобочитаемости. Он рассчитывается по следующей формуле.

* ((слова на предложение) + (длинные слова на предложение)) x 0,4

Для получения дополнительной информации см: <https://en.wikipedia.org/wiki/Gunning_fog_index>';
$string['forceupgrade'] = 'Принудительное обновление';
$string['gradeband'] = 'Диапазон оценивания [{no}]';
$string['gradeband_help'] = 'Укажите минимальное количество учитываемых элементов для применения этого диапазона, а также оценку, которая будет выставлена в случае применения этого диапазона.';
$string['gradebands'] = 'Диапазоны оценивания';
$string['gradecalculation'] = 'Вычисление оценки';
$string['gradeforthisquestion'] = 'Оценка за этот вопрос';
$string['hidesample'] = 'Скрыть пример';
$string['itemcount'] = 'Ожидаемое количество элементов';
$string['itemcount_help'] = 'Минимальное количество учитываемых элементов, которые должны быть в тексте эссе, чтобы получить максимальную оценку за этот вопрос.

Обратите внимание, что это значение может быть неэффективным из-за определенных ниже диапазонов оценок (если таковые имеются).';
$string['itemtype'] = 'Тип учитываемых элементов';
$string['itemtype_help'] = 'Выберите тип элементов в тексте эссе, которые будут участвовать в автооценке.';
$string['lexicaldensity'] = 'Лексическая плотность';
$string['lexicaldensity_help'] = 'Лексическая плотность - это процент, рассчитываемый по следующей формуле.

* 100 x (количество уникальных слов) / (общее количество слов).

Таким образом, эссе, в котором многие слова повторяются, имеет низкую лексическую плотность, в то время как эссе с большим количеством уникальных слов имеет высокую лексическую плотность.';
$string['longwords'] = 'Длинные слова';
$string['longwords_help'] = '"Длинные слова" - это слова, состоящие из трех и более слогов. Обратите внимание, что алгоритм определения количества слогов дает лишь приблизительные результаты.';
$string['longwordspersentence'] = 'Длинные слова в предложении';
$string['maximumfilecount'] = 'Максимальное количество файлов: {$a}';
$string['maximumfilesize'] = 'Максимальный размер файлов: {$a}';
$string['maxwordslabel'] = 'Максимальное число слов';
$string['maxwordswarning'] = 'Ой, написано слишком много слов!';
$string['minimumfilecount'] = 'Минимальное число файлов: {$a}';
$string['minwordslabel'] = 'Минимальное количество слов';
$string['minwordswarning'] = 'Продолжайте! Вы еще не написали достаточно слов.';
$string['missing'] = 'Отсутствует';
$string['paragraphs'] = 'Параграфы';
$string['percentofquestiongrade'] = '{$a}% оценки вопроса.';
$string['phrasebehavior'] = 'Целевая фраза поведения [{no}]';
$string['phrasebehavior_help'] = 'Эти настройки уточняют поведение соответствия для данной целевой фразы.';
$string['phrasecasesensitiveno'] = 'Соответствие не зависит от регистра.';
$string['phrasecasesensitiveyes'] = 'Соответствие зависит от регистра.';
$string['phrasefullmatchno'] = 'Сопоставлять полные или неполные слова.';
$string['phrasefullmatchyes'] = 'Сопоставлять только полные слова.';
$string['phraseignorebreaksno'] = 'Распознавать разрывы строк.';
$string['phraseignorebreaksyes'] = 'Игнорировать разрывы строк.';
$string['phrasematch'] = 'Если';
$string['phrasepercent'] = 'используется, присудить';
$string['pleaseattachfiles'] = 'Пожалуйста, приложите необходимое количество файлов.';
$string['pleaseinputtext'] = 'Пожалуйста, введите свой ответ в текстовое поле.';
$string['pluginname'] = 'Эссе (автоматическая оценка)';
$string['pluginname_help'] = 'В ответ на вопрос, который может включать изображение, респондент пишет ответ из одного или нескольких абзацев. Первоначально оценка выставляется автоматически на основании количества символов, слов, предложений или абзацев, а также наличия определенных целевых фраз. Автоматическая оценка может быть позже отменена учителем.';
$string['pluginname_link'] = 'question/type/essayautograde';
$string['pluginnameadding'] = 'Добавление вопроса для эссе (автоматическая оценка)';
$string['pluginnameediting'] = 'Редактирование вопроса для эссе (автоматическая оценка)';
$string['pluginnamesummary'] = 'Позволяет в качестве ответа на вопрос представить эссе из нескольких предложений или абзацев. Эссе оценивается автоматически. Позднее оценка может быть изменена.';
$string['present'] = 'Present';
$string['privacy:metadata'] = 'Плагин типа вопроса "Эссе (автоматическая оценка)" не хранит никаких личных данных.';
$string['requiredfilecount'] = 'Необходимое количество файлов: {$a}';
$string['responseisnotoriginal'] = 'Пожалуйста, сделайте ваш текст более оригинальным.';
$string['responsesample'] = 'Образец ответа';
$string['responsesample_help'] = 'Введённый здесь текст будет отображаться как образец ответа, если студент нажмет на ссылку "Показать образец" в тексте вопроса.';
$string['responsesampleformat'] = 'Формат образца ответа';
$string['responsesampleformat_help'] = 'Выберите формат образца ответа.';
$string['rewriteresubmit'] = 'и отправьте снова.';
$string['rewriteresubmitbreaks'] = 'удалить разрывы строк';
$string['rewriteresubmitchars'] = 'добавить больше символов';
$string['rewriteresubmiterrors'] = 'исправить распространённые ошибки';
$string['rewriteresubmitfiles'] = 'добавить необходимое количество файлов';
$string['rewriteresubmitjoin'] = ',';
$string['rewriteresubmitparagraphs'] = 'добавить больше параграфов';
$string['rewriteresubmitphrases'] = 'добавить пропущенные фразы';
$string['rewriteresubmitsentences'] = 'добавить больше предложений';
$string['rewriteresubmitwords'] = 'добавить больше слов';
$string['sentences'] = 'Предложения';
$string['sentencesperparagraph'] = 'Предложений на параграф';
$string['showcalculation'] = 'Показывать расчет оценки?';
$string['showcalculation_help'] = 'Если эта опция включена, на страницах выставления оценок и рецензирования будет показано объяснение расчета автоматически сгенерированной оценки.';
$string['showfeedback'] = 'Показывать отзывы?';
$string['showfeedback_help'] = 'Если эта опция включена, на страницах оценивания и рецензирования будут отображаться поля с отзывами. Отзыв - это обратная связь, которая сообщает учащимся, что им нужно сделать для улучшения работы.';
$string['showgradebands'] = 'Показывать диапазоны оценок?';
$string['showgradebands_help'] = 'Если эта опция включена, подробная информация о диапазонах оценок будет показана на страницах выставления оценок и рецензирования.';
$string['showsample'] = 'Показать образец';
$string['showtargetphrases'] = 'Показывать целевые фразы?';
$string['showtargetphrases_help'] = 'Если эта опция включена, подробная информация о целевых фразах будет показана на страницах оценивания и рецензирования.';
$string['showtextstats'] = 'Показывать статистику?';
$string['showtextstats_help'] = 'Если эта опция включена, будет показана статистика текста.';
$string['showtostudentsonly'] = 'Да, показывать только студентам';
$string['showtoteachersandstudents'] = 'Да, показывать учителям и студентам';
$string['showtoteachersonly'] = 'Да, показывать только учителям';
$string['targetphrase'] = 'Целевая фраза [{no}]';
$string['targetphrase_help'] = 'Укажите оценку, которая будет добавлена, если эта целевая фраза имеется в эссе.

> **например, ** Если используется [Наконец], присудите [10% от оценки за вопрос].

Целевая фраза может быть одной фразой или списком фраз, разделенных либо запятой ",", либо словом "OR" (в верхнем регистре).

> **например** Если используется [Наконец OR Окончательно], присуждается [10% от оценки вопроса].

Вопросительный знак "?" во фразе соответствует любому одиночному символу, а звездочка "*" соответствует произвольному количеству символов (включая ноль символов).

> **например** Если используется [Сначала\\* Затем\\* Наконец], присуждается [50% от оценки вопроса].';
$string['targetphrases'] = 'Целевые фразы';
$string['textstatistics'] = 'Статистика';
$string['textstatitems'] = 'Элементы статистики';
$string['textstatitems_help'] = 'Выберите здесь любые элементы, которые вы хотите отобразить в текстовой статистике, показываемой на страницах оценивания и рецензирования.';
$string['uniquewords'] = 'Уникальные слова';
$string['uploadfiles'] = 'Загруженные файлы';
$string['words'] = 'Слова';
$string['wordspersentence'] = 'Слов на предложение';
