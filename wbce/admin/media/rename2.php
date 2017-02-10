<?php
/**
 * WebsiteBaker Community Edition (WBCE)
 * Way Better Content Editing.
 * Visit http://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

// Create admin object
require('../../config.php');
$admin = new admin('Media', 'media_rename', false);

// Include WBCE functions file (legacy for WBCE 1.1.x)
require_once WB_PATH . '/framework/functions.php';

// Get current dir (relative to media)
$requestMethod = '_'.strtoupper($_SERVER['REQUEST_METHOD']);
$directory = (isset(${$requestMethod}['dir'])) ? ${$requestMethod}['dir'] : '';
$directory = ($directory == '/' or $directory == '\\') ? '' : $directory;
$dirlink = 'browse.php?dir='.$directory;

// Ensure directory is inside WBCE media folder
if (!check_media_path($directory)) {
	$admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS'], 'browse.php?dir=', false);
	die;
}

// include functions.php (backwards compatibility with WBCE 1.x)
require_once WB_PATH . '/framework/functions.php';

// Get the temp id
$file_id = intval($admin->checkIDKEY('id', false, $_SERVER['REQUEST_METHOD']));
if (!$file_id) {
	$admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS'],$dirlink, false);
	die;
}

// Check for potentially malicious files
$forbidden_file_types  = preg_replace( '/\s*[,;\|#]\s*/','|',RENAME_FILES_ON_UPLOAD);
// Get home folder not to show
$home_folders = get_home_folders();

// Figure out what folder name the temp id is
if($handle = opendir(WB_PATH.MEDIA_DIRECTORY.'/'.$directory)) {
	// Loop through the files and dirs an add to list
	while (false !== ($file = readdir($handle))) {
		$info = pathinfo($file);
		$ext = isset($info['extension']) ? $info['extension'] : '';
		if(substr($file, 0, 1) != '.' AND $file != '.svn' AND $file != 'index.php') {
			if( !preg_match('/'.$forbidden_file_types.'$/i', $ext) ) {
				if(is_dir(WB_PATH.MEDIA_DIRECTORY.$directory.'/'.$file)) {
					if(!isset($home_folders[$directory.'/'.$file])) {
						$DIR[] = $file;
					}
				} else {
					$FILE[] = $file;
				}
			}
		}
	}

	$temp_id = 0;
	if(isset($DIR)) {
		sort($DIR);
		foreach($DIR AS $name) {
			$temp_id++;
			if($file_id == $temp_id) {
				$rename_file = $name;
				$type = 'folder';
			}
		}
	}

	if(isset($FILE)) {
		sort($FILE);
		foreach($FILE AS $name) {
			$temp_id++;
			if($file_id == $temp_id) {
				$rename_file = $name;
				$type = 'file';
			}
		}
	}
}

// Check if there is a file/folder to rename
if(!isset($rename_file)) {
	$admin->print_error($MESSAGE['MEDIA_FILE_NOT_FOUND'], $dirlink, false);
	die;
}

// Check if a new file/folder name was defined
$file_id = $admin->getIDKEY($file_id);
if($admin->get_post('name') == '') {
	$admin->print_error($MESSAGE['MEDIA_BLANK_NAME'], "rename.php?dir=$directory&id=$file_id", false);
	die;
}

// Extract new name and file extension from user input
$new_name = media_filename($admin->get_post('name'));
$extension = media_filename($admin->get_post('extension'));

if($type == 'file' && ($extension == '' || $extension == '_')) {
	$admin->print_error($MESSAGE['MEDIA_BLANK_EXTENSION'], "rename.php?dir=$directory&id=$file_id", false);
	die;
}

// Stop hiding files/folders by adding a leading dot
if (substr($new_name, 0, 1) == '.') {
	$admin->print_error($MESSAGE['MEDIA_CANNOT_RENAME'], "rename.php?dir=$directory&id=$file_id", false);
	die;
}

// Check if the file extension is in blacklist
$ext = stristr($extension, '.');
$ext = substr($ext, 1, strlen($ext));
if (preg_match('/' . $forbidden_file_types . '$/i', $ext)) {
	$admin->print_error($MESSAGE['MEDIA_CANNOT_RENAME'], "rename.php?dir=$directory&id=$file_id", false);
	die;
}

// Concatenate new filename, strip invalid chars and perform some checks
$name = media_filename($new_name . $extension);
if($name == 'index.php') {
	$admin->print_error($MESSAGE['MEDIA_NAME_INDEX_PHP'], "rename.php?dir=$directory&id=$file_id", false);
	die;
}

// Check if we should overwrite or not
if($admin->get_post('overwrite') != 'yes' AND file_exists(WB_PATH.MEDIA_DIRECTORY.$directory.'/'.$name) == true) {
	if($type == 'folder') {
		$admin->print_error($MESSAGE['MEDIA_DIR_EXISTS'], "rename.php?dir=$directory&id=$file_id", false);
	} else {
		$admin->print_error($MESSAGE['MEDIA_FILE_EXISTS'], "rename.php?dir=$directory&id=$file_id", false);
	}
	// stop script execution (file or folder already exists)
	die;
}

// Finally, try to rename the file/folder
if(rename(WB_PATH.MEDIA_DIRECTORY.$directory.'/'.$rename_file, WB_PATH.MEDIA_DIRECTORY.$directory.'/'.$name)) {
	$admin->print_success($MESSAGE['MEDIA_RENAMED'], $dirlink);
} else {
	$admin->print_error($MESSAGE['MEDIA_CANNOT_RENAME'], "rename.php?dir=$directory&id=$file_id", false);
	die;
}
