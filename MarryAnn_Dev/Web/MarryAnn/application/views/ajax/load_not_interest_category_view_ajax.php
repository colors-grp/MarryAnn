<?php if($not_interest_cats && count($not_interest_cats)) { ?>
<?php 
$this->lang->load('category',$_SESSION['language']);
$this->lang->load('card',$_SESSION['language']);
$this->lang->load('score',$_SESSION['language']);
?>
<div id="catss_not_interest">
	<table id="new-cat">
			<tr>
				<td colspan="3"
					style="border-top: 8px solid #ca65be; box-shadow: 0 2px 2px -1px gray;">
					<h4>
						<img class="arrow"
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/pink-arrow.png"
							alt="purple-arrow"><?=$this->lang->line('Categories');?>
					</h4>
				</td>
			</tr>
			<?php
			$i = 0;
			 foreach($not_interest_cats as $not_int_cat) {?>
					<?php if ($i % 2 == 0) {?>
							<tr style="height: 10px;"></tr>
							<tr style="text-align: center;">
								<td>
			 					<a href="javascript:void(0)" onclick="get_not_interest_category('<?=$not_int_cat->id?>','<?= $not_int_cat->name?>','<?=false?>')">
									<img class="new-cat-pic"
									src="<?=base_url()?>/h7-assets/images/categories/<?=$not_int_cat->name?>/main_icon.png"
									alt="<?=$not_int_cat->name?>-cat" style="margin-left: 15px;">
								</a>
								</td>
						<?php } else {?>
							<td>
			 				<a href="javascript:void(0)" onclick="get_not_interest_category('<?=$not_int_cat->id?>','<?= $not_int_cat->name?>','<?=false?>')">
							<img class="new-cat-pic"
								src="<?=base_url()?>/h7-assets/images/categories/<?=$not_int_cat->name?>/main_icon.png"
								alt="<?=$not_int_cat->name?>-cat" style="margin-right: 10px;">		
							</a>
							</td>
							</tr>
						<?php }?>
				<?php $i ++; 
			 } 
			?>
		</table>
</div>
<?php } ?>
