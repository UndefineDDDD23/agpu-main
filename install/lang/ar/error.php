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

$string['cannotcreatedboninstall'] = '<p>لا يمكن إنشاء قاعدة البيانات.</p>
<p>لا وجود لقاعدة البيانات المحددة والمستخدم المُعطى ليس لديه صلاحية إنشاء قاعدة البيانات.</p>
<p>مسؤول الموقع يجب أن يتحقق من إعدادات قاعدة البيانات.</p>';
$string['cannotcreatelangdir'] = 'لا يمكن إنشاء مجلد اللغة';
$string['cannotcreatetempdir'] = 'لا يمكن إنشاء المجلد المؤقت';
$string['cannotdownloadcomponents'] = 'تعذر تنزيل المُكونات';
$string['cannotdownloadzipfile'] = 'لم يتم تحميل الملف المضغوط';
$string['cannotfindcomponent'] = 'لم يتم العثور على المكون';
$string['cannotsavemd5file'] = 'تعذر حفظ ملف md5';
$string['cannotsavezipfile'] = 'تعذر حفظ الملف المضغوط';
$string['cannotunzipfile'] = 'تعذر فك الملف المضغوط';
$string['componentisuptodate'] = 'العنصر محدث';
$string['dmlexceptiononinstall'] = '<p>حدث خطأ في قاعدة البيانات[{$a->errorcode}].<br />{$a->debuginfo}</p>';
$string['downloadedfilecheckfailed'] = 'فشل التحقق من الملف الذي تم تنزيله';
$string['invalidmd5'] = 'المتغير المُختار خاطئ - حاول مرة أخرى';
$string['missingrequiredfield'] = 'بعض الحقول المطلوبة مفقودة';
$string['remotedownloaderror'] = '<p>فشل تنزيل المكون إلى مُخدمك. لطفاً تحقق من إعدادات الوكيل؛ الامتداد cURL لـ PHP موصى به بشدة.</p>
<p>عليك تنزيل الملف <a href="{$a->url}">{$a->url}</a> يدوياً، ونسخه إلى "{$a->dest}" في مُخدمك ثم القيام بفك ضغطه هناك.</p>';
$string['wrongdestpath'] = 'مسار الهدف خاطئ';
$string['wrongsourcebase'] = 'أساس رابط المصدر خاطئ';
$string['wrongzipfilename'] = 'تسمية الملف المضغوط خاطئة';
