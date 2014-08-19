<!doctype html>
<!--[if lt IE 7]> <html calss="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7]>    <html calss="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8]>    <html calss="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9]>    <html calss="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<!-- the "no-js" class is for bootstrap modernizer. !-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
	<title>The Colors Concorrenza</title>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/bootstrap/css/bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/bootstrap/css/bootstrap-theme.css"/>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/css/style.css"/>
	
	<link href="http://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>/h7-assets/resources/css/demo.css">
<!-- 	Alertify -->
		<script src="<?=base_url()?>/h7-assets/resources/alertify/lib/alertify.min.js"></script>
    
    	<link rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/alertify/themes/alertify.core.css" />
		<link rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/alertify/themes/alertify.default.css" />
<!--     Alertify End -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	
<!-- 	<script src="<?=base_url()?>/h7-assets/resources/bootstrap/js/bootstrap.min.js"></script> -->
	<script src="<?=base_url()?>/h7-assets/resources/bootstrap/js/dropdown.js"></script>
    <script type="text/javascript" src="<?=base_url()?>/h7-assets/resources/js/jquery.js"></script> 

<!-- Simple Modal -->
<script type='text/javascript'
	src="<?= $this->config->item('platform_url');?>assets/js/simplemodal/js/jquery.simplemodal.js"></script>
<script type='text/javascript'
	src="<?= $this->config->item('platform_url');?>assets/js/simplemodal/js/basic.js"></script>
<link rel="stylesheet"
	href="<?= $this->config->item('platform_url');?>assets/js/simplemodal/css/basic.css">
<!-- End of Simple Modal -->

<!-- FULLSCREEN Plugin -->
<script type='text/javascript'
	src="<?= $this->config->item('platform_url');?>h7-assets/resources/js/jquery.fullscreen-min.js">
</script>
<!-- End of FULLSCREEN Plugin -->


<script>
	var cur_game_type = "";
	var game_started = false;
	var final_score = 0;
	$(document).keyup(function(e) {
		if (cur_game_type == "mcq") {
			if (e.keyCode == 27) {
				if (game_started == true) {
				  	document.getElementById('current_question').style.display = 'none';
				  	document.getElementById('confirm_exit').style.display = 'block';
				}
				else {
					document.getElementById('close_game').click();
				}
			}
		}
		else {
			if (e.keyCode == 27) {
				document.getElementById('close_popup').click();
			}
		}
	});
	/*
	window.onbeforeunload = function (e) {
		if (game_started == true) {
			var r=confirm("You will got a score of " + final_score + ". Are you sure you want to exit");
			if (r==true) {
				done_fun();
			}
		    //e = e || window.event;

		    var msg = "You will only get " + final_score + " Points";
		    if (e) {
		        e.returnValue = msg + "msh safari";
		    }
		    game_started = false;
		    return msg;
		}
	};
	*/
	window.onunload = function() {
	    if (game_started == true) {
	    	update_game_score();
	    }
	}

	function alert_success(message){
    	alertify.success(message);
    	return false;
    }
    
    function alert_error(message){
    	alertify.error(message);
    	return false;
    }
    
    function alert_warning(message){
    	alertify.warning(message);
    	return false;
    }
    
    function alert_info(){
    	alertify.info(message);
    	return false;
    }
</script>
<!-- Header Begin -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		 <div id = "header-container">
		 <div class="navbar-header">
			<h4 style = "color: white;">
				<img id = "header-pic" src = "http://graph.facebook.com/<?=$fb_id?>/picture" alt="Profile Picture">
				<?=$name?>
			</h4>
		 </div>
		 <ul class="nav nav-pills navbar-right" style = "height:40px;" >
		 	<li>
		 		<a href="#">
                	<img src="<?=base_url()?>/h7-assets/resources/img/main-icons/friends.png" alt="invite-friends" width = "30" >
                </a>
		 	</li>
		 	<li><img class = "indicator" src="<?=base_url()?>/h7-assets/resources/img/main-icons/header_indecator_icon.png" alt=""></li>
		 	<li>
		 		<a href="#">
                	<img src="<?=base_url()?>/h7-assets/resources/img/main-icons/notifications.png" alt="notifications" width = "30" >
                </a>
		 	</li>
		 	<li><img class = "indicator" src="<?=base_url()?>/h7-assets/resources/img/main-icons/header_indecator_icon.png" alt=""></li>
		 	<li>
		 		<a href="<?=base_url()?>index.php?/activity_log/show_log">
                	<img src="<?=base_url()?>/h7-assets/resources/img/main-icons/activitylog.png" alt="activity-log" width = "30" >
                </a>
		 	</li>
		 	<?php if ($is_admin == true) {?>
		 	<li><img class = "indicator" src="<?=base_url()?>/h7-assets/resources/img/main-icons/header_indecator_icon.png" alt=""></li>
			 	<li>
			 		<a href="<?= base_url()?>index.php?/admin_page">
	                	<img src="<?=base_url()?>/h7-assets/resources/img/main-icons/admin.png" alt="admin-icon" width = "30" >
	                </a>
			 	</li>
		 	<?php }?>
		 	<li><img class = "indicator" src="<?=base_url()?>/h7-assets/resources/img/main-icons/header_indecator_icon.png" alt=""></li>
		 	<li class="dropdown">
            	<a href="#" class="dropdown-toggle" data-toggle="dropdown" style = "height: 42px;">
                	<img id = "en-icon" src="<?=base_url()?>/h7-assets/resources/img/main-icons/en_icon.png" alt="English" width = "40">
                </a>
                <ul class="dropdown-menu ar">
                    <li>
                        <a href="#">
                        	<img src="<?=base_url()?>/h7-assets/resources/img/main-icons/ar_icon.png" alt="Arabic" width = "22">
                    	</a>
                	</li>
            	</ul>
         	</li>
         </ul>
         </div>
	</div>
<!-- 	Header End -->

</head>
<body 
	<?php if($page == 'main_view') {?>
		onload ="onload_function('<?='-1'?>','<?='-1'?>','<?=true?>');">
	<?php } else if($page == 'my_collection_view') {?>
		onload ="on_load_my_collection('<?='-1'?>','<?='-1'?>','<?=$cur_card_id?>','<?=$cur_card_name?>','<?=$cur_card_price?>','<?=$cur_card_score?>');">
	<?php }else if ($page == 'scoreboard_view') {?>
		onload ="onload_scoreboard('<?='-1'?>','<?='-1'?>','<?=true?>');">
	<?php }?>
	<a href="javascript:void(0);"
					id="close_popup" class="simplemodal-close"
					style="text-decoration: none;"><font color="white">Done</font> </a>