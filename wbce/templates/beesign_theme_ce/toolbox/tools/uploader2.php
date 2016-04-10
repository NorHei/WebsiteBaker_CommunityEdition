<?php include('../header.php'); ?>
<a class="toolboxmenue"  href="../toolbox.php?page_id=<?php echo $page_id; ?>">Back</a> 
<?php

if (!$_FILES['uploadfile']['tmp_name'] OR $_FILES['uploadfile']['tmp_name'] == '') {
	echo '<p>no file uploaded!</p>';
	die();
}


require_once(WB_PATH."/framework/functions.php");
require_once("upload/imagefunctions.php");

//Check, if there are the folders in media directory
$userfile_dir = '/user_uploads';	
$file_dir= WB_PATH.MEDIA_DIRECTORY.$userfile_dir;
if (!is_dir($file_dir)) { 
	if(!@mkdir($file_dir, 0777)){
		die ('<p style="color: red; text-align: center;">Could not create file-folder</p>');
	}
}

$origfileFolder = $file_dir.'/orig';
if(!is_dir($origfileFolder)){
	$u = umask(0);
	if(!@mkdir($origfileFolder, 0777)){
		echo '<p style="color: red; text-align: center;">Could not create orig-folder</p>';
	}
	umask($u);
}

//File checken:
//chechen, ob das ein Bild ist:
$w_view = 0+(int) $_POST['resizew'];
$h_view = 0+(int) $_POST['resizeh'];
@@ list($width, $height, $type, $attr) = getimagesize($_FILES['uploadfile']['tmp_name']);

$bildtype = '';
if ($type == 1) {$bildtype = "gif";}
if ($type == 2) {$bildtype = "jpg";}			
if ($type == 3) {$bildtype = "png";}


$filename = trim($_FILES['uploadfile']['name']);
$path_parts = pathinfo($filename);
if ($bildtype == '') {$fileext = strtolower($path_parts['extension']);} else {$fileext = $bildtype;}
$filename = substr($filename, 0, strlen($filename) - (strlen($fileext) + 1));
$filename = page_filename($filename); 
//echo '<p>'.$filename.'</p>';

$messages = '';

//Checken ob überschreiben:
$filereload='';
if(isset($_POST['nooverwrite']) ) {
	$ncount = 1;
	while ($ncount < 100) {
		if ($ncount == 1) {
			$newfile_name = $filename.'.'.$fileext;
		} else {
			$newfile_name = $filename.'-'.$ncount.'.'.$fileext;
		}
		$newfile_path = $file_dir.'/'.$newfile_name;
		if (!file_exists($newfile_path)) {break;}
		$ncount++;
	}
} else {
	$newfile_name = $filename.'.'.$fileext;
	$newfile_path = $file_dir.'/'.$newfile_name;
	if (file_exists($newfile_path)) {$filereload='?t='.time();}
}
	
//echo '<p>'.$newfile_path.'</p>';	


	

//Wenn kein Bild: Checken ob es eine erlaubte Datei ist:
if ($bildtype == "" OR $width == 0) {

	//No image// Get real filename and set new filename
	//======================================================
	
	
	$iconspath = '/templates/beesign_theme/toolbox/img/file_icons';
	$icons_dir = WB_PATH.$iconspath;
	$iconsArr = glob($icons_dir.'/*.png');
	$allowed = array();
	foreach($iconsArr as $icon){	
		$allowed[] = str_replace('.png', '',basename($icon) );
	}
	
	//$allowed = array('jpg','pdf','doc','docx','xls','zip', 'txt');
	if (!in_array($fileext, $allowed)) {
		echo '<h1>Die Extension "'.$fileext.'" ist nicht in der Whitelist.</h1><p>Sollte dies ein Fehler sein, wenden Sie sich bitte an den Administrator</p>';
		die();
	}
	
	
	
	//$size = round( filesize ($path) / 1024 );
	//nur verschieben
	
	if (! move_uploaded_file($_FILES['uploadfile']['tmp_name'], $newfile_path))  { 
		die (' <h2>Speichern der Datei fehlgeschlagen!</h2>');	
	 } else {
		 change_mode($newfile_path);
		 $link = WB_URL.MEDIA_DIRECTORY.$userfile_dir.'/'.$newfile_name;
		 echo '<div id="toolbox_piclist"><a style="font-size:auto;"  target="blank" href="'.$link.'">
		 <img src="../img/file_icons/'.$fileext.'.png" style="font-size:auto;" alt="" title="'.$newfile_name.'" /></a><br/>
		 <a style="font-size:auto;"  target="blank" href="'.$link.'">'.$newfile_name.'</a>
		 </div>';
echo $messages;
	 }
	echo '</body></html>';
	return 0;
	//die('Bis hier OK');
}


//Ist also ein Bild:

$orig_ratio = $width / $height;


//---------------------------------------------------------------------------------
//Gegen Hirn-Knoten
$doresize = false;
if ($w_view != 0 AND $width > $w_view ) {$doresize = true;}
if ($h_view != 0 AND $height > $h_view ) {$doresize = true;}
if ($doresize) {
	// Original behalten und dann verkleinern
	$origfilepath = $file_dir.'/orig/'.$newfile_name;
	if (! move_uploaded_file($_FILES['uploadfile']['tmp_name'], $origfilepath))  { die (' <h2>Speichern fehlgeschlagen!</h2>'); }
	$newfilepath = $file_dir.'/'.$newfile_name;
	resizepic($origfilepath, $newfile_path, $w_view, $h_view);
	$filepath = $newfilepath;	
	$messages .= '<p>Original File saved [<a target="_blank" href="'.WB_URL.MEDIA_DIRECTORY.$userfile_dir.'/orig/'.$newfile_name.'">link</a>]</p>';
} else {
	//nur verschieben
	$filepath = $file_dir.'/'.$newfile_name;
	if (! move_uploaded_file($_FILES['uploadfile']['tmp_name'], $newfile_path))  { die (' <h2>Speichern fehlgeschlagen!</h2>'); }
}

echo '<div id="toolbox_piclist"><img src="'.WB_URL.MEDIA_DIRECTORY.$userfile_dir.'/'.$newfile_name.'" style="font-size:auto;" alt="" title="'.$newfile_name.$filereload.'" /></div>';
echo $messages;

?>

</body></html>