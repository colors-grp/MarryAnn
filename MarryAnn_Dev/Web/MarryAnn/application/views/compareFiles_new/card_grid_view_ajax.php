<?php
$this->lang->load('market',$_SESSION['language']);
$h = 100; $w = 100;
?>
<!-- Cards -->

<div id="list_view">
	<table id="cards" style="text-align: left;">
		<?php
		$i = 0;
		$first_blocked_card = false;
                if(count($blocked_cards) > 0){
                    $i++;
                    $card_time = $blocked_cards[0]['start_date'];
                    ?>
                    <tr align="center">
                        <td> 
                            <div class="card-holder">
                                    <img
                                        width="<?=$w?>" height="<?=$h?>"
                                        src="<?=base_url()?>/h7-assets/resources/img/cat/locked_card.png"
                                        class="card-pic" alt="card" title="الكارت لسة مفتحش" >
                                    <div id = "card-counter">
                                            <div id = "fadel_text" style = "display: block;">
                                            <?php if ($cat_id == 1){?>
                                                    <font>فاضل عاللعبة</font>
                                            <?php } elseif ($cat_id == 2){?>
                                                    <font>فاضل عالمسلسل</font>
                                            <?php }elseif ($cat_id == 3){?>
                                                    <font>فاضل عالحلقة</font>
                                            <?php }elseif ($cat_id == 4){?>
                                                    <font>فاضل عالحلقة</font>
                                            <?php }?>
                                            </div>
                                            <table id="table" border="0">
                                                <tr>
                                                    <td align="center" colspan="6"><div class="numbers" id="count2" style="padding: 5px 0 0 0; "></div></td>
                                                </tr>
                                                <tr id="spacer1">
                                                    <td align="center" ><div class="numbers" ></div></td>
                                                    <td align="center" ><div class="numbers" id="dsec"></div></td>
                                                    <td align="center" ><div class="numbers" id = "clock_sep_1">:</div></td>
                                                    <td align="center" ><div class="numbers" id="dmin"></div></td>
                                                    <td align="center" ><div class="numbers" id = "clock_sep_2">:</div></td>
                                                    <td align="center" ><div class="numbers" id="dhour"></div></td>
                                                    <td align="center" ><div class="numbers" ></div></td>
                                                </tr>
                                            </table>
                                    </div>
                            </div>
                        </td>
                    <?php
                }
                $score = array_reverse($score);
		foreach (array_reverse($cards) as $card) {
			if ($i % 2 == 0) {
    		if ($i != 0) { ?>
		</tr>
		<?php } ?>
		<tr align="center">
			<?php }
				$i ++;
	            $rest = 0;
			?>
			<td>
				<div class="card-holder">
                                    <a href="javascript:void(0);" title = "<?= $card['name'] ?>" style="text-decoration: none;" onclick="display_mixed_popup(<?=$cat_id;?>,<?=$card['id'];?>)">
                                        <img width="<?=$w?>" height="<?=$h?>"
                                        src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card['id']?>/ui/grid_view.png"
                                        class="card-pic" alt="<?= $card['name'] ?>" >
                                        <div class = "card-pic-name"><h4><?= $card['name']?></h4></div>
                                    </a>
                                    <?php if ($score[$i-2] == -1){?>
                                        <img src = "<?=base_url()?>/h7-assets/resources/img/new_mark.png" class = "new-mark" style = "position: relative; top: -194px; left: -36px;">
                                    <?php }else{?>
                                        <img src = "<?=base_url()?>/h7-assets/resources/img/new_mark.png" class = "new-mark" style = "display: none; position: relative; top: -194px; left: -36px;">
                                    <?php }?>
				</div>
			</td>
			<?php } ?>
		<tr style="height: 30px;"></tr>
	</table>
</div>

<?php
	date_default_timezone_set('Africa/Cairo');
	$now_date = new DateTime(date('Y/m/d H:i:s'));
	
	$userTimezone = new DateTimeZone('Africa/Cairo');
	$gmtTimezone = new DateTimeZone('GMT');
	$myDateTime = new DateTime($now_date->format('Y-m-d H:i:s'), $gmtTimezone);
	$offset = $userTimezone->getOffset($myDateTime)/3600;
?>

<script type="text/javascript">
<?php if ($cat_id == 1){?>
	var current="اللعبة إتفتحت";
<?php } elseif ($cat_id == 2){?>
	var current ="المسلسل اتفتح";
<?php }elseif ($cat_id == 3){?>
	var current = "الحلقة إتفتحت";
<?php }elseif ($cat_id == 4){?>
	var current = "الحلقة إتفتحت";
<?php }?>


var year =  <?=substr($card_time, 0,strpos($card_time, '-'));?>;
var month =  <?=substr($card_time, 5,2);?>;      
var day =  <?=substr($card_time, 8,2);?>;       
var hour =  <?=substr($card_time, 11,2);?>;      
var minute =  <?=substr($card_time, 14,2);?>;   

var tz=+<?php echo $offset; ?>;

var dateString = "<?php echo $now_date->format('Y-m-d H:i:s');?>"; 
dateString = dateString.replace(/-/g, '/');
var today = new Date(dateString);   

//    DO NOT CHANGE THE CODE BELOW!
var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

function countdown(yr,m,d,hr,min,today){
    theyear=yr;themonth=m;theday=d;thehour=hr;theminute=min;
  
	var todayy=today.getYear();
    if (todayy < 1000) {todayy+=1900;}
    
	var todaym=today.getMonth();
    var todayd=today.getDate();
    var todayh=today.getHours();
    var todaymin=today.getMinutes();
    var todaysec=today.getSeconds();
    
	var todaystring1=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec;
    var todaystring=Date.parse(todaystring1)+(tz*1000*60*60);

	var futurestring1=(montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min);
    var futurestring=Date.parse(futurestring1)+(2*1000*60*60);

    var dd=futurestring-todaystring;
    
	var dday=Math.floor(dd/(60*60*1000*24)*1);
	var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1);
	var dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
    var dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
	if(dday<=0 && dhour<=0 && dmin<=0 && dsec<=0){

        document.getElementById('fadel_text').style.display="none";
        document.getElementById('clock_sep_1').style.display="none";
        document.getElementById('clock_sep_2').style.display="none";
        document.getElementById('count2').innerHTML=current;
        document.getElementById('count2').style.display="inline";
        document.getElementById('count2').style.width="390px";
       	document.getElementById('dhour').style.display="none";
        document.getElementById('dmin').style.display="none";
        document.getElementById('dsec').style.display="none";
        return;
    }
    else {
        document.getElementById('count2').style.display="none";
        document.getElementById('dhour').innerHTML=dhour;
        document.getElementById('dmin').innerHTML=dmin;
        document.getElementById('dsec').innerHTML=dsec;
		today.setSeconds(today.getSeconds()+1);
        setTimeout("countdown(theyear,themonth,theday,thehour,theminute,today)",1000);
    }
}
</script>