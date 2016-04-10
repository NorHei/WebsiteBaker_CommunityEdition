var toolboxopen = false;
var pid = location.search.split('page_id=')[1];
if (pid == undefined) {
	document.getElementById("starttoolbox").style.display = "none";
}

function starttoolbox() {
	
	var tbxw = 200;
	var tbxh = window.innerHeight - 160;	
	if (toolboxopen==true) {
		tbxw = 20;
		tbxh = 70;
	
		//alert('jepp2!');
		document.getElementById("content_container").style.marginLeft = "auto";
		document.getElementById("toolboxframe").innerHTML = '';
		document.getElementById("toolboxframe").style.display = "none";
		toolboxopen = false;	
	
	} else {	
		
		document.getElementById("content_container").style.marginLeft = (tbxw + 20) + "px";
		document.getElementById("toolboxframe").innerHTML = '<iframe src="'+THEME_URL+'/toolbox/toolbox.php?page_id='+pid+'" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>';	
		document.getElementById("toolboxframe").style.display = "block";
		toolboxopen = true;		
	}

	document.getElementById("toolboxframe").style.height = tbxh + "px";
	document.getElementById("toolboxframe").style.width = tbxw + "px";
	
}