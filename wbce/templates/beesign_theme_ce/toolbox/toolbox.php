<?php include('header.php'); ?>
<div ><a class="toolboxmenue" style="text-align:right;"  href="javascript:closetoolbox();"><img src="img/close.png" title="close"></a></div> 
<?php include('config.php'); 

foreach($menuarr as $key=>$value) {
	echo '<a class="toolboxmenue" href="tools/'.$key.'.php?page_id='.$page_id.'">'.$value.'</a>';
}
?>



</body>
</html>
