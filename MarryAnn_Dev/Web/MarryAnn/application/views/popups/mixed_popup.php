
<!-- Simple Modal -->
<script type='text/javascript'
	src="<?=base_url();?>assets/js/simplemodal/js/jquery.simplemodal.js"></script>
<script type='text/javascript'
	src="<?=base_url();?>assets/js/simplemodal/js/basic.js"></script>
<link rel="stylesheet"
      href="<?=base_url();?>assets/js/simplemodal/css/basic.css">
<!-- End of Simple Modal -->
<div id="play_story" style="display: none; background-color: transparent;" align = "center">
<?php /* <!--	<div class="popup-container">
		<div id="game-content">
			<a href='javascript:void(0)' style="visibility:hidden;" id="previous-image" onclick='get_previous_story_image();'><img alt="previous" src="<?=base_url()?>h7-assets/resources/img/main-icons/bigarrow_left_icon.png"></a>
			<a onclick="getElementReadyForFullScreenMode('#story_id')" >
				<img id= "story_id" width="400px" height="400px" align = "center" style = "margin: 50px;" src="" >
			</a>
			<a href='javascript:void(0);' id="next-image" onclick='get_next_story_image(0);'><img alt="next" src="<?=base_url()?>h7-assets/resources/img/main-icons/bigarrow_right_icon.png"></a>
		</div>
		<div id="right-bar">
                    <a href="javascript:void(0);" onclick="toggleFullScreen('#play_story');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
                    <a href="javascript:void(0);" onclick="closeModal('#play_story');"><img id="close-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
			<table style="margin-top: 5px;">
				<tr>
					<td>
						<h4 style="margin-top: -31px;"><?//= $card_name?></h4>
					</td>
					<td>
						<div class="card-holder-popup" style="margin-left: 25px;">
							<img align = "center" src="<?//=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/ui/list_view.png"
								class="card-pic-popup" alt="card">
						</div>
					</td>
				</tr>
				<tr style="height: 40px;">
					<td colspan="2" style="border-bottom: 4px solid #68c220;"></td>
				</tr>
			</table>
			<h5 style = "text-align: left;">
				<img
					src="<?//=base_url()?>h7-assets/resources/img/main-icons/green-arrow.png"
					style="margin-right: 5px;"
				>
				<a href="javascript:void(0)" onclick="getElementReadyForFullScreenMode('#play_story')" >
					<?//=$card_name?>
				</a>
			</h5>
		</div>
	</div>--> */ ?>
</div>

<script>
var main_cat_id = 0;
// get next element in given div id
function get_elem_view(cat_id,card_id,next,elem_id){
    //var next_view = "";
    // Get card's next type (img,aud,vid,gam)
    //alert('cat_id= '+cat_id+'card_id = '+card_id);
    if(cat_id > -1){
    // ready ajaxpage source
        var ajaxpage = "<?=base_url();?>index.php?/card/get_element_view";
    // Get view from controller
        $.post(ajaxpage, {cat_id : cat_id, card_id : card_id, next : next})
                .success(function(data){
                    if(data == -1){window.location = '<?=base_url();?>'; return;}
                         //alert(data);
                 //alert('cat_id='+cat_id+'\n card_id='+card_id+'\n next='+next+'\n elem_id='+elem_id+'\n data='+data);
                        $(elem_id).html(data);
        });
    }
}
//----------------------------------------
function display_mixed_popup(cat_id,card_id){//this function called first time only
    $.ajaxSetup({async: false}); //So as to avoid any other ajax calls made sybchrounously
// Get card's first type (img,aud,vid,gam)
    //var type = get_elem_type(cat_id,card_id,-1);
// Get card's first view
    main_cat_id = cat_id;
    var elem_id = '#play_story';
    get_elem_view(cat_id,card_id,-1,elem_id);
    $.ajaxSetup({async: true}); //So as to avoid any other ajax calls made sybchrounously
// Display modal
    play_modal(elem_id);
}
//----------------------------------------
function get_elem(cat_id,card_id, next){// next = -1,0,1 , first,prev,next
// Get card's next type (img,aud,vid,gam)
    //$.ajaxSetup({async: false}); //So as to avoid any other ajax calls made sybchrounously
    //var type = get_elem_type(cat_id,card_id,next);
// Get card's next view
    var elem_id = '#play_story';
    get_elem_view(cat_id,card_id,next,elem_id);
    //$.ajaxSetup({async: true}); //So as to avoid any other ajax calls made sybchrounously
    //play_modal(elem_id);
// Get view ready
    
}
function play_modal(elem_id) {
        return_to_normal_mode();
	// Opening animations
	<?php // if($own_card!=FALSE ){ ?>
	//document.getElementById(elem_id).src = story_src;
	var wid = 950;
	var hit = 560;
	$(elem_id).modal({
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
                                // Call ending games functions if exists SO FREAKEN IMPORTANT
                                if (typeof clearIntervals == 'function') {
                                    if(typeof updatePipes == 'function'){//only shahryar 
                                        game_ended = true;
                                        clearIntervals(1);
                                    } else {
                                        clearIntervals();//any other game
                                    }
                                }// will be called only when games beeing played
                                get_user_score(main_cat_id);
								get_cards_grid_view(-1, -1);
                                $.modal.close(); // must call this!
                                });
                            });
                        });
                }
        });
}
function closeModal(cat_id){
    $.modal.close();
}
var is_fullscreen = false;
var elem_id = '#play_story';
//    var elem_id = '#image_content_view_id';
var popup_container_div = '.popup-container';

var max_height = screen.height;
var max_width = screen.width;

var basic_height = 560;
var basic_width = 950;

var height_paddings = 140;
var width_paddings = 72;

var basic_top_padding = 93;
var calculated_top_padding = screen.height * 0.1653645833333333;

var basic_game_content_height = 339,
        basic_game_content_width = 600,
        basic_img_margin_top = -2,
        basic_img_margin_left = 0;
        basic_right_bar_height = 385;

var calculated_game_content_height = screen.height * 0.7591145833333333,
        calculated_game_content_width = screen.width * 0.7496339677891654,
        calculated_img_content_height = screen.height * 0.7447916666666667,
        calculated_img_content_width = screen.width * 0.7335285505124451,
        calculated_img_margin_top = screen.height * -0.0520833333333333,
        calculated_img_margin_left = screen.width * 0.0109809663250366,
        calculated_right_bar_height = screen.height * 0.7096354166666667;

var basic_next_top = -97,
        basic_prev_top = 94,
        basic_prev_left = 4;
var calculated_next_top = screen.height * -0.2408854166666667,
        calculated_prev_top = screen.height * 0.2604166666666667,
        calculated_prev_left = screen.width * 0.0146412884333821;



function toggleFullScreen(){
// to toggle fullscreen mode
    if(is_fullscreen){// change back to normal sizes
    // change sizes of contents to normal sizes
        return_to_normal_mode();
    } else {// change to fullscreen sizes
    // change sizes of contents to fullscreen sizes
        fullscreen_mode();
    }
    $(elem_id).toggleFullScreen();
}
window.addEventListener('keyup', function(e) {
    var key = {left: 37, up: 38, right: 39, down: 40, esc: 27, space: 32};
    if(e.keyCode == key.esc) { //esc
        if(is_fullscreen){
            return_to_normal_mode();
            is_fullscreen = false;
        }
    }
    else if(e.keyCode == key.up || e.keyCode == key.right || e.keyCode == key.space){
        if($('#next-image').length && $('#next-image').css('visibility') == 'visible'){
            $('#next-image').click();
        } else if($('#next-image-mcq').length && $('#next-image-mcq').css('visibility') == 'visible'){
            $('#next-image-mcq').click();
        }
    } else if(e.keyCode == key.down || e.keyCode == key.left){
        if($('#previous-image').length && $('#previous-image').css('visibility') == 'visible'){
            $('#previous-image').click();
        } else if($('#previous-image-mcq').length && $('#previous-image-mcq').css('visibility') == 'visible'){
            $('#previous-image-mcq').click();
        }
    }
    e.preventDefault();
});

function return_to_normal_mode(){
    is_fullscreen = false;
    $(elem_id).css('height', basic_height);
    $(elem_id).css('width', basic_width);
    $.modal.update();
    
    $('#game-content-view').css("height", basic_game_content_height);
    $('#game-content-view').css("width", basic_game_content_width);
    $('#game-content-view').css("top-padding", basic_top_padding);
    
    $('#image_content_view_id').css("height", basic_game_content_height);
    $('#image_content_view_id').css("width", basic_game_content_width);
    $('#image_content_view_id').css("margin-top", basic_img_margin_top);
    $('#image_content_view_id').css("margin-left", basic_img_margin_left);
    
//    $('#previous-image').css("top", basic_prev_top);
//    $('#previous-image').css("left", basic_prev_left);
    $('.prev-img').css("top", basic_prev_top);
    $('.prev-img').css("left", basic_prev_left);
    $('.next-img').css("top", basic_next_top);
//    $('#next-image').css("top", basic_next_top);
    
    $('#right-bar-view').css("height", basic_right_bar_height);


    $(popup_container_div).height(basic_height - height_paddings);
    $(popup_container_div).width(basic_width - width_paddings);

    $(popup_container_div).css({ 
        "background-size": basic_width+'px' + ' ' + basic_height+'px',
        "padding-top": basic_top_padding + 'px'
    });


    $('#close-popup-button').css("display", "block");
}

function fullscreen_mode(){
    is_fullscreen = true;
    $(elem_id).css('height', max_height);
    $(elem_id).css('width', max_width);
    $.modal.update();

//          $(elem_id).height(max_height);
//          $(elem_id).width(max_width);



    $(popup_container_div).height(max_height - height_paddings);
    $(popup_container_div).width(max_width - width_paddings);

    $(popup_container_div).css({
        "background-size": max_width+'px' + ' ' + max_height+'px',
        "padding-top": calculated_top_padding + 'px'
    });

    $('#close-popup-button').css("display", "none");

    $('#game-content-view').css("height", calculated_game_content_height);
    $('#game-content-view').css("width", calculated_game_content_width);
    $('#game-content-view').css("top-padding", calculated_top_padding);

    $('#image_content_view_id').css("height", calculated_img_content_height);
    $('#image_content_view_id').css("width", calculated_img_content_width);
    $('#image_content_view_id').css("margin-top", calculated_img_margin_top);
    $('#image_content_view_id').css("margin-left", calculated_img_margin_left);

    $('#right-bar-view').css("height", calculated_right_bar_height);

//    $('#previous-image').css("top", calculated_prev_top);
//    $('#previous-image').css("left", calculated_prev_left);
    $('.prev-img').css("top", calculated_prev_top);
    $('.prev-img').css("left", calculated_prev_left);
    $('.next-img').css("top", calculated_next_top);
//    $('#next-image').css("top", calculated_next_top);
}
function share_on_fb(my_message) {
	var ajaxpage = "<?=base_url()?>index.php?/game_center/share_of_fb";
	$.post(ajaxpage, { message : my_message })
	.done(function( data ) {
            if(data == -1){window.location = '<?=base_url();?>'; return;}
	});
    }
</script>
