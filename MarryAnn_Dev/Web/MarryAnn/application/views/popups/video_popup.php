<div id="show_vid" style="display: none;" align = "center">
	<div class="popup-container">
		<div id="game-content">
			<video align = "center" style = "margin-top: 50px;" controls>
				<source id="video_id" src="" type="video/mp4"></source>
			</video>
		</div>
		<div id="right-bar">
                    <a href="javascript:void(0);" onclick="toggleFullScreen('#show_vid');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
                    <a href="javascript:void(0);" onclick="closeModal('#show_vid');"><img id="close-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
			<table style="margin-top: 5px;">
				<tr>
					<td>
						<h4 style="margin-top: -31px;"><?= $card_name?></h4>
					</td>
					<td>
						<div class="card-holder-popup" style="margin-left: 25px;">
							<img align = "center" src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/ui/list_view.png"
								class="card-pic-popup" alt="card">
						</div>
					</td>
				</tr>
				<tr style="height: 40px;">
					<td colspan="2" style="border-bottom: 4px solid #68c220;"></td>
				</tr>
			</table>
			<h5 style = "text-align: left;">
				<img
					src="<?=base_url()?>h7-assets/resources/img/main-icons/green-arrow.png"
					style="margin-right: 5px;">Image Name
			</h5>
		</div>
	</div>
</div>

<script>

function show_video(video_src) {
		// Opening animations
		<?php if($own_card!=FALSE ){?>
		document.getElementById("video_id").src = video_src;  
		wid = 950;
		hit = 458;
		$("#show_vid").modal({
			minHeight:hit,
			minWidth: wid,
			onOpen: function (dialog) {
			$('#show_vid').unbind('click');
			dialog.overlay.fadeIn('slow', function () {
				dialog.data.hide();
				dialog.container.fadeIn('slow', function () {
					dialog.data.slideDown('slow');	 
				});
			});
			
		}});
		<?php }else  {?>
			alert('Buy card ya 7abeeby l awl :P');ss
		<?php }?>
}

</script>
