<div id = "top-users-div">
<table id = "top-users-table">
<?php
for($i = 0; $i < count($top_three); $i++) {
    //log_message('error','mo7eb scoreboard_top_players_ajax $i='.$i.' $top_three[$i]='.  print_r($top_three[$i],TRUE));
        //if($all_users[$i]['rank'] > 3){$removedRanks++; continue;}?>
            <tr>
            <?php $id = "top-users-row-".$i;?>
            	<td id = "<?=$id?>">
            		<div style = "float: left">
	                  	<img src="http://graph.facebook.com/<?=$fb_ids[$i];?>/picture?width=100&height=100" alt="profile-pic" class = "top-pic">
	                    <?php $src = base_url() ."h7-assets/resources/img/fanos_winner.png"; ?>
	                    <img src="<?=$src?>" class = "top-fanos" />
                    </div>
                    <div class = "top_name_score">
                    	<?php
                            $name = $top_three[$i]['user_name'];
                            $max_length = 10;
                            $min_length = 3;
                            if(strpos($name, ' ')>0 && strpos($name, ' ') > $min_length){
                                $name = substr($name, 0,strpos($name, ' '));
                            } else if(strlen($name)>$max_length){
                                $name = substr($name,0,$max_length);
                            }
                            echo $name;
//                                echo substr($top_three[$i]['user_name'], 0,strpos($top_three[$i]['user_name'], ' '));
//                            } else {
//                                echo $top_three[$i]['user_name'];
//                            }
                        ?>
                    	<br />
						<?=$top_three[$i]['score']?>
					</div>
    			</td>
    		</tr>
    <?php 
    } ?>
</table>
</div>