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
 * Strings for component 'qtype_ordering', language 'ru', version '4.5'.
 *
 * @package     qtype_ordering
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['absoluteposition'] = 'Абсолютная позиция';
$string['addmultipleanswers'] = 'Добавить еще элементы: {$a}';
$string['addsingleanswer'] = 'Добавить еще один элемент';
$string['allornothing'] = 'Все или ничего';
$string['answer'] = 'Текстовый элемент';
$string['correctitemsnumber'] = 'Верные позиции: {$a}';
$string['correctorder'] = 'Для этих элементов правильный порядок выглядит так:';
$string['defaultanswerformat'] = 'Формат ответа по умолчанию';
$string['defaultquestionname'] = 'Расположите следующие элементы в правильном порядке.';
$string['draggableitemno'] = 'Перетаскиваемый элемент {no}';
$string['draggableitems'] = 'Перетаскиваемые элементы';
$string['duplicatesnotallowed'] = 'Дублирование перетаскиваемых элементов не допускается. Строка «{$a->text}» уже используется в {$a->item}.';
$string['editingordering'] = 'Редактирование вопроса на упорядочение';
$string['gradedetails'] = 'Подробности оценки';
$string['gradingtype'] = 'Вид оценивания';
$string['gradingtype_help'] = '**Все или ничего**
&nbsp; Если все элементы находятся в правильной позиции, то начисляется максимальная оценка. В противном случае оценка равна нулю.

**Абсолютная позиция**
&nbsp; Элемент считается верным, если он находится в той же позиции, что и в правильном ответе. Максимально возможная оценка за вопрос **такая же**, как количество элементов вопроса, отображаемых студенту.

**Относительно правильной позиции**
&nbsp; Элемент считается верным, если он находится в той же позиции, что и в правильном ответе. Верные элементы получают балл, равный количеству показанных элементов минус один. Неверные элементы получают балл, равный количеству показанных элементов минус один и минус расстояние элемента от его правильной позиции. Таким образом, если студенту показано ***n*** элементов, то количество баллов, доступных для каждого элемента, составляет ***(n - 1)***, а максимальная оценка, доступная для вопроса, составляет ***n x (n - 1)***, что равно ***(n² - n)***.

**Относительно следующего элемента (исключая последний)**
&nbsp; Элемент считается верным, если за ним следует тот же элемент, что и в правильном ответе. Элемент на последней позиции не проверяется. Таким образом, максимально возможная оценка за вопрос **на единицу меньше** , чем количество элементов, отображаемых студенту.

**Относительно следующего элемента (включая последний)**
&nbsp; Элемент считается верным, если за ним следует тот же элемент, что и в правильном ответе. Засчитывается и последний элемент, за которым не должно быть ни одного элемента. Таким образом, максимально возможная оценка за вопрос **такая же**, как количество элементов, отображаемых студенту.

**Относительно как предыдущего, так и следующего элементов**
&nbsp; Элемент считается верным, если и предыдущий, и следующий элементы те же, как и в правильном ответе. Первый элемент не должен иметь предыдущего элемента, а за последним элементом не должно быть следующего элемента. Таким образом, для каждого элемента существует два возможных балла, а наивысшая возможная оценка за вопрос **в два раза** больше количества элементов, отображаемых студенту.


**Относительно ВСЕХ предыдущих и следующих элементов**
&nbsp; Элемент считается верным, если ему предшествуют все те же элементы, что и в правильном ответе, и за ним следуют все те же элементы, что и в правильном ответе. Порядок предыдущих элементов не имеет значения, как и порядок следующих элементов. Таким образом, если ученику отображается ***n*** элементов, то количество баллов, доступных для каждого элемента, составляет ***(n - 1)***, а наивысшая оценка, доступная для вопроса, составляет ***n x (n - 1)***, что равно ***(n² - n)***.

**Самое длинное упорядоченное подмножество**
&nbsp; Оценка — это количество элементов в самом длинном упорядоченном подмножестве элементов. Наивысшая возможная оценка совпадает с количеством отображаемых элементов. Подмножество должно содержать не менее двух элементов. Подмножества не обязательно должны (но могут) начинаться с первого элемента и не обязательно (но могут) должны быть смежными. При наличии нескольких подмножеств одинаковой длины элементы в подмножестве, найденные первыми при поиске слева направо, будут отображаться как верные. Другие элементы будут помечены как неверные.

**Самое длинное непрерывное подмножество**
&nbsp; Оценка — это количество элементов в самом длинном смежном подмножестве элементов. Наивысшая возможная оценка совпадает с количеством отображаемых элементов. Подмножество должно иметь не менее двух элементов. Подмножества не обязательно должны (но могут) начинаться с первого элемента и ДОЛЖНЫ БЫТЬ НЕПРЕРЫВНЫМИ. При наличии нескольких подмножеств одинаковой длины элементы в подмножестве, найденные первыми при поиске слева направо, будут отображаться как верные. Другие элементы будут помечены как неверные.';
$string['highlightresponse'] = 'Выделить ответ как верный или неверный';
$string['horizontal'] = 'Горизонтально';
$string['incorrectitemsnumber'] = 'Неверные позиции: {$a}';
$string['layouttype'] = 'Расположение элементов';
$string['layouttype_help'] = 'Выберите способ отображения элементов (вертикально или горизонтально)';
$string['longestcontiguoussubset'] = 'Самое длинное непрерывное подмножество';
$string['longestorderedsubset'] = 'Самое длинное упорядоченное подмножество';
$string['moved'] = '{$a->item} перемещен. Новая позиция: {$a->position} из {$a->total}.';
$string['moveleft'] = 'Переместить влево';
$string['moveright'] = 'Переместить вправо';
$string['noresponsedetails'] = 'К сожалению,  не имеется никаких деталей ответа на этот вопрос.';
$string['noscore'] = 'Без оценки';
$string['notenoughanswers'] = 'Вопросов для упорядочения должно быть больше, чем  ответов ({$a}).';
$string['notenoughsubsetitems'] = 'В подмножестве должно быть не менее {$a} элементов.';
$string['numberingstyle'] = 'Пронумеровать варианты?';
$string['numberingstyle123'] = '1., 2., 3., ...';
$string['numberingstyleABCD'] = 'A., B., C., ...';
$string['numberingstyleIIII'] = 'I., II., III., ...';
$string['numberingstyle_desc'] = 'Стиль нумерации по умолчанию.';
$string['numberingstyle_help'] = 'Выберите стиль нумерации для перетаскиваемых элементов в этом вопросе.';
$string['numberingstyleabc'] = 'a., b., c., ...';
$string['numberingstyleiii'] = 'i., ii., iii., ...';
$string['numberingstylenone'] = 'Без нумерации';
$string['partialitemsnumber'] = 'Частично правильные позиции: {$a}';
$string['pluginname'] = 'Упорядочение';
$string['pluginname_help'] = 'Некоторые элементы отображаются в случайном порядке. Элементы могут быть перетянуты и расположены в правильном порядке.';
$string['pluginname_link'] = 'question/type/ordering';
$string['pluginnameadding'] = 'Добавление вопроса на Упорядочение';
$string['pluginnameediting'] = 'Редактирование вопроса на Упорядочение';
$string['pluginnamesummary'] = 'Расположите перемешанные элементы в правильном порядке.';
$string['positionx'] = 'Позиция {$a}';
$string['privacy:preference:gradingtype'] = 'Вид оценивания.';
$string['privacy:preference:layouttype'] = 'Расположение элементов.';
$string['privacy:preference:numberingstyle'] = 'Стиль нумерации вариантов.';
$string['privacy:preference:selectcount'] = 'Выбранное количество.';
$string['privacy:preference:selecttype'] = 'Тип выбора элемента.';
$string['privacy:preference:showgrading'] = 'Показывать ли подробную информацию об оценке.';
$string['regradeissuenumitemschanged'] = 'Изменилось количество перетаскиваемых элементов.';
$string['relativeallpreviousandnext'] = 'Относительно ВСЕХ предыдущих и следующих элементов';
$string['relativenextexcludelast'] = 'Относительно следующего элемента (исключая последний)';
$string['relativenextincludelast'] = 'Относительно следующего элемента (включая последний)';
$string['relativeonepreviousandnext'] = 'Относительно как предыдущего, так и следующего элементов';
$string['relativetocorrect'] = 'Относительно правильной позиции';
$string['removeeditor'] = 'Убрать HTML редактор';
$string['removeitem'] = 'Убрать перетаскиваемые элементы';
$string['scoredetails'] = 'Баллы по каждому пункту этого ответа:';
$string['selectall'] = 'Выберите все элементы';
$string['selectcontiguous'] = 'Выберите непрерывное подмножество элементов';
$string['selectcount'] = 'Размер подмножества';
$string['selectcount_help'] = 'Количество отображаемых элементов при показе вопроса в тесте.';
$string['selectrandom'] = 'Выберите случайное подмножество элементов';
$string['selecttype'] = 'Тип выбираемых элементов';
$string['selecttype_help'] = 'Выберите, следует ли отображать все элементы или только некоторые подмножества элементов.';
$string['showgrading'] = 'Подробности оценивания';
$string['showgrading_help'] = 'Выберите, следует ли показывать или скрывать подробности расчета баллов, когда учащийся просматривает ответ на этот вопрос.';
$string['vertical'] = 'Вертикально';
