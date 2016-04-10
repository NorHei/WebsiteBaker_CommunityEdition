Multilingual 
-----------------

Basically WBCE does not need Multilingual for creating multilanguage pages. Just activate multilanguage support in settings and generate a directory structure like this.

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

Please keep in mind to name the languagepages after the languagecodes used in WB(CE) 
like DE, EN, PL... Basically its just the filename that is important, but you only can set the filename manually after creating the page. 

The best module used for this pages is the Menulink, As it can redirect directly to its sub starting page. (Leave link empty till you got some sub pages)

Multilingual serves two purposes:

- It generates a language switcher menu.  
- It is used to connect multilanguage pages whith the same topic. So if you switch from German "Impressum" to English you get the English "Imprint" page not just the English startpage.

If you installed the module AND activated page languages in the option 
settings of WBCE, there will be an extra field in pagesettings to select 
the matching page in default language to connect to.

If you are somewhat lazy you can use this module as a simple language switcher even if pages 
are not connected to each other. 

To display the language menu you need to add the following lines to your template:

	<?php  if(function_exists('language_menu')) { language_menu(); }  ?>

Possible options are:  png,gif,jpg,txt,TXT.

	<?php  if(function_exists('language_menu')) { language_menu('png'); }  ?>

jpg - uses the taller .png flags.
txt - Just writes the language shortcuts. (DE EN FR)
TXT - Writes language names. (Deutsch English Francaise)
png - uses the taller .png flags.
gif - uses the smaller .gif flags

Default is txt!
TXT uses the Title of the language pages, this feature is experimental.  

The generated HTML should look like this:

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



To see the additional field in backend you need to match the folowing conditions:

1. Database needs to contain the field "page_code" in table "pages".(The module installer schould create this)
2. Multilanguage is activated in options(Settings).
3. The file "update_keys.php" whithin folder "/modules/mod_multilingual/" does exist.(Module is installed.)

		

