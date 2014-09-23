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
<!-- 	CRUD Stuff -->
	<style type='text/css'>
	body
	{
		font-family: Arial;
		font-size: 14px;
	}
	a {
	    color: blue;
	    text-decoration: none;
	    font-size: 14px;
	}
	a:hover
	{
		text-decoration: underline;
	}
	</style>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->	
 	<script src="<?=base_url()?>/h7-assets/resources/bootstrap/js/bootstrap.min.js"></script> 
    <!--<script src="<?=base_url()?>/h7-assets/resources/bootstrap/js/dropdown.js"></script>-->
    <!--<script type="text/javascript" src="<?=base_url()?>/h7-assets/resources/js/jquery.js"></script>--> 
<!-- 	End of CRUD Stuff -->
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
	<title>The Colors Concorrenza</title>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/bootstrap/css/bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/bootstrap/css/bootstrap-theme.css"/>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>/h7-assets/resources/css/style.css"/>
	
	<link href="http://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>/h7-assets/resources/css/demo.css">

<!-- Simple Modal -->
<!--<link rel="stylesheet"
	href="<?= $this->config->item('base_url');?>assets/js/simplemodal/css/basic.css">-->
<!-- End of Simple Modal -->
    
<!-- Header Begin -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		 <div id = "header-container">
		 <div class="navbar-header">
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
		 	<li><img class = "indicator" src="<?=base_url()?>/h7-assets/resources/img/main-icons/header_indecator_icon.png" alt=""></li>
		 	<li>
		 		<a href="<?= base_url()?>index.php?/admin_page">
                	<img src="<?=base_url()?>/h7-assets/resources/img/main-icons/admin.png" alt="admin-icon" width = "30" >
                </a>
		 	</li>
		 	<li><img class = "indicator" src="<?=base_url()?>/h7-assets/resources/img/main-icons/header_indecator_icon.png" alt=""></li>
		 	<li class="dropdown">
            	<a href="#" class="dropdown-toggle" data-toggle="dropdown" style = "height: 42px;">
                	<img id = "en-icon" src="<?=base_url()?>/h7-assets/resources/img/main-icons/en_icon.png" alt="English" width = "40">
                </a>
                <ul class="dropdown-menu ar">
                    <li>
                        <a href="#">
                        	<img src="<?=base_url();?>/h7-assets/resources/img/main-icons/ar_icon.png" alt="Arabic" width = "22">
                    	</a>
                	</li>
            	</ul>
         	</li>
         </ul>
         </div>
	</div>
</head>
<body onload = "container_height()">
        <div id="sign_in" style="position: relative; top: 50px; left: 10px;">
            <a href = "<?php echo $this->config->item('core_url');?>?admin_page=<?=site_url('admin_page/');?>&mode=signin<?php if(isset($canvas_fbid)){echo '&cfbid='.$canvas_fbid;}?>" id = "fb-div1" >
                <img src = "<?=base_url();?>h7-assets/resources/img/fb_login.png" id = "fb_img1" style="height: 45px;">
            </a>
            <a href = "<?php echo $this->config->item('core_url');?>?admin_page=<?=site_url('admin_page/');?>&mode=twitter<?php if(isset($canvas_fbid)){echo '&cfbid='.$canvas_fbid;}?>" id = "fb-div2" >
                <img src = "<?=base_url();?>h7-assets/resources/img/fb_login.png" id = "fb_img2" style="height: 45px;">
            </a>
        </div>
	<div id="show_tables">
	</div>
</div>

<script>
	function container_height(){
		var h = $('#My-container').height() + 100;
		document.getElementById('My-container').style.height = h + "px";
	}
	function add_mcq() {
		page = "<?= base_url()?>index.php?/admin_page/add_mcq_question";
		$.post(page, $( "#add_mcq_form" ).serialize() )
		.done(function(data) {
			alert('Your question added successfully');
		});
	}
	$("#add_mcq_form").on('submit',function(){
		add_mcq();
		return false;
	});
</script>


</body>
</html>