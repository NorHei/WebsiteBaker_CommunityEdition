<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}


include_once(WB_PATH.'/framework/functions.php');
include_once(WB_PATH.'/framework/module.functions.php');
require_once(WB_PATH.'/framework/class.frontend.php');
require_once(WB_PATH.'/framework/class.admin.php');

$default_language = DEFAULT_LANGUAGE;
// later get from addons or directory
$allowed_langs = array ( 'bg','ca','cs','da','de','en','es','et','fi','fr','hr',
                         'hu','it','lv','nl','no','pl','pt','ru','se','sk','tr' );

// Browsersprache ermitteln
function lang_getfrombrowser ($allowed_langs, $default_language, $lang_variable = null, $strict_mode = true) {
        // $_SERVER['HTTP_ACCEPT_LANGUAGE'] verwenden, wenn keine Sprachvariable mitgegeben wurde
        if ($lang_variable === null)
        {
                $lang_variable = isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])
                    ? $_SERVER['HTTP_ACCEPT_LANGUAGE']
                    : 'en-GB';
        }

        // wurde irgendwelche Information mitgeschickt?
        if (empty($lang_variable))
        {
                // Nein? => Standardsprache zur�ckgeben
                return strtoupper($default_language);
        }

        // Den Header auftrennen
        $accepted_languages = preg_split('/,\s*/', $lang_variable);

        // Die Standardwerte einstellen
        $current_lang = $default_language;
        $current_q = 0;

        // Nun alle mitgegebenen Sprachen abarbeiten
        foreach ($accepted_languages as $accepted_language)
        {
                // Alle Infos �ber diese Sprache rausholen
                $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)'.
                                   '(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accepted_language, $matches);

                // war die Syntax g�ltig?
                if (!$res)
                {
                        // Nein? Dann ignorieren
                        continue;
                }

                // Sprachcode holen und dann sofort in die Einzelteile trennen
                $lang_code = explode ('-', $matches[1]);

                // Wurde eine Qualit�t mitgegeben?
                if (isset($matches[2]))
                {
                        // die Qualit�t benutzen
                        $lang_quality = (float)$matches[2];
                } else {
                        // Kompabilit�tsmodus: Qualit�t 1 annehmen
                        $lang_quality = 1.0;
                }

                // Bis der Sprachcode leer ist...
                while (count ($lang_code))
                {
                        // mal sehen, ob der Sprachcode angeboten wird
                        if (in_array (strtolower (join ('-', $lang_code)), $allowed_langs))
                        {
                                // Qualit�t anschauen
                                if ($lang_quality > $current_q) {
                                        // diese Sprache verwenden
                                        $current_lang = strtolower (join ('-', $lang_code));
                                        $current_q = $lang_quality;
                                        // Hier die innere while-Schleife verlassen
                                        break;
                                }
                        }
                        // Wenn wir im strengen Modus sind, die Sprache nicht versuchen zu minimalisieren
                        if ($strict_mode)
                        {
                                // innere While-Schleife aufbrechen
                                break;
                        }
                        // den rechtesten Teil des Sprachcodes abschneiden
                        array_pop ($lang_code);
                }
        }

        // die gefundene Sprache zur�ckgeben
        return strtoupper($current_lang);
}

function get_languages($langKey) {
    global $database, $admin;
    $return_value = 'English';
    $sql  = 'SELECT `name`,`type`,`directory` FROM `'.TABLE_PREFIX.'addons` ';
    $sql .= 'WHERE `type` = \'language\' AND `directory` = \''.$langKey.'\' ';

    $query_num = $database->query($sql);
    if( !$database->is_error() && ($query_num->numRows() == 1) )
    {
        $result  = $query_num->fetchRow(MYSQL_ASSOC);
        $return_value = $result['name'];
    } else {
        $return_value = $admin->print_error($database->get_error(),'');
    }
    return $return_value;
}

function set_language_icon ($pageId = 0, $ext='txt' )
{
    $return_value = array();
    $mod_path = dirname(__FILE__);
    $mod_rel = str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\', '/', $mod_path ));
    $mod_name = basename($mod_path);

    $array = get_page_languages();
    $array2= get_pageCode_values( $pageId );
    $langPageArray = array_merge($array , $array2);

    foreach( $langPageArray as $key=>$value )
    {
        $langKey = $key;
        if($array[$langKey]['visibility'] == 'hidden') {continue;}
        $page_title = get_languages($langKey);
        $langUrl = get_page_url( $value);
        $class = strtoupper($langKey) == LANGUAGE ? 'class="current"' : ' class="default"';
        $return_value [ $langKey ] = "\t\t".'<a '.$class.' href ="'. $langUrl .'" title="'.$page_title.'" >'.PHP_EOL;
        $return_value [ $langKey ] .= "\t\t\t".'<span>';
        if ($ext=='TXT'){
            $return_value [ $langKey ] .=  " ".$array[$key]['page_title'].  " " ;
        } else if ($ext=='txt'){
            $return_value [ $langKey ] .=" $langKey " ;
        } else {
            $return_value [ $langKey ] .= PHP_EOL."\t\t\t\t".'<img src="'.WB_URL.'/modules/'.$mod_name.'/flags/'.strtolower( $langKey ).'.'.$ext.'" alt="'.$page_title.'" title="'.$page_title.'" />'.PHP_EOL."\t\t\t";
        }
        $return_value [ $langKey ] .= '</span>'.PHP_EOL."\t\t".'</a>'.PHP_EOL;
    }
    return $return_value;
}

function get_pageCode_values( $pageId = 0 )
{
    global $database;
    $return_value = array();
    $sql  = 'SELECT `page_code` FROM `'.TABLE_PREFIX.'pages` ';
    $sql .= 'WHERE `page_id` = '.(int)$pageId.' ';
    $sql .= '';
    $query_num = $database->query($sql);
    if($database->is_error())
    {
      return $return_value;
    }

     if($query_num->numRows() == 1)
     {
        $query_result = $query_num->fetchRow(MYSQL_ASSOC);
        $result = trim($query_result['page_code']);
        if(!empty($result))
        {
            // search entry in pages
            $sql = 'SELECT `page_id`, `page_code`,`language`,`visibility` FROM `'.TABLE_PREFIX.'pages` WHERE `page_code` = '.$result.' ORDER BY `position`';
            $query_code = $database->query($sql);
            if($numrows = $query_code->numRows() )
            {
                while( $return  = $query_code->fetchRow(MYSQL_ASSOC))
                {
                  $return_value[$return['language']] = $return;
                }
              }
          }
      }

  return $return_value;
}

// function to update a var/value-pair into table
function db_update_field_entry($page_id, $table, $entry=NULL )
{
    global $database;
    if(!isset($entry))
    {  // set page_code  = $page_id
        $sql  = 'UPDATE  `'.TABLE_PREFIX.$table.'` SET `page_code` = '.$page_id.', ';
    } else {    // if set an entry
        $sql = 'UPDATE `'.TABLE_PREFIX.$table.'` SET `page_code` = '.$entry.', ';
    }
    $sql .= '`modified_when` = '.time().' WHERE `page_id` = '.$page_id;
    $sql .= '';
    return $database->query($sql);
}

// set array with languages setting in wb_pages
function get_page_languages()
{
    global $database, $admin, $wb;
    $result=array();
    $query  = 'SELECT `level`,`page_title`,`language`,`visibility`,`viewing_groups`,`viewing_users`,`page_id`,`page_code`,`link`,`parent` ';
    $query .= 'FROM `'.TABLE_PREFIX.'pages` ';
    $query .= 'WHERE `level` = \'0\' ';
    $query .=   'AND `menu_title` LIKE \'__\' ';
    // $query .=   'AND `visibility` = \'public\' ';
    $query .= 'GROUP BY `language` ';
    $query .=   'ORDER BY `position` ';
    $get_query = $database->query($query);
    if($get_query->numRows() > 0)
    {
        while($value = $get_query->fetchRow(MYSQL_ASSOC))
        {
          if(!$admin->page_is_visible($value)) {continue;}
          $result[$value['language']]['page_id'] = $value['page_id'];
          $result[$value['language']]['page_code'] = $value['page_code'];
          $result[$value['language']]['language'] = $value['language'];
          $result[$value['language']]['visibility'] = $value['visibility'];
          $result[$value['language']]['page_title'] = $value['page_title'];
        }
      }
        
  return $result;
}
// set the absolute url with spezified page_id
function get_page_url( $value )
{
    global $database;
    $return_value = strtolower(WB_URL.PAGES_DIRECTORY.'/'.strtolower(LANGUAGE).PAGE_EXTENSION);
    // if(!isset($langPageArray)) { return $return_value; }
    $sql  = 'SELECT `page_id`, `menu_title`,`link` FROM `'.TABLE_PREFIX.'pages` ';
    $sql .= 'WHERE `page_code` = '.intval($value['page_code']).' ';
    $sql .=   'AND `language` = \''.$value['language'].'\' ';
    if( $query_menu = $database->query($sql))
    {
        if ( $query_menu->numRows() > 0 )
        {
             $page = $query_menu->fetchRow(MYSQL_ASSOC);
             $return_value = page_link($page['link']);
        }
    }


return $return_value;
}

function get_page_list($parent, $this_page=0 )
{
    global $database, $entries;
    $sql = 'SELECT `page_id`, `language`, `menu_title`, `page_code`, `parent` FROM `'.TABLE_PREFIX.'pages` WHERE `parent` = '.$parent.' ORDER BY `position`';
    $get_query = $database->query($sql);
    if ( $get_query->numRows() )
    {
        while($value = $get_query->fetchRow(MYSQL_ASSOC))
        {
            if (( $value['page_id'] != $this_page ) )
            {
                $entries [$value['page_id']]['language'] = $value['language'];
                $entries [$value['page_id']]['menu_title'] = $value['menu_title'];
                get_page_list($value['page_id'], $this_page );
            }
          }
    }
   return $entries;
}

//
function show_vars($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

if(!function_exists('getBaseUrl')) {
    function getBaseUrl()
    {
    global $mod_path;

    // identify Server Document_Root
    // on WIN/IIS create this entry
    $script_name = str_replace('\\', '/',dirname(dirname(__FILE__)));
    $sys_root = ( !isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT'] == '' ) ? (str_replace('\\', '/', $script_name)) : str_replace('\\', '/',$_SERVER['DOCUMENT_ROOT']);

       $_SERVER['DOCUMENT_ROOT'] = $sys_root;

    $wb_rel = str_replace( $sys_root, '' ,($script_name));

    $mod_path = (!empty($mod_path)) ? $mod_path : '/' ;
    $regex = '#(?=\\'.$mod_path.').*#i';
    $replace = '';
    $wb_rel = preg_replace ($regex, $replace, $wb_rel, -1 );
    $wb_rel = str_replace('//', '/', $wb_rel );
    if(!defined('WB_REL')) {define('WB_REL', $wb_rel);}
    if(!defined('ADMIN_REL')) {define('ADMIN_REL', $wb_rel.'/admin');}

    }

getBaseUrl( );

}


