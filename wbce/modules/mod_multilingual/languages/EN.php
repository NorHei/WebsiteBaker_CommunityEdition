<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}


// Set the language information
$language_code = 'EN';
$language_name = 'English';
$language_version = '2.8';
$language_platform = '2.8.x';
$language_author = 'Stefan Braunewell, Matthias Gallas';
$language_license = 'GNU General Public License';

$MENU['LANG_PAGES'] = 'Languagepages';
$LANG['EN'] = 'english';
$MESSAGE['PAGES']['UPDATE_SETTINGS'] = 'Catchwords were updated';


?>
