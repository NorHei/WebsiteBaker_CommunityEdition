<?php
/**
 * @category        modules
 * @package         adminer
 * @author          Jakub Vrána (Adminer)
 * @author          Bernd Michna (WBCE Wrapper)
 * @author          WBCE Project
 * @copyright       2016, WBCE Project
 * @link            http://www.wbce.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see info.php of this module
 *
 */


/*
Info for module(tool) builders.
Already included here :
config.php
framework/initialize.php
framework/class.wb.php
framework/class.admin.php
framework/functions.php

Admin class is initialized($admin) and header printed.

Additional vars for this tool: 
$modulePath     Path to this module directory
$languagePath   Path to language files of this module
$returnToTools  Url to return to generic tools page
$returnUrl      Url for return link after saving AND for sending the form!
$doSave         Set true if form is send
$saveSettings   Set true if there are actual settings send
$saveDefault    Set true if default button was pressed
$toolDir        Plain tool directory name like "maintainance_mode"
$toolName       The name of the tool eg "Maintainance Mode"

For language vars please take a look in the language files.
Language files no longer need manual loading.

All other vars usually abailable in Admin pages schould be available here too.
Maybe you need to import them via global.

backend.js and backend.css are automatically loaded, 
manual loading is no longer required.
*/

//no direct file access
if(count(get_included_files())==1) die(header("Location: ../index.php",TRUE,301));


//Manual loading a possible templatefile in the BE template as this module 
//is for WBCE before 1.2.x

// Path in BE template
$path=THEME_PATH.'/modules/adminer/templates/tool.tpl.php';

// If no file exists in BE template use the one in module
if (!file_exists($path)) $path=$modulePath.'templates/tool.tpl.php';

// include the file
include($path);




