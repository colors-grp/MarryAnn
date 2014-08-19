<body onload="container_height()">
	<?php if ($logs) {?>
	<div class="container" id="My-container" style="position: relative; top: 40px;">
		<?php } else {?>
		<div class="container" id="My-container" style="position: relative; top: 40px; min-height: 500px;">
		<?php }?>
		<div class="row marketing">
			<div style="width: 900px;">
				<h1 style="position: relative; left: 22px;">Activities</h1>
				<div class="scor_tab_2" style="margin: 20px; width: 876px;">
				<?php if ($logs) {?>
					<table width="100%" class="table table-bordered" cellpadding="10"
						cellspacing="0" style="background: rgba(255, 255, 255, 0.6);">
						<tr style="height: 60px;">
							<td width="22%" style="font-size: 17px;">Type</td>
							<td width="25%" style="font-size: 17px;">Activity</td>
							<td width="25%" style="font-size: 17px;">Date</td>
						</tr>

						<? foreach ($logs->result() as $log){ ?>
						<tr style="font: bold;">
							<td width="20%" style="font-size: 13px; font-weight: bold;"><?=$log->id?>
							</td>
							<td style="font-size: 13px; font-weight: bold;"><?=$log->activity?>
							</td>
							<td width="20%" style="font-size: 13px; font-weight: bold;"><?=$log->time?>
							</td>
						</tr>
						<? } 
					} else {?>
						<tr>
							<td width="25%" style="font-size: 17px;">No Activities</td>
						</tr>
						<?php }?>
					</table>
				</div>
			</div>
			<style>
.row .Cards .cards-head {
	width: 920px;
	background-color: #fff;
}

.row .Cards .cards-head h1 {
	left: inherit;
	padding-left: 20px;
}
</style>
		</div>
	</div>
	<script>
	function container_height(){
		var h = $('#My-container').height() + 100;
		document.getElementById('My-container').style.height = h + "px";
	}
</script>
</body>
