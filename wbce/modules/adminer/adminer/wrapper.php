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
 
include('../../../config.php'); //Loads full system enviroment
if (isset($_POST['logout'])) die(header("Location: ".ADMIN_URL."/admintools/index.php"));


$_GET["tool"]="adminer"; // Sets tool for clas Admin access management
$admin = new admin('admintools', 'admintools',false); // initialize admin 

if (!isset($_GET["username"])) $_GET["username"]=DB_USERNAME;
if (!isset($_GET["db"])) $_GET["db"] = DB_NAME;
//if (!isset($_GET["lang"]))   $_GET["lang"]=strtolower(LANGUAGE);
$_SERVER["HTTP_ACCEPT_LANGUAGE"]=strtolower(LANGUAGE);


//echo "<pre>";print_r($_SESSION);echo "</pre>";

function adminer_object() {
    class AdminerSoftware extends Adminer {
        function name() {
            return 'Adminer für WBCE';
        }
        
        function credentials() {
            return array(DB_HOST, DB_USERNAME, DB_PASSWORD);
        }

        function database() {
        // database name, will be escaped by Adminer
        return DB_NAME;
            }
        
        function dumpFilename($identifier) {
            return friendly_url($identifier != "" ? $identifier.'_'.date("Y-m-d_H-i") : (SERVER != "" ? SERVER : "localhost"));
        }
    }
    return new AdminerSoftware;
}

include "adminer.php";

