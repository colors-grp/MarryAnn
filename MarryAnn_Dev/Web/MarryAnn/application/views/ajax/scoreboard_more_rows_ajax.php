<?php
$flag = 1;
//log_message('error','mo7eb scoreboard_more_rows_ajax $ranks='.  print_r($ranks,TRUE));
log_message('error','mo7eb scoreboard_more_rows_ajax $all='.$_SESSION['all']);
foreach($ranks as $rank){
    $flag = ($flag)?0:1;
    $class = ($flag)?'even-row':'odd-row'; ?>
    <tr class = "<?=$class?>" >
        <td class = "first-col"><?=$rank['rank']?></td>
        <td><?=$rank['user_name']?></td>
        <td><?=$rank['score']?></td>
        <?php /* <td><img src="<?=base_url()?>h7-assets/images/scoreboard/change/<?=$rank['change']?>.png" alt="<?=$rank['change']?>"></td> */ ?>
</tr>
<?php }