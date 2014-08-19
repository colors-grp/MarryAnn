<div class="popup-container" >
    <!--style="position: absolute; top: 0px; left: 0px; background-color: transparent;"-->
    <div id="game-content-view">
        <a href='javascript:void(0)' style="visibility: <?=(($currentElement)?'visible':'hidden')?>" id="previous-image" onclick='get_elem(<?=$cat_id;?>,<?=$card_id;?>,0);'><img alt="previous" id="previous-image" class="prev-img" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_white_left_icon.png"></a>
            <!--<a onclick="getElementReadyForFullScreenMode('#story_content_view_id')" > -->
                <?php if($type == 1) { // image ?>
                    <img id= "image_content_view_id"
                         src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/image/<?=$element?>" >
                <?php  } elseif($type == 2) { // audio ?>
                    <audio controls id= "audio_content_view_id">
                        <source src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/audio/<?=$element?>" type="audio/mpeg">
                    </audio>
                <?php  } elseif($type == 3) { // video ?>
                    <video id= "video_content_view_id" controls>
				<source src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/video/<?=$element?>"
                                        type="video/mp4" >
                    </video>
                <?php } ?>
            <!--</a>-->
            <a href='javascript:void(0);' style="visibility: <?=(($size > $currentElement+1)?'visible':'hidden')?>" id="next-image" onclick='get_elem(<?=$cat_id;?>,<?=$card_id;?>,1);'><img alt="next" id="next-image" class="next-img" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_white_right_icon.png"></a>
    </div>
    <div id="right-bar-view">
        <a href="javascript:void(0);" onclick="toggleFullScreen();" style="width: 20px;"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/fullscreen.png" style="position: absolute; width: 20px; top: -18px; left: 223px;"></a>
        <a href="javascript:void(0);"  id="close-popup-button" onclick="closeModal(<?=$cat_id?>);" style="width: 20px;">
        	<img src="<?=base_url()?>h7-assets/resources/img/main-icons/close_window.png" style = "width: 20px;">
        </a>
        <h5 style = "text-align: center; position: relative;"><?=$card_name?></h5>
        
            <table style="margin-top: 5px;">
                    <tr>
                        <td>
                                <h4 style="margin-top: -31px;"><?//=$card_name;?></h4>
                        </td>
                        <td>
                                <div class="card-holder-popup-view">
                                        <img align = "center" src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/ui/list_view.png"
                                                class="card-pic-popup-view" alt="card">
                                </div>
                        </td>
                    </tr>
                    <tr style="height: 40px;">
                            <td colspan="2" style="border-bottom: 4px solid #FF0000; width: 208px;"></td>
                    </tr>
            </table>
    </div>
</div>
<script>
if(is_fullscreen){
    fullscreen_mode();
} else {
    return_to_normal_mode();
}
</script>
