
<div id="buy_credit" style="display: none;">
	<div class="popup-container" style = "width: 585px; height: 330px;">
		<div id="buy_credit_content" class="Ques" style="position: relative;left: -20px;top: 30px;">
			<h2 style = "color :#68b220;">Choose the desired amount</h2>
			<form id="buy_credit_form" action="" method="post">
				<input id="b1" type="radio" name="credit" value="10" checked="checked"><label for="b1"><font>10</font></label><br>
				<input id="b2" type="radio" name="credit" value="20"><label for="b2"><font>20</font></label><br> 
				<input id="b3" type="radio" name="credit" value="50"><label for="b3"><font>50</font></label><br> 
				<input id="b4" type="radio" name="credit" value="100"><label for="b4"><font>100</font></label><br> 
				<input id="b5" type="radio" name="credit" value="200"><label for="b5"><font>200</font></label><br> 
				<input id="b6" type="radio" name="credit" value="500"><label for="b6"><font>500</font></label><br>
				<input class="play-button" type="submit" value = "Submit" name="credit_submission" style = "position: relative; top: 15px; left: 185px;">
			</form>
  		</div>
	</div>
</div>

<script>
$("#getPointsButton").on('click',function(e){
	e.preventDefault();
	// Opening animations
	$("#buy_credit").modal({onOpen: function (dialog) {
		dialog.overlay.fadeIn('slow', function () {
			dialog.data.hide();
			dialog.container.fadeIn('slow', function () {
				dialog.data.slideDown('slow');
			});
		});
	}});
});
$("#buy_credit_form").on('submit',function(){
	$.post( "<?= base_url() ?>index.php?/platform/buy_credit", $( "#buy_credit_form" ).serialize() ).done(function(data) {
		$.modal.close();
		$("#user_points").html(data);
	});
	return false;
});
</script>
