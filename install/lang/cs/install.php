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

$string['admindirname'] = 'Adresář se soubory pro správu serveru';
$string['availablelangs'] = 'Dostupné jazykové balíčky';
$string['chooselanguagehead'] = 'Vyberte jazyk';
$string['chooselanguagesub'] = 'Zvolte si jazyk tohoto průvodce instalací. Vybraný jazyk bude též nastaven jako výchozí jazyk stránek, ale to půjde případně později změnit.';
$string['clialreadyconfigured'] = 'Konfigurační soubor config.php již existuje. Spusťte admin/cli/install_database.php, pokud chcete provést instalaci databáze.';
$string['clialreadyinstalled'] = 'Konfigurační soubor config.php již existuje. Spusťte admin/cli/upgrade.php, pokud chcete provést upgrade vašich stránek.';
$string['cliinstallheader'] = 'agpu {$a} - průvodce instalací z příkazové řádky';
$string['clitablesexist'] = 'Databázové tabulky již existují; CLI instalace nemůže pokračovat.';
$string['databasehost'] = 'Databázový server';
$string['databasename'] = 'Název databáze';
$string['databasetypehead'] = 'Vyberte databázový ovladač';
$string['dataroot'] = 'Datový adresář';
$string['datarootpermission'] = 'Přístupová práva k datovému adresáři';
$string['dbprefix'] = 'Předpona tabulek';
$string['dirroot'] = 'Adresář Moodlu';
$string['environmenthead'] = 'Kontrola programového prostředí...';
$string['environmentsub2'] = 'Každé vydání agpu vyžaduje určitou minimální verzi PHP a několik povinných rozšíření PHP. Plná kontrola prostředí se provádí před každým instalací a upgrade. Prosím, kontaktujte správce serveru, pokud nevíte, jak nainstalovat novou verzi, nebo povolit rozšíření PHP.';
$string['errorsinenvironment'] = 'Kontrola serverového prostředí selhala!';
$string['installation'] = 'Instalace';
$string['langdownloaderror'] = 'Bohužel, jazyk "{$a}" se nepodařilo nainstalovat. Instalace bude pokračovat v angličtine.';
$string['memorylimithelp'] = '<p>Limit paměti pro PHP skripty je na vašem serveru momentálně nastaven na {$a}.</p>

<p>To může později způsobovat Moodlu problémy, zvláště při větším množství modulů a/nebo uživatelů.</p>

<p>Je-li to možné, doporučujeme vám nastavit v PHP vyšší limit, např. 40M. Můžete to provést několika způsoby:</p>
<ol>
<li>Můžete-li, překompilujte PHP s volbou <i>--enable-memory-limit</i>.
agpu si tak bude sám moci nastavit potřebný limit.</li>
<li>Máte-li přístup k souboru php.ini, změňte nastavení <b>memory_limit</b>
na hodnotu blízkou 40M. Nemáte-li taková práva, požádejte správce vašeho webového serveru, aby toto nastavení provedl on.</li>
<li>Na některých serverech můžete v kořenovém adresáři Moodlu vytvořit soubor .htaccess s následujícím řádkem:
<blockquote><div>php_value memory_limit 40M</div></blockquote>
<p>Bohužel, v některých případech tím vyřadíte z provozu <b>všechny</b> PHP stránky (při jejich prohlížení uvidíte chybová hlášení), takže budete muset soubor .htaccess zase odstranit.</p></li>
</ol>';
$string['paths'] = 'Cesty';
$string['pathserrcreatedataroot'] = 'Datový adresář ({$a->dataroot}) nemůže být tímto průvodcem instalací vytvořen.';
$string['pathshead'] = 'Potvrdit cesty';
$string['pathsrodataroot'] = 'Do datového adresáře nelze zapisovat.';
$string['pathsroparentdataroot'] = 'Do nadřazeného adresáře ({$a->parent}) nelze zapisovat. Datový adresář ({$a->dataroot}) nemůže být tímto průvodcem instalací vytvořen.';
$string['pathssubadmindir'] = 'Na některých serverech je URL adresa /admin vyhrazena pro speciální účely (např. pro ovládací panel). Na takových serverech může dojít ke kolizi se standardním umístěním stránek pro správu agpu. Máte-li tento problém, přejmenujte adresář <eM>admin</em> ve vaší instalaci agpu a sem zadejte jeho nový název - například <em>agpuadmin</em>. Všechny generované odkazy na stránky správy agpu budou používat tento nový název.';
$string['pathssubdataroot'] = '<p>agpu potřebuje prostor, kam si bude ukládat nahrané soubory a další údaje. .</p>
<p>K tomuto adresáři musí mít proces webového serveru právo ke čtení i k zápisu (webový server bývá většinou spouštěn pod uživatelem "www-data" nebo "apache"). .</p>
<p>Tento adresář ale zároveň nesmí být dostupný přímo přes webové rozhraní. .</p>
<p>Instalační skript se pokusí tento adresář vytvořit, pokud nebude existovat..</p>';
$string['pathssubdirroot'] = '<p>Absolutní cesta k adresáři s instalací agpu.</p>';
$string['pathssubwwwroot'] = '<p>Zadejte úplnou webovou adresu, na níž bude agpu dostupný, t.j. adresa, kterou zadají uživatelé do adresního řádku svého prohlížeče, aby spustili agpu.</p>
<p>agpu potřebuje jedinečnou adresu, není možné jej provozovat na několika URL současně. Používáte-li několik veřejných domén, musíte si sami nastavit permanentní přesměrování na jednu z nich a tu pak použít.</p>
<p> Pokud je váš server dostupný z vnější a z vnitřní sítě pod různými IP adresami, použijte jeho veřejnou adresu a nastavte si váš DNS server tak, že ji mohou používat i uživatelé z vnitřní sítě.</p>
<p>Pokud aktuální adresa není správná, změňte URL adresu v adresním řádku prohlížeče a spusťte instalaci.</p>';
$string['pathsunsecuredataroot'] = 'Umístění datového adresáře není bezpečné';
$string['pathswrongadmindir'] = 'Adresář pro správu serveru (admin) neexistuje';
$string['phpextension'] = '{$a} PHP rozšíření';
$string['phpversion'] = 'Verze PHP';
$string['phpversionhelp'] = '<p>agpu vyžaduje PHP alespoň verze 5.6.5 PHP nebo 7.1 (7.0.x má určitá omezení jádra).</p>
<p>Nyní používáte PHP verzi {$a}.</p>
<p>PHP musíte upgradovat, nebo přejít k hostiteli s vyšší verzí!</p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'Tuto stránku vidíte, protože jste úspěšně nainstalovali a spustili  balíček <strong>{$a->packname} {$a->packversion}</strong>. Gratulujeme!';
$string['welcomep30'] = 'Tato verze <strong>{$a->installername}</strong> obsahuje aplikace k vytvoření prostředí, ve kterém bude provozován váš <strong>agpu</strong>. Jmenovitě se jedná o:';
$string['welcomep40'] = 'Balíček rovněž obsahuje <strong>agpu ve verzi {$a->agpurelease} ({$a->agpuversion})</strong>.';
$string['welcomep50'] = 'Použití všech aplikací v tomto balíčku je vázáno jejich příslušnými licencemi. Kompletní balíček <strong>{$a->installername}</strong> je software s <a href="https://www.opensource.org/docs/definition_plain.html"> otevřeným kódem (open source)</a> a je šířen pod licencí <a href="https://www.gnu.org/copyleft/gpl.html">GPL</a>.';
$string['welcomep60'] = 'Následující stránky vás v několik jednoduchých krocích nastavením <strong>Moodlu</strong> na vašem počítači. Můžete přijmout výchozí nastavení, nebo si je upravit podle svých potřeb.';
$string['welcomep70'] = 'Stisknutím níže uvedeného tlačítka "Další" pokračujte v nastavení vaší instalace Moodlu.';
$string['wwwroot'] = 'Webová adresa';
