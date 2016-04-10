<?php include('../header.php'); ?>
<a class="toolboxmenue"  href="../toolbox.php?page_id=<?php echo $page_id; ?>">Back</a> 
<div class="toolboxcontent">
<h3>Save before you click!</h3>
<hr/>

<?php 
echo "<h3>Jump to recently changed pages:</h3>";
$theq = "SELECT * FROM " . TABLE_PREFIX . "pages WHERE visibility != 'none' ORDER BY modified_when DESC LIMIT 20";
$ergebnis = $database->query($theq);

$heute = floor(time() / 86400);
$bisher = -1;
while ($zeile = $ergebnis->fetchRow()) {
  $tag =floor($zeile['modified_when'] / 86400);  
  $aktuell = $heute - $tag;
  if ($aktuell > 3) { $aktuell = 3; }
  if ($aktuell < 3) { 
    $aenderungsdatum= date("H:i ", $zeile['modified_when']);
  } else {
    $aenderungsdatum= date("d. M Y ", $zeile['modified_when']);
  }

  $weblink=$zeile['link'];
  $cutzeichen=strrpos($weblink,"/");
  $weblinktext = substr($weblink,0,$cutzeichen);
  if ($weblinktext == "")
  {
    $weblink_text = "";
  }
  else
  {
    $weblink_text = "<br/>(in " .  str_replace('/', ' > ', $weblinktext) . ")";
  }

  if ($bisher <> $aktuell)
  {
      $bisher = $aktuell;
      switch ($aktuell)
      {
         case 0: echo '<h3>Today</h3>'; break;
         case 1: echo '<h3>Yesterday</h3>'; break;
         case 2: echo '<h3>2 days ago</h3>'; break;
         case 3: echo '<h3>3 days and more</h3>'; break;
      }
  }
  $frontendlink = WB_URL.PAGES_DIRECTORY.$weblink.PAGE_EXTENSION;
  $editlink = WB_URL.'/'.ADMIN_DIRECTORY.'/pages/modify.php?page_id='.$zeile['page_id'];
  echo '<p>'. $aenderungsdatum .'<br/><a href="'.$editlink.'" target="_top"><b>'. $zeile['menu_title'].'</b></a>'. $weblink_text . '</p>';

}
?>

</div>
</body>
</html>
