<?php

/*
  Lepton Project <http://www.lepton-cms.org/>
  Copyright (C) 2010, Lepton Project

*/



// Must include code to stop this file being access directly
if(defined('WB_PATH') == false) { exit("Cannot access this file directly"); }

// Delete the editor directory
rm_full_dir(WB_PATH.'/modules/nicEdit/nicEdit');

?>