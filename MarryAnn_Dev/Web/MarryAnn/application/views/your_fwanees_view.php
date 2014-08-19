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

	function inIframe() {
	    try {
	        return window.self !== window.top;
	    } catch (e) {
	        return true;
	    }
	}
	
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

		var FB = inIframe();
		if(FB){
			document.getElementById('arrow-des').innerHTML = "ظبط صورتك جوه الفانوس بالاسهم ";
		}
	 	document.getElementById("container").style.width = w + "px";
 		document.getElementById("container").style.height = h + "px";
 		document.getElementById("container").style.backgroundSize = w +"px" + " " + h + "px";
 		
 		document.getElementById("small-header").style.width = w + "px";
 		document.getElementById("small-header").style.height = (h*0.18) + "px";
 		document.getElementById("small-header").style.backgroundSize = w +"px" + " " + (h*0.18) + "px";

 		document.getElementById("H7-logo").style.height = (h * 0.09158) + "px";
 		document.getElementById("H7-logo").style.left = (w * 0.1925) + "px";
 		document.getElementById("H7-logo").style.top = (h * 0.02215) + "px";
 		
 		document.getElementById("logo").style.width = (w * 0.152269) + "px";
 		document.getElementById("logo").style.left = (w * 0.63323) + "px";
 		document.getElementById("logo").style.top = (h * 0.02215) + "px";

 		img_ratio = 231 / document.getElementById("img2").width;
    	img_h = document.getElementById("img2").height * img_ratio;

    	if(img_h > 390){
    		img_h = 390;
    	}
    	
// 		document.getElementById("img2-container").style.marginTop = -1 * (390 - img_h) + "px"; 

		document.getElementById("img2-container").style.marginTop = -390 + "px"; 
		document.getElementById("fanousize_text").style.marginTop = -1 * (img_h) + "px";

		if(img_h > 286)
			temp_h = img_h;
		else 
			temp_h = 286;
		
		document.getElementById("frame").style.marginTop = -1 * (temp_h + 30) + "px"; 
	 	
	 	//document.getElementById("upload_button1").style.top = h * 0.5539 + "px";
	 	//document.getElementById("upload_button1").style.marginLeft = w * 0.0959 + "px";

	 	//document.getElementById("upload_button2").style.top = h * 0.5539 + "px";
	 	//document.getElementById("upload_button2").style.marginLeft = w * 0.36822 + "px";
	 	
 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = h - (h*0.04) + "px";
 		document.getElementById("footer").style.paddingTop = (h * 0.04 * 0.166667) + "px";
 		document.getElementById("footer").style.paddingLeft = w * 0.17789 + "px";
 		document.getElementById("footer").style.paddingRight = w * 0.175695 + "px";
 		
 		document.getElementById("small-header").style.display = "block";
 		document.getElementById("container").style.display = "block";
 		document.getElementById("footer").style.display = "block";
    }

	function leftArrowPressed() {
		var element = document.getElementById("img2-container");
        if(parseInt(element.style.left)  > -28)
        	element.style.left = parseInt(element.style.left) - 2 + 'px';
    }

    function rightArrowPressed() {
        var element = document.getElementById("img2-container");
        if(parseInt(element.style.left)  < 130)
	        element.style.left = parseInt(element.style.left) + 2 + 'px';
	}
	
	function upArrowPressed() {
        var element = document.getElementById("img2-container");
        if(parseInt(element.style.top)  > -30)
        	element.style.top = parseInt(element.style.top) - 2 + 'px';
    }

    function downArrowPressed() {
        var element = document.getElementById("img2-container");
        if(parseInt(element.style.top)  < (420 - element.offsetHeight))
            element.style.top = parseInt(element.style.top) + 2 + 'px';
    }

    function moveSelection(evt) {
        switch (evt.keyCode) {
        	case 37:
            leftArrowPressed();
            break;
            case 39:
            rightArrowPressed();
            break;
        	case 38:
            upArrowPressed();
            break;
            case 40:
            downArrowPressed();
            break;
    	}
    };

	function create_img(){
		for (var i = 0; i < 2; i++)
    		document.getElementById("customize_fanos").appendChild(convertCanvasToImage(i));

        function convertCanvasToImage(i) {
            if (i == 0)
				var img1 = document.getElementById('img1');
            else
            	var img1 = document.getElementById('img3');
        	
        	var img2 = document.getElementById('img2');

        	if (i == 0)
        		var canvas = document.getElementById('canvas');
        	else
        		var canvas = document.getElementById('canvas2');
            	
        	var context = canvas.getContext('2d');
        				
        	var top = document.getElementById('img2-container').style.top;
        	top = top.substr(0, top.length - 2);
        	var left = document.getElementById('img2-container').style.left;
        	left = left.substr(0, left.length - 2); 
            				
        	var ratio = 231 / img2.width;
        	var h = img2.height * ratio;
        				
        	canvas.width = 300;
        	canvas.height = 300;
        	context.globalAlpha = 1.0;
        	context.drawImage(img2, left-30, top-45, 231, h);
			context.drawImage(img1, 30, 45, 300, 300, 0, 0, 300, 300);
			
        	if (i == 1){
        		document.getElementById('img1').style.display = "none";
        		img1.style.display = "none";
        		img2.style.display = "none";
        		document.getElementById('img2-container').style.display = "none";
        		document.getElementById('frame').style.display = "none";
        		document.getElementById('fanousize_text').style.display = "none";
        		document.getElementById('upload_button1').style.display = "block";
        		document.getElementById('upload_button2').style.display = "block";
        	}
        	
        	var image = new Image();
        	image.src = canvas.toDataURL("image/png");
        	image.style.position = "relative";
        	image.style.top = 45 + "px";
        	image.style.left = 30 + "px";
        	if(i == 1)
        		image.style.left = 90 + "px";
        	return image;
        }
	}

	function upload_fanosize_image(id){
		if (id == 0)
			var canvasData = document.getElementById('canvas').toDataURL("image/png");
		else
			var canvasData = document.getElementById('canvas2').toDataURL("image/png");

		var ajax = new XMLHttpRequest();
		ajax.open("POST",'<?=base_url();?>index.php/fan_page_upload',false);
		ajax.setRequestHeader('Content-Type', 'application/upload');
		ajax.send(canvasData);
		window.location.href = '<?=base_url();?>index.php/fan_page_upload/post_to_FB';
	}
    
</script>
</head>
<body onload = "window.addEventListener('keydown', moveSelection); page_width();"  style = "overflow: hidden;">
<div id = "small-header">
	<img src = "<?=base_url();?>h7-assets/resources/img/selfie/hitseven_logo.png" id = "H7-logo" style = "position: relative;">
	<img src = "<?=base_url();?>h7-assets/resources/img/logo.png" id = "logo"/>	
</div>
	
<div id = "container">
	<div id = "customize_fanos" style = "font-family: Segoe UI;">
		<img id="img3" src="<?=base_url();?>h7-assets/resources/img/selfie/white_fanous_bg.png" style = "display: none;">
		
		<canvas id="canvas" style = "display: none;"></canvas>
		<canvas id="canvas2" style = "display: none;"></canvas>
		
		<button id = "upload_button1" class = "btn btn-danger" style = "display: none; position: absolute; margin-left: 117px;" onclick = "upload_fanosize_image(0); return false;">حطها على بروفايلى</button>
		<button id = "upload_button2" class = "btn btn-danger" style = "display: none; position: absolute; margin-left: 488px;" onclick = "upload_fanosize_image(1); return false;">حطها على بروفايلى</button>
		
		<?php
			if ($flag == 0) 
				$imgsrc = base_url().'h7-assets/resources/img/uploads/'.$uploadInfo['file_name']; 
			elseif ($flag == 1)
				$imgsrc = base_url().'h7-assets/resources/img/uploads/'.$fb_id.'.jpg';
		?>
		<img id="img1" src="<?=base_url();?>h7-assets/resources/img/selfie/red_fanous_bg.png" style = "z-index: 999; position: relative;">
		<div id = "img2-container" style = "overflow: hidden; max-height: 390px; width: 231px; position: relative; left: 0px; top: 0px;">
			<img id="img2" src = "<?=$imgsrc;?>" style = "width: 231px; position: relative; left: 0px; top: 0px;">
		</div>  
		
		<div id = "fanousize_text">
			<h2>سيلفى جوه الفانوس</h2>
			<h4 id = "arrow-des">ظبط صورتك جوه الفانوس باسهم الكيبورد</h4>
			<table style = "margin-left: auto; margin-right: auto; z-index:99999; position: relative;">
				<tr>
					<td rowspan = "2">
						<img class = "arrows" src = "<?=base_url();?>h7-assets/resources/img/selfie/left.png" onmousedown = "interval = setInterval(leftArrowPressed, 100);" onmouseup = "clearInterval(interval);">
					</td>
					<td>
						<img class = "arrows" src = "<?=base_url();?>h7-assets/resources/img/selfie/up.png" onmousedown = "interval = setInterval(upArrowPressed, 100);" onmouseup = "clearInterval(interval);">
					</td>
					<td rowspan = "2">
						<img class = "arrows" src = "<?=base_url();?>h7-assets/resources/img/selfie/right.png" onmousedown = "interval = setInterval(rightArrowPressed, 100);" onmouseup = "clearInterval(interval);">
					</td>
				</tr>
				<tr>
					<td>
						<img class = "arrows" src = "<?=base_url();?>h7-assets/resources/img/selfie/down.png" onmousedown = "interval = setInterval(downArrowPressed, 100);" onmouseup = "clearInterval(interval);">
					</td>
				</tr>
			</table>
			<button onclick = "create_img()" id = "done" class="btn btn-danger">جهز السيلفى</button>
		</div>
		<img src = "<?=base_url();?>h7-assets/resources/img/selfie/fanos_bg_empty.png" id = "frame">
	</div>
</div>

<div id = "footer" style = "color: white;">
	Copyright ©2014 - SuperSayem. All rights reserved
</div>
</body>
</html>