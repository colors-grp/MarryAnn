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
	<meta charset="utf-8" />
	<?php for ($i = 0; $i < count($output); $i++) {
		$cur = $output[$i];
		foreach($cur->css_files as $file): ?>
			<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
		<?php endforeach; ?>
		<?php foreach($cur->js_files as $file): ?>
			<script src="<?php echo $file; ?>"></script>
		<?php endforeach; 
	}?>
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
			<h4 style = "color: white;">
                            <img id = "header-pic" src = "http://graph.facebook.com/<?=$fb_id?>/picture" alt="Profile Picture" height="30">
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
        <div style="position: relative; top: 30px; left: 15px;">
            <?='<br />';?>
            <a href='<?=base_url();?>'>Home</a> | 
        <?php if($site_type) { //site type selected ?>
            <a href='<?=site_url('admin_page/type');?>'>Type</a> | 
            <a href='<?=site_url('admin_page/category');?>'>Categories</a> | 
            <a href='<?=site_url('admin_page/card');?>'>Cards</a> | 
            <a href='<?=site_url('admin_page/credit');?>'>Platform Credits</a> | 
        <?php } 
              if($site_type == 2) {//album ?>
            <a href='<?=site_url('admin_page/pack');?>'>Pack</a> | 
        <?php } ?>
        </div>
</head>
<body onload = "container_height()">
<div class="container" id="My-container" style="position: relative;top: 40px;">
<!--	<div id="add_mcq">
	<h2>Enter Question and 4 answers</h2>
		<form id="add_mcq_form" action = "" method="post">
			<input name = "question" type = "text"></br>
			<input name = "answer1" type = "text"></br>
			<input name = "answer2" type = "text"></br>
			<input name = "answer3" type = "text"></br>
			<input name = "answer4" type = "text"></br>
			<input name = "correct_answer" type = "text"></br>
			<input type="submit" value="Submit" name="mcq_submission">
		</form>

	</div>-->
<!--
<?php if (isset($error) && $error == 1) { ?>
    <div id="platform_type">
	<h2>This site is already registered!!</h2>
        <h3>For more information please contact us.</h3>
    </div>
<?php } elseif(!$site_type){ ?>
	<div id="choose_type">
	<h2>Please choose your platform type:</h2>
                <form name="input" action="<?=site_url('admin_page/set_site_type');?>" method="post">
                    Platform Name:<input type="text" name="name"><br />
                    Platform Type:<select name="type">
                        <option value="1">Competition</option>
                        <option value="2">Album</option>
                    </select><br />
                    Start Date:<input type="date" name="start" value="<?=date('Y-m-d');?>"><br />
                    End Date:<input type="date" name="end" value="<?=date('Y-m-d');?>"><br />
                    Start Credit:<input type="text" name="credit" value="0"><br />
                    Round:<select name="round">
                        <option value="Daily">Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Annual">Annual</option>
                    </select><br />
                    <input type="submit" value="Submit">
                </form>
        <h1>All Fields Are Mandatory.</h1>
	</div>
<?php } if($site_type) { ?>
-->    <div id="platform_type">
            <h2>Your Platform type: <B><?=($site_type==1)?'Competition':'Album';?>.</B></h2>
            <h3>Please choose another tab.</h3>
        </div><!--
<?php } ?> -->
        <div id="type_description">
            <h1><B>Description</B></h1>
            <p>
                <B>Site Code:</B>Platform code through the core.<br />
                <B>Name:</B>Platform name.<br />
                <B>Start date:</B>When players will be able to sign in and play.<br />
                <B>End date:</B>When players will <B>NOT</B> be able to sign in and play.<br />
                <B>Round:</B>When winners will be announced.<br />
                <B>Url:</B>Which this platform is signed in with.<br />
                <B>Start Credit:</B>Amount of credit the player will have when he/she register.<br />
            </p>
        </div>
	<table>
			<?php for ($i = 0; $i < count($tables); $i++) {?>
		<tr>
				<td>
					<h2><?= $tables[$i]?></h2></br>
					<?php print_r($output[$i]->output)?>
				</td>
		</tr>
			<?php }?>
	</table>
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