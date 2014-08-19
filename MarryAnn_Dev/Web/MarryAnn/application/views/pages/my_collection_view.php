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
		<div id="cat_interest_my_collection"></div>
		<!-- 		Load Other Categories -->
		<div id="catss_not_interest_my_collection"></div>

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
							href="<?=base_url()?>index.php?/platform/index"
							style="text-decoration: none;"><h4><?=$this->lang->line('MARKET');?></h4> </a></td>
						<td><img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/separator.png"
							alt="separator"></td>
						<td style="width: 200px;"><a
							href="<?=base_url()?>index.php?/my_collection/get_my_collection"
							style="text-decoration: none;"><h4><?=$this->lang->line('MY_COLLECTION');?></h4> </a></td>
						<td><img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/separator.png"
							alt="separator"></td>
						<td style="width: 200px;"><a
							href="<?=base_url()?>index.php?/scoreboard/index"
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


<script type="text/javascript">
    function get_category_highlited(cat_id,cat_name){
    // Load categories with selected catgory highlighted
        cur_cat_name = 'white';
	get_page = "<?=base_url() ?>index.php?/category/get_category_name_without_href" ;
	$.post(get_page, {})
	.done(function( data ) {
            if (cat_name != '-1') {
                cur_cat_name = cat_name;
            } else if(data){
                    cat_name = cur_cat_name = data;
            }
            ajaxpage = "<?=base_url() ?>index.php?/category/load_interest_category_my_collection" ;
            $.post(ajaxpage , {cat_id : cat_id , cat_name : cat_name})
            .done(function(data){
                    $("#cat_interest_my_collection").html(data);
            });
	});
    }
    //-----------------------------------------
    /*function get_cards_my_collection(cat_id,cat_name){
        // Get cards of selected category with first card selected
            cur_cat_name = cat_name;
            ajaxpage = "<?=base_url() ?>index.php?/card/get_cards_my_collection_view";
            $.post(ajaxpage, { cat_id: cat_id , cat_name : cat_name , card_id : -1})
            .done(function( data ) {
                    $('#left_panel').html(data);
            });
        // select first card in category after highlited
            show_card_content(cat_id , -1, -1, -1, -1, cat_name);
    }*/
    //-----------------------------------------
    function show_card_content(cat_id, card_id, card_name, card_price, card_score, cat_name) {
        // Get card content if card was selected else it selected first card
            if(card_id != '-1') {
                    ajaxpage = "<?=base_url() ?>index.php?/card/get_card_info_mycollection";
                    $.post(ajaxpage, { cat_id: cat_id , card_id: card_id , card_name : card_name , card_price : card_price, user_points : <?= $user_points?>  , card_score : card_score , cat_name : cat_name})
                    .done(function( data ) {
                            if(data){
                                    $('#right_panel').html(data);
                            }	
                    });
            } else {
                    ajaxpage = "<?=base_url() ?>index.php?/card/on_load_get_card_info";
                    $.post(ajaxpage, { cat_id: cat_id , cat_name : cat_name})
                    .done(function( data ) {
                            if(data){
                                    $('#right_panel').html(data);
                            }	
                    });
            }
    }
    //-----------------------------------------
    /*function get_not_interest_category_my_collection(cat_id , cat_name ,  to_load){
        // Gets not interest categories from db -> if to_load = false it will add selected category to interest
        // if to_load = false it will only show its contents with first card selected if buyed
            ajaxpage = "<?//=base_url() ?>index.php?/category/load_not_interest_category_my_collction";
            $.post(ajaxpage, {cat_id : cat_id  ,  to_load :  to_load  })
            .done(function( data ) {
                    if(data){
                            $('#catss_not_interest_my_collection').html(data);
                    } else { 
                    	$('#catss_not_interest_my_collection').hide();
                    }
            });
            if(!to_load){
                // Get cards of selected category
                get_category_highlited(cat_id,cat_name);
                get_category_cards(cat_id,cat_name);
                show_card_content(cat_id, -1, -1, -1, -1, cat_name);
            }
            // Refresh dashboard from db
            load_dashboard(cat_id);
    }*/
    //-----------------------------------------
    function get_category_cards(cat_id,cat_name,card_id){
    // Gets bought cards in selected category
        ajaxpage = "<?=base_url() ?>index.php?/card/get_cards_my_collection_view";
        $.post(ajaxpage, { cat_id: cat_id , cat_name : cat_name , card_id : card_id})
        .done(function( data ) {
                $('#left_panel').html(data);
        });
    }
    //-----------------------------------------
    function on_load_my_collection(cat_id , cat_name, card_id, card_name, card_price, card_score) {
    // Sequence needed when selected category
        if (typeof cat_id === 'undefined'){cat_id = -1;}
    // Get category selected highlited
        get_category_highlited(cat_id,cat_name);
    // Get not interest categories
        //get_not_interest_category_my_collection(cat_id , cat_name ,  true);
    // Get cards of selected category
        get_category_cards(cat_id,cat_name,card_id);
    // Get selected card contents
        show_card_content(cat_id , card_id, card_name, card_price, card_score, cat_name);
    // Load dashboard of selected category
        load_dashboard(cat_id);
    }
    //-----------------------------------------
    function load_dashboard(cat_id){
    // Load dashboard content
        if(cat_id == -1){
            $('#score').html('Please Wait ...');
            $('#rank').html('');
        }
        ajaxpage = "<?=base_url() ?>index.php?/dashboard/load_new_ranks";
        $.post(ajaxpage, {cat_id : cat_id })
                .done(function(data){
                    $("#dashboard_ranks").html(data);
                });
    }
</script>
