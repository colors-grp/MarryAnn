<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Super Sayem</title>

<link type="text/css" rel="stylesheet" href="./resources/bootstrap/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="./resources/bootstrap/css/bootstrap-theme.css"/>
<link type="text/css" rel="stylesheet" href="./resources/css/style.css"/>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	

<script type="text/javascript">
    function page_width(){
    	var scroll_width = (window.innerWidth-$(window).width());
		var w = (window.screen.availWidth - (window.outerWidth - window.innerWidth)) - scroll_width;
		var h = window.screen.availHeight - (window.outerHeight - window.innerHeight);
		if (window.screen.availHeight > 700 && h < 600)
			h = 640;
 		document.getElementById("container").style.width = w + "px";
 		document.getElementById("container").style.height = h + "px";
 		document.getElementById("container").style.backgroundSize = w +"px" + " " + h + "px";
 		
 		document.getElementById("header").style.width = w + "px";
 		document.getElementById("header").style.height = (h*0.292) + "px";
 		document.getElementById("header").style.backgroundSize = w +"px" + " " + (h*0.292) + "px";
 		
 		document.getElementById("logo").style.width = (w * 0.23352) + "px";
 		document.getElementById("logo").style.left = (w * 0.5724743 ) + "px";
 		document.getElementById("logo").style.top = (h * 0.17179 * 0.292) + "px";
 		
 		document.getElementById("form-info").style.width = (w * 0.295168) + "px";
 		document.getElementById("form-info").style.height = (h * 0.287149) + "px";
 		document.getElementById("form-info").style.backgroundSize = (w * 0.295168) + "px" + " " + (h * 0.287149) + "px";
 		document.getElementById("form-info").style.top = (h * 0.4165) + "px";
 		
 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = h - (h*0.04) + "px";
 		
 		document.getElementById("header").style.display = "block";
 		document.getElementById("container").style.display = "block";
 		document.getElementById("footer").style.display = "block";
    }	
</script>
</head>
<body onload = "page_width();">
<div id = "header">
	<img src = "./resources/img/logo.png" id = "logo"/>	
</div>
	
<div id = "container">
	<div id = "form-info">
	</div>
</div>

<div id = "footer"></div>
</body>
</html>