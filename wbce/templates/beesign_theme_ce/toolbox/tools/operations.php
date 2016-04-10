<?php include('../header.php'); ?>
<a class="toolboxmenue"  href="../toolbox.php?page_id=<?php echo $page_id; ?>">Back</a> 
<div class="toolboxcontent">
<h3>Save before you click!</h3>
<hr/>

<?php 
$topbackurl = WB_URL.'/'.ADMIN_DIRECTORY.'/pages/modify.php?page_id='.$page_id;

$theq = "SELECT * FROM " . TABLE_PREFIX . "sections WHERE page_id = ".$page_id." AND module='menu_link'";
$erg = $database->query($theq);
if ($erg->numRows() == 1) {
	echo '<p><b>Remove Menu_Link</b></p><p>Here you can remove the Menu_Link in order to add other sections and get a "normal" page</p>
	<p><b>Note:</b> If want to change a "normal" page to a Menu_Link, you have to delete all sections first</p>';
	
	if ( isset($_GET['do']) AND $_GET['do'] == 'deleteml' ) {
		$theq = "DELETE FROM " . TABLE_PREFIX . "sections WHERE page_id = ".$page_id." AND module='menu_link'";
		$database->query($theq);
		$theq = "DELETE FROM " . TABLE_PREFIX . "mod_menu_link WHERE page_id = ".$page_id;
		$database->query($theq);
		
		echo '<script type="text/javascript">
			window.top.location.href = "'.$topbackurl.'";
		</script>';
		
		
	} else {
		echo '<h3><a href="?page_id='.$page_id.'&amp;do=deleteml">Remove Menu_Link<a></h3>';
	}	
	echo '</div></body></html>';
	die();
} 

$theq = "SELECT * FROM " . TABLE_PREFIX . "sections WHERE page_id = ".$page_id;
$erg = $database->query($theq);
if ($erg->numRows() == 0) {
	echo "<h3>The pagehas no sections. You can add a menulink</h3>";
	
	if ( isset($_GET['do']) AND $_GET['do'] == 'insertml' ) {
		$theq = "INSERT INTO `".TABLE_PREFIX ."sections` (`page_id` ,`position` ,`module` ,`block` ,`publ_start` ,`publ_end`) VALUES ( '$page_id',  '0',  'menu_link',  '2',  '0',  '0');";
		$database->query($theq);
		echo $theq;
		$section_id = $database->get_one("SELECT LAST_INSERT_ID()");	
		
		$theq = "INSERT INTO ".TABLE_PREFIX ."mod_menu_link  (`page_id`, `section_id`, `target_page_id`, `anchor`, `extern`) VALUES ('$page_id', '$section_id', '0', '0', '')";
		//$theq = "INSERT INTO ".TABLE_PREFIX ."mod_menu_link  (`page_id`, `target_page_id`, `anchor`, `extern`) VALUES ('$page_id', '0', '0', '')";
		$database->query($theq);
		echo '<script type="text/javascript">
			window.top.location.href = "'.$topbackurl.'";
		</script>';
	} else {
		echo '<h3><a href="?page_id='.$page_id.'&amp;do=insertml">Insert Menulink<a></h3>';
	}	
	echo '</div></body></html>';
	die();
}

echo '<h3>no operations</h3>';
/*
$frontendlink = WB_URL.PAGES_DIRECTORY.$weblink.PAGE_EXTENSION;
$editlink = WB_URL.'/'.ADMIN_DIRECTORY.'/pages/modify.php?page_id='.$zeile['page_id'];
echo '<p>'. $aenderungsdatum .'<br/><a href="'.$editlink.'" target="_top"><b>'. $zeile['menu_title'].'</b></a>'. $weblink_text . '</p>';
*/

?>

</div>
</body>
</html>
