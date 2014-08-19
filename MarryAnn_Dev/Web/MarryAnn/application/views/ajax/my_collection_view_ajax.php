<?php 
$this->lang->load('card',$_SESSION['language']);
?>
	<!-- 	Load the Image Popup ... -->
	<?php
	$this->load->view('popups/image_popup');
	?>
	
    <!-- 	Load the Audio Popup ... -->
	<?php
	$this->load->view('popups/audio_popup');
	?>
    
    <!-- 	Load the Video Popup ... -->
	<?php
	$this->load->view('popups/video_popup');
	?>
    <!-- 	Load the Game Popup ... -->
	<?php
	$this->load->view('popups/game_popup');
	?>
	<!-- 	Load the Story Popup ... -->
	<?php
	$this->load->view('popups/story_popup');
	?>

<?php if ($images != false) { ?>
<table id="card-photos">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_photo.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" /><?=$this->lang->line('Photos');?>
		</td>
	</tr>
        <?php
        for($pos=0;$pos<count($images);) { ?>
	<tr align="center">
    <?php  $counter = 0; 
    for($i=0;$i<3&&$pos<count($images);$i++,$pos++,$counter++) { ?>
		<td class="photo-padding">
			<a href="javascript:void(0)"
				onclick="display_image('<?= base_url(); ?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/image/<?= $images[$pos]?>')">
					<img
					src="<?= base_url(); ?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/image/<?= $images[$pos]?>"
					border="0" class="img-circle" style="width: 40px; height: 40px;">
			</a>
		
		</td>
            <?php } ?> 
        </tr> 
        <tr align="center">
            <?php $pos = $pos - $counter; //log_message('error','mo7eb my_collection_view_ajax $pos='.$pos.'   $counter='.$counter);
                for($i=0;$i<3&&$pos<count($images);$i++,$pos++) { 
            ?>
                <td> <?=substr($images[$pos] , 0 , strrpos( $images[$pos] , '.' , 0 ));?> </td>
            <?php } ?> 
        </tr> 
        <?php } ?>
</table>
<?php } if ($videos != false) { ?>
<table id="card-videos">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_video.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" /><?=$this->lang->line('Videos');?>
		</td>
	</tr>
	<?php
        for($pos=0;$pos<count($videos);) { ?>
	<tr align="center">
    <?php  $counter = 0; 
    for($i=0;$i<3&&$pos<count($videos);$i++,$pos++,$counter++) { ?>
		<td class="photo-padding">
			<a href="javascript:void(0)"
                                           
				onclick="show_video('<?=base_url();?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/video/<?= $videos[$pos]?>')">
					<img
                                            <?php if(file_exists(base_url()."h7-assets/images/categories/".$cat_name."/cards/".$card_id."/video/".$videos[$pos])){ ?>
                                                src="<?= base_url(); ?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/video/<?= $videos[$pos]?>"
                                            <?php } else { ?>
                                                src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_video.png"
                                            <?php } ?>
                                            border="0" class="img-circle" style="width: 40px; height: 40px;">
			</a>
		
		</td>
            <?php } ?> 
        </tr> 
        <tr align="center">
            <?php $pos = $pos - $counter; //log_message('error','mo7eb my_collection_view_ajax $pos='.$pos.'   $counter='.$counter);
                for($i=0;$i<3&&$pos<count($videos);$i++,$pos++) { 
            ?>
                <td> <?=substr($videos[$pos] , 0 , strrpos( $videos[$pos] , '.' , 0 ));?> </td>
            <?php } ?> 
        </tr> 
        <?php } ?>
</table>
<?php } if ($audios != false) { ?>
<table id="card-music">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_music.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" /><?=$this->lang->line('Music');?>
		</td>
	</tr>
	<?php
        for($pos=0;$pos<count($audios);) { ?>
	<tr align="center">
    <?php  $counter = 0; 
    for($i=0;$i<3&&$pos<count($audios);$i++,$pos++,$counter++) { ?>
		<td class="photo-padding">
			<a href="javascript:void(0)"
				onclick="play_audio('<?=base_url();?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/audio/<?=$audios[$pos];?>')">
					<img
                                            <?php if(file_exists(base_url()."h7-assets/images/categories/".$cat_name."/cards/".$card_id."/audio/".$audios[$pos])){ ?>
                                                src="<?= base_url(); ?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/audio/<?= $audios[$pos]?>"
                                            <?php } else { ?>
                                                src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_music.png"
                                            <?php } ?>
					
					border="0" class="img-circle" style="width: 40px; height: 40px;">
			</a>
		
		</td>
            <?php } ?> 
        </tr> 
        <tr align="center">
            <?php $pos = $pos - $counter; //log_message('error','mo7eb my_collection_view_ajax $pos='.$pos.'   $counter='.$counter);
                for($i=0;$i<3&&$pos<count($audios);$i++,$pos++) { 
            ?>
                <td> <?=substr($audios[$pos] , 0 , strrpos( $audios[$pos] , '.' , 0 ));?> </td>
            <?php } ?> 
        </tr> 
        <?php } ?>
</table>
<?php } if ($games != false) { ?>
<table id="card-game">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_game.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" /><?=$this->lang->line('Games');?>
		</td>
	</tr>
	
	<tr align="center">
		<?php foreach ($games->result() as $game) {  ?>
		<td class="photo-padding">
			<a href="javascript:void(0)" onclick ="open_game('<?=$card_id?>', '<?= $game->game_id?>','<?= $game->game_type?>', '<?= $card_name ?>')">
				<img src="<?= base_url(); ?>h7-assets/resources/img/main-icons/game_icon.jpg" border="0" class="img-circle" > 
			</a>
		</td>
		<?php }?>
	</tr>
        <tr align="center">
            <?php foreach ($games->result() as $game) { ?>
            <td>
                <?=$game->game_type;?>
            </td>
            <?php }?>
        </tr>
</table>
<?php } if ($stories != false) { ?>
<table id="card-game">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img width="30" height="30"
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_story.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" /><?=$this->lang->line('Story');?>
		</td>
	</tr>
	<tr align="center">
		<td class="photo-padding">
			<a href="javascript:void(0)"
				onclick="play_story('<?=base_url();?>h7-assets/images/categories/<?=$cat_name;?>/cards/<?=$card_id;?>/story/<?=$stories[0];?>');">
					<img
					src="<?= base_url(); ?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/story/<?=$stories[0]?>"
					border="0" class="img-circle" style="width: 40px; height: 40px;">
			</a>
		</td>
	</tr>
</table>
<?php } ?>