<?php 
$this->lang->load('category',$_SESSION['language']);
$this->lang->load('dashboard',$_SESSION['language']);
$this->lang->load('score',$_SESSION['language']);
?>
<table id = "score">
    <tr style = "border-bottom:6px solid #68c220;font-size: 13px;font-weight: bold;">
        <td style = "width: 170px;"><?=$this->lang->line('Player');?></td>
        <td style = "width: 80px;"><?=$this->lang->line('Score');?></td>
        <td style = "width: 60px;"><?=$this->lang->line('Rank');?></td>
    </tr>
    <?php
    if ($users){
        $i = 0;
        log_message('error','mo7eb dash_ranks count($users)='.print_r(count($users),TRUE));
        foreach ($users->result() as $row){
            //log_message('error','mo7eb dash_ranks $row='.print_r($row,TRUE)); 
         ?>
        <tr style = "height: 45px; border-bottom: 1px solid #E4E4E4;">
                <td class = "right-border-grey" style = "font-size: 12px;" align="left" >
                        <img width = "27" height = "27" src = "http://graph.facebook.com/<?=$fb_ids[$i]?>/picture" alt="Profile Picture">
                        <?=$row->user_name?>
                </td>
                <td><?=$row->score?></td>
                <td class = "left-border-grey"> <?=$row->rank?> </td>
        </tr>
    <?php  $i++; }
    } ?>
</table>
<table id = "rank">
    <thead>
        <tr style = "border-bottom:6px solid #68c220;font-size: 13px;font-weight: bold;">
                <td style = "width: 100px;"><?=$this->lang->line('Category');?></td>
                <td style = "width: 80px;"><?=$this->lang->line('Score');?></td>
                <td style = "width: 50px;"><?=$this->lang->line('Pos');?></td>
        </tr>
    </thead>
    <tbody id = "rank-body">
        <?php 
        //log_message('error','mo7eb dash_ranks_ajax $dashboard='.  print_r($dashboard,TRUE));
        //log_message('error','mo7eb dash_ranks_ajax $pos='.  print_r($pos,TRUE));
        if ($dashboard){
                for ($i = 0; $i < count($dashboard) ; $i ++) { ?>
                <tr style = "height: 45px; border-bottom: 1px solid #E4E4E4;">
                        <td class = "right-border-grey" style = "width: 100px;">
                            <img align="left" class = "cat-rank" src="<?=base_url()?>/h7-assets/resources/img/main-icons/<?= $dashboard[$i]['cat_name'] ?>.png" alt="<?= $dashboard[$i]['cat_name'] ?>-cat" >
                            <?=$dashboard[$i]['cat_name']?>
                        </td>
                        <td style = "width: 80px;"><?= $dashboard[$i]['users']->row($dashboard[$i]['pos'])->score ?></td>
                        <td class = "left-border-grey" style = "width: 50px;"><div class = "triangle"><img src="http://gloryette.org/bonjour_april/h7-assets/images/scoreboard/change/<?=$dashboard[$i]['users']->row($dashboard[$i]['pos'])->change?>.png" alt="u"></div></td>
                </tr> 
         <?php  }
        }  ?>
    </tbody>
</table>