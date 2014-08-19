<?php
$this->lang->load('general',$_SESSION['language']);
$this->lang->load('competition',$_SESSION['language']);
$this->lang->load('message',$_SESSION['language']);
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
<link type="text/css" rel="stylesheet" href="<?=base_url();?>h7-assets/resources/css/popup.css"/>

<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>h7-assets/resources/img/favicon.ico">

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	-->
<script src="<?=base_url();?>h7-assets/resources/js/jquery_custom_all.js"></script>	
<script src="<?=base_url();?>h7-assets/resources/js/popup.js"></script>
<script src="<?=base_url();?>h7-assets/resources/js/facebook_all.js"></script>
<script type="text/javascript" src="<?=base_url();?>h7-assets/resources/js/jquery.fullscreen-min.js"></script>

<script type="text/javascript">
	function inIframe() {
	    try {
	        return window.self !== window.top;
	    } catch (e) {
	        return true;
	    }
	}
 
 	window.onresize = function() { page_width(0); };
    window.onfocus = function() { page_width(0); };
    function page_width(get_contents){
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

		document.getElementById("cat-container").style.width = w + "px";
 		document.getElementById("cat-container").style.height = full_h + "px";
 		document.getElementById("cat-container").style.backgroundSize = w +"px" + " " + full_h + "px";
 		
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
 		
 		document.getElementById("cat-content").style.width = w * 0.7833 + "px";
 		document.getElementById("cat-content").style.marginTop = h * 0.12555 + "px";

		document.getElementById("buttons-table").style.position = "relative";
		document.getElementById("buttons-table").style.width = (w * 0.11346998) + "px";
 		document.getElementById("buttons-table").style.left = (w * 0.012445) + "px";
 		document.getElementById("buttons-table").style.top = h * 0.02215657 + "px";
 		
 		document.getElementById("cat_head").style.width = (w * 0.322108) + "px";
 		document.getElementById("cat_head").style.height = h * 0.1491875 + "px";
 		document.getElementById("cat_head").style.left = (w * 0.126647) + "px";
 		document.getElementById("cat_head").style.top = h * 0.1225997 + "px";
 		document.getElementById("cat_head").style.backgroundSize = (w * 0.322108) + "px" + " " + (h * 0.1491875) + "px";

 		var tabs = document.getElementsByClassName("cat_tabs");
 		for(var i = 0; i < tabs.length; i++){
 			tabs[i].style.height = (h * 0.08567) + "px";
 		}
 		
 		document.getElementById("unknown").style.width = w * 0.4026 + "px";
 		document.getElementById("unknown").style.height = h * 0.549483 + "px";
 		document.getElementById("unknown").style.top = h * 0.11669 + "px";
 		document.getElementById("unknown").style.left = w * 0.09736 + "px";
 		document.getElementById("unknown").style.backgroundSize = (w * 0.4026) + "px" + " " + (h * 0.549483) + "px";
 		
 		document.getElementById("bar").style.height = h * 0.062 + "px";
 		
//                alert(h);
                
 		document.getElementById("main_view_div").style.height = h * (0.3820089955022489) + "px";
//                alert(document.getElementById("main_view_div").style.height);
 		document.getElementById("main_view_div").style.width = w * 0.3491947 + "px";
 		document.getElementById("main_view_div").style.marginTop = h * 0.09158 + "px";
 		document.getElementById("main_view_div").style.marginLeft = w * 0.0226933997 + "px";

        if(selectedLink){
        	document.getElementById("main_view_div").style.overflow = "hidden";
        } else {
        	document.getElementById("main_view_div").style.overflow = "auto";
        }

        document.getElementById("games-icons").style.top = h * 0.47119 + "px";
        document.getElementById("games-icons").style.left = w * 0.32137 + "px";
        
 		document.getElementById("snd_sep").style.marginLeft = -(w * 0.0073206) + "px";
 		
 		document.getElementById("right-header").style.left = w * 0.5168 + "px";
 		document.getElementById("right-header").style.top = h * 0.17725258 + "px";
 		
        document.getElementById("user-fanous").style.width = w * 0.3197 + "px";
 		document.getElementById("user-fanous").style.height = h * 0.44165 + "px";
  		document.getElementById("user-fanous").style.left = -(w * 0.019) + "px";
 		
 		document.getElementById("small-pp").style.width = w * 0.1098 + "px";
 		document.getElementById("small-pp").style.height = h * 0.2245199 + "px";
 		document.getElementById("small-pp").style.left = w * 0.144 + "px";
 		document.getElementById("small-pp").style.top = h * 0.15657 + "px";
 		document.getElementById("small-pp").style.borderRadius = w * 0.089311 + "px";
 		document.getElementById("small-pp").style.borderBottomRightRadius = w * 0.10907759 + "px";

		document.getElementById("user_score").style.width = w * 0.04319 + "px";
		document.getElementById("user_score").style.top = -(h * 0.093) + "px";
		document.getElementById("user_score").style.left = w * 0.14055 + "px";
 	 		
 		document.getElementById("description-box-image").style.width = w * 0.161786 + "px";
 		document.getElementById("description-box-image").style.height = h * 0.1713 + "px";
 		//document.getElementById("description-box-image").style.marginTop = h * 0.028 + "px";
 		document.getElementById("description-box").style.left = w * 0.11493 + "px";
 		document.getElementById("description-box").style.top = h * 0.477 + "px";
 		document.getElementById("description").style.top = -(h * 0.14032) + "px";
 		document.getElementById("description").style.width = (w * 0.161786) + "px";
 		document.getElementById("description").style.height = (h * 0.0974) + "px";

 		document.getElementById("fb_invite").style.width = (w * 0.0959) + "px";
        document.getElementById("fb_invite").style.marginTop = -(h * 0.1683) + "px";
 		
 		 if (navigator.userAgent.indexOf("Firefox")!=-1){
			 document.getElementById("description").style.display = "block";
		}

 		document.getElementById("help-container").style.width = w * 0.15959 + "px";
 		document.getElementById("help-container").style.marginTop = -(h * 0.1004) + "px";
 		document.getElementById("help-table").style.height = h * 0.08567 + "px";
 		document.getElementById("help-table").style.marginTop = -(h * 0.09158) + "px";

 		var help_td = document.getElementsByClassName("help-table-td");
 		for(var i = 0; i < help_td.length; i++){
 	 		if(i == 1){
 	 			help_td[i].style.padding="0px " + w * 0.00585 + "px " + "0px " + w * 0.00585 + "px";
 	 	 	}
 			help_td[i].style.width = (w * 0.05344) + "px";
 		}
 		
		/*document.getElementById("user_name_cat").style.width = (w * 0.06222) + "px";
 		document.getElementById("user_name_cat").style.left = (w * 0.1698) + "px";
		document.getElementById("user_name_cat").style.top = (h * 0.036927) + "px";
*/
		if(FB){
 			document.getElementById("main_view_div").style.marginTop = h * 0.0878 + "px";
 	 		document.getElementById("main_view_div").style.marginLeft = w * 0.0208 + "px";
 //	 		document.getElementById("user_name_cat").style.top = (h * 0.0239) + "px";
		}     
 		
     /*   document.getElementById("header_counter").style.width = (w * 0.166178) + "px";
 		document.getElementById("header_counter").style.height = (h * 0.12555) + "px";
 		document.getElementById("header_counter").style.left = (w * 0.63836) + "px";
		document.getElementById("header_counter").style.top = (h * 0.76514) + "px";
	
		if( h/w > 0.5){
 			document.getElementById("header_counter").style.top = (h * 0.75375) + "px";
 		}
		
		var clock = document.getElementsByClassName("clock-item");
 		for(var i = 0; i < clock.length; i++){
 			clock[i].style.width = (w * 0.04758) + "px";
 		}

 		var text = document.getElementsByClassName("text");
 		for(var i = 0; i < text.length; i++){
 			text[i].style.top = (h * 0.0132939) + "px";
 		}
 		*/

 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = full_h - (h*0.04) + "px";
 		document.getElementById("footer").style.paddingTop = (h * 0.04 * 0.166667) + "px";
 		document.getElementById("footer").style.paddingLeft = w * 0.17789 + "px";
 		document.getElementById("footer").style.paddingRight = w * 0.175695 + "px";

 		if(last_cat_id == 0 && !selectedLink){
        	document.getElementById("games-icons").style.display = "block";
    	}else{
    		document.getElementById("games-icons").style.display = "none";
    	}
 		
 		document.getElementById("small-header").style.display = "block";
 		document.getElementById("cat-container").style.display = "block";
 		document.getElementById("footer").style.display = "block";
        //document.getElementById("header_counter").style.visibility = "visible";

                if(get_contents){
                    document.getElementById("<?=("cat_".($cat_id));?>").click();
                } else {
                    selected_cat(last_cat_id,get_contents);
                }
    }
    var last_cat_id = -1;
        function selected_cat(id, get_contents){
	        last_cat_id = id;
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
				h = w * 0.4956;
			}
//            alert(typeof(get_contents));

			for(var i = 0; i < 4; i++){
				if (id == i){
                	document.getElementById("user-fanous").src = "<?=base_url();?>h7-assets/resources/img/user_fanos_"+ i +".png";
                    document.getElementById("cat_head").style.background = "transparent url('<?=base_url();?>h7-assets/resources/img/cat/cat_head_"+ i +".png') no-repeat";
                    document.getElementById("cat_head").style.backgroundSize = (w * 0.322108) + "px" + " " + (h * 0.1491875) + "px";
                    if(!selectedLink){ // 0 in cards and 1 in scoreboard
                    	document.getElementById("ss").src = "<?=base_url();?>h7-assets/resources/img/cat/super_saymeen_" + i +".png";
                        document.getElementById("el7ala2at").src = "<?=base_url();?>h7-assets/resources/img/cat/El7ala2at_selected_" + i +".png";
                    } else {
                    	document.getElementById("ss").src = "<?=base_url();?>h7-assets/resources/img/cat/super_saymeen_selected_" + i +".png";
                        document.getElementById("el7ala2at").src = "<?=base_url();?>h7-assets/resources/img/cat/El7ala2at_" + i +".png";
                    }
				}
			}

             var imgs = document.getElementsByClassName("cat");
             for(var i = 0; i < imgs.length; i++){
                if(i == id){
                        imgs[i].style.height = (h * 0.12) + "px";
                                }else{
                        imgs[i].style.height = (h * 0.088626) + "px";
                }
             }
             
            if(typeof(get_contents)==='undefined'){
                get_user_score(id+1);
                var cats = ["sallySyamak", "mosalslat", "manElQatel" , "shahryar"];
                if(selectedLink){
                    load_scoreboard_view(id+1,2);
                } else {
                    get_cards_grid_view(id+1,cats[id]);
                }
            }
            //alert(id + " " + cats[id]);
            if(last_cat_id == 0 && !selectedLink){
            	document.getElementById("games-icons").style.display = "block";
        	}else{
        		document.getElementById("games-icons").style.display = "none";
        	}
        }
        
	// ads popups
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
<body onload = "page_width(1);" style = "overflow: hidden;">
<div id = "small-header">
	<table id = "header-table">
		<tr>
			<td>
 				<a href = "javascript:void(0);" style = "text-decoration: none;" title = "سلّي صيامك" onclick = "selected_cat(0); return false;" id="cat_0"> 
					<img src = "<?=base_url();?>h7-assets/resources/img/categories/sally.png" class = "cat" />
 				</a> 
				<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator"/>
			</td>
			<td>
 				<a href = "javascript:void(0);" style = "text-decoration: none;" title = "مسلسلات" onclick = "selected_cat(1); return false;" id="cat_1"> 
					<img src = "<?=base_url();?>h7-assets/resources/img/categories/mosalsalat.png" class = "cat" />
 				</a> 
				<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator"/>
			</td>
			<td>
 				<a href = "javascript:void(0);" style = "text-decoration: none;" title = "فين السلاح" onclick = "selected_cat(2); return false;" id="cat_2"> 
					<img src = "<?=base_url();?>h7-assets/resources/img/categories/qatel.png" class = "cat" />
 				</a> 
				<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator"/>
			</td>
			<td>
				<a href = "javascript:void(0);" style = "text-decoration: none;" title = "الف ليلة و ليلة" onclick = "selected_cat(3); return false;" id="cat_3">
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
<div id = "cat-container">
	<div id = "cat-content">
		<div id = "cat_head">
			<table id = "buttons-table">
				<tr>
					<td>
						<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator" style = "margin-right:-5px;"/>
                                                <a href = "javascript:void(0);" onclick = "load_scoreboard_view(-1,2); $('#games-icons').css('display', 'none'); return false;">
							<img src = "<?=base_url();?>h7-assets/resources/img/cat/super_saymeen_3.png" class = "cat_tabs" id = "ss"/>
						</a>
					</td>
					<td>
						<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator" id = "snd_sep" style = "margin-right: -5px;"/>
						<a href = "javascript:void(0);" onclick = "get_cards_grid_view(-1,-1); return false;">
							<img src = "<?=base_url();?>h7-assets/resources/img/cat/El7ala2at_selected_3.png" class = "cat_tabs" id = "el7ala2at"/>
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div id = "unknown" style = "z-index: 1;">
			<div id = "bar" style = "display: none;"></div>
            <div id= "main_view_div" style="overflow:auto;">
            </div>
            <table id = "games-icons" style = "position: fixed; display:none;">
            	<tr>
            		<td>
                            <a href = "javascript:void(0);" style = "text-decoration: none;" onclick="display_mixed_popup(1,33)">
							<img src = "<?=base_url();?>h7-assets/resources/img/2048.png" class = "cat"/>
						</a>
						<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator" />
            		</td>
            		<td>
                            <a href = "javascript:void(0);" style = "text-decoration: none;" onclick="display_mixed_popup(1,34)">
							<img src = "<?=base_url();?>h7-assets/resources/img/khoshaf.png" class = "cat"/>
						</a>
						<img src = "<?=base_url();?>h7-assets/resources/img/separator.png" class = "separator" />
            		</td>
            		<td>
                            <a href = "javascript:void(0);" style = "text-decoration: none;" onclick="display_mixed_popup(1,35)">
							<img src = "<?=base_url();?>h7-assets/resources/img/shahryar.png" class = "cat"/>
						</a>
					</td>
            	</tr>
            </table>
		</div>
		<div id = "right-header">
			<img src = "https://graph.facebook.com/<?=$_SESSION['fb_id']?>/picture?width=400&height=400" id = "small-pp"/>
			<img src = "<?=base_url();?>h7-assets/resources/img/user_fanos_3.png" id = "user-fanous"/>
			<div id = "user_score"><?=$user_score;?></div>
			<!--  <h4 id = "user_name_cat"><?=substr($user_fullname, 0,strpos($user_fullname, ' '));?></h4>-->
			<div id = "description-box">
				<img src = "<?=base_url();?>h7-assets/resources/img/box.png" id = "description-box-image"/>
				<div  id = "description">
					<?=$user_fullname?>
				</div>
				<a href = "#"  onclick = "InviteF(); return false;">
					<img src = "<?=base_url();?>h7-assets/resources/img/e3zem.png" id = "fb_invite" style = "cursor: pointer;"/>
				</a>
				<img src = "<?=base_url();?>h7-assets/resources/img/timer_holder.png" id = "help-container" />
				<table id = "help-table" style = "text-align: center;">
				<tr>
					<td class = "help-table-td">
                        <a href = "<?=base_url();?>index.php?/sign_out" style = "text-decoration: none; color: #CE3333;"><h5 style = "font-weight: bold;">خروج</h5></a>
					</td>
					<td class = "help-table-td">
						<a href = "https://www.facebook.com/SuperSayem" target = "_blank" style = "text-decoration: none; color: #CE3333;"><h5 style = "font-weight: bold;">صفحة الفايسبوك</h5></a>
					</td>
					<td class = "help-table-td">
						<a href = "<?=base_url();?>index.php?/help" target = "_blank" style = "text-decoration: none; color: #CE3333;"><h5 style = "font-weight: bold;">مساعدة</h5></a>
					</td>
				</tr>
			</table>
			</div>
		</div>
	</div>
</div>
    <?php
    // Load the mixed Popupand timer
//  $this->load->view('ajax/timer_view_ajax');
	$this->load->view('popups/mixed_popup');
    ?>
<script type="text/javascript" >
    // 0 = cards view , 1 = scoreboard view
    var selectedLink = 0;
    //---------------------------
    /*
    #ranks_table_div{
	overflow: hidden;
	float:right;
	background: transparent url('../img/cat/score_table_bg_3.png');	
    */
    function load_scoreboard_view(cat_id, all){
        if(cat_id == -1){
            document.getElementById("ss").src = "<?=base_url();?>h7-assets/resources/img/cat/super_saymeen_selected_"+(last_cat_id)+".png";
            document.getElementById("el7ala2at").src = "<?=base_url();?>h7-assets/resources/img/cat/El7ala2at_"+(last_cat_id)+".png";
            $('#unknown').css('background', 'url(<?=base_url();?>h7-assets/resources/img/cat/cat_score_bg_'+(last_cat_id)+'.png) no-repeat');
        }
        else{
        	document.getElementById("ss").src = "<?=base_url();?>h7-assets/resources/img/cat/super_saymeen_selected_"+(cat_id - 1)+".png";
        	document.getElementById("el7ala2at").src = "<?=base_url();?>h7-assets/resources/img/cat/El7ala2at_"+(cat_id - 1)+".png";
        	$('#unknown').css('background', 'url(<?=base_url();?>h7-assets/resources/img/cat/cat_score_bg_'+(cat_id - 1)+'.png) no-repeat');
        }
		

		document.getElementById("main_view_div").style.direction = "ltr";
		
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
			h = w * 0.4956;
		}
		
        document.getElementById("unknown").style.backgroundSize = (w * 0.4026) + "px" + " " + (h * 0.549483) + "px";
    // Get top three users
        $("*").css("cursor", "progress");
    	$.ajaxSetup({async: false}); //So as to avoid any other ajax calls made sybchrounously
        get_top_three(cat_id);
        $.ajaxSetup({async: true}); //So as to avoid any other ajax calls made sybchrounously
    // call scoreboard main function
        scoreboard(cat_id,all);
        selectedLink = 1;
    }
    <?php
        $this->load->view('ajax/my_collection_main_functions_ajax');
        $this->load->view('ajax/scoreboard_main_functions_ajax');
   
    ?>
</script>
<?=$this->load->view('includes/alerttify_functions');?>
<div id = "footer"  style = "color: white;">
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
				<input name="redirect" type="hidden" value="<?= "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ?>" />
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