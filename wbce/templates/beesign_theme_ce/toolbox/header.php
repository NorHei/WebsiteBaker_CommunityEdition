<?php 
if (file_exists('../../../config.php')) {
	require('../../../config.php');
	$raus = '';
} else {
	require('../../../../config.php');
	$raus = '../';
}
//as ist mal nur kopiert, ohne Überprüfung und funktion

if(!defined('WB_PATH')) { exit("Cannot access this file directly"); } 
if (!defined('THEME_URL')) define ("THEME_URL", ADMIN_URL);

$theauto_header = false;
require_once(WB_PATH.'/framework/class.admin.php');
$admin = new admin('Pages', 'pages_modify', $theauto_header, TRUE);
$page_id = (int) $_GET['page_id'];


if(!$admin->is_authenticated()) {
	die();
} 
/*
// Load Language file
if(LANGUAGE_LOADED) {
	if(!file_exists(WB_PATH.'/modules/'.$mod_dir.'/languages/'.LANGUAGE.'.php')) {
		require_once(WB_PATH.'/modules/'.$mod_dir.'/languages/EN.php');
	} else {
		require_once(WB_PATH.'/modules/'.$mod_dir.'/languages/'.LANGUAGE.'.php');
	}
}
*/

$user_id = $admin->get_user_id();
$user_in_groups = $admin->get_groups_id();

$mod_dir = basename(dirname(__FILE__));
?>



<!DOCTYPE html>
<html>
<head>
<title>Toolbox Start</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="<?php echo $raus; ?>toolbox.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $raus; ?>toolbox.js" type="text/javascript"></script>
</head>

<body>