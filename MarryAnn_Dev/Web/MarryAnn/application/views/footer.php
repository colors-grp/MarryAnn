<!--<div id = "footer" style = "position:absolute; bottom:0; width:100%; height:60px; background:#001364;">
</div>
-->


<div class="row">
	<div id = "footer" style = "width:100%; height:150px; background:#001364; ">
		<div class="container" style = "padding-top: 65px; margin-top: 30px;">
	    	<strong>
	        	<small>Copyright &copy; <?php echo date('Y'); ?> <?php echo lang('website_title'); ?></small>
	        </strong>
	
	        <div class="pull-right">
	        	<small>
					<?php echo sprintf(lang('website_page_rendered_in_x_seconds'), $this->benchmark->elapsed_time()); ?>
	            </small>
	        </div>
	    </div>
	</div>
</div>