<?php 
$this->lang->load('dashboard',$_SESSION['language']);
$this->lang->load('score',$_SESSION['language']);
$this->lang->load('date',$_SESSION['language']);
?>
<!-- Dashboard -->
<div id = "Dashboard">
	<div id = "Orange-Background">
		<h3 style = "color: white; position: relative; top:5px;" align = "center"><?=$this->lang->line('My_Dashboard');?></h3>
			<div id = "White-Background">
			<table id = "counter">
				<tr style = "height: 100px;">
					<td style = "border-left:6px solid #68c220;">
						<img class = "arrow" src="<?=base_url()?>/h7-assets/resources/img/main-icons/green-arrow.png" alt="green-arrow" style = "position: relative;top: -22px;">
					</td>
					<td style = "width: 50px;">
						<h3><?=(($_SESSION['cur_round']!=FALSE)?$_SESSION['cur_round']->name:"NON")?></h3>
					</td>
					<!-- <td>
						<img src="<?=base_url()?>/h7-assets/resources/img/main-icons/counter.png" alt="counter" style = "margin-left: 15px;">
					</td>-->
					<td style = "width: 20px;"></td>
					<td>
						<div class="clock-item clock-days countdown-time-value" style = "width: 95px;">
							<div class="wrap">
								<div class="inner">
									<div id="canvas_days" class="clock-canvas">
									</div>
									<div class="text">
										<p class="val">0</p>
										<p class="type-days type-time"><?=$this->lang->line('DAYS');?></p>
									</div>
								</div>
							</div> 
						</div>
					</td>
					<td style = "width: 15px;"></td>
					<td>
						<div class="clock-item clock-hours countdown-time-value" style = "width: 95px;">
						<div class="wrap">
						<div class="inner">
						<div id="canvas_hours" class="clock-canvas"></div>
						<div class="text">
						<p class="val">0</p>
						<p class="type-hours type-time"><?=$this->lang->line('HOURS');?></p>
						</div>
						<!-- /.text --> 
						</div>
						<!-- /.inner --> 
						</div>
						<!-- /.wrap --> 
						</div>
						<!-- /.clock-item -->
					</td>
					<td style = "width: 15px;"></td>
					<td>
						<div class="clock-item clock-minutes countdown-time-value" style = "width: 95px;">
						<div class="wrap">
						<div class="inner">
						<div id="canvas_minutes" class="clock-canvas"></div>
						<div class="text">
						<p class="val">0</p>
						<p class="type-minutes type-time"><?=$this->lang->line('MINUTES');?></p>
						</div>
						<!-- /.text --> 
						</div>
						<!-- /.inner --> 
						</div>
						<!-- /.wrap --> 
						</div>
						<!-- /.clock-item -->
					</td>
					<td style = "width: 15px;"></td>
					<td>
						<div class="clock-item clock-seconds countdown-time-value" style = "width: 95px;">
						<div class="wrap">
						<div class="inner">
						<div id="canvas_seconds" class="clock-canvas"></div>
						<div class="text">
						<p class="val">0</p>
						<p class="type-seconds type-time"><?=$this->lang->line('SECONDS');?></p>
						</div>
						<!-- /.text --> 
						</div>
						<!-- /.inner --> 
						</div>
						<!-- /.wrap --> 
						</div>
						<!-- /.clock-item --> 
					</td>
				</tr>
			</table>
			
			<div id = "dashboard_ranks">
                            
			</div>
		</div>
		<!-- end of Orange-Background -->
	</div>
	<!-- end of Orange-Background -->
</div>
<!-- end of dashboard -->