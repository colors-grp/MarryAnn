<?php 
$this->lang->load('market',$_SESSION['language']);
$this->lang->load('competition',$_SESSION['language']);
$this->lang->load('view',$_SESSION['language']);
$this->lang->load('card',$_SESSION['language']);
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
								alt=""> <font id="user_points"><?= $user_points?> </font> <?=$this->lang->line('Points');?>
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
		<!-- 		Load Other Categories -->
		<div id="catss_not_interest"></div>

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

		<!-- List&Grid buttons -->
		<!-- 		<table id = "buttons"> 
				<tr style = "height: 20px;">
					<td style = "background-color: white; width: 82px; border-radius:2px;"><a href = "#" style = "text-decoration: none;"><img src = "<?=base_url()?>/h7-assets/resources/img/main-icons/list_icon.png" alt = "list"> LIST</a></td>
					<td style = "width: 10px;"></td>
					<td style = "background-color: white; width: 82px; border-radius:2px;"><a href = "#" style = "text-decoration: none;"><img src = "<?=base_url()?>/h7-assets/resources/img/main-icons/grid_icon.png" alt = "grid"> GRID</a></td>
 				</tr> 
 			</table> -->
		<!-- end of List&Grid  -->
		<!-- Cards -->

		<table id="cards" style="text-align: left; z-index: 1">
			<tr>
				<td colspan="2"
					style="border-top: 8px solid #68c220; box-shadow: 0 2px 2px -1px gray;">
					<h4>
						<img class="arrow"
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/green-arrow.png"
							alt="green-arrow"><?=$this->lang->line('Cards');?> <a href="javascript:void(0);"
							onclick="get_cards(-1,-1);"
							style="text-decoration: none; margin-left: 353px; margin-right: 10px;"><img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/list_icon.png"
							alt="list"> <?=$this->lang->line('LIST');?></a> <a href="javascript:void(0);"
							onclick="get_cards_grid_view();" style="text-decoration: none;"><img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/grid_icon.png"
							alt="grid"> <?=$this->lang->line('GRID');?></a>
					</h4>
				</td>

			</tr>
		</table>
		<div id="card-ajax"></div>
	</div>
</div>


<script
	type="text/javascript"
	src="<?=base_url()?>/h7-assets/resources/js/kinetic.js"></script>
<script type="text/javascript" src="<?=base_url()?>/h7-assets/resources/js/jquery.final-countdown.js"></script>
<script type="text/javascript">
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
function get_cards(cat_id,cat_name){
	//Load categories with selected catgory highlighted
        if (typeof cat_id === 'undefined'){cat_id = -1;}
	cur_cat_name = 'white';
	get_page = "<?=base_url() ?>index.php?/category/get_category_name_without_href" ;
	$.post(get_page, {})
	.done(function( data ) {
		if (cat_name != '-1') {
                    cur_cat_name = cat_name;
                } else if(data){
			cat_name = cur_cat_name = data;
		}
                ajaxpage = "<?=base_url() ?>index.php?/category/load_interest_category";
                $.post(ajaxpage , {cat_id : cat_id , cat_name : cat_name})
                .done(function(data){
                        $("#cat_interest").html(data);
                });
                
		//Load new cards
		ajaxpage = "<?= base_url()?>index.php?/card/get_card_list_view"  ;
		$('#card-ajax').html('Please Wait ...');
		$('#card-sta-hide').hide();
		$.post(ajaxpage, { cat_id : cat_id , cat_name: cat_name })
		.done(function( data ) {
			if(data){
				$('#card-ajax').html(data);
			}
		});
		if(cat_id!= '-1') {
			data = '<a href="javascript:void(0);" onclick="get_cards(\'' + cat_id +'\',\'' + cat_name + '\');">' + cat_name + '</a>' ;
			$('#cat_name').html(data);
		}else {
			ajaxpage = "<?=base_url() ?>index.php?/category/get_category_name" ;
			$.post(ajaxpage)
			.done(function(data){
				cat_name = data;
				$('#cat_name').html(data);
			});	
		}
	});
        load_dashboard(cat_id);
}

function get_cards_grid_view() {
	ajaxpage = "<?= base_url()?>index.php?/card/get_card_grid_view";
	$('#card-ajax').html('Please Wait ...');
	$('#card-sta-hide').hide();
	$.post(ajaxpage)
	.done(function( data ) {
		if(data){
			$('#card-ajax').html(data);
		}	
	});
	//Load new category name
	ajaxpage = "<?=base_url() ?>index.php?/category/get_category_name" ;
	$.post(ajaxpage)
	.done(function(data){
		$('#cat_name').html(data);
	});
}


function get_not_interest_category(cat_id , cat_name ,  to_load){
	ajaxpage = "<?=base_url() ?>index.php?/category/load_not_interest_category";
	$.post(ajaxpage, {cat_id : cat_id  ,  to_load :  to_load  })
	.done(function( data ) {
		//alert(data);
		if(data){
			$('#catss_not_interest').html(data);
		} else {
			$('#catss_not_interest').hide();
		}
	});
	get_cards(cat_id , cat_name);
}

function show_card_content(cat_id, card_id,card_name , card_price,card_score,cat_name) {
	ajaxpage = "<?=base_url() ?>index.php?/card/get_card_info_mycollection";
	$('#card-ajax').html('Please Wait ...' + cat_id);
	$('#card-sta-hide').hide();
	$.post(ajaxpage, { cat_id: cat_id , card_id: card_id, card_name : card_name , card_price : card_price, user_points : <?= $user_points?>  , card_score : card_score , cat_name : cat_name})
	.done(function( data ) {
		if(data){
			$('#card-ajax').html(data);
		}	
	});
	$('#cat_name').html(
			'<a href="javascript:void(0);" onclick="get_cards(\'' + cat_id +'\',\'' + cat_name + '\');">' + cat_name + '</a>'
			+ ' - ' + card_name
			 );
                 
}
function onload_function(cat_id , cat_name, to_load) {
		get_cards(cat_id,cat_name);
		get_not_interest_category(cat_id , cat_name , to_load);
}
function load_dashboard(cat_id){
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
<script type="text/javascript">
    function my_collection(cur_card_id){
        document.location = "<?=base_url() ?>index.php?/my_collection/get_my_collection/?cur_card_id=" + cur_card_id;
    }
</script>
