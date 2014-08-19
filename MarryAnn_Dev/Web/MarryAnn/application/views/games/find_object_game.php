<?php
$this->lang->load('game',$_SESSION['language']);
?>

<div id = "mcq_game" class="popup-container">
	<div id="game-content-view">
            <img id= "image_content_view_id" src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/find/bg.png" style="display: none;">
            <img id= "obj" src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/find/obj.png" style="display: none; position: relative; opacity: 0;" onclick = "found();">
            <img id= "obj_found" src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/find/obj_found.png" style="display: none; position: relative;">
            <div id="intro" style="display: <?=($is_played==-1 || $cat_id == 3)?'block':'none';?>;">
                <h2 id="How-to-play"><?=($cat_id==4)?$this->lang->line('HOW_TO_PLAY'):'';?></h2>
                <a href='javascript:void(0)' style="visibility: <?=(($currentElement)?'visible':'hidden')?>" id="previous-image-mcq" onclick='get_elem(<?=$cat_id;?>,<?=$card_id;?>,0);'><img alt="previous" height="45px" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_white_left_icon.png"></a>
                <p id="game-intro" <?php if($cat_id==3){?> style = "width: 550px; direction: rtl; font-size: 16px; font-weight: bold;" <?php } ?>>
                        
                        <?=(strlen($description))?$description:$this->lang->line('game_intro_find_bottle');?>
                        <B>تحذير:</B>مينفعش تلعب غير مرة واحدة بس ولو قفلت الصفحة أو اللعبة هتسجل 0 نقاط بس
                </p>
                <a href="javascript:void(0);" style="text-decoration: none;"
                        onclick="init_find_object_game();">
                        <div class="play-button">
                                <font id="button-text"><?=$this->lang->line('Play');?></font>
                        </div>
                </a>
                <!--<a href='javascript:void(0);' style="visibility: <?=(($size > $currentElement+1)?'visible':'hidden')?>" id="next-image-game" onclick='get_elem(<?//=$cat_id;?>,<?//=$card_id;?>,1);'><img alt="next" height="45px" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_grey_right_icon.png"></a>--> 
            </div>
            <div id="final_score" style="display: <?=($is_played==-1 || $cat_id == 3)?'none':'block';?>;">
                    <h3 align="center" id="final-score-title"><?=$this->lang->line('Final_Score');?></h3>
                    <h1 align="center" id="total-score"><?=$best_score;?></h1>
                    <a href="javascript:void(0);" onclick="closeModal(<?=$cat_id?>);"
                       id="close_game" class="simplemodal-close" style="text-decoration: none;">
                        <div class="play-button" style="margin-top: 75px;position: relative;left: 88px;">
                            <font id="button-text">
                                <font color="white"><?=$this->lang->line('Done');?></font>
                            </font>
                        </div>
                    </a>
                    <a href = "#" onclick = "share_on_fb(msg); alert_fb('Shared on Facebook: ' + '\n' +  msg); closeModal(<?=$cat_id;?>);">
                    	<img src = "<?=base_url()?>h7-assets/resources/img/fb_share.png" id = "fb-share-button"/>
                    </a>
            </div>
	</div>

	<div id="right-bar-view">
        <?php /* <a href="javascript:void(0);" onclick="toggleFullScreen('#display_game');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a> */ ?>
            <a href="javascript:void(0);" id="close-popup-button" onclick="closeModal(<?=$cat_id;?>);">
        	<img src="<?=base_url()?>h7-assets/resources/img/main-icons/close_window.png" style = "width: 20px;">
        </a>
		<h5 style = "text-align: center; position: relative;">
                   <?=$card_name?>
        </h5>
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
		<h5>
			<img
				src="<?=base_url()?>h7-assets/resources/img/main-icons/game_sort.png"
				style="margin-right: 5px;"><?=($cat_id==3)?"دور عالسلاح":"دور على إزازة الخروب";?>
		</h5>
                <h4><?=($cat_id==3)?$this->lang->line('the_used_weapon'):'إزازة الخروب';?></h4>
               <?php if($cat_id==3){?>
               		<img src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/find/used_obj.png" style="height: 60px;">
               <?php }else{?>
                	<img src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/find/obj.png" style="height: 60px;">
				<?php } ?>
		<div id="score-count" style="display: none;">
                        <h4><?=$this->lang->line('SCORE');?></h4>
			<h1 id="timer" align="center" style="color: red; margin-top: -6px;">100</h1>
		</div>
	</div>
</div>
<script>
	var time_interval,final_interval,score = <?=$best_score;?>,timer = 100;
	<?php if($cat_id == 3){?>
		var msg = "أنا لقيت السلاح في حلقة  " + '<?php echo $card_name;?>' + " في سوبر صايم و جبت سكور " + score  + "\n" + "https://apps.facebook.com/hitsevenapp";
	<?php }else{?>
		var msg = "أنا إتفرجت على كومكس  " + '<?php echo $card_name;?>' + " زوجة شهريار  في سوبر صايم وجبت سكور " + score  + "\n" + "https://apps.facebook.com/hitsevenapp";
	<?php }?>
    function init_find_object_game(){
        document.getElementById('intro').style.display = 'none';
        if(<?=($is_played==-1)?1:0;?>){
            document.getElementById('image_content_view_id').style.display = 'block';
            document.getElementById('image_content_view_id').style.marginTop = '42px';
            document.getElementById('obj').style.display = 'block';
            document.getElementById('obj').style.width = <?php echo $width;?> + 'px';
            document.getElementById('obj').style.left = <?php echo $left;?> + 'px';
            document.getElementById('obj').style.top = <?php echo $top;?> + 'px';
            document.getElementById('score-count').style.display = 'block';
            document.getElementById('timer').innerHTML = timer;
            clearInterval(time_interval);
            time_interval = setInterval('count_timer()', 1000);
            update_game_score();
        } else {
            document.getElementById('final_score').style.display = 'block';
        }
    }

     function found(){
        clearInterval(time_interval);
        update_game_score();
    	document.getElementById('obj_found').style.display = 'block';
    	document.getElementById('obj_found').style.top = <?php echo $bottle_top;?> + 'px';
    	document.getElementById('obj_found').style.width = '280px';
    	document.getElementById('image_content_view_id').style.opacity = '0.7';
        final_interval = setInterval('final_timer()', 3000);
    }
    function update_game_score() {
	var ajaxpage = "<?=base_url()?>index.php?/game_center/update_score";
	$.post(ajaxpage, { game_score : score })
	.done(function( data ) {
            if(data == -1){window.location = '<?=base_url();?>'; return;}
            $("#score-<?=$cat_id?>").html(data);
	});
    }
    function count_timer(){
  	if (timer > 10){timer-=3;}
        else {timer=10;}
        score = timer;
  	document.getElementById('timer').innerHTML = timer;
    }
    function final_timer(){
  	clearInterval(final_interval);
        document.getElementById('obj_found').style.display = 'none';
        document.getElementById('image_content_view_id').style.display = 'none';
        document.getElementById('score-count').style.display = 'none';
        document.getElementById('total-score').innerHTML = timer;
        document.getElementById('final_score').style.display = 'block';
        <?php if($cat_id == 3){?>
        	msg = "أنا لقيت السلاح في حلقة  " + '<?php echo $card_name;?>' + " في سوبر صايم و جبت سكور " + score  + "\n" + "https://apps.facebook.com/hitsevenapp";
	    <?php }else{?>
	    	msg = "أنا إتفرجت على كومكس  " + '<?php echo $card_name;?>' + " زوجة شهريار  في سوبر صايم وجبت سكور " + score  + "\n" + "https://apps.facebook.com/hitsevenapp";
	    <?php }?>
    }
    function clearIntervals(){
        clearInterval(time_interval);
        clearInterval(final_interval);
    }
    if(is_fullscreen){
        $(elem_id).toggleFullScreen();
        return_to_normal_mode();
    }
</script>
