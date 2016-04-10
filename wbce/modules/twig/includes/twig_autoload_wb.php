<?php
//no direct file access
if(count(get_included_files())==1) die(header("Location: ../index.php",TRUE,301));

// register TWIG autoloader ---
require WB_PATH . '/modules/twig/classes/Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

require_once WB_PATH . '/modules/twig/includes/twig_initialize_wb.php';
 
