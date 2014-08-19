<?php
$q = implode("~",$ques);
$c = array(array());
for ($i = 0; $i < count($choice) ; $i ++) {
	$c[$i] = implode("~",$choice[$i]);
}
$cc = implode("^", $c);
$a = implode("~",$ans);
$this->lang->load('game',$_SESSION['language']);
?>
<div id = "mcq_answers" class="popup-container">
	<div id="game-content-view">
		<div id="mcq-content">
                    <div id="final_score" style="display: none;">
                            <h3 align="center" id="final-score-title"><?=$this->lang->line('Final_Score');?></h3>
                            <h1 align="center" id="total-score"><?=$best_score?></h1>
                            <a href="javascript:void(0);" onclick="closeModal(<?=$cat_id?>);" id="close_game" class="simplemodal-close" style="text-decoration: none;">
                                <div class="play-button" style="margin-top: 75px;position: relative;left: 88px;">
                                    <font id="button-text"> 
                                        <font color="white"><?=$this->lang->line('Keep_going');?></font>
                                    </font>
                                </div>
                            </a>
                            <a href = "#" onclick = "share_on_fb(msg); alert_fb('Shared on Facebook: ' + '\n' +  msg); closeModal(<?=$cat_id?>);">
			                	<img src = "<?=base_url()?>h7-assets/resources/img/fb_share.png" id = "fb-share-button"/>
			                </a>
                    </div>
                    <div id="current_question" style="position: relative; top: -26px; display: none;">
                            <table id="Q-number">
                                    <tr>
                                            <td><font id="question_count"></font></td>
                                    </tr>
                            </table>

                            <div class="Ques">
                                <font id="question_content" align="center"></font><br /> <br />
                                <font id="a1">A1</font> <br /> 
                                <font id="a2">A2</font> <br /> 
                                <font id="a3">A3</font> <br /> 
                                <font id="a4">A4</font> <br />
                            </div>

                            <a href="javascript:void(0);" onclick="next_question();"
                                    style="text-decoration: none;" >
                                    <div class="play-button" style="margin-top: 105px;">
                                            <font id="button-text"><?=$this->lang->line('Keep_going');?></font>
                                    </div>
                            </a>
                    </div>
		</div>
                <div id="intro">
                    <a href='javascript:void(0)' style="visibility: <?=(($currentElement)?'visible':'hidden')?>" id="previous-image-mcq" onclick='get_elem(<?=$cat_id;?>,<?=$card_id;?>,0);'><img alt="previous" height="45px" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_grey_left_icon.png"></a>
                    <h3 align="center" id="final-score-title">
                            <?=$this->lang->line('game_intro_mcq_answers');?>
                    </h3>
                    <a href="javascript:void(0);" style="text-decoration: none;"
                            onclick="init_questions('<?= $q ?>', '<?= $cc ?>', '<?= $a ?>', '<?=$is_played?>');">
                            <div class="play-button" style = "margin-top: 82px;">
                                    <font id="button-text"><?=$this->lang->line('show_answers');?></font>
                            </div>
                    </a>
                </div>
	</div>
	<div id="right-bar-view">
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
                    <img src="<?=base_url()?>h7-assets/resources/img/main-icons/game_sort.png" style="margin-right: 5px;">
                    <?=$this->lang->line('Pick_the_Correct_Choice');?>
            </h5>
	</div>
</div>
<script>
var questions;
var choices;
var answers;
var id;
var msg = "أنا حليت اسئلة مسلسل  " +'<?php echo $card_name;?>' + " في سوبر صايم و جبت سكور" + <?php echo $best_score;?> + "\n" + "https://apps.facebook.com/hitsevenapp";

function init_questions(q, c, a, is_played) {
        var obj = document.getElementById('current_question');
        obj.style.display = 'block';
        var obj = document.getElementById('final_score');
        obj.style.display = 'none';
        var obj = document.getElementById('intro');
        obj.style.display = 'none';
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
	id = 0;
	next_question();
}
function next_question() {
	var tmp = questions.length;
	var len = tmp.toString();
	var cur_id = (id + 1).toString();
        document.getElementById("question_count").innerHTML = ("<?=$this->lang->line('Question');?> " + cur_id + " <?=$this->lang->line('of');?> " + len);
	if (id == questions.length) {
            var obj = document.getElementById('current_question');
            obj.style.display = 'none';
            var obj = document.getElementById('final_score');
            obj.style.display = 'block';
	} else {
            document.getElementById('question_content').innerHTML = questions[id];
            
            for (var i = 0; i < 4; i ++) {
                if(i == answers[id]){
                    document.getElementById("a" + (i + 1)).style.color = 'green';
                    document.getElementById("a" + (i + 1)).style.fontWeight = "bold";
                    document.getElementById("a" + (i + 1)).style.fontSize = "x-large";
                } else {
                    document.getElementById("a" + (i + 1)).style.color = 'grey';
                    document.getElementById("a" + (i + 1)).style.fontWeight = "normal";
                    document.getElementById("a" + (i + 1)).style.fontSize = "medium";
                }
                    document.getElementById("a" + (i + 1)).innerHTML = choices[id][i];
            }
        }
	id++;
}
</script>
