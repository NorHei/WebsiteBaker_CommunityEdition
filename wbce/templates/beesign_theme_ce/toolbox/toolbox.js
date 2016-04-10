function closetoolbox() {
	parent.starttoolbox(); 
}

function changepicsize(v) {
	werte = v.split("/");
	if (werte[0] < 1) {werte[0] = "";}
	document.getElementById("resizew").value = werte[0];
	if (werte[1] < 1) {werte[1] = "";}
	document.getElementById("resizeh").value = werte[1];
}

function showtherest() {
//alert("jou");
	document.getElementById("istherest").style.opacity="1";
}




function checkseofields(hidescore) {
	if (hidescore == 1) {
		document.getElementById("seoscore").style.opacity="0";
	}
	
	the_title = document.getElementById("page_title").value.toLowerCase();
	the_description = document.getElementById("description").value.toLowerCase();
	the_keywords = document.getElementById("keywords").value.toLowerCase();

	the_title_soll = 40;
	keywords_soll = 50;
	//description_soll = 160;

	
	
    //Title:

	titlescoretext = 'OK';
	strl = the_title.length;		
	l = Math.abs(the_title_soll - strl);
	if (l > the_title_soll) {l = the_title_soll;}	
	titlescore = Math.round((the_title_soll - l) / 3);
	if (titlescore > 10) {titlescore = 10;} //max 10
	if (strl > (the_title_soll*1.5)) {titlescoretext = 'too long: '+strl+' chars, should be: '+the_title_soll+' chars';}
	if (strl < (the_title_soll*0.5)) {titlescoretext = 'too short: '+strl+' chars, should be: '+the_title_soll+'  chars';}
				
	metasscore = 3 * titlescore; //max: 30 GesamtPunkte
	metasscoretext = ''+(3 * titlescore);
	
	document.getElementById("page_title_result").innerHTML = titlescoretext;
	document.getElementById("page_title_balken").style.width = (10 * titlescore)+'%';
	
	


	descriptionscoretext = 'OK';
	strl = the_description.length;
	l = Math.abs(30 - (strl / 5));
	if (l > 30) {l = 30;}
	descriptionscore = Math.round((30 - l) / 2.5); 
	if (descriptionscore > 10) {descriptionscore = 10;} //max 10
	
	if (strl > 200) {descriptionscoretext = 'too long: '+strl+' chars, should be: ca 150 chars';}
	if (strl < 100) {descriptionscoretext = 'too short: '+strl+' chars, should be: ca 150 chars';}
	if (strl < 1) {descriptionscoretext = 'No Meta-Description!';}	
				
	metasscore += 3 * descriptionscore; //max: 30 GesamtPunkte
	metasscoretext += '+'+(3 * descriptionscore);
	
	document.getElementById("description_result").innerHTML = descriptionscoretext;
	document.getElementById("description_balken").style.width = (10 * descriptionscore)+'%';
	
			
	
	//keywords are not that important, around 50 chars:
	keywordsscoretext = 'OK';
	strl = the_keywords.length;
			
	l = Math.abs(keywords_soll - strl);
	if (l > keywords_soll) {l = keywords_soll;}	
	keywordsscore = Math.round((keywords_soll - l) / 3);
	if (keywordsscore > 10) {keywordsscore = 10;} //max 10
	if (strl > 100) {$keywordsscoretext = 'too long: '+strl+' chars, should be: ca 50 chars';}
	if (strl < 20) {$keywordsscoretext = 'too short: '+strl+' chars, should be: ca 50 chars';}
	if (strl < 1) {keywordsscoretext = 'No Meta-Keywords!';}	
			
	metasscore += keywordsscore; //max: 10 GesamtPunkte
	metasscoretext += '+'+keywordsscore;
	
	document.getElementById("keywords_result").innerHTML = keywordsscoretext;
	document.getElementById("keywords_balken").style.width = (10 * keywordsscore)+'%';
	
	//alert (metasscoretext);

/*

//Nicht ideal, aber ein anhaltspunkt:
allwords = strtolower(the_title.' '.$the_description.' '.$the_keywords);
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

echo '<h1 style="background:#'.$colorarr[$score].';">SEO-Score: '.$score.'/10</h1>
<p style="color:#'.$colorarr[$titlescore].'"><i>Title: '.$titlescoretext.'</i><br/><b>'.$the_title.'</b></p>
<p style="color:#'.$colorarr[$descriptionscore].'"><i>Description: '.$descriptionscoretext.'</i><br/><b>'.$the_description.'</b></p>
<p style="color:#'.$colorarr[$keywordsscore].'"><i>Keywords: '.$keywordsscoretext.'</i><br/><b>'.$the_keywords.'</b></p>
<h3 style="color:#'.$colorarr[$score].'">Score:<br />'.$metasscoretext.'='.$metasscore.'/100 <br /><a target="_top" href="'.ADMIN_URL.'/pages/settings.php?page_id='.$page_id.'">[EDIT]</a></h3>		
*/
}
