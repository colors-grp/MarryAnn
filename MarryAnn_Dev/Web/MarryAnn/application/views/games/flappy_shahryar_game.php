<?php
$this->lang->load('game',$_SESSION['language']);
$this->lang->load('date',$_SESSION['language']);
?>
<div class="popup-container">
    <div class="game_match3_container" style="float: left;">
        <!--how to play-->
        <div id="intro">
            <h2 id="How-to-play"><?=$this->lang->line('HOW_TO_PLAY');?></h2>
            <p id="game-intro">
                    <?=$this->lang->line('game_intro_flappy_shahryar');?>
            </p>
            <a href="javascript:void(0);" style="text-decoration: none;" onclick="init_search_word_game();">
                    <div class="play-button">
                            <font id="button-text"><?=$this->lang->line('Play');?></font>
                    </div>
            </a>
        </div>
        <!--end of how to play-->
        <div class="game-container" style="display: none; direction: rtl;">
            <div id="gamecontainer">
                <div id="gamescreen">
                   <div id="sky" class="animated">
                      <div id="flyarea">
                         <div id="ceiling" class="animated"></div>
                         <!-- This is the flying and pipe area container -->
                         <div id="player" class="bird animated"></div>

                         <div id="bigscore"></div>

                         <div id="splash"></div>

                         <div id="scoreboard">
                             <div id="medal">
                                 
                             </div>
                            <div id="currentscore"></div>
                            <div id="highscore"></div>
                            <div id="replay"><img src="<?=base_url()."h7-assets/resources/flappy_shahryar/";?>assets/replay.png" alt="replay"></div>
                         </div>

                         <!-- Pipes go here! -->
                      </div>
                   </div>
                   <div id="land" class="animated"><div id="debug"></div></div>
                </div>
             </div>
            <div class="boundingbox" id="playerbox"></div>
            <div class="boundingbox" id="pipebox"></div>
        </div>
        <!-- end of game-container -->
        <div id="final_score" style="display: none; position: relative; left: 245px; top: 70px;">
                <h3 align="center" id="final-score-title"><?=$this->lang->line('Final_Score');?></h3>
                <h1 align="center" id="total-score"></h1>
                <h1 align="center" id="score"></h1>
                <a href="javascript:void(0);" onclick="closeModal(<?=$cat_id?>);" id="close_game" class="simplemodal-close" style="text-decoration: none;">
                    <div class="play-button" style="margin-top: 75px;">
                        <font id="button-text">
                            <font color="white"><?=$this->lang->line('Done');?></font>
                        </font>
                    </div>
                </a>
        </div>
    </div>
    <!-- end of final_score -->
    <!-- end of game_match3_container -->
    <div id="right-bar-view">
        <?php /* <a href="javascript:void(0);" onclick="toggleFullScreen('#display_game');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a> */ ?>
        <a href="javascript:void(0);" id="close-popup-button" onclick="clearIntervals(1); closeModal(<?=$cat_id?>);">
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
                <button id="game_over_button" onclick="game_over();" style="display: none; "></button>
<!--                <br />-->
<!--		<div id="score-count" style="display: none;">
                  