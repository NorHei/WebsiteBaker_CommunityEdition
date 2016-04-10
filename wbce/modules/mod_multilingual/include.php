<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}


// this is by far the worst Hack i ever done
// This compete braindead piece of code needs $admin but is a frontend module 
// Who ever programmed this piece of shit in first place must be completely braindead 
// UNBELIEVABLE!!!!
$admin=&$wb;


function language_menu($ext='txt') {
    global $database;

	if (!preg_match("/jpg|png|gif|txt|TXT/", $ext)) $ext='txt';

	$mod_path = str_replace('\\', '/', dirname(__FILE__));
	$mod_rel = str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\', '/', $mod_path ));
	$mod_name = basename($mod_path);

	include('lang.functions.php');

    // Work-out we should check for existing page_code
    $field_set = $database->field_exists(TABLE_PREFIX.'pages', 'page_code');
    if (defined('PAGE_LANGUAGES') && (PAGE_LANGUAGES==true) && ($field_set==true)) {
		include(get_module_language_file($mod_name));
		$langIcons  = array();
		echo '<div id="langmenu">'.PHP_EOL;
		$langIcons = set_language_icon(PAGE_ID,$ext );

        if( sizeof($langIcons) > 1 ) {
			foreach( $langIcons as $key=>$value ) {
				print $value;
			}
		}
	}
	print "\t".'</div>'.PHP_EOL;
    return true;
}


