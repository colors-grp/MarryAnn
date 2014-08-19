<?php
$this->lang->load('game',$_SESSION['language']);
?>
<!--<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>2048</title>-->

  <link href="<?=base_url()?>h7-assets/resources/2048/style/main.css" rel="stylesheet" type="text/css">
<!--  <link rel="shortcut icon" href="favicon.ico">
  <link rel="apple-touch-icon" href="meta/apple-touch-icon.png">
  <link rel="apple-touch-startup-image" href="meta/apple-touch-startup-image-640x1096.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)">  iPhone 5+ 
  <link rel="apple-touch-startup-image" href="meta/apple-touch-startup-image-640x920.png"  media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)">  iPhone, retina -->
<!--  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">-->

<!--  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
</head>-->
<!--<body>-->
<div class="popup-container">
    <!--how to play-->
    <div id="intro" style="float: left;">
        <h2 id="How-to-play"><?=$this->lang->line('HOW_TO_PLAY');?></h2>
        <!--<a href='javascript:void(0)' style="visibility: <?=(($currentElement)?'visible':'hidden')?>" id="previous-image-mcq" onclick='get_elem(<?=$cat_id;?>,<?=$card_id;?>,0);'><img alt="previous" height="45px" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_grey_left_icon.png"></a>-->
        <p id="game-intro">
                <?=$this->lang->line('game_intro_2048');?>
        </p>
        <a href="javascript:void(0);" style="text-decoration: none;" onclick="init_2048();">
                <div class="play-button">
                        <font id="button-text"><?=$this->lang->line('Play');?></font>
                </div>
        </a>
    </div>
    <!--end of how to play-->
    <div class="game_2048_container" style=" display: none; ">
    <div class="heading" style="height: 2px;">
        <div class="above-game" style="float: left;">
         <!--<p class="game-intro">Join the numbers and get to the <strong>2048 tile!</strong></p>-->
            <a class="restart-button" >New Game</a>
       </div>
      <!--<h1 class="title">2048</h1>-->
      <div class="scores-container">
        <div class="score-container">0</div>
        <div class="best-container">0</div>
      </div>
    </div>

    <div class="game-container">
      <div class="game-message">
        <p></p>
        <div class="lower">
	        <a class="keep-playing-button">Keep going</a>
          <a class="retry-button">Try again</a>
        </div>
      </div>

      <div class="grid-container">
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
      </div>

      <div class="tile-container">

      </div>
    </div>

<!--    <p class="game-explanation">
      <strong class="important">How to play:</strong> Use your <strong>arrow keys</strong> to move the tiles. When two tiles with the same number touch, they <strong>merge into one!</strong>
    </p>
    <hr>
    <p>
    <strong class="important">Note:</strong> This site is the official version of 2048. You can play it on your phone via <a href="http://git.io/2048">http://git.io/2048.</a> All other apps or sites are derivatives or fakes, and should be used with caution.
    </p>-->
    <!--<hr>-->
<!--    <p>
    Created by <a href="http://gabrielecirulli.com" target="_blank">Gabriele Cirulli.</a> Based on <a href="https://itunes.apple.com/us/app/1024!/id823499224" target="_blank">1024 by Veewo Studio</a> and conceptually similar to <a href="http://asherv.com/threes/" target="_blank">Threes by Asher Vollmer.</a>
    </p>-->
  </div>
    <div id="right-bar-view">
        <?php /* <a href="javascript:void(0);" onclick="toggleFullScreen('#display_game');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a> */ ?>
        <a href="javascript:void(0);" id="close-popup-button" onclick="closeModal(<?=$cat_id?>);">
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
		<div id="score-count" style="display: none;">
			<?php /* <h5 style="margin-top: 20px;">
				<img
					src="<?=base_url()?>h7-assets/resources/img/main-icons/green-arrow.png"
					style="margin-right: 5px;">Score
			</h5> */ ?>
			<h1 id="timer" align="center"
				style="color: red; margin-top: -6px;"></h1>
		</div> 
		<a href = "#" onclick = "share_on_fb(msg); alert_fb('Shared on Facebook: ' + '\n' +  msg); closeModal(<?=$cat_id?>);" id = "fb-share-link" style = "display: none;">
        	<img src = "<?=base_url()?>h7-assets/resources/img/fb_share.png" id = "fb-share-button" style = "top: 15px;left: 0px;height: 35px;"/>
        </a>
	</div>
    </div>

<!--  <script src="<?=base_url()?>h7-assets/resources/2048/js/bind_polyfill.js"></script>
  <script src="<?=base_url()?>h7-assets/resources/2048/js/classlist_polyfill.js"></script>
  <script src="<?=base_url()?>h7-assets/resources/2048/js/animframe_polyfill.js"></script>-->

  <script src="<?=base_url()?>h7-assets/resources/2048/js/keyboard_input_manager.js"></script>
  <script src="<?=base_url()?>h7-assets/resources/2048/js/html_actuator.js"></script>
  <script src="<?=base_url()?>h7-assets/resources/2048/js/grid.js"></script>
  <script src="<?=base_url()?>h7-assets/resources/2048/js/tile.js"></script>
  <script src="<?=base_url()?>h7-assets/resources/2048/js/local_storage_manager.js"></script>
  <script src="<?=base_url()?>h7-assets/resources/2048/js/game_manager.js"></script>
  
  <script>
 	  var msg = "";
      function init_2048(){
          document.getElementById("intro").style.display = "none";
          var games = document.getElementsByClassName("game_2048_container");
          for(var i = 0; i < games.length; i++){
                games[i].style.display = "block";
          }
//          document.getElementById("game_2048_container").style.display = "block";
          new GameManager(4, KeyboardInputManager, HTMLActuator, LocalStorageManager);
      }
      function get_user_game_score(){
            return <?=$best_score;?>;
      }
      function base_url(){
          return '<?=base_url();?>';
      }
  </script>
  
  <!--<script src="<?=base_url()?>h7-assets/resources/2048/js/application.js"></script>-->
<!--</body>
</html>-->
