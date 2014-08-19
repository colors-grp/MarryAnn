<?php
$this->lang->load('game',$_SESSION['language']);
$this->lang->load('date',$_SESSION['language']);
?>
<!--
 * a match 3 game, practice on using HTML5 canvas 
 * https://github.com/anhvu0911/Match3
 *
 * Author: Nguyen Huu Anh Vu (https://github.com/anhvu0911)
 *
 * Date: 2013-07-13
-->
<style>
    #gameCanvas{
            margin: auto;
            z-index: 1;
    }
    #gridCanvas{
            margin: auto;
            z-index: 0;
    }
    canvas { 
            position: absolute;
            top: 125px;
            left: 160px;
    }
</style>
<div class="popup-container">
    <div class="game_match3_container" style="float: left;">
        <!--how to play-->
        <div id="intro">
            <h2 id="How-to-play"><?=$this->lang->line('HOW_TO_PLAY');?></h2>
            <p id="game-intro">
                    <?=$this->lang->line('game_intro_match3');?>
            </p>
            <a href="javascript:void(0);" style="text-decoration: none;" onclick="init_match3_game();">
                    <div class="play-button">
                            <font id="button-text"><?=$this->lang->line('Play');?></font>
                    </div>
            </a>
        </div>
        <!--end of how to play-->
        <div class="game-container" style="display: none;">
            <canvas id="gridCanvas" width="365" height="356">
            </canvas>
            <canvas id="gameCanvas" width="325" height="325" tabindex="1">
                    <img id="slash" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/";?>slash.png"/>
                    <img id="shine" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/";?>shine.png"/>
                    <img id="sun" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/";?>sun.png"/>
                    <img id="blue" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/elemental/";?>blue.png"/>
                    <img id="green" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/elemental/";?>green.png"/>
                    <img id="magenta" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/elemental/";?>magenta.png"/>
                    <img id="orange" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/elemental/";?>orange.png"/>
                    <img id="purple" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/elemental/";?>purple.png"/>
                    <img id="red" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/elemental/";?>red.png"/>
                    <img id="yellow" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/elemental/";?>yellow.png"/>
                    <img id="special" src="<?=base_url()."h7-assets/images/categories/sallySyamak/cards/". $card_id ."/game_images/elemental/";?>special.png"/>
            </canvas>
        </div>
        <!-- end of game-container -->
        <div id="final_score" style="display: none; position: relative; left: 145px; top: 70px; margin-top:-52px;">
                <h3 align="center" id="final-score-title"><?=$this->lang->line('Final_Score');?></h3>
                <h1 align="center" id="total-score"></h1>
                <div>
                    <a href="javascript:void(0);" onclick="clearIntervals(); closeModal(<?=$cat_id?>);" id="close_game" class="simplemodal-close" style="text-decoration: none; position: relative; float: right; margin-left: -147px;">
                        <div class="play-button" style="margin-top: 75px;">
                            <font id="button-text">
                                <font color="white"><?=$this->lang->line('Done');?></font>
                            </font>
                        </div>
                    </a>
                    <a href="javascript:void(0);" onclick="clearIntervals(); init_match3_game();" style="text-decoration: none; position: relative; float: left;">
                        <div class="play-button" style="margin-top: 75px; background-color: green;">
                            <font id="button-text">
                                <font color="white">:D تاني</font>
                            </font>
                        </div>
                    </a>
                    <a href = "#" onclick = "share_on_fb(msg); alert_fb('Shared on Facebook: ' + '\n' +  msg); closeModal(<?=$cat_id?>);">
	                	<img src = "<?=base_url()?>h7-assets/resources/img/fb_share.png" id = "fb-share-button" style = "left: -80px;top: 132px;"/>
	                </a>
                </div>
        </div>
    </div>
    <!-- end of final_score -->
    <!-- end of game_match3_container -->
    <div id="right-bar-view">
        <?php /* <a href="javascript:void(0);" onclick="toggleFullScreen('#display_game');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a> */ ?>
        <a href="javascript:void(0);" id="close-popup-button" onclick="clearIntervals(); closeModal(<?=$cat_id?>);">
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
				style="margin-right: 5px;"><?=$this->lang->line('Game');?>
		</h5>
                <br />
		<div id="score-count" style="display: none;">
                    <h4><?=$this->lang->line('SECONDS');?></h4>
                    <h1 id="timer" align="center" style="color: red; margin-top: -6px;">0</h1>
                    <h4><?=$this->lang->line('SCORE');?></h4>
                    <h1 id="score" align="center" style="color: red; margin-top: -6px;">0</h1>
                    <button id="game_over_button" onclick="game_over();" style="display: none; "></button>
		</div> 
	</div>
    </div>
<div id="base_url" style="display: none;"><?=base_url();?></div>
<div id="card_id" style="display: none;"><?=$card_id;?></div>

<!--<div id="Score" style="color: red;"></div>
<div id="mainGame">
        <canvas id="gridCanvas" width="365" height="356">
        </canvas>

         use tabindex='1' to gain focus 
        <canvas id="gameCanvas" width="325" height="325" tabindex="1">
                <img id="slash" src="images/slash.png"/>
                <img id="shine" src="images/shine.png"/>
                <img id="special" src="images/special.png"/>
                <img id="sun" src="images/sun.png"/>
        </canvas>
</div>-->
<script type="text/javascript" src="<?=base_url()."h7-assets/resources/match3/"?>token.js"></script>
<script type="text/javascript" src="<?=base_url()."h7-assets/resources/match3/"?>match3.js"></script>
<script>
    var old_score = <?=$best_score?>,game_over_clicked=false;
    var msg = ' أنا لعبت خشاف  في سوبر صايم و جبت سكور' + old_score + "\n" + "https://apps.facebook.com/hitsevenapp";
    function init_match3_game(){
        document.getElementById("intro").style.display = "none";
        document.getElementById("final_score").style.display = "none";
        document.getElementById("score-count").style.display = "block";
        var games = document.getElementsByClassName("game-container");
        for(var i = 0; i < games.length; i++){
              games[i].style.display = "block";
        }
        game_over_clicked=false;
        main();
    }
    function base_url(){
        return '<?=base_url();?>';
    }
    function card_id(){
        return '<?=$card_id;?>';
    }
    function game_over(){
        if(!game_over_clicked){
            game_over_clicked = true;
            var ajaxpage = "<?=base_url();?>index.php?/game_center/update_score";
            var ajax_old_score = old_score, ajax_new_score = parseInt(document.getElementById('score').innerHTML);
            msg = ' أنا لعبت خشاف  في سوبر صايم و جبت سكور' + ajax_new_score + "\n" + "https://apps.facebook.com/hitsevenapp";
            $.post(ajaxpage , {game_score: ajax_new_score}).done(function( data ) {
                if(data == -1){window.location = '<?=base_url();?>'; return;}
                if ( ajax_new_score > ajax_old_score){
                    old_score = ajax_new_score;
                    var message = '<?=($this->lang->line('congrats').'...'.$this->lang->line('you_scored'));?> '+ ajax_new_score +' <?=($this->lang->line('up_score').', '.$this->lang->line('will_be_displayed_after_time'));?>';
                    alert_success(message);
                } else {
                    var message = '<?=$this->lang->line('try_again_info_message');?>';
                    alert_info(message);
                }
                $("#score-<?=$cat_id?>").html(data);
            });
            var games = document.getElementsByClassName("game-container");
            for(var i = 0; i < games.length; i++){
                  games[i].style.display = "none";
            }
            document.getElementById('total-score').innerHTML = document.getElementById('score').innerHTML;
            document.getElementById('final_score').style.display = 'block';
        }
    }
  </script>
