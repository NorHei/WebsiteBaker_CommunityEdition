<?php include('../header.php'); ?>
<a class="toolboxmenue"  href="../toolbox.php?page_id=<?php echo $page_id; ?>">Back</a> 
<div class="toolboxcontent">
<?php 

if($admin->get_post('page_id') == $page_id) {
	$the_title = trim($admin->get_post_escaped('page_title'));
	$the_description = trim($admin->get_post_escaped('description'));
	$the_keywords = trim($admin->get_post_escaped('keywords'));
	
	// Update row
	$database->query("UPDATE ".TABLE_PREFIX."pages SET page_title = '$the_title', description = '$the_description', keywords = '$the_keywords' WHERE page_id = '$page_id'");
}

$query = "SELECT * FROM ".TABLE_PREFIX."pages WHERE page_id = '$page_id'";
$query_page = $database->query($query);
$results_array = $query_page->fetchRow();
$the_title = $results_array['page_title']; 
$the_description = $results_array['description'];
$the_keywords = $results_array['keywords'];
$the_menu_title = $results_array['menu_title'];
?>



<?php
//=========================================================
//Hinweis: Diese Rechnung hier ist annähernd das gleiche wie javascript function checkseofields() 
//Die Berechnung des Gesamtscores sollte eigentlich auch dort erfolgen, hab ich aber nicht zusammengebracht. Und ist auch nicht so wichtig.

//Make some kind of score;
//Title should be around 40 Chars:

$strl = strlen($the_title);		
$l = abs(40 - $strl);
if ($l > 40) {$l = 40;}	
$titlescore = round((40 - $l) / 3);
if ($titlescore > 10) {$titlescore = 10;} //max 10				
$metasscore = 3 * $titlescore; //max: 30 GesamtPunkte
$metasscoretext = ''.(3 * $titlescore);
//echo floor(30.0 - $l);		

//Description should be around 30 * 5 Chars:
$strl = strlen($the_description);
$l = abs(30 - ($strl / 5));
if ($l > 30) {$l = 30;}
$descriptionscore = round((30 - $l) / 2.5); 
if ($descriptionscore > 10) {$descriptionscore = 10;} //max 10	
$metasscore += 3 * $descriptionscore; //max: 30 GesamtPunkte
$metasscoretext .= '+'.(3 * $descriptionscore);		

//keywords are not that important, around 50 chars:
$strl = strlen($the_keywords);
$l = abs(10 - ($strl / 5));
if ($l > 10) {$l = 10;} 
$keywordsscore = round($l);
if ($keywordsscore > 10) {$keywordsscore = 10;} //max 10
$metasscore += $keywordsscore; //max: 10 GesamtPunkte
$metasscoretext .= '+'.$keywordsscore;


//Nicht ideal, aber ein anhaltspunkt:
$allwords = strtolower($the_title.' '.$the_description.' '.$the_keywords);
//$allwords=preg_replace('/[^a-zA-Z :,. 0-9_,+;\-]/', ' ', $allwords);
$allwords=preg_replace('/[^a-z]/', ' ', $allwords);
$wortarr =  array_unique(explode(' ', $allwords));

$allwords2 = '';
foreach($wortarr as $wort) {
	if (strlen($wort) > 3) $allwords2 .= ' '.$wort;
}
$anteil = floor(strlen($allwords2) * (100.0 / strlen($allwords)));

//Anteil der nicht wiederholten, längeren Wörter sollte um die 60% sein:		
$l = abs(30 - ($anteil /2 ));
if ($l > 30) {$l = 30;}
$metasscore += (30 - $l); //max: 30 Punkte
$metasscoretext .= '+'.floor(30 - $l);

$score = floor($metasscore / 10);
if ($score > 10) $score = 10;
$colorarr = array('ff0000','ff3500','ff7b00','ffa900','ffc100','ffe900','e3f929','c5df49','a6e55d','5bd65c','2adb2c');

echo '<h3 id="seoscore" style="text-align:center; font-size:18px; background:#'.$colorarr[$score].';">SEO-Score: '.$score.'/10</h3>
<!-- h3 style="color:#'.$colorarr[$score].'">Score:<br />'.$metasscoretext.'='.$metasscore.'/100 <br /><a target="_top" href="'.ADMIN_URL.'/pages/settings.php?page_id='.$page_id.'">[EDIT]</a></h3 -->		
';
		
?>

<form name="settings" action="?page_id=<?php echo $page_id; ?>" method="post" autocomplete="off">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">

<p>Menuetitle:<br/>
<b><?php echo $the_menu_title; ?></b></p>

<div class="formblock"><div id="seoanzeige"><div id="page_title_balken"></div></div>
Page-Title:<br/>
<input class="toolboxform" type="text" id="page_title" name="page_title" value="<?php echo $the_title; ?>" onkeyup="checkseofields(1)">
<br/><i id="page_title_result"></i></div>

<div class="formblock"><div id="seoanzeige"><div id="description_balken"></div></div>Meta-Description:<br/>
<textarea class="toolboxform" id="description" name="description" rows="5" cols="30" onkeyup="checkseofields(1)"><?php echo $the_description; ?></textarea>
<br/><i id="description_result"></i></div>

<div class="formblock"><div id="seoanzeige"><div id="keywords_balken"></div></div>Meta-Keywords:<br/>
<textarea class="toolboxform" id="keywords" name="keywords" rows="3" cols="30" onkeyup="checkseofields(1)"><?php echo $the_keywords; ?></textarea>
<br/><i id="keywords_result"></i></div>

<input class="toolboxsubmit" type="submit"  value="Save" onclick="checkseofields()">
</form>
<script type="text/javascript">
	checkseofields(0);
</script>
</div>
</body>
</html>
