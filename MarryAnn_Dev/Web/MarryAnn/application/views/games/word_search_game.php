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
                    <?=$this->lang->line('game_intro_word_search');?>
            </p>
            <a href="javascript:void(0);" style="text-decoration: none;" onclick="init_search_word_game();">
                    <div class="play-button">
                            <font id="button-text"><?=$this->lang->line('Play');?></font>
                    </div>
            </a>
        </div>
        <!--end of how to play-->
        <div class="game-container" style="display: none; direction: rtl;">
        </div>
        <!-- end of game-container -->
        <div id="final_score" style="display: none; position: relative; left: 245px; top: 70px;">
                <h3 align="center" id="final-score-title"><?=$this->lang->line('Final_Score');?></h3>
                <h1 align="center" id="total-score"></h1>
                <a href="javascript:void(0);" onclick="closeModal(<?=$cat_id?>);" id="close_game" class="simplemodal-close" style="text-decoration: none;">
                    <div class="play-button" style="margin-top: 75px;position: relative;left: 88px;">
                        <font id="button-text">
                            <font color="white"><?=$this->lang->line('Done');?></font>
                        </font>
                    </div>
                </a>
                <a href = "#" onclick = "share_on_fb(msg); alert_fb('Shared on Facebook: ' + '\n' + msg); closeModal(<?=$cat_id?>);">
                	<img src = "<?=base_url()?>h7-assets/resources/img/fb_share.png" id = "fb-share-button"/>
                </a>
        </div>
    </div>
    <!-- end of final_score -->
    <!-- end of game_match3_container -->
    <div id="right-bar-view">
        <?php /* <a href="javascript:void(0);" onclick="toggleFullScreen('#display_game');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a> */ ?>
        <a href="javascript:void(0);" id="close-popup-button" onclick="closeModal(<?=$cat_id?>);">
        	<img src="<?=base_url()?>h7-assets/resources/img/main-icons/close_window.png" style = "width: 20px;">
        </a>
		<h5 style = "text-align: center; position: relative; direction: rtl;">
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
				style="margin-right: 5px;"><?=$this->lang->line('Puzzle');?>
		</h5>
                <br />
		<div id="score-count" style="display: none;">
<!--                    <h4><?=$this->lang->line('SECONDS');?></h4>
                    <h1 id="timer" align="center" style="color: red; margin-top: -6px;">0</h1>-->
                    <h4><?=$this->lang->line('SCORE');?></h4>
                    <h1 id="score" align="center" style="color: red; margin-top: -6px;">0</h1>
                    <h4><?=$this->lang->line('you_scored');?></h4>
                    <h1 id="best-score" align="center" style="color: red; margin-top: -6px;"><?=$best_score;?></h1>
                    <button id="game_over_button" onclick="game_over();" style="display: none; "></button>
		</div> 
	</div>
    </div>
<div id="base_url" style="display: none;"><?=base_url();?></div>
<div id="card_id" style="display: none;"><?=$card_id;?></div>

<!--<script type="text/javascript" src="<?=base_url()."h7-assets/resources/word_search/"?>jquery-1.6.2.min.js"></script>-->
<!--<script src="<?=base_url();?>h7-assets/resources/js/jquery_custom_all.js"></script>-->
<script type="text/javascript" src="<?=base_url()."h7-assets/resources/word_search/"?>jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url()."h7-assets/resources/word_search/"?>jquery.wordsearchgame.js" charset="UTF-8"></script>
<link  rel="stylesheet" type="text/css" href="<?=base_url()."h7-assets/resources/word_search/"?>jquery.wordsearchgame.css">
<script type="text/javascript">
    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })();
</script>


<script>
    var old_score = <?=$best_score;?>,game_over_clicked=false;
    var msg = "";
    function init_search_word_game(){
        var words = "<?=$words?>";
        //attach the game to a div
        $(".game-container").wordsearchwidget({"wordlist" : words,"gridsize" : 10});
        document.getElementById("intro").style.display = "none";
        document.getElementById("score-count").style.display = "block";
        var games = document.getElementsByClassName("game-container");
        for(var i = 0; i < games.length; i++){
              games[i].style.display = "block";
        }
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
//            alert(document.getElementById('score').innerHTML);
            //$.ajaxSetup({async: false}); //So as to avoid any other ajax calls made sybchrounously
            var score = parseInt(document.getElementById('score').innerHTML);
            msg = "أنا جمعت الكلمات في حلقة  " + '<?php echo $card_name;?>' + " من سلي صيامك  في سوبر صايم و جبت سكور " + score  + "\n" + "https://apps.facebook.com/hitsevenapp";
            var ajax_new_score = score, ajax_old_score = old_score;
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
