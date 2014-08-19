
<div id="display_game" style="display: none;">
	
</div>


<script>
	
function open_game(card_id, game_id, game_type, card_name) {
	<?php if($own_card!=FALSE ){?>
	game_page = "<?=base_url() ?>index.php?/games/" + game_type;
	wid = 0.8 * $(window).width();
	hit = 0.8 * $(window).height();
	
	$.post(game_page , {card_id : card_id, game_id : game_id, game_type : game_type, card_name : card_name})
	.done(function( data ) {
		$('#display_game').html(data);
		if(data){
			$("#display_game").modal({
				minHeight:hit,
				minWidth: wid,
				onOpen: function (dialog) {
				dialog.overlay.fadeIn('slow', function () {
					dialog.data.hide();
						dialog.container.fadeIn('slow', function () {
							dialog.data.slideDown('slow');
						});
					});
				}
			});
		}	
	});
	<?php }else  {?>
		alert('Buy card ya 7abeeby l awl :P');
	<?php }?>
}

</script>
