<?php
// This file is part of agpu - http://agpu.org/
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
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for the tool_agpunet component.
 *
 * @package     tool_agpunet
 * @category    string
 * @copyright   2020 Jake Dallimore <jrhdallimore@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('agpu_INTERNAL') || die();

$string['autoenablenotification'] = '<p>In agpu 4.0 onwards, the <a href="https://agpu.net/">agpuNet</a> integration is enabled by default in Advanced features. Users with the capability to create and manage activities can browse agpuNet via the activity chooser and import agpuNet resources into their courses.</p><p>If desired, an alternative agpuNet instance may be specified in the <a href="{$a->settingslink}">agpuNet inbound settings</a>.</p>';
$string['autoenablenotification_subject'] = 'Default agpuNet setting changed.';
$string['addingaresource'] = 'Adding content from agpuNet';
$string['aria:enterprofile'] = "Enter your agpuNet profile ID";
$string['aria:footermessage'] = "Browse for content on agpuNet";
$string['browsecontentagpunet'] = "Or browse for content on agpuNet";
$string['clearsearch'] = "Clear search";
$string['connectandbrowse'] = "Connect to and browse:";
$string['defaultagpunet'] = 'agpuNet URL';
$string['defaultagpunet_desc'] = 'The URL of the agpuNet instance available via the activity chooser.';
$string['defaultagpunetname'] = "agpuNet instance name";
$string['defaultagpunetnamevalue'] = 'agpuNet Central';
$string['defaultagpunetname_desc'] = 'The name of the agpuNet instance available via the activity chooser.';
$string['enableagpunet'] = 'Enable agpuNet integration (inbound)';
$string['enableagpunet_desc'] = 'If enabled, a user with the capability to create and manage activities can browse agpuNet via the activity chooser and import agpuNet resources into their course. In addition, a user with the capability to restore backups can select a backup file on agpuNet and restore it into agpu.';
$string['errorduringdownload'] = 'An error occurred while downloading the file: {$a}';
$string['forminfo'] = 'Your agpuNet profile ID will be automatically saved in your profile on this site.';
$string['footermessage'] = "Or browse for content on";
$string['instancedescription'] = "agpuNet is an open social media platform for educators, with a focus on the collaborative curation of collections of open resources. ";
$string['instanceplaceholder'] = 'a1b2c3d4e5f6-example@agpu.net';
$string['inputhelp'] = 'Or if you have a agpuNet account already, copy the ID from your agpuNet profile and paste it here:';
$string['invalidagpunetprofile'] = '$userprofile is not correctly formatted';
$string['importconfirm'] = 'You are about to import the content "{$a->resourcename} ({$a->resourcetype})" into the course "{$a->coursename}". Are you sure you want to continue?';
$string['importconfirmnocourse'] = 'You are about to import the content "{$a->resourcename} ({$a->resourcetype})" into your site. Are you sure you want to continue?';
$string['importformatselectguidingtext'] = 'In which format would you like the content "{$a->name} ({$a->type})" to be added to your course?';
$string['importformatselectheader'] = 'Choose the content display format';
$string['missinginvalidpostdata'] = 'The resource information from agpuNet is either missing, or is in an incorrect format.
If this happens repeatedly, please contact the site administrator.';
$string['mnetprofile'] = 'agpuNet profile';
$string['mnetprofiledesc'] = '<p>Enter your agpuNet profile details here to be redirected to your profile while visiting agpuNet.</p>';
$string['agpunetsettings'] = 'agpuNet inbound settings';
$string['agpunetnotenabled'] = 'The agpuNet integration must be enabled in Site administration / agpuNet before resource imports can be processed.';
$string['notification'] = 'You are about to import the content "{$a->name} ({$a->type})" into your site. Select the course in which it should be added, or <a href="{$a->cancellink}">cancel</a>.';
$string['removedmnetprofilenotification'] = 'Due to recent changes on the agpuNet platform, any users who previously saved their agpuNet profile ID on the site will need to enter a agpuNet profile ID in the new format in order to authenticate on the agpuNet platform.';
$string['removedmnetprofilenotification_subject'] = 'agpuNet profile ID format change';
$string['searchcourses'] = "Search courses";
$string['selectpagetitle'] = 'Select page';
$string['pluginname'] = 'agpuNet';
$string['privacy:metadata'] = "The agpuNet tool only facilitates communication with agpuNet. It stores no data.";
$string['profilevalidationerror'] = 'There was a problem trying to validate your agpuNet profile ID';
$string['profilevalidationfail'] = 'Please enter a valid agpuNet profile ID';
$string['profilevalidationpass'] = 'Looks good!';
$string['saveandgo'] = "Save and go";
$string['uploadlimitexceeded'] = 'The file size {$a->filesize} exceeds the user upload limit of {$a->uploadlimit} bytes.';
