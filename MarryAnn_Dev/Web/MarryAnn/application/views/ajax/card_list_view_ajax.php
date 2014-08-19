<?php 
$this->lang->load('card',$_SESSION['language']);
$this->lang->load('market',$_SESSION['language']);
?>
<!-- Cards -->
<div id="list_view">
	<table id="cards" style="text-align: left;">
		<?php $j = 0;foreach ($cards as $card) {
			if ($j % 2 == 0) {
				?>
		<tr>
			<?php } $rest = 0; ?>
			<td>
				<div class="card-list">
                                    <div style =" position: relative;top: 28px;left: 10px;">
                                    <?php
                                          if (in_array($card->id , $user_cards)) {?>
					<a href="javascript:void(0);" onclick="my_collection(<?=$card->id?>);return false;">
                                    <?php }else { ?>
                                            <a href="javascript:void(0);" onclick="buy_card_now('<?= $card->price ?>', '<?= $user_points?>' , '<?= $card->score ?>', '<?= $card->id ?>')">
                                    <?php } $h = "55"; $w = "30"; ?>
						<div class="card-holder-list">
							<img
								src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card->id?>/ui/list_view.png"
								class="card-pic-small" alt="card">
                                                        
                                                        <img
                                                            <?php if (in_array($card->id , $user_cards)) {?>
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/done_button.png"
                                                            <?php }else if( $card->price != 0 ) { ?>
                                                        src="<?=base_url()?>/h7-assets/resources/img/main-icons/get_button.png"
                                                            <?php }else {?>
                                                        src="<?=base_url()?>/h7-assets/resources/img/main-icons/trade_icon.png"
                                                            <?php } ?>
                                                        alt="" class = "list-trade-button" height="<?=$h?>" width="<?=$w?>" >
                                                        </a>
                                            <?php if( $card->price != 0 ) { ?>
							<h6 align="center" class="card-list-points">
								<?= $card->price ?>
								<?=$this->lang->line('Hit_Coins');?>
							</h6>
                                            <?php } else { ?>
                                                       <h6 align="center" class="card-list-points">
                                                                <?= $card->score ?>
                                                                <?=$this->lang->line('Points');?>
							</h6>
                                            <?php } ?>
						</div>
					
                                    </div>
					<table class="card-list-details">
						<tr>
							<td colspan="5"><h4>
									<?= $card->name ?>
								</h4></td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="media-div"><?=$this->lang->line('Media');?></div>
							</td>
                                                        <?php //log_message('error','mo7eb card_list_view_ajax $videos='.print_r($audios,TRUE));
                                                        if($images[$j] != FALSE){ ?>
							<td><img
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/cards_photo.png"
                                                                width="20">
							</td>
                                                        <?php } else { $rest++; } 
                                                              if($audios[$j] != FALSE){ ?>
							<td><img
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/cards_music.png"
                                                                width="20">
							</td>
                                                        <?php } else { $rest++; } 
                                                              if($videos[$j] != FALSE){ ?>
							<td><img
                                                                src="<?=base_url()?>/h7-assets/resources/img/main-icons/cards_video.png"
                                                                width="20">
							</td>
                                                        <?php } else { $rest++; } 
                                                              while($rest > 0){ ?>
                                                        <td><img
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/empty_button.png"
								width="20">
							</td>
                                                        <?php $rest--; } ?>
						</tr>
						<tr style="height: 10px;"></tr>
						<tr>
							<td colspan="2">
								<div class="Games-div"><?=$this->lang->line('Games');?></div>
							</td>
							<?php if($games[$j] != FALSE) {?>
							<td><img
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/cards_games.png"
								width="20">
							</td>
                                                        <?php } ?>
						</tr>
					</table>
				</div>
			</td>
			<?php if ($j % 2 != 0) {?>
		</tr>
		<?php } $j ++;
}?>
	</table>
</div>
<script>
function buy_card_now(card_price, user_points,card_score, card_id) {
	platform_page = "<?=base_url() ?>index.php?/platform/buy_card";
	$('#card-ajax').html('Processing ...'); //want to load card view after this ...
	$('#card-sta-hide').hide();
	$.post(platform_page, { card_price : card_price, user_points : user_points , card_id : card_id , cat_id : <?= $cat_id?> , card_score : card_score})
	.done(function( data ) {
		if (data > -1) {
			alert_success("Succeeded");
    		$("#user_points").html(data);
		}
		else {
    		alert_error("No Enough Points :(");
		}
		get_cards("<?=$cat_id ?>", "<?=$cat_name ?>");
	});
}
</script>