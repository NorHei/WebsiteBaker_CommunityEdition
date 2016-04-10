<?php 
include('../header.php');
include('../config.php');

?>
<a class="toolboxmenue"  href="../toolbox.php?page_id=<?php echo $page_id; ?>">Back</a>
<div class="toolboxcontent">

<div id="loaderanimation" style="display:none; height:50px;text-align:center;"><img src="../img/loader.gif" width="208" height="13" /><br/>don't interrupt..
</div>
<form name="upload" action="uploader2.php?page_id=<?php echo $page_id; ?>" method="post" style="margin: 0; width:100%; font-size:10px;"  enctype="multipart/form-data" >
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
<input type="file" class="toolboxform" name="uploadfile" style="width:250px;font-size:11px;" onchange="showtherest();" />
<div id="istherest">
<table style="border:none; padding:0;" ><tr>
<td style="width:50%; padding:0;">Max Width:<br/><input class="toolboxform" style="width:60%;" type="text" width="3" name="resizew"  id="resizew" value="<?php echo $picwidthdefault; ?>"></td>
<td style="width:50%; padding:0;">Max Height:<br/><input class="toolboxform" style="width:60%;" type="text" width="3" name="resizeh"  id="resizeh" value=""></td>
</tr></table>
<select class="toolboxform" name="picsizes" id="picsizes" onchange="changepicsize(this.options[this.selectedIndex].value)">
<?php 
foreach($picsizesarr as $key=>$value) {
	echo '<option value="'.$value.'">'.$key.'</option>';
}
?>
</select>

<div style="clear:both;" ><input type="checkbox" name="nooverwrite" value="1">Do not overwrite existing files</div>

<input type="submit" class="toolboxsubmit" value="Upload" onclick="startupload()">
</div>
</form>

<script type="text/javascript">
	function startupload() {
		document.getElementById("loaderanimation").style.display="block";
		document.upload.submit()
	}
</script>

</div>
</body>
</html>
