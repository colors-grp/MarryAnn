<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Super Sayem</title>

<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/bootstrap/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/bootstrap/css/bootstrap-theme.css"/>
<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/css/style.css"/>

<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>h7-assets/resources/img/favicon.ico">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	

<script type="text/javascript">

	window.onresize = function() { page_width(); };
	window.onfocus = function() { page_width(); };
	
	function page_width(){
		var scroll_width = (window.innerWidth-$(window).width());
            var w_outerWidth = (window.outerWidth > window.screen.availWidth)?window.screen.availWidth:window.outerWidth;
            var h_outerHeight = (window.outerHeight > window.screen.availHeight)?window.screen.availHeight:window.outerHeight;
            var w_difference = (window.innerWidth >= window.screen.availWidth || window.innerWidth >= window.outerWidth)?0:( w_outerWidth  - window.innerWidth);
            var h_difference = (window.innerHeight >= window.screen.availHeight || window.innerHeight >= window.outerHeight)?0:(h_outerHeight - window.innerHeight);
		var w = (window.screen.availWidth - w_difference ) - scroll_width;
		var h = window.screen.availHeight - h_difference;

		if (window.screen.availHeight > 700 && h < 600)
			h = 640;		

	 	document.getElementById("container").style.width = w + "px";
 		document.getElementById("container").style.height = h + "px";
 		document.getElementById("container").style.backgroundSize = w +"px" + " " + h + "px";
 		
 		document.getElementById("header").style.width = w + "px";
 		document.getElementById("header").style.height = (h*0.292) + "px";
 		document.getElementById("header").style.backgroundSize = w +"px" + " " + (h*0.292) + "px";
 		
 		document.getElementById("H7-logo").style.height = (h * 0.14032) + "px";
 		document.getElementById("H7-logo").style.left = (w * 0.179355 ) + "px";
 		document.getElementById("H7-logo").style.top = (h * 0.17179 * 0.292) + "px";
 		
 		document.getElementById("logo").style.width = (w * 0.23352) + "px";
 		document.getElementById("logo").style.left = (w * 0.5724743 ) + "px";
 		document.getElementById("logo").style.top = (h * 0.17179 * 0.292) + "px";
 		
 		document.getElementById("form-info").style.width = (w * 0.295168) + "px";
 		document.getElementById("form-info").style.height = (h * 0.3545) + "px";
 		document.getElementById("form-info").style.backgroundSize = (w * 0.295168) + "px" + " " + (h * 0.3545) + "px";
 		document.getElementById("form-info").style.top = (h * 0.4165) + "px";
 		document.getElementById("form-info").style.paddingTop = h * 0.0753323 + "px";
 		document.getElementById("form-info").style.paddingBottom = h * 0.02511 + "px";
 		document.getElementById("form-info").style.paddingLeft = w * 0.0095 + "px";
 		document.getElementById("form-info").style.paddingRight = w * 0.013909 + "px";

 		document.getElementById("choose-photo").style.width = (w * 0.146412) + "px";
 		
 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = h - (h*0.04) + "px";
 		document.getElementById("footer").style.paddingTop = (h * 0.04 * 0.166667) + "px";
 		document.getElementById("footer").style.paddingLeft = w * 0.17789 + "px";
 		document.getElementById("footer").style.paddingRight = w * 0.175695 + "px";
 		
 		document.getElementById("header").style.display = "block";
 		document.getElementById("container").style.display = "block";
 		document.getElementById("footer").style.display = "block";
    }
    	
</script>
</head>
<body onload = "page_width();"  style = "overflow: hidden; font-family: Segoe UI;">
<div id = "header">
	<img src = "<?=base_url();?>h7-assets/resources/img/selfie/hitseven_logo.png" id = "H7-logo" style = "position: relative;">
	<img src = "<?=base_url();?>h7-assets/resources/img/logo.png" id = "logo"/>	
</div>
	
<div id = "container">
	<div id = "form-info" style = "text-align: center;">
		<h3 style = "color: red; font-family: Segoe UI;">اعمل سيلفى جوه الفانوس</h3>
		<form action="<?=base_url();?>index.php/fanos_selfie/get_image" method="post" enctype="multipart/form-data">
			<table id = "upload_image_table">
				<tr>
					<td>
						<input id = "choose-photo" type="file" name="userfile" accept="image/*" onchange = "document.getElementById('image_upload_button').disabled = false;"/>
					</td>
					<td>
						<input type = "submit" id = "image_upload_button" value = " ظبط  صورتك" class="btn btn-danger" disabled/>
					</td>
				</tr>
				<tr>
					<td colspan = "2"><font style = "font-size: 18px;">او</font></td>
				</tr>
				<tr>
					<td colspan = "2">
						<a href = "<?=base_url();?>index.php/fanos_selfie/get_facebook_pic">
						<input type = "button" value = "هات صورتك من فايسبوك" class="btn btn-danger" />
						</a>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<div id = "footer" style = "color: white;">
	Copyright ©2014 - SuperSayem. All rights reserved
</div>
</body>
</html>