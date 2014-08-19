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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	
<script src="<?=base_url();?>h7-assets/resources/js/popup.js"></script>

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
      
		if (window.screen.availHeight > 700 && h < 600)
			h = 640;

		full_h = h;

		var FB = inIframe();
		if(FB){
			h = w * 0.4956;
		}
		
 		document.getElementById("container").style.width = w + "px";
 		document.getElementById("container").style.height = "auto";
 		document.getElementById("container").style.backgroundSize = "cover";
 		
 		document.getElementById("small-header").style.width = w + "px";
 		document.getElementById("small-header").style.height = (h*0.18) + "px";
 		document.getElementById("small-header").style.backgroundSize = w +"px" + " " + (h*0.18) + "px";
 		document.getElementById("header-table").style.marginTop = -(h * 0.0118) + "px";
 		document.getElementById("small-flags").style.width = w * 0.2928 + "px";
 		document.getElementById("small-flags").style.marginTop = h *  0.042836 + "px";

 		var imgs = document.getElementsByClassName("cat");
 		for(var i = 0; i < imgs.length; i++){
 			imgs[i].style.height = (h * 0.088626) + "px";
 		}
 		
 		var sep = document.getElementsByClassName("separator");
 		for(var i = 0; i < sep.length; i++){
 			sep[i].style.height = (h * 0.0576) + "px";
 		}
 		
 		document.getElementById("logo").style.width = (w * 0.152269) + "px";

 		document.getElementById("cats_help").style.marginTop = (h * 0.192) + "px";
 			 		
 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = (document.getElementById('container').offsetHeight + 26) - (h*0.04) + "px";
 		document.getElementById("footer").style.paddingTop = (h * 0.04 * 0.166667) + "px";
 		document.getElementById("footer").style.paddingLeft = w * 0.17789 + "px";
 		document.getElementById("footer").style.paddingRight = w * 0.175695 + "px";
 		
 		document.getElementById("small-header").style.display = "block";
 		document.getElementById("container").style.display = "block";
 		document.getElementById("footer").style.display = "block";

 		if(scroll_width == 0){
 			page_width();
 		}
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
</script>
</head>
<body onload = "page_width();">
<div id = "small-header">
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
			<td>
				<a href = "<?=base_url();?>index.php?/home" style = "text-decoration: none;" title = "سوبر صايم">
					<img src = "<?=base_url();?>h7-assets/resources/img/logo.png" id = "logo"/>
				</a>
			</td>
		</tr>
	</table>
</div>
<div id = "container">
	<table id = "cats_help">
		<tr>
			<td>
				<img src = "<?=base_url();?>h7-assets/resources/img/help/2_help.png">
			</td>
			<td>
				<img src = "<?=base_url();?>h7-assets/resources/img/help/3_help.png">
			</td>
		</tr>
		<tr>
			<td>
				<img src = "<?=base_url();?>h7-assets/resources/img/help/0_help.png">
			</td>
			<td>
				<img src = "<?=base_url();?>h7-assets/resources/img/help/1_help.png">
			</td>
		</tr>
	</table>
</div>
    <?php 
      //  $data['current_page'] = 'home';
      //  $this->load->view('ajax/timer_view_ajax',$data);
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