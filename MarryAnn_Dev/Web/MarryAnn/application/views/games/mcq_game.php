<?php $q = implode("~",$ques);
$c = array(array());
for ($i = 0; $i < count($choice) ; $i ++) {
	$c[$i] = implode("~",$choice[$i]);
}
$cc = implode("^", $c);
$a = implode("~",$ans);
$this->lang->load('game',$_SESSION['language']);
?>
<div id = "mcq_game" class="popup-container">
	<div id="game-content-view">
		<div id="mcq-content" style="display: <?=($is_played==-1)?'none':'block';?>;">
                    <table id="Q-score-table" <?=($is_played==-1)?'':'style="display: none;"';?>>
				<tr>
					<?php for ($i = 0 ; $i < count($ques); $i ++) { ?>
					<td>
						<div id="question-<?=$i?>" class="empty-circle">
							<font id="question-score-<?=$i?>" class="Q-score">
                                                                Q<?=($i + 1)?>
							</font>
						</div>
					</td>
					<?php }?>
				</tr>
			</table>
			<div id="final_score" style="display: <?=($is_played==-1)?'none':'block';?>;">
				<h3 align="center" id="final-score-title"><?=$this->lang->line('Final_Score');?></h3>
				<h1 align="center" id="total-score"><?=$best_score;?></h1>
                    <a href="javascript:void(0);" onclick="clearIntervals(); closeModal(<?=$cat_id?>);" id="close_game" class="simplemodal-close" style="text-decoration: none;">
                    	<div class="play-button" style="margin-top: 75px;position: relative;left: 88px;">
                        	<font id="button-text"> 
                            	<font color="white"><?=$this->lang->line('Done');?></font>
                            </font>
                        </div>
                    </a>
                    <a href = "#" onclick = "share_on_fb(msg); alert_fb('Shared on Facebook: ' + '\n' +  msg); closeModal(<?=$cat_id?>);">
	                	<img src = "<?=base_url()?>h7-assets/resources/img/fb_share.png" id = "fb-share-button"/>
	                </a>
			</div>
			<div id="current_question" style="position: relative; top: -26px; display: <?=($is_played==-1)?'block':'none';?>;">
				<table id="Q-number">
					<tr>
						<td><font id="question_count"></font></td>
					</tr>
				</table>

				<div class="Ques">
<!--					<font id="question_content" align="center"></font> <br /> <br /> <input
						id="c1" type="radio" name="choice"> <label for="c1"><font id="a1">A1</font>
					</label> <br /> <input id="c2" type="radio" name="choice"> <label
						for="c2"><font id="a2">A2</font> </label> <br /> <input id="c3"
						type="radio" name="choice"> <label for="c3"><font id="a3">A3</font>
					</label> <br /> <input id="c4" type="radio" name="choice"> <label
						for="c4"><font id="a4">A4</font> </label>-->
                                    <font id="question_content" align="center"></font> <br /> <br />
                                        <label for="c1"><font id="a1">A1</font> </label> <input id="c1" type="radio" name="choice"> <br /> 
                                        <label for="c2"><font id="a2">A2</font> </label> <input id="c2" type="radio" name="choice"> <br /> 
                                        <label for="c3"><font id="a3">A3</font> </label> <input id="c3" type="radio" name="choice"> <br /> 
                                        <label for="c4"><font id="a4">A4</font> </label> <input id="c4" type="radio" name="choice"> <br />
				</div>

				<a href="javascript:void(0);" onclick="next_question();"
					style="text-decoration: none;" >
					<div class="play-button" style="margin-top: 105px;">
						<font id="button-text"><?=$this->lang->line('Score_It');?></font>
					</div>
				</a>
			</div>
		</div>
		<div id="confirm_exit" class="Ques" style="display: none;">
                    <font align="center" style="position: relative; right: 150px; font-size: xx-large;"><?=$this->lang->line('Are_you_sure_you_want_to_exit');?></font>
			<a href="javascript:void(0);" id="close_game" style="text-decoration: none;" onclick="done_fun()">
                            <div class="play-button">
                                    <font id="button-text"> <font
                                                    color="white"><?=$this->lang->line('Yes');?></font>
                                    </font>
                            </div>
                        </a>
                        <a href="javascript:void(0);" id="close_game" style="text-decoration: none;" onclick="cont_game()">
                            <div class="play-button">
                                    <font id="button-text"> <font color="white"><?=$this->lang->line('No');?></font>
                                    </font>
                            </div>
                        </a>
		</div>
            <div id="intro" style="display: <?=($is_played==-1)?'block':'none';?>;">
            <h2 id="How-to-play"><?=$this->lang->line('HOW_TO_PLAY');?></h2>
			<a href='javascript:void(0)' style="visibility: <?=(($currentElement)?'visible':'hidden')?>" id="previous-image-mcq" onclick='get_elem(<?=$cat_id;?>,<?=$card_id;?>,0);'><img alt="previous" height="45px" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_grey_left_icon.png"></a>
			<p id="game-intro">
				<?=$this->lang->line('game_intro_mcq');?>
			</p>
			<a href="javascript:void(0);" style="text-decoration: none;"
				onclick="init_questions('<?= $q ?>', '<?= $cc ?>', '<?= $a ?>', '<?=$is_played?>');">
				<div class="play-button">
					<font id="button-text"><?=$this->lang->line('Play');?></font>
				</div>
			</a>
                        <!--<a href='javascript:void(0);' style="visibility: <?=(($size > $currentElement+1)?'visible':'hidden')?>" id="next-image-game" onclick='get_elem(<?//=$cat_id;?>,<?//=$card_id;?>,1);'><img alt="next" height="45px" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_grey_right_icon.png"></a>--> 
		</div>
	</div>

	<div id="right-bar-view">
        <?php /* <a href="javascript:void(0);" onclick="toggleFullScreen('#display_game');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a> */ ?>
        <a href="javascript:void(0);" id="close-popup-button" onclick="confirm_exit();">
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
				style="margin-right: 5px;"><?=$this->lang->line('Pick_the_Correct_Choice');?>
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
	</div>
</div>
<script>
var questions;
var choices;
var answers;
var id;
var game_started = false;
var score;
var final_score = 0;
var time_interval;
var cur_game_type = "mcq";
var msg = "أنا حليت اسئلة مسلسل  " + '<?php echo $card_name;?>' + " في سوبر صايم و جبت سكور" + '<?php echo $best_score;?>'  + "\n" + "https://apps.facebook.com/hitsevenapp";

function update_game_score() {
	game_page = "<?=base_url()?>index.php?/game_center/update_score";
    var ajax_new_score = final_score;
    msg = "أنا حليت اسئلة مسلسل  " + '<?php echo $card_name;?>' + " في سوبر صايم و جبت سكور" + final_score  + "\n" + "https://apps.facebook.com/hitsevenapp";
	$.post(game_page, { game_score : ajax_new_score })
	.done(function( data ) {
            if(data == -1){window.location = '<?=base_url();?>'; return;}
            $("#score-<?=$cat_id?>").html(data);
	});
}

function done_fun() {
        clearIntervals();
  	document.getElementById('Q-score-table').style.display = 'none';
  	document.getElementById('confirm_exit').style.display = 'none';
  	document.getElementById('timer').style.display = 'none';
  	document.getElementById('final_score').style.display = 'block';
  	document.getElementById('current_question').style.display = 'none';
	document.getElementById('total-score').innerHTML = final_score + " <?=$this->lang->line('Points');?>";
	game_started = false;
        closeModal(<?=$cat_id?>);
}

function cont_game() {
  	document.getElementById('current_question').style.display = 'block';
//        document.getElementById('Q-score-table').style.display = 'block';
        document.getElementById("Q-score-table").style.visibility="visible";
  	document.getElementById('confirm_exit').style.display = 'none';
}

function count_timer(){
  	if (score > 10)
  		score -= 5;
  	if (score < 10)
  		score = 10;
  	document.getElementById('timer').innerHTML = score;
}

function init_questions (q, c, a, is_played) {
	game_started = true;
	questions = new Array();
	questions = q.split('~');
	answers = new Array();
	answers = a.split('~');
	var ch = new Array();
	ch = c.split('^');
	choices = new Array();
	for (var i = 0; i < ch.length ; i ++) {
		choices[i] = new Array();
		choices[i] = ch[i].split('~');
	}
	var ob1 = document.getElementById('intro');
	ob1.style.display = 'none';
	var ob2 = document.getElementById('mcq-content');
	ob2.style.display = 'block';
	id = 0;
	final_score = 0;
	score = 50;
	clearInterval(time_interval);
	time_interval = setInterval('count_timer()', 1000);
	var ob3 = document.getElementById('score-count');
	ob3.style.display = 'block';
	if (is_played != '-1') {
		game_started = false;
	  	document.getElementById('Q-score-table').style.display = 'none';
	  	document.getElementById('timer').style.display = 'none';
		var obj = document.getElementById('final_score');
		obj.style.display = 'block';
	  	document.getElementById('final_score').style.marginTop = 105 + 'px';
		var obj = document.getElementById('current_question');
		obj.style.display = 'none';
		document.getElementById('total-score').innerHTML = is_played + " <?=$this->lang->line('Points');?>";
	} else {
            
        }
	next_question();
}
function next_question() {
  	document.getElementById('timer').innerHTML = score;
	if (id != 0) {
		var ans = -1;
		for (var i = 1; i <= 4; i ++) {
			var cur = "c";
			var num = i.toString();
			cur += num;
			var ch = document.getElementById(cur).checked;
			if (ch)
				ans = i - 1;
		}
		id --;
		var cur_id = id.toString();
		id ++;
		if (ans == answers[id - 1]) {
			final_score += score;
			document.getElementById("question-" + cur_id).className = "green-circle";
			document.getElementById("question-score-" + cur_id).innerHTML = score;
		}
		else {
			document.getElementById("question-" + cur_id).className = "red-circle";
			document.getElementById("question-score-" + cur_id).innerHTML = "0";
		}
		document.getElementById("question-score-" + cur_id).style.color = "white";
                update_game_score();
	}
	var tmp = questions.length;
	var len = tmp.toString();
	var cur_id = (id + 1).toString();
        document.getElementById("question_count").innerHTML = ("<?=$this->lang->line('Question');?> " + cur_id + " <?=$this->lang->line('of');?> " + len);
	if (id == questions.length) {
	  	document.getElementById('timer').style.display = 'none';
		var obj = document.getElementById('current_question');
		obj.style.display = 'none';
		var obj = document.getElementById('final_score');
		obj.style.display = 'block';
		document.getElementById('total-score').innerHTML = final_score + " <?=$this->lang->line('Points');?>";
//		game_page = "<?=base_url()?>index.php?/game_center/update_score";
//		$.post(game_page, { game_score : final_score })
//		.done(function( data ) {
//	    	$("#score-<?=$cat_id?>").html(data);
//		});
		game_started = false;
	}
	document.getElementById('question_content').innerHTML = questions[id];
	for (var i = 0; i < 4; i ++) {
		document.getElementById("a" + (i + 1)).innerHTML = choices[id][i];
	}
	$("#c1").prop('checked',true);
	id ++;
	score = 50;
        document.getElementById('timer').innerHTML = score;
	clearInterval(time_interval);
	time_interval = setInterval('count_timer()', 1000);
}
function confirm_exit(){
    if(game_started){
        document.getElementById("Q-score-table").style.visibility="hidden";
        document.getElementById('confirm_exit').style.display = 'block';
        document.getElementById('current_question').style.display = 'none';
        document.getElementById('total-score').innerHTML = final_score + " <?=$this->lang->line('Points');?>";
    } else {
        clearInterval(time_interval);
        closeModal(<?=$cat_id?>);
    }
}
function clearIntervals(){
    clearInterval(time_interval);
}
</script>
