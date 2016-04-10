<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}


// Get page id
if(isset($_GET['page_id']))
{
	$temp_page_id =  intval( htmlentities($_GET['page_id'] ) );
}

include_once('../../config.php');
$mod_path = dirname(__FILE__);
$mod_rel = str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\', '/', $mod_path ));
$mod_name = basename($mod_path);

// Include WB admin wrapper script
$update_when_modified = false; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');

include('lang.functions.php');
include(get_module_language_file($mod_name));

$lang_array = get_page_languages(); // check for page languages

if(count($lang_array))
{
            $entries = array();
            $entries = get_page_list( 0 );
            // fill page_code with menu_title for default_language
            while( list( $page_id, $val ) = each ( $entries ) )
            {
				db_update_field_entry((int)$page_id, 'pages', (int)$page_id );
            }
}

// Check if there is a db error, otherwise say successful
if($database->is_error())
{
	$admin->print_error($database->get_error(), ADMIN_URL.'/pages/index.php' );
} else {
	$admin->print_success($MESSAGE['PAGES']['UPDATE_SETTINGS'], ADMIN_URL.'/pages/settings.php?page_id='.$temp_page_id );
}
// Print admin footer
// $admin->print_footer();
