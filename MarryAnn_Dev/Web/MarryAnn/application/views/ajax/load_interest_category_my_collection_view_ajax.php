<?php 
$this->lang->load('category',$_SESSION['language']);
$this->lang->load('card',$_SESSION['language']);
$this->lang->load('score',$_SESSION['language']);
?>
<table id="MyFav-cat">
			<tr id = "my-fav-cat-header">
				<td colspan="3"
					style="border-top: 8px solid #68c220; box-shadow: 0 2px 2px -1px gray;">
					<h4>
						<img class="arrow"
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/green-arrow.png"
							alt="green-arrow"><?=$this->lang->line('Categories');?>
					</h4>
				</td>
			</tr>
			<?php 
			if ($interest_cats != FALSE) {
				$i = 0;
				$size = $interest_cats->num_rows();
				foreach ($interest_cats->result() as $int_cat) {?>
				<tr style="height: 10px;"></tr>
				<?php if ($int_cat->id == $cat_id) {?>
					<tr id="cat-<?=$i?>"style="height: 95px; background :  <?=$color ?>;">
				<?php } else {?>
					<tr id="cat-<?=$i?>"style="height: 95px; background :  rgba(255,255,255,0);">
				<?php }?>
					<td colspan="3" style="border-radius: 3px;">
						<a href="javascript:void(0);" onclick= "on_load_my_collection('<?= $int_cat->id?>' , '<?= $int_cat->name?>','<?='-1'?>','<?='-1'?>','<?='-1'?>','<?='-1'?>');">
							<ul class="nav nav-pills">
								<li style = "height: 90px;">
									<img class = "circle-pic" src="<?=base_url()?>/h7-assets/resources/img/main-icons/score_icon.png" alt="circle"  style = "margin-top:13px;">
								 	<div class = "left-line"></div>
								 	<font id = "score-text"><?=$this->lang->line('Score');?></font>
								 	<br />
								 	<font class = "user-score" id = "score-<?=$int_cat->id?>"><?=$int_cat->score?></font>
								</li>													
								<li style = "width: 83px; height: 90px;">
									<img class = "cat-pic" src="<?=base_url()?>/h7-assets/images/categories/<?=$int_cat->name?>/main_icon.png" alt="<?=$int_cat->name?>-cat" >
									<!--  <font class = "cat-name"><?php //$int_cat->name?></font> -->
								</li>
								<li style = "height: 90px;">
									<font id = "rank-text"><?=$this->lang->line('Cards');?></font>
									<br />
									<font class = "user-rank"><?=$int_cat->num_of_cards?>/<?=$total_cards[$i]?></font>
								 	<div class = "right-line"></div>
									<img class = "circle-pic" src="<?=base_url()?>/h7-assets/resources/img/main-icons/score_icon.png" alt="circle" style = "margin-top: -39px;">
								</li>												
							</ul>
					</a>
					</td>
				</tr>
				<?php $i ++;
				}
			}else { ?>
					<tr>
						<td>
							<h3><?=$this->lang->line('No_Categories');?></h3>
						</td>
					</tr>
			<?php } ?>
		</table>