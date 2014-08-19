<?php 
$this->lang->load('competition',$_SESSION['language']);
$this->lang->load('market',$_SESSION['language']);
?>
<!-- Container -->
<div class="container" id="My-container">
	<!-- Left Header -->
	<div id="left-header">
		<div id="logo">
			<img
				src="<?=base_url()?>/h7-assets/resources/img/main-icons/Logo.png"
				alt="Logo" style="margin-left: 11.5px;">
			<div id="profile">
				<div id="profile-white-background">
					<div id="profile-orange-background">
						<img
							src="http://graph.facebook.com/<?=$fb_id?>/picture?width=200&height=200"
							alt="profile picture" id="profile-pic">
						<div style="position: relative; top: -23px; width: 229px; text-align: center; color: white; font-size: 18px;">
							<font><?=$name?> </font>
						</div>
                                                <?php if($user_points != 0){ ?>
						<div id="points-image">
							<img
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/points_icon.png"
								alt=""> <font id="user_points"><?= $user_points?> </font><?=$this->lang->line('Points');?> 
							<br /> <img
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/arrow_icon.png"
								alt=""> <a id="getPointsButton" href="#"
								style="text-decoration: none;"><?=$this->lang->line('GetMorePoints');?></a>
						</div>
                                                <?php } ?>
					</div>
				</div>
			</div>
		</div>
		<!-- 	Load the Buy Credit Popup ... -->
		<?php
                    $this->load->view('popups/buy_credit_popup');
		?>
		<!-- 		Load Interset Categories -->
		<div id="cat_interest"></div>
		<!-- 		Load Other Categories 
		<div id="catss_not_interest_my_collection"></div> -->

	</div>
	<!-- end of left header -->
	<!-- Content -->
	<div id="content">

		<!-- pages bar -->
		<div id="pages-bar">
			<div class="row">
				<table style="margin-left: 25px; text-align: center;">
					<tr>
						<td style="width: 158px;"><a
							href="javascript:void(0);"
                                                        onclick=""
							style="text-decoration: none;"><h4><?=$this->lang->line('MARKET');?></h4> </a></td>
						<td><img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/separator.png"
							alt="separator"></td>
						<td style="width: 200px;" ><a
							href="javascript:void(0);"
                                                        onclick="load_my_collection_views();"
							style="text-decoration: none;"><h4><?=$this->lang->line('MY_COLLECTION');?></h4> </a></td>
						<td><img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/separator.png"
							alt="separator"></td>
						<td style="width: 200px;"><a
							href="javascript:void(0);"
                                                        onclick="load_scoreboard_views();"
							style="text-decoration: none;"><h4><?=$this->lang->line('SCOREBOARDS');?></h4> </a></td>
					</tr>
				</table>
			</div>
		</div>
		<!-- end of pages bar -->

		<!-- 		Load Dashboard -->
		<?php $this->load->view('pages/dashboard_view')?>
		<!-- 		End of Dashboard -->
                
                    <div id="card-details">

                            <!-- Category cards -->
                            <div id="left_panel"></div>
                            <!-- Category cards End -->

                            <!-- Card Details -->
                            <div id="right_panel"></div>
                            <!-- Card Details End -->

                    </div>
                
	</div>
</div>
<script
	type="text/javascript"
	src="<?=base_url()?>/h7-assets/resources/js/kinetic.js"></script>
<script
	type="text/javascript"
	src="<?=base_url()?>/h7-assets/resources/js/jquery.final-countdown.js"></script>
<script type="text/javascript">
    
    <?php //log_message('error','Mo7eb my_collection_view finalCountDown >>>> ', $_SESSION['cur_round']->start_date .",". $_SESSION['cur_round']->end_date); ?>
    $('.countdown').final_countdown(<?php 
                                        if($_SESSION['cur_round'] != FALSE)
                                            {  echo time() .",". $_SESSION['cur_round']->start_date .",". $_SESSION['cur_round']->end_date;}
                                        else{echo "0 ,0 , 0";}
                                     ?>);
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


<script type="text/javascript" >
    function load_my_collection_views(){// load needed divs as my collection selected
    // get my_collection main divs
        //$('#cards').show();
        $('#card-details').html("<!-- Category cards --><div id='left_panel'></div><!-- Category cards End --><!-- Card Details --><div id='right_panel'></div><!-- Card Details End -->");
    // call my_collection main function
        on_load_my_collection(-1,-1,-1,-1,-1,-1);
    }
    //---------------------------
    function load_scoreboard_views(){
    // call scoreboard main function
        onload_scoreboard(-1,-1,1);
    }
    <?php
        $this->load->view('ajax/my_collection_main_functions_ajax');
        $this->load->view('ajax/scoreboard_main_functions_ajax');
    ?>
        document.onload=load_my_collection_views();
</script>
