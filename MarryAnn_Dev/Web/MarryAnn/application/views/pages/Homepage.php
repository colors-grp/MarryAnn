<?php
$this->lang->load('general',$_SESSION['language']);
//$this->lang->load('date',$_SESSION['language']);
//$this->lang->load('home',$_SESSION['language']);
//$this->lang->load('score',$_SESSION['language']);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$this->lang->line('website_title');?></title>

<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/bootstrap/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/bootstrap/css/bootstrap-theme.css"/>
<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/css/style.css"/>

<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>h7-assets/resources/img/favicon.ico">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	
<script src="<?=base_url();?>h7-assets/resources/js/popup.js"></script>
<script src="<?=base_url();?>h7-assets/resources/js/facebook_all.js"></script>

<script type="text/javascript">
	function inIframe() {
	    try {
	        return window.self !== window.top;
	    } catch (e) {
	        return true;
	    }
	}
 
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
//                alert('h='+h+'\nw='+w+
//                '\navailHeight='+window.screen.availHeight+'\navailWidth='+window.screen.availWidth+
//                '\nouterHeight='+window.outerHeight+'\ninnerHeight='+window.innerHeight+
//                '\nouterWidth='+window.outerWidth+'\ninnerWidth='+window.innerWidth+
//                '\nw_difference='+w_difference+
//                '\nh_difference='+h_difference
//                );
                
		if (window.screen.availHeight > 700 && h < 600)
			h = 640;

		full_h = h;

		var FB = inIframe();
		if(FB){
			h = w * 0.4956;
		}
		
 		document.getElementById("container").style.width = w + "px";
 		document.getElementById("container").style.height = full_h + "px";
 		document.getElementById("container").style.backgroundSize = w +"px" + " " + full_h + "px";
 		
 		document.getElementById("small-header").style.width = w + "px";
 		document.getElementById("small-header").style.height = (h*0.18) + "px";
 		document.getElementById("small-header").style.backgroundSize = w +"px" + " " + (h*0.18) + "px";
 		document.getElementById("header-table").style.marginTop = -(h * 0.05169) + "px";
 		document.getElementById("small-flags").style.width = w * 0.2928 + "px";
 		document.getElementById("small-flags").style.marginTop = h *  0.042836 + "px";

 		var imgs = document.getElementsByClassName("cat");
 		for(var i = 0; i < imgs.length; i++){
 			imgs[i].style.height = (h * 0.088626) + "px";
 		}
 		
 		var sep = document.getElementsByClassName("separator");
 		for(var i = 0; i < sep.length; i++){
 			sep[i].style.height = (h * 0.0576) + "px";

 			if(FB == true && navigator.userAgent.indexOf("Firefox")!=-1){
 				sep[i].style.marginLeft = -(w * 0.00457) + "px";
 			}
 		}
 		
 		document.getElementById("logo").style.width = (w * 0.152269) + "px";

		document.getElementById("social-table").style.width = w * 0.04538 + "px";
 		document.getElementById("social-table").style.top = h * 0.062 + "px";
 		document.getElementById("social-table").style.left = w * 0.0805 + "px";

 		document.getElementById("help-table").style.width = w * 0.04538 + "px";
 		document.getElementById("help-table").style.top = -(h * 0.0812) + "px";
 		document.getElementById("help-table").style.left = -(w * 0.08418) + "px";
 		
 		var icons = document.getElementsByClassName("header-icons");
 		for(var i = 0; i < icons.length; i++){
 			icons[i].style.width = (w * 0.019) + "px";
 		}
 		
 		document.getElementById("main-content").style.width = w * 0.8997 + "px";
 		document.getElementById("main-content").style.marginTop = h * 0.10635 + "px";
 		
 		document.getElementById("main-fanous").style.width = w * 0.8997 + "px";
 		document.getElementById("main-fanous").style.top = h * 0.0103397 + "px";
 		document.getElementById("main-fanous").style.left = -(w * 0.0029) + "px";
//  		document.getElementById("main-fanous").style.top = h * 0.098966 + "px";
//  		document.getElementById("main-fanous").style.left = w * 0.04978 + "px";

 		
 		document.getElementById("sally-score").style.top = -(h * 0.24667) + "px";
 		document.getElementById("sally-score").style.left = w * 0.06149 + "px";
 		document.getElementById("sally-score").style.width = w * 0.0732 + "px";
 		
 		document.getElementById("moslsalat-score").style.top = -(h * 0.2304) + "px";
 		document.getElementById("moslsalat-score").style.left = w * 0.20278 + "px";
 		document.getElementById("moslsalat-score").style.width = w * 0.0732 + "px";
 		
 		document.getElementById("qatel-score").style.top = -(h * 0.3279) + "px";
 		document.getElementById("qatel-score").style.left = w * 0.5878 + "px";
 		document.getElementById("qatel-score").style.width = w * 0.0732 + "px";
 		
 		document.getElementById("alf-leila-score").style.top = -(h * 0.49926) + "px";
 		document.getElementById("alf-leila-score").style.left = w * 0.7467 + "px";
 		document.getElementById("alf-leila-score").style.width = w * 0.0732 + "px";
 		
 		document.getElementById("pp").style.width = w * 0.20571 + "px";
 		document.getElementById("pp").style.height = h * 0.409158 + "px";
 		document.getElementById("pp").style.left = w * 0.3067 + "px";
 		document.getElementById("pp").style.top = h * 0.32496 + "px";
 		document.getElementById("pp").style.borderRadius = w * 0.089311 + "px";
 		document.getElementById("pp").style.borderBottomRightRadius = w * 0.10907759 + "px";

		/*document.getElementById("user-name").style.width = (w * 0.12737) + "px";
 		document.getElementById("user-name").style.left = -(w * 0.02928) + "px";
		document.getElementById("user-name").style.top = -(h * 0.09601) + "px";

		if(h/w == 0.5){
			document.getElementById("user-name").style.top = -(h * 0.1203) + "px";
		}
		*/
		if(FB){
			//document.getElementById("user-name").style.top = -(h * 0.1697) + "px";
			document.getElementById("qatel-score").style.top = -(h * 0.3468) + "px";
			document.getElementById("alf-leila-score").style.top = -(h * 0.535) + "px";
		}
		
 		/*document.getElementById("header_counter").style.width = (w * 0.204245) + "px";
 		document.getElementById("header_counter").style.height = (h * 0.12555) + "px";
 		document.getElementById("header_counter").style.left = (w * 0.62957) + "px";
		document.getElementById("header_counter").style.top = (h * 0.7548) + "px";*/

		if( h/w > 0.5){
 			document.getElementById("pp").style.width = w * 0.2052 + "px";
 	 		document.getElementById("pp").style.height = h * 0.408 + "px";
 			document.getElementById("pp").style.top = h * 0.2999 + "px";
 			//document.getElementById("user-name").style.top = -(h * 0.13) + "px";
// 			document.getElementById("header_counter").style.top = (h * 0.74174) + "px";
 		}

		document.getElementById("left-cats").style.height = h * 0.3618 + "px";
		document.getElementById("left-cats").style.marginTop = -(h * 0.254) + "px";
		document.getElementById("left-cats").style.marginLeft = w * 0.0549 + "px";

		document.getElementById("right-cats").style.height = h * 0.3618 + "px";
		document.getElementById("right-cats").style.marginTop = -(h * 0.3633) + "px";
		document.getElementById("right-cats").style.marginRight = w * 0.11346 + "px";
		
		var cats_text = document.getElementsByClassName("cat_text");
 		for(var i = 0; i < cats_text.length; i++){
 			cats_text[i].style.width = (w * 0.1464) + "px";
 			cats_text[i].style.position = "relative";
 		}
 		
		/*var clock = document.getElementsByClassName("clock-item");
 		for(var i = 0; i < clock.length; i++){
 			clock[i].style.width = (w * 0.058565) + "px";
 		}*/
 		
 		/* document.getElementById("description-box").style.width = w * 0.198389 + "px";
 		document.getElementById("description-box-image").style.width = w * 0.198389 + "px";
 		//document.getElementById("description-box-image").style.marginTop = h * 0.2067 + "px";
 		document.getElementById("description-box").style.left = w * 0.62225 + "px";
		document.getElementById("description-box").style.top = h * 0.589 + "px";
  		document.getElementById("description").style.top = -(h * 0.1654) + "px";
  		document.getElementById("description").style.width = w * 0.182284 + "px";
  		document.getElementById("description").style.left = w * 0.006588 + "px";
  		document.getElementById("description").style.height = h * 0.1122599 + "px";
        document.getElementById("description").style.zIndex = "999";

        document.getElementById("fb_invite").style.width = (w * 0.0988) + "px";
        document.getElementById("fb_invite").style.marginTop = -(h * 0.1935) + "px";
        
        document.getElementById("help-container").style.width = w * 0.198389 + "px";
 		document.getElementById("help-container").style.marginTop = -(h * 0.1152) + "px";
 		document.getElementById("help-table").style.height = h * 0.096 + "px";
 		document.getElementById("help-table").style.marginTop = -(h * 0.109) + "px";

 		if (navigator.userAgent.indexOf("Firefox")!=-1){
 			document.getElementById("help-table").style.marginTop = -(h * 0.1529) + "px";
		}
 		
 		var help_td = document.getElementsByClassName("help-table-td");
 		for(var i = 0; i < help_td.length; i++){
 			if(i == 1){
 	 			help_td[i].style.padding="0px " + w * 0.00585 + "px " + "0px " + w * 0.00585 + "px";
 	 	 	}
 			help_td[i].style.width = (w * 0.06588) + "px";
 		}
        
        if (navigator.userAgent.indexOf("Firefox")!=-1){
			 //w = window.screen.availWidth ;
			 document.getElementById("description").style.display = "block";
			 document.getElementById("help-container").style.top = -(h * 0.04497) + "px";
		}*/
 		
 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = full_h - (h*0.04) + "px";
 		document.getElementById("footer").style.paddingTop = (h * 0.04 * 0.166667) + "px";
 		document.getElementById("footer").style.paddingLeft = w * 0.17789 + "px";
 		document.getElementById("footer").style.paddingRight = w * 0.175695 + "px";
 		
 		document.getElementById("small-header").style.display = "block";
 		document.getElementById("container").style.display = "block";
 		document.getElementById("footer").style.display = "block";
	//	document.getElementById("header_counter").style.visibility = "visible";
    }

    //ads popup
     	;(function($) {
        $(function() {
			$('#my-button').bind('click', function(e) {
				e.preventDefault();

                $('#element_to_pop_up').bPopup();

            });

        });

    })(jQuery);

    function cancel_fun(){
        if(document.getElementById('comment-text').value != ""){
	    	var x;
	    	var r = confirm("You haven't finished your comment yet. Do you want to leave without finishing?");
	    	if (r == true){
	    		document.getElementById('comment-text').value = "";
	    		document.my_form.name.value = "";
	    		document.my_form.email.value = "";
	    		document.my_form.company.value = "";
	    		$('#element_to_pop_up').bPopup().close();
	    	}
        }else{
        	$('#element_to_pop_up').bPopup().close();
        }
    } 

   
    function valid() { 
    	 var x = true;   	
        if(document.my_form.name.value == ""){
			x = false;
        }

        if(document.my_form.email.value == ""){
        	x = false;
       }

        if(document.my_form.company.value == ""){
        	x = false;
       }

        if(document.my_form.comment_text.value == ""){
        	x = false;
      }

        if(x == true){
            document.getElementById("submit-button").disabled = false;
        }
        else
        	document.getElementById("submit-button").disabled = true;
    }

    function email_valid(){
    	if(document.my_form.email.value != ""){
     	   var z = document.my_form.email.value;
     	   var atpos = z.indexOf("@");
     	   var dotpos = z.lastIndexOf(".");
     	   if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= z.length){
     		   	alert("Please enter a valid email");
 	    	    document.my_form.email.focus();
 	    	    return false;
     	    }
    	}
    }   
  	//end of ads popup 	
  	
  	FB.init({
		appId:'170161316509571',
		cookie:true,
		status:true,
		xfbml:true
	});
	
	function InviteF(){
		FB.ui({
		method: 'apprequests',
		message: 'Welcome to HitSeven App',
		});
	}
</script>
</head>
<body onload = "page_width();" style = "overflow: hidden;">
<div id="fb-root"></div>
<div id = "small-header">
	<table id = "social-table" style = "position: relative; text-align: center;">
		<tr>
			<td>
				<a href = "https://www.facebook.com/SuperSayem" target = "_blank" title = "صفحة الفايسبوك" style = "text-decoration: none;">
					<img src = "<?=base_url();?>h7-assets/resources/img/fb_page.png" class = "header-icons" />
				</a>
			</td>
			<td>
				<a href = "https://twitter.com/SuperSayem2014" target = "_blank" title = "تويتر" style = "text-decoration: none;">
					<img src = "<?=base_url();?>h7-assets/resources/img/twitter.png" class = "header-icons" />
				</a>
			</td>
		</tr>
	</table>
	<table id = "header-table">
		<tr>
			<td>
  				<a href = "javascript:void(0);" style = "text-decoration: none;" title = "سلّي صيامك" onclick = "goToCat(0);">   
					<img src = "<?=base_url();?>h7-assets/resources/img/categories/sally.png" class = "cat" />
 				</a> 
				<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator"/>
			</td>
			<td>
 				<a href = "javascript:void(0);" style = "text-decoration: none;" title = "مسلسلات" onclick = "goToCat(1);"> 
					<img src = "<?=base_url();?>h7-assets/resources/img/categories/mosalsalat.png" class = "cat" />
 				</a> 
				<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator"/>
			</td>
			<td>
 				<a href = "javascript:void(0);" style = "text-decoration: none;" title = "فين السلاح" onclick = "goToCat(2);"> 
					<img src = "<?=base_url();?>h7-assets/resources/img/categories/qatel.png" class = "cat" />
 				</a> 
				<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator"/>
			</td>
			<td>
				<a href = "javascript:void(0);" style = "text-decoration: none;" title = "الف ليلة و ليلة" onclick = "goToCat(3);">
					<img src = "<?=base_url();?>h7-assets/resources/img/categories/alfleila.png"  class = "cat" />
				</a>
			</td>
			<td><img src = "<?=base_url();?>h7-assets/resources/img/small_flags.png" id = "small-flags" /></td>
			<td><img src = "<?=base_url();?>h7-assets/resources/img/logo.png" id = "logo"/></td>
		</tr>
	</table>
	<table id = "help-table" style = "position: relative; text-align: center; float: right;">
		<tr>
			<td>
				<a href = "<?=base_url();?>index.php?/help" target = "_blank" title = "مساعدة" style = "text-decoration: none;">
					<img src = "<?=base_url();?>h7-assets/resources/img/help.png" class = "header-icons" />
				</a>
			</td>
			<td>
				<a href = "<?=base_url();?>index.php?/sign_out" title = "خروج" style = "text-decoration: none;">
					<img src = "<?=base_url();?>h7-assets/resources/img/logout.png" class = "header-icons" />
				</a>
			</td>
		</tr>
	</table>
</div>
<div id = "container">
	<div id = "main-content">
		<div id = "swing-div">
			<img src = "https://graph.facebook.com/<?=$_SESSION['fb_id']?>/picture?width=400&height=400" id = "pp"/>
			<img src = "<?=base_url();?>h7-assets/resources/img/fanous_main.png" id = "main-fanous"/>
			<h3 id = "sally-score"><?=$score[0];?></h3>
			<h3 id = moslsalat-score><?=$score[1];?></h3>
			<h3 id = "qatel-score"><?=$score[2];?></h3>
			<h3 id = "alf-leila-score"><?=$score[3];?></h3>
			<!--  <h2 id = "user-name"><?=substr($user_fullname, 0,strpos($user_fullname, ' '));?></h2>-->
		</div>
		<table id = "left-cats">
			<tr>
				<td>
					<a href = "javascript:void(0);" style = "text-decoration: none;" title = "مسلسلات" onclick = "goToCat(1);"> 
						<img src = "<?=base_url();?>h7-assets/resources/img/categories/mosalsalat_text.png" class = "cat_text" />
 					</a> 
				</td>
			</tr>
			<tr>
				<td>
					<a href = "javascript:void(0);" style = "text-decoration: none;" title = "سلّي صيامك" onclick = "goToCat(0);">   
						<img src = "<?=base_url();?>h7-assets/resources/img/categories/sally_text.png" class = "cat_text" />
	 				</a> 
				</td>
			</tr>		
		</table>
		<table id = "right-cats" style = "float: right;">
			<tr>
				<td> 
					<a href = "javascript:void(0);" style = "text-decoration: none;" title = "الف ليلة و ليلة" onclick = "goToCat(3);"> 
						<img src = "<?=base_url();?>h7-assets/resources/img/categories/alfleila_text.png" class = "cat_text" />
 					</a> 
				</td>
			</tr>
			<tr>
				<td>
					<a href = "javascript:void(0);" style = "text-decoration: none;" title = "فين السلاح" onclick = "goToCat(2);">   
						<img src = "<?=base_url();?>h7-assets/resources/img/categories/qatel_text.png" class = "cat_text" />
	 				</a> 
				</td>
			</tr>		
		</table>
		<!-- <div id = "description-box">
			<img src = "<?=base_url();?>h7-assets/resources/img/box.png" id = "description-box-image"/>
			<h2 id = "description"><?=$user_fullname?></h2>
			<img src = "<?=base_url();?>h7-assets/resources/img/e3zem.png" id = "fb_invite" onclick = "InviteF();"/>
			<img src = "<?=base_url();?>h7-assets/resources/img/timer_holder.png" id = "help-container" />
			<table id = "help-table" style = "text-align: center;">
				<tr>
					<td class = "help-table-td">
						<a href = "<?=base_url();?>index.php?/sign_out" style = "text-decoration: none; color: #CE3333;"><h4>خروج</h4></a>
					</td>
					<td class = "help-table-td">
						<a href = "https://www.facebook.com/SuperSayem" target = "_blank" style = "text-decoration: none; color: #CE3333;"><h4>صفحة الفايسبوك</h4></a>
					</td>
					<td class = "help-table-td">
						<a href = "<?=base_url();?>index.php?/help" target = "_blank" style = "text-decoration: none; color: #CE3333;"><h4>مساعدة</h4></a>
					</td>
				</tr>
			</table>
		</div>-->
	</div>
</div>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/css/style.css"/>
    <script src="<?=base_url();?>h7-assets/resources/js/popup.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/css/popup.css"/>
    <?php 
      //  $data['current_page'] = 'home';
      //  $this->load->view('ajax/timer_view_ajax',$data);
        $this->load->view('popups/home_tutorial_popup');
    ?>
    <script>
        function goToCat(cat_id){
            window.location.href = '<?=base_url();?>index.php?/platform?cat_id='+cat_id;
        }
    </script>
<div id = "footer" style = "color: white;">
Copyright ©2014 - SuperSayem. All rights reserved
<a href = "#"  id = "my-button" style = "text-decoration: none; float: right; color: white;" onclick = "return false;">Advertise with us!</a>
</div>

<div id="element_to_pop_up">
	<form action = "<?=base_url();?>index.php?/adv" name = "my_form" method = "post">
	<table style = "margin-top: 45px; margin-left: auto; margin-right:auto; text-align: left;">
		<tr style = " text-align: center;">
			<td colspan = "2" style = "padding-bottom: 15px;">
				SuperSayem advertisment at the moment, is by invitation only
			</td>
		</tr>
		<tr>
			<td class = "input_label">Name</td>
			<td><input type = "text" name = "name" style = "width: 250px;" onkeyup ="valid();"/><font style = "color: rgb(240, 27, 27);">  *</font></td>	 
		</tr>
		<tr>	
			<td class = "input_label">Email</td>
			<td><input type = "text" name = "email" style = "width: 250px;" onkeyup ="valid();" onchange = "email_valid();"/><font style = "color: rgb(240, 27, 27);">  *</font></td>
		</tr>
		<tr>		
			<td class = "input_label">Company</td>
			<td><input type = "text" name = "company" style = "width: 250px;" onkeyup = "valid();"/><font style = "color: rgb(240, 27, 27);">  *</font></td>
		</tr>
		<tr>
			<td colspan = "2">
				<textarea placeholder="Write your comment here" name = "comment_text" id = "comment-text" onkeyup = "valid();"></textarea>
				<font style="position: relative;top: -127px;color: rgb(240, 27, 27);">  *</font>
				<input name="redirect" type="hidden" value="<?= "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ?>" />
			</td>
		</tr>
		<tr>
			<td colspan = "2"><input type = "submit" value = "Submit" id = "submit-button" class="btn btn-primary"  onclick = "return email_valid();" disabled/></td>
		</tr>
	</table>
	</form>
	<button onclick = "cancel_fun();" class = "btn btn-default" id = "cancel-button">Cancel</button>
</div>

</body>
</html>