<html>
<head>
<title>Super Sayem</title>
<link type="text/css" rel="stylesheet" href="http://hitseven.net/SS/h7-assets/resources/bootstrap/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="http://hitseven.net/SS/h7-assets/resources/bootstrap/css/bootstrap-theme.css"/>
<link type="text/css" rel="stylesheet" href="http://hitseven.net/SS/h7-assets/resources/css/style.css"/>

<link rel="shortcut icon" type="image/x-icon" href="http://hitseven.net/SS/h7-assets/resources/img/favicon.ico">


<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	

<script type="text/javascript">
    window.onresize = function() { page_width(); };
    window.onfocus = function() { page_width(); };
    function page_width(){
    	var scroll_width = (window.innerWidth-$(window).width());
		var w = (window.screen.availWidth - (window.outerWidth - window.innerWidth)) - scroll_width;
		var h = window.screen.availHeight - (window.outerHeight - window.innerHeight);
		
 		document.getElementById("container").style.width = w + "px";
 		document.getElementById("container").style.height = h + "px";
 		document.getElementById("container").style.backgroundSize = w +"px" + " " + h + "px";
 		
 		document.getElementById("header").style.width = w + "px";
 		document.getElementById("header").style.height = (h*0.292) + "px";
 		document.getElementById("header").style.backgroundSize = w +"px" + " " + (h*0.292) + "px";
 		
 		document.getElementById("logo").style.width = (w * 0.23352) + "px";
 		document.getElementById("logo").style.left = (w * 0.5168374816983895 ) + "px";
 		document.getElementById("logo").style.top = (h * 0.17179 * 0.292) + "px";
 		
		document.getElementById("hit_seven_logo").style.left = (w * 0.1822840409956076 ) + "px";
		document.getElementById("hit_seven_logo").style.top = (h * 0.047976011994003 ) + "px";
		document.getElementById("hit_seven_logo").style.height = (h * 0.1424287856071964 ) + "px";
 		
 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = h - (h*0.04) + "px";
 		
 		document.getElementById("header").style.display = "block";
 		document.getElementById("container").style.display = "block";
 		document.getElementById("footer").style.display = "block";
                
                document.getElementById("text").style.left = (w*0.289898) + "px";
 		document.getElementById("text").style.top = (h*0.58471) + "px";
    }	
</script>
</head>
<body onload = "page_width();"  style = "overflow: hidden;">
<div id = "header">
    <a href="http://hitseven.net"> <img src = "http://hitseven.net/SS/h7-assets/resources/img/hitseven_logo.png" id = "hit_seven_logo" style="position: relative;" /> </a>
    <a href="http://hitseven.net/SS"> <img src = "http://hitseven.net/SS/h7-assets/resources/img/logo.png" id = "logo" /> </a> 
</div>
	
<div id = "container">
    <div id="text" style="position: relative; color: red;">			
        <b>Please send E-mail to super@SuperSayem.com for inquiries regarding the competition.</b>
    </div>
</div>

<div id = "footer"></div>
</body>
</html>