<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}


/**
  Module developed for the Open Source Content Management System WBCE (http://WBCE.org)
  Copyright (C) 2009-2010, Dietmar Wöllbrink (wdsnet.de)
  Reworked 2015 by Norbert Heimsath (heimsath.org)

  This module is free software. You can redistribute it and/or modify it
  under the terms of the GNU General Public License  - version 2 or later,
  as published by the Free Software Foundation: http://www.gnu.org/licenses/gpl.html.

  This module is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
**/


$module_directory = 'mod_multilingual';
$module_name = 'Multilingual Switcher 1.6.7';
$module_function = 'snippet';
$module_version = '1.7.0';
$module_status	= 'beta';
$module_platform = '2.8.3';
$module_author = 'LuiseHahne, Norbert Heimsath';
$module_license = 'GNU General Public License 2';
$module_requirements = 'min. PHP 5.2.2 and WB 2.8.2 or higher)';
$module_description = 'This snippet switches between different languages and tries to keep position in page structure';

