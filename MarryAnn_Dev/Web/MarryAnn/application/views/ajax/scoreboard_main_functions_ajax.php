

function scoreboard(cat_id, all){

    ajaxpage = "<?= base_url()?>index.php?/scoreboard/get_scoreboard_details";

    //$('#main_view_div').html('إستنى شوية');

    $.post(ajaxpage , { cat_id : cat_id ,  all : all })

    .done(function( data ) {

        $("*").css("cursor", "auto");

        if(data == '-1' || data == -1){
            window.location = "<?= base_url()?>";
            return;
        }

    	else if(all == 2){

    		$('#main_view_div').append("<div id='ranks_table_div'>");

    		$('#ranks_table_div').append(data);

    		$('#main_view_div').append("</div>");

    	}else{

    		$('#ranks_table_div').html(data);

    		if(all == 0){

    			if(cat_id == 3)

    				document.getElementById("my_friends_img").src = "<?=base_url();?>h7-assets/resources/img/cat/friends_selected_1.png";

    			else

    				document.getElementById("my_friends_img").src = "<?=base_url();?>h7-assets/resources/img/cat/friends_selected.png";

    		}else if(all == 1){

    			if(cat_id == 3)

    				document.getElementById("all_p_img").src = "<?=base_url();?>h7-assets/resources/img/cat/all_selected_1.png";

    			else

    				document.getElementById("all_p_img").src = "<?=base_url();?>h7-assets/resources/img/cat/all_selected.png";

    		}

    	}

    	if(data != -1){

		var scroll_width = (window.innerWidth-$(window).width());

                var w_outerWidth = (window.outerWidth > window.screen.availWidth)?window.screen.availWidth:window.outerWidth;

                var h_outerHeight = (window.outerHeight > window.screen.availHeight)?window.screen.availHeight:window.outerHeight;

                var w_difference = (window.innerWidth >= window.screen.availWidth || window.innerWidth >= window.outerWidth)?0:( w_outerWidth  - window.innerWidth);

                var h_difference = (window.innerHeight >= window.screen.availHeight || window.innerHeight >= window.outerHeight)?0:(h_outerHeight - window.innerHeight);

		var w = (window.screen.availWidth - w_difference ) - scroll_width;

		var h = window.screen.availHeight - h_difference;

		

		if (window.screen.availHeight > 700 && h < 600)

			h = 640;

		

		var FB = inIframe();

		if(FB){

			h = w * 0.4956;

		}

		        	

                document.getElementById("main_view_div").style.height = h * 0.4 + "px";



                document.getElementById("my_friends_img").style.width = w * 0.0732 + "px";

                document.getElementById("my_friends_img").style.margin = w * 0.00366 + "px";



                document.getElementById("all_p_img").style.width = w * 0.08784 + "px";

                document.getElementById("all_p_img").style.margin = w * 0.00366 + "px";



                if(cat_id == -1){

                        $('#ranks_table_div').css('background', 'url(<?=base_url();?>h7-assets/resources/img/cat/score_table_bg_'+(last_cat_id)+'.png) no-repeat');

                }else{

                        $('#ranks_table_div').css('background', 'url(<?=base_url();?>h7-assets/resources/img/cat/score_table_bg_'+(cat_id - 1)+'.png) no-repeat');

                }

                document.getElementById("ranks_table_div").style.width = w * 0.236456 + "px";

                document.getElementById("ranks_table_div").style.height = h * 0.387 + "px";

                document.getElementById("ranks_table_div").style.backgroundSize = w * 0.236456 + "px" + " " + h * 0.387 + "px";



                document.getElementById("ranks_buttons_table").style.width = w * 0.2284 + "px";

                document.getElementById("ranks_buttons_table").style.marginLeft = w * 0.00439 + "px";

                document.getElementById("ranks_buttons_table").style.height = h * 0.05908 + "px";



                document.getElementById("rank-table").style.width = w * 0.2284 + "px";

                document.getElementById("rank-table").style.marginLeft = w * 0.00439 + "px";

                document.getElementById("rank-table-body").style.height = h * 0.23633 + "px";



                 var rank = document.getElementsByClassName("rank_cell");

                     for(var i = 0; i < rank.length; i++){

                        rank[i].style.width = (w * 0.02928) + "px";

                     }



                document.getElementById("score_head").style.width = w * 0.04392 + "px";



                var score = document.getElementsByClassName("score_cell");

                     for(var i = 0; i < score.length; i++){

                        score[i].style.width = (w * 0.0512445) + "px";

                     }



                var name_cells = document.getElementsByClassName("name_cell");

                     for(var i = 0; i < name_cells.length; i++){

                        name_cells[i].style.width = (w * 0.14641288) + "px";

                     }

        }

    });

// Check user's score if != 0 && != his current score then display a waiting message

    var user_score = parseInt(document.getElementById("user_score").innerHTML);

    var user_past_score = 0;

    ajaxpage = "<?= base_url()?>index.php?/scoreboard/get_user_scoreboard_score";

    $.ajaxSetup({async: false}); //So as to avoid any other ajax calls made sybchrounously

    $.post(ajaxpage , { cat_id : cat_id})

    .done(function( data ) {
        if(data == '-1'){
            window.location = "<?= base_url()?>";
            return;
        }

        user_past_score = parseInt(data);

    });

    $.ajaxSetup({async: true}); //So as to avoid any other ajax calls made sybchrounously

    if(user_past_score == -1){

        alert_error('<?=$this->lang->line('some_thing_wrong');?>');

    } else if(user_score != 0 && user_past_score != user_score && selectedLink == 0){

        alert_info('<?=$this->lang->line('happy_face') .' '. $this->lang->line('scoreboard_wait')?>');

    }

    //alert(user_past_score + '\n' + user_score);

    //alert(typeof(user_past_score) + '\n' + typeof(user_score));

}

function get_top_three(cat_id){

	//selectedLink = 1;

	ajaxpage = "<?= base_url()?>index.php?/scoreboard/get_top_three_players";

    $('#main_view_div').html('إستنى شوية');

    //alert('cat_id='+cat_id);

    $.post(ajaxpage , { cat_id : cat_id })

    .done(function( data ) {
        if(data == '-1'){
            window.location = "<?= base_url()?>";
            return;
        }

    //alert(data);

     	$('#main_view_div').html(data);

        var scroll_width = (window.innerWidth-$(window).width());

                var w_outerWidth = (window.outerWidth > window.screen.availWidth)?window.screen.availWidth:window.outerWidth;

                var h_outerHeight = (window.outerHeight > window.screen.availHeight)?window.screen.availHeight:window.outerHeight;

                var w_difference = (window.innerWidth >= window.screen.availWidth || window.innerWidth >= window.outerWidth)?0:( w_outerWidth  - window.innerWidth);

                var h_difference = (window.innerHeight >= window.screen.availHeight || window.innerHeight >= window.outerHeight)?0:(h_outerHeight - window.innerHeight);

		var w = (window.screen.availWidth - w_difference ) - scroll_width;

		var h = window.screen.availHeight - h_difference;

		

		if (window.screen.availHeight > 700 && h < 600)

			h = 640;

		

		var FB = inIframe();

		if(FB){

			h = w * 0.4956;

		}

			

		document.getElementById("top-users-table").style.marginTop = 0.016248 * h + "px";

		

             for(var i = 0; i < 3; i++){

             	document.getElementById("top-users-row-"+i).style.width = (w * 0.098828) + "px";

             	document.getElementById("top-users-row-"+i).style.height = (h * 0.10192) + "px";

             	document.getElementById("top-users-row-"+i).style.backgroundSize = (w * 0.098828) + "px" + " " + (h * 0.10192) + "px";

             	document.getElementById("top-users-row-"+i).style.paddingBottom = (h * 0.02658788) + "px";

             	if(i == 2)

             		document.getElementById("top-users-row-"+i).style.paddingBottom = (h * 0.01477) + "px";

             }

		

		var pics = document.getElementsByClassName("top-pic");

             for(var i = 0; i < pics.length; i++){

             	pics[i].style.width = (w * 0.03367) + "px";

             	pics[i].style.left = (w * 0.00512) + "px";

             	pics[i].style.top = -(h * 0.0044) + "px";

             }

             

        var fanos = document.getElementsByClassName("top-fanos");

             for(var i = 0; i < fanos.length; i++){

             	fanos[i].style.width = (w * 0.03733528) + "px";

             	fanos[i].style.marginLeft = -(w * 0.03298) + "px";

             }

             

        var names_scores = document.getElementsByClassName("top_name_score");

             for(var i = 0; i < names_scores.length; i++){

             	names_scores[i].style.width = (w * 0.0571) + "px";

             	names_scores[i].style.marginTop = (h * 0.02511) + "px";

             }

             

             //alert(data);

    });

}

function get_user_score(cat_id){

    var ajaxpage = "<?= base_url()?>index.php?/scoreboard/get_user_score";

    $.post(ajaxpage , { cat_id : cat_id })

    .done(function( data ) {
        if(data == '-1' ){
            window.location = "<?= base_url()?>";
            return;

        } else {

            //alert(data);

            document.getElementById("user_score").innerHTML = data;

        }

    });

}

function load_scoreboard(cat_id, cat_name){

        $("*").css("cursor", "progress");

        load_dashboard(cat_id);

	ajaxpage = "<?=base_url() ?>index.php?/category/load_interest_category" ;

	$.post(ajaxpage , {cat_id : cat_id , cat_name : cat_name })

	.done(function(data){

		$("#cat_interest").html(data);

	});

	scoreboard(cat_id, 2);

	//get_not_interest_category(cat_id, cat_name, true);

}



function load_dashboard(cat_id){

    if(cat_id == -1){

        $('#score').html('إستنى شوية');

        $('#rank').html('');

    }

    ajaxpage = "<?=base_url() ?>index.php?/dashboard/load_new_ranks";

    $.post(ajaxpage, {cat_id : cat_id })

            .done(function(data){

                $("#dashboard_ranks").html(data);

            });

}



function onload_scoreboard(cat_id , cat_name, to_load) {

	load_scoreboard(cat_id,cat_name);

}

