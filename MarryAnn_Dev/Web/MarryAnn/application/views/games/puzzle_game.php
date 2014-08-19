<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
$this->lang->load('game',$_SESSION['language']);
?>
<html>
<head>
<title>Image puzzle</title>

<style type="text/css">
a:hover {
	text-decoration: underline;
}

#puzzle_container {
	line-height: 500px;
	text-align: center;
	vertical-align: middle;
	border: 10px outset #CCCCCC;
	position: relative;
	color: #FFFFFF;
	background-color: #707070;
	width /* */: /**/ 500px; /* Other browsers */
	width: /**/ 500px;
	height /* */: /**/ 500px; /* Other browsers */
	height: /**/ 500px;
	display: block;
	width: 319px;
	height: 320px;
        top: 60px;
}

#puzzle_container .square {
	overflow: hidden;
	border-left: 1px solid #FFF;
	border-top: 1px solid #FFF;
	position: absolute;
}

.activeImageIndicator {
	border: 1px solid #FF0000;
	position: absolute;
	z-index: 10000;
}

.revealedImage {
	position: absolute;
	left: 0px;
	opacity: 0;
	filter: alpha(opacity =                         50);
	top: -103px;
	z-index: 50000;
}
</style>


<script type="text/javascript">
	/*
	(C) www.dhtmlgoodies.com, September 2005
	
	You are free to use this script as long as the copyright message is kept intact
	
	
	Alf Magne Kalleland
	
	*/
	cur_game_type = "puzzle";
		
	var puzzleImages = ['<?=base_url()?>/h7-assets/images/games/<?=$data->image_name?>'];	// Array of images to choose from
	var rows = <?=$data->image_length?>;
	var cols = <?=$data->image_width?>;
		
	var imageArray = new Array();
	var imageInUse = false;
	var puzzleContainer;
	var activeImageIndicator = false;
	var activeSquare = false; 	// Reference to active puzzle square
	var squareArray = new Array(); // Array with references to all the squares

	
	var emptySquare_x;
	var emptySquare_y;
	
	var colWidth;
	var rowHeight;
	
	var gameInProgress = false;
	
	var revealedImage = false;

	var counter = 0;
	var myInterval;
	
	var timer = 0;
	var score = 200;
        var old_score = <?=$best_score;?>;
        var new_score = 0;
	var time_interval;
	var score_interval;
	var puzzle_game_started = true;

	function count_timer(){
		if (puzzle_game_started)
			return;
	  timer++;
	}
	function calc_score(){
		if (puzzle_game_started)
			return;
	  if (timer % 3 == 0 && score > 5) {
		  if (score > 100)
		  	score -= 5;
		  score -= 5;
	  }
	  document.getElementById('timer').innerHTML = score;
	}
	// 1,000 means 1 second.
	// time_interval = setInterval('count_timer()', 1000);
	// score_interval = setInterval('calc_score()', 1000);
	
	for(var no=0;no<puzzleImages.length;no++){
		imageArray[no] = new Image();
		imageArray[no].src = puzzleImages[no];	
	}
	
	function initPuzzle()
	{
		gameInProgress = false;
                var squareArray = new Array();
		var tmpInUse = imageInUse;
		imageInUse = imageArray[Math.floor(Math.random() * puzzleImages.length)];
		if(puzzleImages.length<=1) {
			puzzle_game_started = false;
			clearInterval(myInterval);
			clearInterval(time_interval);
			clearInterval(score_interval);
			time_interval = setInterval('count_timer()', 1000);
			score_interval = setInterval('calc_score()', 1000);
			myInterval = setInterval(function () {
			  ++counter;
			}, 1000);
			 document.getElementById('timer').innerHTML = score;
			var ob3 = document.getElementById('score-count');
			ob3.style.display = 'block';
			puzzleContainer = document.getElementById('puzzle_container');
			document.getElementById('puzzle_container').style.display = "block";
			document.getElementById('intro').style.display = "none";
			getImageWidth();
			scramble();
		}
	}
	
	function getImageWidth()
	{
		if(imageInUse.width>0){
			startPuzzle();	
		}else{
			setTimeout('getImageWidth()',100);	
		}
	}
	
	function scramble()
	{
		gameInProgress = true;
		var currentRow = cols-1;
		var currentCol = rows-1;
		
		document.getElementById('revealedImage').style.display='none';
		
		for(var no=0;no<rows;no++){
			for(var no2=0;no2<cols;no2++){
				if(no<rows.length || no2<cols.length){
					var el = document.getElementById('square_' + no2 + '_' + no);
					if(el){
						el.style.left = (no2 * colWidth) + (no2) + 'px';
						el.style.top = (no * rowHeight) + (no) + 'px';	
					}else{
						initPuzzle();
						return;
					}
				}			
			}
		}		
		
		
		var lastPos=false;
		var countMoves = 0;
		while(countMoves<(50*cols*rows)){
			var dir = Math.floor(Math.random()*4);
			var readyToMove = false;
			if(dir==0 && currentRow>0 && lastPos!=1){	// Moving peice down
				currentRow = currentRow-1;	
				readyToMove = true;
			}				
			if(dir==1 && currentRow<(rows-1) && lastPos!=0){	// Moving peice up
				currentRow = currentRow+1;
				readyToMove = true;
			}	
			if(dir==2 && currentCol>0 && lastPos!=3){ 	// Moving peice right
				currentCol = currentCol -1;
				readyToMove = true;
			}	
			if(dir==3 && currentCol<(cols-1) && lastPos!=2){ 	// Moving peice right
				currentCol = currentCol + 1;
				readyToMove = true;
			}
			if(readyToMove){
				activeSquare = document.getElementById('square_' + currentCol + '_' + currentRow);
				moveImage(false,true);	
				lastPos = dir;
				countMoves++;
			}
		}
		
		return;
	}

	
	
	function gameFinished()
	{
		var string = "";

		var squareWidth = colWidth + 1;
		var squareHeight = rowHeight + 1;		
		var squareCounter = 0;
		var errorsFound = false;
		var correctSquares = 0;
		for(var prop in squareArray){
			var currentCol = squareCounter % cols; 
			var currentRow = Math.floor(squareCounter/cols);
			var correctLeft = currentCol * squareWidth;
			var correctTop = currentRow * squareHeight;
			if(squareArray[prop].style.left.replace('px','') != correctLeft || squareArray[prop].style.top.replace('px','') != correctTop){
				//return;			
			}else{
				correctSquares++;
			}
				
			squareCounter++;	
		}	
		
		if(correctSquares == ((cols * rows) -1)){
			// Update Score
			game_score = score;
			// to stop the counter
			clearInterval(myInterval);
			clearInterval(time_interval);
			clearInterval(score_interval);
		  	document.getElementById('score-count').style.display = 'none';
			var obj = document.getElementById('puzzle_container');
			obj.style.display = 'none';
			var obj = document.getElementById('puzzle_final_score');
			obj.style.display = 'block';
			document.getElementById('total-score').innerHTML = score + " <?=$this->lang->line('Points');?>";
			game_page = "<?=base_url()?>index.php?/game_center/update_score";
                        //$.ajaxSetup({async: false}); //So as to avoid any other ajax calls made sybchrounously
                        var ajax_new_score = game_score, ajax_old_score = old_score;
			$.post(game_page, { game_score : ajax_new_score })
                        .done(function( data ) {
                            if(data == -1){window.location = '<?=base_url();?>'; return;}
                            if(ajax_new_score > ajax_old_score){
                                old_score = ajax_new_score;
                                var message = '<?=($this->lang->line('congrats').'...'.$this->lang->line('you_scored'));?> '+ajax_new_score+' <?=($this->lang->line('up_score').', '.$this->lang->line('will_be_displayed_after_time'));?>';
                                alert_success(message);
                            } else {
                                var message = '<?=$this->lang->line('try_again_info_message');?>';
                                alert_info(message);
                            }
                            $("#score-<?=$cat_id?>").html(data);
			});
                        //$.ajaxSetup({async: true}); //So as to avoid any other ajax calls made sybchrounously
//                        alert(game_score+'\n'+old_score);
			gameInProgress = false;
			revealImage();
			timer = 0;
			score = 200;
			puzzle_game_started = true;
		}else{
			// document.getElementById('messageDiv').innerHTML = 'Currently, you have ' + correctSquares + ' out of ' + ((cols * rows) -1) + ' pieces placed correctly';
		}
		
	}
	
	var currentOpacity = 0;
	function revealImage()
	{
		if(currentOpacity==100)currentOpacity=0;
		var obj = document.getElementById('revealedImage');
		obj.style.display = 'block';
		currentOpacity = currentOpacity +2;
		if(document.all){
			obj.style.filter = 'alpha(opacity='+currentOpacity+')';
		}else{
			obj.style.opacity = currentOpacity/100;
		}
		
		if(currentOpacity<100)setTimeout('revealImage()',10);
		
	}
	function displayActiveImage()
	{
		if(!gameInProgress)return;
		if(!activeImageIndicator){
			activeImageIndicator = document.createElement('DIV');
			activeImageIndicator.className = 'activeImageIndicator';
			puzzleContainer.appendChild(activeImageIndicator);
			activeImageIndicator.onclick = moveImage;
			
		}
		activeImageIndicator.style.display='block';
		activeImageIndicator.style.left = this.offsetLeft +  'px';
		activeImageIndicator.style.top = this.offsetTop + 'px';
		activeImageIndicator.style.width = this.style.width;
		activeImageIndicator.style.height = this.style.height;
		activeImageIndicator.innerHTML = '<span></span>';
		activeSquare = this;
	}
	
	function moveImage(e,fromShuffleFunction)
	{
		if(!activeSquare)return;
		if(!gameInProgress && !fromShuffleFunction){
			alert('You have to shuffle the cards first');
			return;
		}
		var currentLeft = activeSquare.style.left.replace('px','') /1;
		var currentTop = activeSquare.style.top.replace('px','') /1;
		
		var diffLeft = Math.round((currentLeft - emptySquare_x) / colWidth);
		var diffTop = Math.round((currentTop - emptySquare_y) / rowHeight);	
		
		if(((diffLeft==-1 || diffLeft==1) && diffTop==0) || ((diffTop==-1 || diffTop==1) && diffLeft==0)){	// Moving right
			activeSquare.style.left = emptySquare_x + 'px';
			activeSquare.style.top = emptySquare_y + 'px';
			emptySquare_x = currentLeft;
			emptySquare_y = currentTop;	
			activeSquare = false;	
			if(activeImageIndicator)activeImageIndicator.style.display = 'none';
			if(!fromShuffleFunction)gameFinished();	
		}
	}
	
	function startPuzzle()
	{
		puzzleContainer.innerHTML = '';


		var subDivs = puzzleContainer.getElementsByTagName('DIV');
		for(var no=0;no<subDivs.length;no++){
			subDivs[no].parentNode.removeChild(subDivs[no]);
		}
		activeImageIndicator = false;
		squareArray.length = 0; 

		
		if(document.getElementById('revealedImage')){
			var obj = document.getElementById('revealedImage');
			obj.parentNode.removeChild(obj);
		}
		var revealedImage = document.createElement('DIV');
		revealedImage.style.display='none';
		revealedImage.id='revealedImage';;
		revealedImage.className='revealedImage';;
		var img = document.createElement('IMG');
		img.src = imageInUse.src;
		revealedImage.appendChild(img);
		puzzleContainer.appendChild(revealedImage);
		
                var containerWidth = 520;
                var containerHeight = 320;
                
                puzzleContainer.style.width = containerWidth + 'px';
                puzzleContainer.style.height = containerHeight + 'px';
                
		colWidth = Math.round((containerWidth - 20) / cols);
		rowHeight = Math.round((containerHeight - 20) / rows);
                

		//puzzleContainer.style.width = colWidth * cols + (cols * 1) + 20 + 'px';
		//puzzleContainer.style.height = rowHeight * rows + (rows * 1) + 20 + 'px';
		
		if(navigator.appVersion.indexOf('5.')>=0 && navigator.userAgent.indexOf('MSIE')>=0){
			//puzzleContainer.style.width = colWidth * cols + (cols * 1) + 20 + 'px';
			//puzzleContainer.style.height = rowHeight * rows + (rows * 1) + 20 + 'px';	
                        puzzleContainer.style.width = containerWidth + 'px';
                        puzzleContainer.style.height = containerHeight + 'px';
		}
                
                //alert('colWidth='+colWidth+'\nrowHeight='+rowHeight+'\npuzzleContainer.style.width='+puzzleContainer.style.width+'\npuzzleContainer.style.height='+puzzleContainer.style.height);
				
		if(!revealedImage){
			revealedImage = document.createElement('DIV');
			revealedImage.style.display='none';	
			revealedImage.innerHTML = '';
			
		}
		for(var no=0;no<rows;no++){
			for(var no2=0;no2<cols;no2++){
				if(no2==cols-1 && no==rows-1){
					emptySquare_x = (no2 * colWidth) + (no2);	
					emptySquare_y = (no * rowHeight) + (no);	
					break;
				}
				var newDiv = document.createElement('DIV');
				newDiv.id = 'square_' + no2 + '_' + no;
				newDiv.onmouseover = displayActiveImage;
				newDiv.onclick = moveImage;
				newDiv.className = 'square';
				newDiv.style.width = colWidth + 'px';
				newDiv.style.height = rowHeight + 'px';	
				newDiv.style.left = (no2 * colWidth) + (no2) + 'px';
				newDiv.style.top = (no * rowHeight) + (no) + 'px';
				newDiv.setAttribute('initPosition',(no2 * colWidth) + (no2) + '_' + (no * rowHeight) + (no));
				var img = new Image();
				img.src = imageInUse.src;
				img.style.position = 'absolute';
				img.style.left = 0 - (no2 * colWidth) + 'px';
				img.style.top = 0 - (no * rowHeight) + 'px';
				newDiv.appendChild(img);				
				puzzleContainer.appendChild(newDiv);
				squareArray.push(newDiv);
			}
		}	
		
		
	}
        function clearIntervals(){
            clearInterval(myInterval);
            clearInterval(time_interval);
            clearInterval(score_interval);
        }
	window.onload = initPuzzle;
	</script>
</head>
<div id = "puzzle_game" class="popup-container">
	<div id="game-content-view">
           <!--  <a href='javascript:void(0)' style="visibility: <?=(($currentElement)?'visible':'hidden')?>" id="previous-image-game" onclick='get_elem(<?=$cat_id;?>,<?=$card_id;?>,0);'><img alt="previous" height="45px" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_grey_left_icon.png"></a> -->
		<div id="puzzle_container" style="display: none;"></div>
		<div id="puzzle_final_score" style="display: none;">
			<h3 align="center" id="final-score-title"><?=$this->lang->line('Final_Score');?></h3>
			<h1 align="center" id="total-score"></h1>
                        <a href="javascript:void(0);" id="close_game" class="simplemodal-close" style="text-decoration: none;" onclick="closeModal(<?=$cat_id?>);">
                            <div class="play-button" style="position: relative; top: 100px;">
                                    <font id="button-text"> <font color="white"><?=$this->lang->line('Done');?></font>
                                    </font>
                            </div>
                        </a>
		</div>
		<div id="intro">
			<h2 id="How-to-play"><?=$this->lang->line('HOW_TO_PLAY');?></h2>
			<p id="game-intro">
				<?=$this->lang->line('game_intro_puzzle');?>
			</p>
			<a href="javascript:void(0);" style="text-decoration: none;"
				onclick="initPuzzle();">
				<div class="play-button">
					<font id="button-text"><?=$this->lang->line('Play');?></font>
				</div>
			</a>
		</div>
          <!--       <a href='javascript:void(0);' style="visibility: <?=(($size > $currentElement+1)?'visible':'hidden')?>" id="next-image-game" onclick='get_elem(<?=$cat_id;?>,<?=$card_id;?>,1);'><img alt="next" height="45px" src="<?=base_url()?>h7-assets/resources/img/main-icons/light_grey_right_icon.png"></a>-->
	</div>
	<div id="right-bar-view">
            <?php /*<a href="javascript:void(0);" onclick="toggleFullScreen('#play_story');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a> */ ?>
            <a  id="close-popup-button" href="javascript:void(0);" onclick="clearIntervals(); closeModal(<?=$cat_id?>);"><img src="<?=base_url()?>h7-assets/resources/img/main-icons/close_window.png" style = "width: 20px;"></a>
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
                                <td colspan="2" style="border-bottom: 4px solid red; width: 208px;"></td>
                        </tr>
                </table>
		<h5>
			<img
				src="<?=base_url()?>h7-assets/resources/img/main-icons/game_sort.png"
				style="margin-right: 5px;"><?=$this->lang->line('Puzzle');?>
		</h5>
		<div id="score-count" style="display: none;">
			<h5 style="margin-top: 20px;">
				<?=$this->lang->line('SCORE');?>
			</h5>
			<h1 id="timer" align="center"
				style="color: red; margin-top: -6px;"></h1>
		</div>
	</div>
</div>
</html>
