Mod_Multilingual 
-----------------

Grundsätzlich wird bei WBCE  für mehrsprachige Seiten kein Mod_Multilingual benötigt. Einfach mehrsprachen Support in den Einstellungen aktivieren und folgende Verzeichnisstruktur anlegen.

	EN
	|-Home
	|-Blog
	|-About
	DE
	|-Start
	|-Blog
	|-Über Mich
	FR
	.
	.
	.
	
Wobei darauf zu achten ist, das die Verzeichnisse Entsprechend der Ländercodes der jeweiligen Sprachen benannt werden. Eigentlich ist nur der Dateiname wichtig, den kann man aber erst nach erstellen der Seite getrennt bearbeiten also bitte diese Reihenfolge einhalten.  

Am besten nimmt man hierzu das Menülink Modul, damit direkte aufrufe des Verzeichnisses auch direkt auf die Startseite der jeweiligen Sprache weitergeleitet werden. 

Wichtig ist in der Verzeichnisseite sowie in den Unterseiten auch die Seitensprache richtig einzustellen. 

Die Seite die im Menübaum oben steht, ist die Standardsprache und sollte auch Allgemeinen Einstellungen als Standardsprache gewählt sein. 


Multilingual dient zwei Zwecken:

- Es erstellt ein Menu zum umstellen der Sprache.
- Es verknüpft die jeweiligen Seiten der verschiedenen Sprachen miteinander. Also wenn man im Deutschen "Impressum" auf Englisch klickt landet man direkt im englischen "Imprint" und nicht einfach auf der Startseite.

Wenn Sie das Modul installiert haben und in den Einstellungen Mehrsprachigkeit aktiviert haben, dann erscheint in den Seiteneinstellungen ein zusätzliche Feld in dem Sie die Verknüpfungen zwischen den Seiten einstellen können. Mit dieser Dropdownliste kann dann die jeweilige Seite mit einer Seite der der Standardsprache verknüpft werden. Damit weiß das System dann welche Seiten zusammen gehören.

Wenn Sie etwas faul sind können sie auch einfach den Sprachumschalter nutzen ohne das sie Verknüpfungen zwischen den Seiten definiert haben. (Der Schaltet dann natürlich immer auf die Startseite)

Um das Sprachmenu anzuzeigen brauchen Sie folgenden Code im Template:

	<?php  if(function_exists('language_menu')) { language_menu(); }  ?>
	
Mögliche Optionen sind png,gif,jpg,txt,TXT.
 
	<?php  if(function_exists('language_menu')) { language_menu('png'); }  ?>
	
jpg - benutzt die etwas größeren .jpg Flaggen.
txt - gibt einfach die länder als Abkürzung aus. (DE EN FR)
TXT - gibt die Länder als Text aus (Deutsch English Francaise)
png - benutzt die etwas größeren .png Flaggen
gif - benutzt die kleineren .gif Flaggen

Default ist 'txt'!
TXT nutzt den Titel der Ordnerseiten, dieses Feature ist experimentell. 

Eine entsprechendes erzeugtes Menü sieht dann im HTML etwa so aus:


	<div id="langmenu">
		<a class="current" href ="http://mydomain.de/pages/de/startseite.php" title="Germany" >
			<span>
				<img src="http://mydomain.de/modules/mod_multilingual/flags/de.png" alt="Germany" title="Germany" />
			</span>
		</a>
		<a  class="default" href ="http://mydomain.de/pages/en.php" title="English" >
			<span>
				<img src="http://mydomain.de/modules/mod_multilingual/flags/en.png" alt="English" title="English" />
			</span>
		</a>
		<a  class="default" href ="http://mydomain.de/pages/fr.php" title="French" >
			<span>
				<img src="http://mydomain.de/modules/mod_multilingual/flags/fr.png" alt="French" title="French" />
			</span>
		</a>
	</div>




Eine Annnmerkung für interessierte:

Damit der Menüpunkt im Backend angezeigt wird ,
müssen folgende Bedingungen erfüllt sein:

1. Das Datenbankfeld "page_code" ist vorhanden.(legt der Modul Installer an)
2. Seitensprache ist eingeschaltet
3. Die Datei update_keys.php im Ordner /modules/mod_multilingual/ ist vorhanden.
   (Also das Modul ist installiert.)

		

