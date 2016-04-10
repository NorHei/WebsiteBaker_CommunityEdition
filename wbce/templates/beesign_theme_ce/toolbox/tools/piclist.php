<?php include('../header.php'); ?>
<a class="toolboxmenue"  href="../toolbox.php?page_id=<?php echo $page_id; ?>">Back</a> 


<div id="toolbox_piclist">
<?php 

$picture_dir = '/user_uploads';	
$file_dir= WB_PATH.MEDIA_DIRECTORY.$picture_dir;

$allpreviews = '';

$files = glob($file_dir.'/*.*');
/*
usort($files, function($a, $b) {
	return filemtime($a) < filemtime($b);
});
*/
//var_dump($files);
foreach($files as $file){
	$thepreview = '';	
	$file = basename($file);
	if ($file == "index.php") continue;
	
	$width = 0;
	if (preg_match('/.+\.(jpeg|jpg|gif|png|JPG|GIF|PNG)$/',$file)) {
		list($width, $height, $type, $attr) = getimagesize($file_dir.'/'.$file);
		$thepreview = '<img src="'.WB_URL.MEDIA_DIRECTORY.$picture_dir.'/'.$file.'" class="upl_w_'.$width.'" alt="" title="'.$file.'" />';	
		if ($width > 0) $thepreview .= '<div class="fileattr">width: '.$width.' px</div>';				
	} 
	if ($thepreview == '') {
	//Kein Bild:
		//if (preg_match('/.+\.(doc|docx|pdf|xls)$/',$file)) {} Whitelist oder Blacklist??	
		$thepreview = '<a href="'.WB_URL.MEDIA_DIRECTORY.$picture_dir.'/'.$file.'" target="_blank" alt="" title="'.$file.'" />[FILE]</a>';
	}	
	
	if ($thepreview != '') {$allpreviews = $allpreviews.$thepreview.'<div class="filename">'.$file.'</div>'; }

}

if ($allpreviews == '') {
	echo '<p class="toolboxcontent">No files found in<br/><b>'.MEDIA_DIRECTORY.$picture_dir.'/</b></p>';
} else {
	echo '<h3 class="toolboxcontent">Drag & Drop the files:</h3>';
	echo $allpreviews;
}
if ($allpreviews == '') {echo '<p class="toolboxcontent">No directory found: <br/><b>'.MEDIA_DIRECTORY.$picture_dir.'</b></p>';}



?>
</div>

</body>
</html>
