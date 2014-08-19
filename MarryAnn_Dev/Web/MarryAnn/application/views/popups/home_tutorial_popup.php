<!-- Simple Modal -->
<script type='text/javascript'
	src="<?=base_url();?>assets/js/simplemodal/js/jquery.simplemodal.js"></script>
<script type='text/javascript'
	src="<?=base_url();?>assets/js/simplemodal/js/basic.js"></script>
<link rel="stylesheet"
      href="<?=base_url();?>assets/js/simplemodal/css/basic.css">
<!-- End of Simple Modal -->
<div id="display_game" style="display: none;">
    <div class="popup-container" style="background: transparent url('<?=base_url()?>h7-assets/resources/img/home_popup.png') no-repeat center top; background-size: 1050px 660px; height: 660px; width: 1050px;">
        <div id="game-content-view">
            <a href="javascript:void(0);"  id="close-popup-button" onclick="$.modal.close();" style="left: 869px; top: 0px;">
                        <img src="<?=base_url()?>h7-assets/resources/img/main-icons/close_window.png" style = "width: 13px; position: relative; width: 13px; top: 61px; left: 105px;">
            </a>
            <!-- <img id= "image_content_view_id" src="<?=base_url()?>h7-assets/resources/img/help/home/1.png" style="margin-top: -20px; margin-left: -6px; width: 895px; height: 425px;"> -->
            <iframe src="//www.youtube.com/embed/jZZH-eTtBRo" frameborder="0" allowfullscreen style="margin-top: 48px; margin-left: -4px; height: 462px; width: 991px;"></iframe>
            </div>
    </div>
</div>
<script>
    $(document).ready(load_tutorial_popup);
    function load_tutorial_popup() {
	var wid = 1050;
	var hit = 660;
	$('#display_game').modal({
		minHeight:hit,
		minWidth: wid,
                escClose: !0,
                close: !0,
                overlayClose: !0,
                zIndex: 99999,
		onOpen: function (dialog) {
		dialog.overlay.fadeIn('default', function () {
			dialog.data.hide();
			dialog.container.fadeIn('default', function () {
				dialog.data.slideDown('default');	 
			});
                    });
                },
                onClose: function (dialog) {
                    dialog.data.fadeOut('fast', function () {
                        dialog.container.slideUp('fast', function () {
                            dialog.overlay.fadeOut('fast', function () {
                                    $.modal.close(); // must call this!
                                });
                            });
                        });
                }
        });
    }
</script>