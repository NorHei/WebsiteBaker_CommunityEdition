<?php include('../header.php'); ?>
<a class="toolboxmenue"  href="../toolbox.php?page_id=<?php echo $page_id; ?>">Back</a> 
<div class="toolboxcontent">
<h3>Save before you click!</h3>
<hr/>
edit:<br/>
Parent<br/>
Some Childs<br/>

<?php 
define('PAGE_ID', $page_id);

/* Das geht leider so nicht
include(WB_PATH.'/modules/show_menu2/include.php');

 show_menu2(
        $aMenu          = 0,
        $aStart         = PAGE_ID,
        $aMaxLevel      = SM2_CURR+1,
        $aOptions       = SM2_TRIM,
        $aItemOpen      = '[li][a][menu_title]</a>',
        $aItemClose     = '</li>',
        $aMenuOpen      = '[ul]',
        $aMenuClose     = '</ul>',
        $aTopItemOpen   = false,
        $aTopMenuOpen   = false
        )
*/
?>

</div>
</body>
</html>
