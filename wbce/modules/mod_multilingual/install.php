<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}


// include_once('../../config.php');
$mod_path = dirname(__FILE__);
$mod_rel = str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\', '/', $mod_path ));
$mod_name = basename($mod_path);
include('lang.functions.php');
include(get_module_language_file($mod_name));

// this function checks the basic configurations of an existing WB intallation
function status_msg($message, $class='check', $element='span') {
	// returns a status message
	print '<'.$element .' class="' .$class .'">' .$message .'</' .$element.'>';
}

/**********************************************************
 *  - Add field "page_code" to table "pages"
 */

print '<h3>Step 1: Updating database pages entrie</h3>';

$database->field_add( TABLE_PREFIX.'pages', 'page_code','INT(11) NOT NULL AFTER `modified_by`');

print '<h3>Step 2: Updating field page_code with page_id by default language</h3>';

$lang_array = get_page_languages(); // check for page languages

if(count($lang_array))
{
            $entries = array();
            $entries = get_page_list( 0 );
           // fill page_code with $page_id for default_language
              while( list( $page_id, $val ) = each ( $entries ) )
                {
                  if( $val['language'] == DEFAULT_LANGUAGE )
                  {
                      db_update_field_entry($page_id, 'pages', (int)$page_id );
                  }
              }
}

// Print admin footer
// $admin->print_footer();
