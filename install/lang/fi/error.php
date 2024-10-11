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

$string['cannotcreatedboninstall'] = '<p>Tietokantaa ei voi luoda.</p>
<p>Määritettyä tietokantaa ei ole olemassa, eikä kyseisellä käyttäjällä ole oikeutta luoda tietokantaa.</p>
<p>Sivuston järjestelmänvalvojan tulee tarkistaa tietokannan määritykset.</p>';
$string['cannotcreatelangdir'] = 'Kielihakemistoa ei voida luoda';
$string['cannotcreatetempdir'] = 'Temp-hakemistoa ei voitu luoda';
$string['cannotdownloadcomponents'] = 'Komponentteja ei voitu ladata';
$string['cannotdownloadzipfile'] = 'ZIP-tiedostoa ei voitu ladata';
$string['cannotfindcomponent'] = 'Komponenttia ei löytynyt';
$string['cannotsavemd5file'] = 'MD5-tiedostoa ei voitu tallentaa';
$string['cannotsavezipfile'] = 'Zip-tiedostoa ei voitu tallentaa';
$string['cannotunzipfile'] = 'Zip-tiedostoa ei voitu purkaa';
$string['componentisuptodate'] = 'Komponentti on ajan tasalla';
$string['dmlexceptiononinstall'] = '<p>Tapahtui tietokantavirhe [{$a->errorcode}].<br />{$a->debuginfo}</p>';
$string['downloadedfilecheckfailed'] = 'Ladatun tiedoston tarkistus epäonnistui';
$string['invalidmd5'] = 'Tarkistusmuuttuja oli väärin - yritä uudelleen';
$string['missingrequiredfield'] = 'Joitakin vaadituista kentistä puuttuu';
$string['remotedownloaderror'] = '<p>Komponentin lataaminen palvelimellesi epäonnistui. Tarkista välityspalvelimen asetukset: PHP cURL -laajennus on erittäin suositeltavaa.</p>
<p>Sinun on ladattava <a href="{$a->url}">{$a->url}</a>-tiedosto manuaalisesti, kopioitava se palvelimellesi kohteeseen "{$a->dest}" ja purettava se sinne.</p>';
$string['wrongdestpath'] = 'Virheellinen kohdekansio';
$string['wrongsourcebase'] = 'Väärä lähteen web-osoitteen kanta';
$string['wrongzipfilename'] = 'Virheellinen zip-tiedoston nimi';
