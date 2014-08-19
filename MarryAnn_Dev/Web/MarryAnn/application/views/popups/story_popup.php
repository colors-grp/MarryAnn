<div id="play_story" style="display: none;" align = "center">
	<div class="popup-container">
		<div id="game-content">
			<a href='javascript:void(0)' style="visibility:hidden;" id="previous-image" onclick='get_previous_story_image();'><img alt="previous" src="<?=base_url()?>h7-assets/resources/img/main-icons/bigarrow_left_icon.png"></a>
			<a onclick="getElementReadyForFullScreenMode('#story_id')" >
				<img id= "story_id" width="400px" height="400px" align = "center" style = "margin: 50px;" src="" >
			</a>
			<a href='javascript:void(0);' id="next-image" onclick='get_next_story_image(0);'><img alt="next" src="<?=base_url()?>h7-assets/resources/img/main-icons/bigarrow_right_icon.png"></a>
		</div>
		<div id="right-bar">
                    <a href="javascript:void(0);" onclick="toggleFullScreen('#play_story');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
                    <a href="javascript:void(0);" onclick="closeModal('#play_story');"><img id="close-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
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
					style="margin-right: 5px;"
				>
				<a href="javascript:void(0)" onclick="getElementReadyForFullScreenMode('#play_story')" >
					<?=$card_name?>
				</a>
			</h5>
		</div>
	</div>
</div>

<script>
function play_story(story_src) {
	// Opening animations
	<?php if($own_card!=FALSE ){?>
	document.getElementById("story_id").src = story_src;
	wid = 950;
	hit = 458;
	$("#play_story").modal({
		minHeight:hit,
		minWidth: wid,
		onOpen: function (dialog) {
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
function get_next_story_image(currentImage){
	$("#previous-image").css("visibility", 'visible');
	ajaxpage = "<?=base_url() ?>index.php?/card/get_next_story_image";
    $.post(ajaxpage, {currentImage : currentImage , card_id : <?=$card_id?> , cat_name : '<?=$cat_name?>'})
            .done(function(data){
            	//alert(data);
                if(data){
                	$("#story_id").attr("src","<?=base_url();?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/story/"+data);
                	$("#next-image").attr("onclick","get_next_story_image(" + (currentImage + 1) + ")" );
                	$("#previous-image").attr("onclick","get_previous_story_image(" + (currentImage + 1) + ")" );
                }
            });
    ajaxpage = "<?=base_url() ?>index.php?/card/get_next_story_image";
    $.post(ajaxpage, {currentImage : (currentImage + 1) , card_id : <?=$card_id?> , cat_name : '<?=$cat_name?>'})
            .done(function(data){
            	//alert(data);
                if(!data){
                	$("#next-image").css("visibility", 'hidden');
                }
            });
}
//----------------------------------------------------
function get_previous_story_image(currentImage){// Get previous story image from story folder
	//alert('entered');
// show next arrow image
	$("#next-image").css("visibility", 'visible');
// Get previous image if found else do nothing
	ajaxpage = "<?=base_url() ?>index.php?/card/get_previous_story_image";
    $.post(ajaxpage, {currentImage : currentImage , card_id : <?=$card_id?> , cat_name : '<?=$cat_name?>'})
            .done(function(data){
                if(data){
                // Change image
                	$("#story_id").attr("src","<?=base_url();?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/story/"+data);
               	// Change next onlclick calling function to call next image
                	$("#next-image").attr("onclick","get_next_story_image(" + (currentImage - 1) + ")" );
                // Change next onlclick calling function to call previous image
                	$("#previous-image").attr("onclick","get_previous_story_image(" + (currentImage - 1) + ")" );
                }
            });
// check if there is no more previous images in the folder
    ajaxpage = "<?=base_url() ?>index.php?/card/get_previous_story_image";
    $.post(ajaxpage, {currentImage : (currentImage - 1) , card_id : <?=$card_id?> , cat_name : '<?=$cat_name?>'})
            .done(function(data){
                if(!data){
                // if no data hide previous arrow image
                	$("#previous-image").css("visibility", 'hidden');
                }
            });
}
</script>