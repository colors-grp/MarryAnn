<?php
$this->lang->load('score',$_SESSION['language']);
$scoreboard = $_SESSION [ 'user_data' ];
$all_users = (isset($scoreboard ['all']))?$scoreboard ['all']:array();
$top_users = (isset($scoreboard ['top']))?$scoreboard ['top']:array();
                //log_message('error','mo7eb scoreboard_ajax $scoreboard[fb_ids]='.  print_r($scoreboard['fb_ids'],TRUE));
                
    /*            <table id="scoreboard_ranks_table" style = "text-align: left;">
                <tr>
                <td>
                			<?//=$_SESSION['current_category_name'];?>
                		    <a href="javascript:void(0);" onclick="scoreboard(<?=$_SESSION['current_category_id']?>, 0);return false;" style = "text-decoration: none; margin-left: 244px;margin-right: 10px">
                		        <img style = "height: 25px;" src = "<?=base_url()?>/h7-assets/resources/img/main-icons/friends_icon.png" alt = "friends">
                		    	<font style = "font-size: 14px"><?=$this->lang->line('FRIENDS');?>  </font>
                			</a>
                            <a href="javascript:void(0);" onclick="scoreboard(<?=$_SESSION['current_category_id']?>, 1);return false;" style = "text-decoration: none;">
                            	<img style = "height: 25px;" src = "<?=base_url()?>/h7-assets/resources/img/main-icons/all_icons.png" alt = "all">
                                <font style = "font-size: 14px"><?=$this->lang->line('ALL_PLAYERS');?></font>
                            </a>
                        </td>
                	</tr>
                    <tr style = "height: 20px;" ></tr>
                </table>
?>*/

?>
<!-- <div id="ranks_table_div"> -->
        <?php
    $removedRanks = 0;
    $min = count($all_users);
    if ($min > count($top_users)){
        $min = count($top_users);
    }
    //log_message('error','mo7eb scoreboard_ajax count($allusers)'.  count($all_users));
    //log_message('error','mo7eb scoreboard_ajax $topusers'. print_r($top_users,TRUE));
    for($i = 0; $i < $min && count($all_users) > 0; $i++) {
        //log_message('error','mo7eb scoreboard_ajax $allusers['.$i.'][rank]='.$all_users[$i]['rank']);
        if($all_users[$i]['rank'] > 3){$removedRanks++; continue;}
            if (($all_users[$i]['rank']-1) % 2 == 0) {
                //Check if 1st friend's rank is not 1 then donot display his image 
                //if(!$_SESSION['all']){ if($all_users[0]['rank'] != 1){$removedRanks++; continue;} }
            ?>
            <!-- GOLD TABLE -->
                    <table>
                            <tr style = "height: 20px;"></tr>
                            <tr>
                                    <td rowspan = "2" style = "width: 190px; text-align: center;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/<?=$top_users[($all_users[$i]['rank']-1)]['name'];?>_icon.png" alt="gold" style = "width:50px; margin-left: 26px;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/bigarrow_right_icon.png" alt="arrow" style = "width:60px; margin-left: -6px;">
                                    </td>
                                    <td rowspan = "2" class = "score-td" style = "width: 70px;">
                                            
                                            <img class = "score-profile-pic" src="https://graph.facebook.com/<?=($_SESSION['all'])?$scoreboard['fb_ids'][$i]:$all_users[$i]['fb_id'];?>/picture?width=50&height=50" alt="profile-pic" >
                                            
                                    </td>
                                    <td class = "score-name" style = "width: 299px;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/profile_icon.png" alt="profile-icon" >
                                            <?=$all_users[$i]['user_name'];?>
                                    </td>
                                    <td rowspan = "2" align = "center" class = "score-td" style = "width: 27px;">
                                            <img src="<?=base_url()?>h7-assets/images/scoreboard/change/<?=$all_users[$i]['change']?>.png" alt="<?=$all_users[$i]['change']?>">
                                    </td>
                                    <td rowspan = "2" style = "width: 13px;"></td>
                            </tr>
                            <tr>
                                    <td class = "score-td" style = "padding-left: 10px;"><img src="<?=base_url()?>/h7-assets/resources/img/main-icons/score_icon2.png" alt="score-icon" ><?=$all_users[$i]['score']?></td>
                            </tr>
                            <tr style = "height: 20px;"></tr>
                    </table>
            <!-- end of gbold table -->
    <?php } else {
                //Check if 2nd friend's rank is not 2 then donot display his image 
                //if(!$_SESSION['all']){ if($all_users[1]['rank'] != 2){$removedRanks++; continue;} }
        ?>
                    <table>
                            <tr style = "height: 20px;"></tr>
                            <tr>
                                    <td rowspan = "2" style = "width: 35px;"></td>

                                    <td rowspan = "2" class = "score-td" style = "width: 70px;">
                                            <img class = "score-profile-pic" src="https://graph.facebook.com/<?=($_SESSION['all'])?$scoreboard['fb_ids'][$i]:$all_users[$i]['fb_id'];?>/picture?width=50&height=50" alt="profile-pic" >
                                    </td>
                                    <td class = "score-name" style = "width: 299px;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/profile_icon.png" alt="profile-icon" >
                                            <?=$all_users[$i]['user_name'];?>
                                    </td>
                                    <td rowspan = "2" align = "center" class = "score-td" style = "width: 27px;">
                                            <img src="<?=base_url()?>h7-assets/images/scoreboard/change/<?=$all_users[$i]['change'];?>.png" alt="<?=$all_users[$i]['change'];?>">
                                    </td>
                                    <td rowspan = "2" style = "width: 190px; text-align: center;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/bigarrow_left_icon.png" alt="arrow" style = "width:60px; margin-right: -6px;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/<?=$top_users[($all_users[$i]['rank']-1)]['name'];?>_icon.png" alt="silver" style = "width:50px; margin-right: 26px;">
                                    </td>
                            </tr>
                            <tr>
                                    <td class = "score-td" style = "padding-left: 10px;"><img src="<?=base_url();?>/h7-assets/resources/img/main-icons/score_icon2.png" alt="score-icon" ><?=$all_users[$i]['score'];?></td>
                            </tr>
                            <tr style = "height: 20px;"></tr>
                    </table>
    <?php }
    } ?>
    <!-- RANK TABLE -->
    <table id = "ranks_buttons_table">
		<tr style = "border-bottom: 2px solid rgba(255,255,255,0.22);">
        	<td style = "width: 50%; border-right: 2px solid rgba(255,255,255,0.22);">
               <?//=$_SESSION['current_category_name'];?>
               <a href="javascript:void(0);" onclick="scoreboard(<?=$_SESSION['current_category_id']?>, 0);return false;" id = "my_friends" style = "text-decoration: none;">
               		<img
               		<?php
               			if($_SESSION['all'] == 0){
							if($_SESSION['current_category_id'] == 3){
					?>
								src = "<?=base_url()?>/h7-assets/resources/img/cat/friends_selected_1.png"
					<?php
							}else{
					?>
								src = "<?=base_url()?>/h7-assets/resources/img/cat/friends_selected.png"
					<?php 	} 
						}else{ 
               		?> 
               				src = "<?=base_url()?>/h7-assets/resources/img/cat/friends.png" 
               		<?php
						} 
               		?>
               		id = "my_friends_img"/>
               </a>
            </td>
            <td style = "width: 50%; border-left: 2px solid rgba(1,1,1,0.25);">
               <a href="javascript:void(0);" onclick="scoreboard(<?=$_SESSION['current_category_id']?>, 1);return false;" id = "all_p" style = "text-decoration: none;">
               		 <img
               		 <?php
               			if($_SESSION['all'] == 1){
							if($_SESSION['current_category_id'] == 3){
					?>
								src = "<?=base_url()?>/h7-assets/resources/img/cat/all_selected_1.png"
					<?php
							}else{
					?>
								src = "<?=base_url()?>/h7-assets/resources/img/cat/all_selected.png"
					<?php 	} 
						}else{ 
               		?> 
               				src = "<?=base_url()?>/h7-assets/resources/img/cat/all.png" 
               		<?php
						} 
               		?>
               		 id = "all_p_img"/>
               </a>
            </td>
		</tr>
    </table>
    <table id = "rank-table">
    	<thead>
            <tr id = "rank-head">
                    <td><?=$this->lang->line('Rank');?></td>
                    <td class = "name_cell"><?=$this->lang->line('Player');?></td>
                    <td id = "score_head"><?=$this->lang->line('Score');?></td>
                <!--     <td class = "change-cell"><?//=$this->lang->line('Change');?></td> -->
            </tr>
        </thead>
        <tbody id = "rank-table-body">
            <?php
            //log_message('error','mo7eb scoreboard_ajax $all='.(($_SESSION['all'])?'TRUE':'FALSE'));
            log_message('error','mo7eb scoreboard_ajax $min='.$min);
            log_message('error','mo7eb scoreboard_ajax $removedRanks='.  $removedRanks);
            log_message('error','mo7eb scoreboard_ajax $all='.  print_r($all_users,TRUE));
            log_message('error','mo7eb scoreboard_ajax $all='.  print_r($top_users,TRUE));
//            if ($min < (count($all_users) + $removedRanks)) {
//            for($i = (count( $top_users ) - $removedRanks); $i < count ( $all_users); $i ++) {
            for($i = 0; $i < count ( $all_users); $i ++) {
                            $class = 'odd-row';
                            if ($i % 2 == 0) {
                                    $class = 'even-row';
                            } ?>
                            <tr class = "<?=$class?>">
                                    <td class = "rank_cell"><?=$all_users[$i]['rank']?></td>
                                    <td class = "name_cell"><?=$all_users[$i]['user_name']?></td>
                                    <td class = "score_cell"><?=$all_users[$i]['score']?></td>
                                    <!-- <td class = "change-cell"><img src="<?//=base_url()?>h7-assets/images/scoreboard/change/<?//=$all_users[$i]['change']?>.png" alt="<?//=$all_users[$i]['change']?>"></td> -->
                            </tr>
            <?php } //}
//            else {
//                    echo 'No Users<br />';} 
                    ?>
        </tbody>
    </table>
<!-- </div> -->
    <!-- end of rank table -->
    <script>
        var more_rows_called = false;
    document.getElementById("rank-table-body").addEventListener('scroll', function (event) {
    if (this.scrollHeight <= (this.scrollTop + this.clientHeight + 10)) {
        if(!more_rows_called){
            more_rows_called = true;
            ajaxpage = "<?=base_url();?>index.php?/scoreboard/get_more_ranks";
            $.post(ajaxpage)
            .done(function(data){
                if(data == '-1'){
                    window.location = "<?= base_url()?>";
                    return;
                }
                $('#rank-table-body').append(data);
                more_rows_called = false;
            });
        }
    }
    //alert(('scroll =' + $(document).scrollHeight()) + ('\ndocument hieght=' + $(document).height()));
    }
    , false);
    </script>