<?php
/**
 * WebsiteBaker Community Edition (WBCE)
 * More Baking. Less Struggling.
 * Visit http://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

require('../../config.php');
require_once(WB_PATH.'/framework/class.admin.php');
require_once(WB_PATH.'/framework/functions.php');

//Fetch toolname
$toolDir = (isset($_GET['tool']) && (trim($_GET['tool']) != '') ? trim($_GET['tool']) : '');
  
// figure out if the form of the tool was send
// the form needs to have exactly the right field names for this to function.
// 'save_settings' set or 'action'set and == 'save'
$doSave = (isset($_POST['save_settings']) || (isset($_POST['action']) && strtolower($_POST['action']) == 'save'));

// Defining some path for use in the actual admin tool
$modulePath=WB_PATH.'/modules/maintainance_mode/'; // we need this one later on too 
$languagePath=$modulePath.'languages/';
$returnToTools = ADMIN_URL.'/admintools/index.php';
$returnUrl= ADMIN_URL.'/admintools/tool.php?tool=maintainance_mode';

$toolCheck = true;

// test for valid tool name
if(!preg_match('/^[a-z][a-z_\-0-9]{2,}$/i', $toolDir)) $toolCheck=false;

// Check if tool is installed
$sql = 'SELECT `name` FROM `'.TABLE_PREFIX.'addons` '.
	   'WHERE `type`=\'module\' AND `function`=\'tool\' '.
       'AND `directory`=\''.$database->escapeString($toolDir).'\'';
if(!($toolName = $database->get_one($sql)))  $toolCheck=false;

// back button triggered, so go back.
if (isset ($_POST['admin_tools'])) {$toolCheck=false;}

// all ok go for display
if ($toolCheck) {
    // create admin-object 
    $admin = new admin('admintools', 'admintools');

    // show title if not function 'save' is requested
    if(!$doSave) {
		print '<h4><a href="'.ADMIN_URL.'/admintools/index.php" '.
			  'title="'.$HEADING['ADMINISTRATION_TOOLS'].'">'.
			   $HEADING['ADMINISTRATION_TOOLS'].'</a>'.
			  '&nbsp;&raquo;&nbsp;'.$toolName.'</h4>'."\n";
	}

    // Loading language files we start whith default EN
    if(is_file($languagePath.'EN.php'))        require_once($languagePath.'EN.php');        
    // Get actual language if exists
    if(is_file($languagePath.LANGUAGE.'.php')) require_once($languagePath.LANGUAGE.'.php'); 

    //Load actual tool
    require(WB_PATH.'/modules/'.$toolDir.'/tool.php');

    // output footer
	$admin->print_footer();  
} else {
    // invalid module name requested, jump to index.php of admintools
	header('location: '.$returnToTools);
	exit(0);
}


