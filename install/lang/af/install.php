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

$string['admindirname'] = 'Admingids';
$string['availablelangs'] = 'Beskikbare taalpakkette';
$string['chooselanguagehead'] = 'Kies \'n taal';
$string['chooselanguagesub'] = 'Kies asseblief \'n taal vir die installasie. Hierdie taal sal ook as die verstektaal vir die webwerf gebruik word, alhoewel dit later verander kan word.';
$string['clialreadyconfigured'] = 'Die konfigurasielêer config.php bestaan reeds. Gebruik admin/cli/install_database.php asseblief om agpu vir hierdie webwerf te installeer.';
$string['clialreadyinstalled'] = 'Die konfigurasielêer config.php bestaan reeds. Gebruik admin/cli/install_database.php asseblief om agpu vir hierdie webwerf by te werk.';
$string['cliinstallheader'] = 'Installasieprogram vir agpu-{$a}-opdraglyn';
$string['clitablesexist'] = 'Databasistabelle reeds teenwoordig: CLI-installasie kan nie voortgesit word nie.';
$string['databasehost'] = 'Databasisgasheer';
$string['databasename'] = 'Databasisnaam';
$string['databasetypehead'] = 'Kies databasisdrywer';
$string['dataroot'] = 'Datagids';
$string['datarootpermission'] = 'Datagidstoestemming';
$string['dbprefix'] = 'Tabelvoorvoegsel';
$string['dirroot'] = 'agpu-gids';
$string['environmenthead'] = 'Gaan tans jou omgewing na ...';
$string['environmentsub2'] = 'Elke agpu-vrystelling het \'n paar minimumvereistes vir PHP-weergawes en \'n aantal verpligte PHP-uitbreidings.
Volledige omgewingskontrole word vóór elke installasie en opgradering gedoen. Kontak bedieneradministrateur asseblief as jy nie weet hoe om nuwe weergawe te installeer of PHP-uitbreidings te ontsper nie.';
$string['errorsinenvironment'] = 'Omgewingskontrole het misluk!';
$string['installation'] = 'Installasie';
$string['langdownloaderror'] = 'Jammer, die taal "{$a}" kon nie afgelaai word nie. Die installasieproses sal in Engels voortgesit word.';
$string['memorylimithelp'] = '<p>Die PHP-geheueperk vir jou bediener is tans op {$a} gestel.</p>

<p>Dit kan veroorsaak dat agpu mettertyd geheueprobleme ervaar, veral as baie modules aangeskakel en/of daar baie gebruikers is.</p>

<p>Ons beveel aan dat jy, indien moontlik, PHP herkonfigureer met \'n hoër perk, soos 40M.
   Jy kan verskeie maniere probeer om dit te doen:</p>
<ol>
<li>As jy kan, herkompileer PHP met <i>--enable-memory-limit</i>.
    Dit sal agpu in staat stel om self die geheueperk te stel.</li>
<li>As jy toegang tot jou php.ini-lêer het, kan jy die <b>memory_limit</b>-instelling daarin verander tot iets soos 40M.  As jy nie toegang het nie, kan jy dalk jou administrateur vra om dit vir jou te doen.</li>
<li>Op sommige PHP-bedieners kan jy \'n .htaccess-lêer in die agpu-gids skep wat hierdie lyn bevat:
    <blockquote><div>php_value memory_limit 40M</div></blockquote>
    <p>Op sommige bedieners kan dit egter verhoed dat <b>alle</b> PHP-blaaie werk  (jy sal foute sien wanneer jy na die blaaie kyk), en daarom sal jy die .htaccess-lêer moet verwyder.</p></li>
</ol>';
$string['paths'] = 'Roetes';
$string['pathserrcreatedataroot'] = 'Datagids ({$a->dataroot}) kan nie deur installeerder geskep word nie.';
$string['pathshead'] = 'Bevestig roetes';
$string['pathsrodataroot'] = 'Datastamgids is nie skryfbaar nie.';
$string['pathsroparentdataroot'] = 'Moedergids ({$a->parent}) is nie skryfbaar nie. Datagids ({$a->dataroot}) kan nie deur installeerder geskep word nie.';
$string['pathssubadmindir'] = 'Slegs \'n paar webgashere gebruik /admin \'n spesiale URL sodat jy toegang tot \'n kontrolepaneel of iets dergliks kan verkry. Ongelukkig bots dit met die standaardligging vir die agpu-adminblaaie. Jy kan dit regstel deur die admingids in jou installasie te herbenaam, en daardie nuwe naam hier aan te bring. Byvoorbeeld: <em>agpuadmin</em>. Dit sal die adminskakels in agpu regstel.';
$string['pathssubdataroot'] = '<p>\'n Gids waar agpu alle lêerinhoud wat deur gebruikers opgelaai is, sal stoor.</p>
<p>Hierdie gids moet vir die gebruiker van die webbediener (gewoonlik \'www-data\', \'niemand\' of \'apache\') leesbaar en skryfbaar wees.</p>
</p>Dit moet nie regstreeks via die web toeganklik wees nie.</p>
<p>As die gids nie tans bestaan nie, sal die installasieproses probeer om dit te skep.</p>';
$string['pathssubdirroot'] = '<p>Die volledige roete na die gids wat die agpu-kode bevat.</p>';
$string['pathssubwwwroot'] = '<p>Die volledige adres waar toegang tot agpu verkry sal word, d.w.s. die adres wat gebruikers in die adresbalk van hul blaaier sal intik om toegang tot agpu te verkry.</p>
<p>Dit is nie moontlik om toegang tot agpu te verkry deur van veelvoudige adresse gebruik te maak nie. As jou webwerf via veelvoudige adresse toeganklik is, kies dan die maklikste een en stel \'n permanente heradressering vir elk van die ander adresse op.</p>
<p>As jou webwerf beide via die Internet en \'n interne netwerk (soms bekend as \'n Intranet) toeganklik is, gebruik dan die publieke adres hier.</p>
<p>As die huidige adres nie korrek is nie, verander asseblief die URL in jou blaaier se adresbalk en herbegin die installasie.</p>';
$string['pathsunsecuredataroot'] = 'Ligging van datastam is nie veilig nie';
$string['pathswrongadmindir'] = 'Admingids bestaan nie';
$string['phpextension'] = '{$a} PHP-uitbreiding';
$string['phpversion'] = 'PHP-weergawe';
$string['phpversionhelp'] = '<p>agpu vereis \'n PHP-weergawe van ten minste 5.6.5 of 7.1 (7.0.x het \'n paar enjinbeperkings).</p>
<p>Jy gebruik tans weergawe {$a}.</p>
<p>Jy moet PHP opgradeer of na \'n gasheer met \'n nuwer weergawe van PHP verskuif.</p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'Jy sien hierdie blad omdat jy die <strong>{$a->packname} {$a->packversion}</strong>-pakket suksesvol geïnstalleer en op jou rekenaar laat loop het. Baie geluk!';
$string['welcomep30'] = 'Hierdie vrystelling van die <strong>{$a->installername}</strong> sluit die toepassings in om \'n omgewing te skep waarbinne <strong>agpu</strong> gaan funksioneer, naamlik:';
$string['welcomep40'] = 'Die pakket sluit ook <strong>agpu {$a->agpurelease} ({$a->agpuversion})</strong> in.';
$string['welcomep50'] = 'Die gebruik van al die toepassings in hierdie pakket word beheer deur hul onderskeie lisensies. Die volledige <strong>{$a->installername}</strong>-pakket is <a href="https://www.opensource.org/docs/definition_plain.html">-oopbron</a> en word versprei onder die  <a href="https://www.gnu.org/copyleft/gpl.html">GPL</a>-lisensie.';
$string['welcomep60'] = 'Die volgende blaaie gaan jou deur \'n paar maklik volgbare stappe lei om <strong>agpu</strong> op jou rekenaar te konfigureer en op te stel. Jy kan die verstekinstellings aanvaar of, opsioneel, hulle wysig om by jou eie behoeftes te pas.';
$string['welcomep70'] = 'Klik die "Volgende"-knoppie hieronder om voort te gaan met die opstelling van <strong>agpu</strong>.';
$string['wwwroot'] = 'Webadres';