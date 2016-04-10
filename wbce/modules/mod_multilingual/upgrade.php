<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}


include('lang.functions.php');

// Work-out if we should check for existing page_code
$sql = 'DESCRIBE `'.TABLE_PREFIX.'pages` `page_code`';
$field_sql = $database->query($sql);
$field_set = $field_sql->numRows();
// $field_set = $database->field_add('page_code', 'pages', 'INT(11) NOT NULL AFTER `modified_by`');

// extract page_id from old format
$pattern = '/(?<=_)([0-9]{1,11})/s';

$format = $field_sql->fetchRow(MYSQL_ASSOC) ;

// upgrade only if old format
if($format['Type'] == 'varchar(255)' )
{
    $sql = 'SELECT `page_code`,`page_id` FROM `'.TABLE_PREFIX.'pages` ORDER BY `page_id`';
    $query_code = $database->query($sql);
    while( $page  = $query_code->fetchRow(MYSQL_ASSOC))
    {
        preg_match($pattern, $page['page_code'], $array);
        $page_code = $array[0];
        $page_id =  $page['page_id'];
        $sql  = 'UPDATE `'.TABLE_PREFIX.'pages` SET ';
        $sql .= (empty($array[0])) ? '`page_code` = 0 ' : '`page_code` = '.$page_code.' ';
        $sql .= 'WHERE `page_id` = '.$page_id;
        $database->query($sql);
    }
    $sql = 'ALTER TABLE `'.TABLE_PREFIX.'pages` MODIFY COLUMN `page_code` INT(11) NOT NULL';
    $database->query($sql);
}
//
$directory = dirname(__FILE__).'/'.'info.php';
// update entry in table addons to new version
load_module($directory, $install = false);
// Print admin footer
// $admin->print_footer();

