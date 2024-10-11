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
 * Strings for component 'tool_clearbackupfiles', language 'ru', version '4.5'.
 *
 * @package     tool_clearbackupfiles
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['backupcompletedlog'] = 'В результате были удалены файлы ({$a->filecount}) с резервными копиями курсов - общий размер {$a->filesize}.';
$string['backupremovedlog'] = 'Файл с резервной копией курса {$a->filename} размером {$a->filesize} был удален.';
$string['clearbackupcompleted'] = 'Очистка резевных копий курсов завершена';
$string['coursebackupremoved'] = 'Резервная копия курса удалена';
$string['filedeletedempty'] = 'Нет резервный копий курсов для удаления.';
$string['filedeletedfooter'] = 'Всего было удалено файлов с резервными копиями курсов - {$a->filecount}. Было освобождено {$a->filesize} дискового пространства.';
$string['filedeletedheader'] = 'Были удалены файлы резервных копий следующих курсов:';
$string['filename'] = 'Имя файла';
$string['filesize'] = 'Размер файла';
$string['pluginname'] = 'Очистка файлов резервных копий';
$string['warningalert'] = 'Вы хотите продолжить?';
$string['warningmsg'] = 'Имейте в виду, что удаление файлов резервных копий курсов - необратимый процесс. Вы не сможете восстановить удаленные файлы резервных копий курсов.';
