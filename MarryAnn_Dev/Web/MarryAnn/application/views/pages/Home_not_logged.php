<?php
$this->lang->load('general',$_SESSION['language']);
$this->lang->load('message',$_SESSION['language']);
//$this->lang->load('date',$_SESSION['language']);
//$this->lang->load('home',$_SESSION['language']);
//$this->lang->load('score',$_SESSION['language']);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
<title><?=$this->lang->line('website_title');?></title>

<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/bootstrap/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/bootstrap/css/bootstrap-theme.css"/>
<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/css/style.css"/>

<a href="https://plus.google.com/117635853740880083872" rel="publisher">Google+</a>

<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>h7-assets/resources/img/favicon.ico">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	
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
 		
 		document.getElementById("header").style.width = w + "px";
 		document.getElementById("header").style.height = (h*0.292) + "px";
 		document.getElementById("header").style.backgroundSize = w +"px" + " " + (h*0.292) + "px";
 		
 		document.getElementById("header-content").style.width = w + "px";
 		document.getElementById("header-content").style.height = h * 0.14771 + "px";
 		document.getElementById("header-content").style.marginTop = h*0.066469 + "px";
		
		document.getElementById("left-flag").style.width = w * 0.247437 + "px";
                
 		document.getElementById("fb-div1").style.width = (w * 0.153733) + "px";
 		document.getElementById("fb-div1").style.height = (h * 0.0576) + "px";
 		document.getElementById("fb-div1").style.left = -(w * 0.042459) + "px";
 		document.getElementById("fb-div1").style.top = -(h * 0.00738) + "px";

 		document.getElementById("fb_img1").style.width = (w * 0.153733) + "px";
                
                document.getElementById("fb-div2").style.width = (w * 0.153733) + "px";
 		document.getElementById("fb-div2").style.height = (h * 0.0576) + "px";
 		document.getElementById("fb-div2").style.left = -(w * 0.042459) + "px";
 		document.getElementById("fb-div2").style.top = -(h * 0.00738) + "px";

 		document.getElementById("fb_img2").style.width = (w * 0.153733) + "px";
                
                document.getElementById("fb-div3").style.width = (w * 0.153733) + "px";
 		document.getElementById("fb-div3").style.height = (h * 0.0576) + "px";
 		document.getElementById("fb-div3").style.left = -(w * 0.042459) + "px";
 		document.getElementById("fb-div3").style.top = -(h * 0.00738) + "px";

 		document.getElementById("fb_img3").style.width = (w * 0.153733) + "px";

 		document.getElementById("mid-flag").style.width = (w * 0.247437) + "px";
 		document.getElementById("mid-flag").style.marginLeft = -(w * 0.05636) + "px";
 		document.getElementById("mid-flag").style.marginTop = (h * 0.02658) + "px";
 		
 		document.getElementById("logo").style.width = (w * 0.2335) + "px";
 		document.getElementById("logo").style.left = -(w * 0.00878) + "px";
 		document.getElementById("logo").style.top = (h * 0.0044) + "px";

 		document.getElementById("right-flag").style.width = (w * 0.247437) + "px";
 		document.getElementById("right-flag").style.marginLeft = -(w * 0.0732) + "px";
 		document.getElementById("right-flag").style.marginTop = (h * 0.00738) + "px";
 		
 		document.getElementById("content").style.width = (w * 0.6453147) + "px";
 		document.getElementById("content").style.height = (h * 0.8271787) + "px";
 		document.getElementById("content").style.backgroundSize = (w * 0.6453147) + "px" + " " + (h * 0.8271787) + "px";

 		var imgs = document.getElementsByClassName("slide-img");
 		for(var i = 0; i < imgs.length; i++){
 			imgs[i].style.height = (h * 0.8271787 * 0.45) + "px";
 			imgs[i].style.marginTop = (h * 0.8271787 * 0.48125) + "px";
 			imgs[i].style.marginLeft = (w * 0.6453147 * 0.051049) + "px";
 		}

 		var ranks = document.getElementsByClassName("ranks-img");
 		for(var i = 0; i < ranks.length; i++){
 			ranks[i].style.height = (h * 0.8271787 * 0.392857) + "px";
 			ranks[i].style.top = -(h * 0.8271787 * 0.42142857) + "px";
 			ranks[i].style.width = (w * 0.6453147 * 0.192853) + "px";
 			ranks[i].style.left = -(w * 0.6453147 * 0.098695) + "px";
 		}

 		var top3 = document.getElementsByClassName("top_3");
 		for(var i = 0; i < top3.length; i++){
 			top3[i].style.width = (w * 0.03733528) + "px";
 			top3[i].style.marginLeft = (w * 0.0102489) + "px";
 			top3[i].style.marginTop =  -(h * 0.02363367799) + "px";
 			top3[i].style.borderRadius = w * 0.1083455 + "px";
 			top3[i].style.borderBottomRightRadius = w * 0.15 + "px";
 		}

 		var top3_fanos = document.getElementsByClassName("top_3_fanos");
 		for(var i = 0; i < top3_fanos.length; i++){
 			top3_fanos[i].style.width = (w * 0.0424597) + "px";
 			top3_fanos[i].style.marginLeft = -(w * 0.0424597) + "px";
 			top3_fanos[i].style.marginTop =  -(h * 0.008862629) + "px";
 			top3_fanos[i].style.marginBottom =  (h * 0.0132939) + "px";
 		}
 		
 		var name_and_score = document.getElementsByClassName("name_and_score");
 		for(var i = 0; i < name_and_score.length; i++){
 			name_and_score[i].style.width = (w * 0.0673499) + "px";
 			name_and_score[i].style.marginTop =  -(h * 0.01477) + "px";
 		}
 		
 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = full_h - (h*0.04) + "px";
 		document.getElementById("footer").style.paddingTop = (h * 0.04 * 0.166667) + "px";
 		document.getElementById("footer").style.paddingLeft = w * 0.17789 + "px";
 		document.getElementById("footer").style.paddingRight = w * 0.175695 + "px";
 		
 		document.getElementById("header").style.display = "block";
 		document.getElementById("container").style.display = "block";
 		document.getElementById("footer").style.display = "block";
    }
        
    $(function () {
    	$('.slideshow div').hide(); // hide all slides
        	$('.slideshow div:first-child').show(); // show first slide
            	setInterval(function () {
                	$('.slideshow div:first-child').fadeOut(500).next('div').fadeIn(1000).end().appendTo('.slideshow');
              },3000); // slide duration
  	});  

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
<body onload = "page_width(); message();" style = "overflow: hidden;">

<div id = "header">
	<div id = "header-content">
		<table>
			<tr>
				<td>
					<img src = "<?=base_url();?>h7-assets/resources/img/flags_single.png" id = "left-flag">
				</td>
				<td>
                                        <!--the facebook login -->
                                        <a href = "<?php echo $this->config->item('core_url');?>?sitecode=<?=$sitecode;?>&mode=signin<?php if(isset($canvas_fbid)){echo '&cfbid='.$canvas_fbid;}?>" id = "fb-div1" >
                                                            <img src = "<?=base_url();?>h7-assets/resources/img/fb_login.png" id = "fb_img1">
                                                    </a>
                                        <a href = "<?php echo $this->config->item('core_url');?>?sitecode=<?=$sitecode;?>&mode=twitter<?php if(isset($canvas_fbid)){echo '&cfbid='.$canvas_fbid;}?>" id = "fb-div2" >
                                                            <img src = "<?=base_url();?>h7-assets/resources/img/fb_login.png" id = "fb_img2">
                                                    </a>
                                        <a href = "<?php echo $this->config->item('core_url');?>?sitecode=<?=$sitecode;?>&mode=google<?php if(isset($canvas_fbid)){echo '&cfbid='.$canvas_fbid;}?>" id = "fb-div3" >
                                                            <img src = "<?=base_url();?>h7-assets/resources/img/fb_login.png" id = "fb_img3">
                                                    </a>
					<!-- end of FB login -->
				</td>
				<td>
					<img src = "<?=base_url();?>h7-assets/resources/img/flags_single.png" id = "mid-flag">
				</td>
				<td>
					<img src = "<?=base_url();?>h7-assets/resources/img/logo.png" id = "logo"/>	
				</td>
				<td>
					<img src = "<?=base_url();?>h7-assets/resources/img/flags_single.png" id = "right-flag">
				</td>
			</tr>
		</table>
	</div>
</div>
	
<div id = "container">
	<div id = content>
		<div class="slideshow">
      		<div id = "slide1">
      			 <img src = "<?=base_url();?>h7-assets/resources/img/slides/1.png" class = "slide-img"/> 
      		</div>
      		<div id = "slide2">
      		 	<img src = "<?=base_url();?>h7-assets/resources/img/slides/2.png" class = "slide-img"/> 
      		</div>
      		<?php $size = count($category_score) - 1;
                    for ($i = 0; $i < $size + 1; $i++){
      			$id = "slide".$i+3;	?>
		      		<div id = <?=$id?>>
		      		 	<img src = "<?=base_url();?>h7-assets/resources/img/slides/<?=$i+3?>.png" class = "slide-img"/>
		      		 	<table class = "ranks-img">
		      			<?php for($j = 0; $j < 3; $j++){
                                            if(!isset($category_score[$size - $i]['top_three'][$j])){break;}
                                            ?>
		      				<tr style = "height: 33.3333%;">
		      					<td  class = "winner_box">
		      						<table>
		      							<tr>
		      								<td>
					      						<img  class = "top_3" src = "https://graph.facebook.com/<?=$category_score[$size - $i]['fb_ids'][$j]?>/picture?width=400&height=400" />
					      						<img  class = "top_3_fanos" src = "<?=base_url();?>h7-assets/resources/img/<?=$j?>.png" />
				      						</td>
				      						<td>
					      						<table class = "name_and_score">
					      							<tr><td><?php
                                                                                                            $name = $category_score[$size - $i]['top_three'][$j]['user_name'];
                                                                                                            $max_length = 10;
                                                                                                            $min_length = 3;
                                                                                                            if(strpos($name, ' ')>0 && strpos($name, ' ') > $min_length){
                                                                                                                $name = substr($name, 0,strpos($name, ' '));
                                                                                                            } else if(strlen($name)>$max_length){
                                                                                                                $name = substr($name,0,$max_length);
                                                                                                            }
                                                                                                            echo $name;
//                                                                                                            substr($category_score[$size - $i]['top_three'][$j]['user_name'], 0,strpos($category_score[$size - $i]['top_three'][$j]['user_name'], ' '));
                                                                                                        ?></td></tr>
					      							<tr><td><?=$category_score[$size - $i]['top_three'][$j]['score']?></td></tr>
					      						</table>
				      						</td>
			      						</tr>
		      						</table>
		      					</td>
		      				</tr>
		      			<?php }?>
		      			</table>
		      		</div>
      		<?php }?>
      		</div>
      	</div>
	</div>
</div>

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
<?=$this->load->view('includes/alerttify_functions');?>
</body>
</html>