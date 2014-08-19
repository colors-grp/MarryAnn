    function get_cards_grid_view(cat_id, cat_name) {
        selectedLink = 0;
		if(cat_id == -1){
	        document.getElementById("ss").src = "<?=base_url();?>h7-assets/resources/img/cat/super_saymeen_"+ last_cat_id +".png";
    	    document.getElementById("el7ala2at").src = "<?=base_url();?>h7-assets/resources/img/cat/El7ala2at_selected_"+ last_cat_id +".png";
    	            $('#unknown').css('background', 'url(<?=base_url();?>h7-assets/resources/img/cat/cat_cards_bg_'+ last_cat_id +'.png) no-repeat');         
    	 }else{
	        document.getElementById("ss").src = "<?=base_url();?>h7-assets/resources/img/cat/super_saymeen_"+ (cat_id - 1) +".png";
	        document.getElementById("el7ala2at").src = "<?=base_url();?>h7-assets/resources/img/cat/El7ala2at_selected_"+ (cat_id - 1) +".png";
	                $('#unknown').css('background', 'url(<?=base_url();?>h7-assets/resources/img/cat/cat_cards_bg_'+ (cat_id - 1) +'.png) no-repeat');
        }
        
        document.getElementById("main_view_div").style.direction = "rtl";
        document.getElementById("main_view_div").style.overflow = "auto";
        
        if(last_cat_id == 0){
            $('#games-icons').css('display', 'block');
        }
        
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
			
        document.getElementById("unknown").style.backgroundSize = (w * 0.4026) + "px" + " " + (h * 0.549483) + "px";
        ajaxpage = "<?= base_url()?>index.php?/card/get_card_grid_view";
        $('#main_view_div').html('إستنى شوية');
        //$('#card-sta-hide').hide();
        $("*").css("cursor", "progress");
        $.post(ajaxpage, { cat_id : cat_id , cat_name: cat_name })
        .done(function( data ) {
        $("*").css("cursor", "auto");
        if(data == '-1'){
            window.location = "<?= base_url()?>";
        }
                else if(data){
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
							
						document.getElementById("main_view_div").style.height = h * 0.38227 + "px";
							
						var holders = document.getElementsByClassName("card-holder");
				 		for(var i = 0; i < holders.length; i++){
				 			holders[i].style.height = (h * 0.317577) + "px";
				 			holders[i].style.width = (w * 0.14641288) + "px";
							holders[i].style.marginTop = (h * 0.032496) + "px";
							holders[i].style.marginLeft = (w * 0.01098) + "px";
					 		holders[i].style.marginRight = (w * 0.01098) + "px";
				 		}
				
				 		var cards = document.getElementsByClassName("card-pic");
				 		for(var i = 0; i < cards.length; i++){
				 			cards[i].style.height = (h * 0.30576) + "px";
				 			cards[i].style.width = (w * 0.13909) + "px";
				 			cards[i].style.marginTop = (h * 0.005908) + "px";
				 		}
				 		
				 		var cards_names = document.getElementsByClassName("card-pic-name");
				 		for(var i = 0; i < cards_names.length; i++){
				 			cards_names[i].style.height = (h * 0.317577 * 0.25) + "px";
				 			cards_names[i].style.width = (w * 0.14641288) + "px";
							cards_names[i].style.marginTop = -(h * 0.072378) + "px";
							cards_names[i].style.paddingTop = (h * 0.0059) + "px";
				 		}
				 		
				 		var card_mark = document.getElementsByClassName("new-mark");
				 		for(var i = 0; i < card_mark.length; i++){
				 			card_mark[i].style.width = (w * 0.0512) + "px";
				 			card_mark[i].style.marginLeft = -(w * 0.09516) + "px";
							card_mark[i].style.marginTop = -(h * 0.31757) + "px";
				 		}
				 		
				 		 if (navigator.userAgent.indexOf("Firefox")!=-1){
				 		 	var card_mark = document.getElementsByClassName("new-mark");
					 		for(var i = 0; i < card_mark.length; i++){
					 			card_mark[i].style.marginTop = -(h * 0.5172) + "px";
					 		}
				 		 }
				 		if($("#card-counter").length){
                                                    document.getElementById("card-counter").style.height = (h * 0.317577 * 0.25) + "px";
                                                    document.getElementById("card-counter").style.width = (w * 0.14641288) + "px";
                                                    document.getElementById("card-counter").style.marginTop = -(h * 0.072378) + "px";
                                                    document.getElementById("card-counter").style.paddingTop = (h * 0.00738) + "px";
                                                }
			 			
						
				 		
				 		countdown(year,month,day,hour,minute,today);
				}	
        });
    }
    function get_cards_list_view(cat_id, cat_name){
        isList = 1;
        ajaxpage = "<?= base_url()?>index.php?/card/get_card_list_view"  ;
        $('#bar').html('إستنى شوية');
        //$('#card-sta-hide').hide();
        $.post(ajaxpage, { cat_id : cat_id , cat_name: cat_name })
        .done(function( data ) {
                if(data){
                        $('#bar').html(data);
                }
        });
    }