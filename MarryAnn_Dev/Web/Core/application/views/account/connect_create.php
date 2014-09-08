<?php
$language = 'arabic';
$this->lang->load('general',$language);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$this->lang->line('website_title');?></title>

<link type="text/css" rel="stylesheet" href="<?=base_url();?>resources/bootstrap/css/bootstrap.css"/>
<link type="text/css" rel="stylesheet" href="<?=base_url();?>resources/bootstrap/css/bootstrap-theme.css"/>
<link type="text/css" rel="stylesheet" href="<?=base_url();?>resources/css/style.css"/>

<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>resources/img/favicon.ico">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	

<script type="text/javascript">
	function inIframe() {
	    try {
	        return window.self !== window.top;
	    } catch (e) {
	        return true;
	    }
	}

    window.onresize = function() { page_width(); };
    window.onfocus = function() { page_width(); };
    function page_width(){
    	var scroll_width = (window.innerWidth-$(window).width());
        var w_outerWidth = (window.outerWidth > window.screen.availWidth)?window.screen.availWidth:window.outerWidth;
        var h_outerHeight = (window.outerHeight > window.screen.availHeight)?window.screen.availHeight:window.outerHeight;
        var w_difference = (window.innerWidth >= window.screen.availWidth || window.innerWidth >= window.outerWidth)?0:( w_outerWidth  - window.innerWidth);
        var h_difference = (window.innerHeight >= window.screen.availHeight || window.innerHeight >= window.outerHeight)?0:(h_outerHeight - window.innerHeight);
		var w = (window.screen.availWidth - w_difference ) - scroll_width;
		var h = window.screen.availHeight - h_difference;

		if (window.screen.availHeight > 700 && h < 600)
			h = 640;

		full_h = h;

		var FB = inIframe();
		if(FB){
			h = w * 0.4956;
		}
		
 		document.getElementById("container").style.width = w + "px";
 		document.getElementById("container").style.height = h + "px";
 		document.getElementById("container").style.backgroundSize = w +"px" + " " + h + "px";
 		
 		document.getElementById("header").style.width = w + "px";
 		document.getElementById("header").style.height = (h*0.292) + "px";
 		document.getElementById("header").style.backgroundSize = w +"px" + " " + (h*0.292) + "px";
 		
 		document.getElementById("logo").style.width = (w * 0.23352) + "px";
 		document.getElementById("logo").style.left = (w * 0.5724743 ) + "px";
 		document.getElementById("logo").style.top = (h * 0.17179 * 0.292) + "px";
 		
                document.getElementById("hit_seven_logo").style.left = (w * 0.2379209370424597 ) + "px";
                document.getElementById("hit_seven_logo").style.top = (h * 0.047976011994003 ) + "px";
//                document.getElementById("hit_seven_logo").style.width = (w * 0.0666178623718887 ) + "px";
                document.getElementById("hit_seven_logo").style.height = (h * 0.1424287856071964 ) + "px";
                
//                left: 325px;
////                top: 32px;
//                width: 91px;
//                height: 95px;
                
                
                //alert(h + '\n' + w);
                
 		document.getElementById("form-info").style.width = (w * 0.53075) + "px";
 		document.getElementById("form-info").style.height = (h * 0.52473) + "px";
 		document.getElementById("form-info").style.backgroundSize = (w * 0.53075) + "px" + " " + (h * 0.52473) + "px";
 		document.getElementById("form-info").style.top = (h * 0.36732) + "px";
                
//                document.getElementByClassName("span6").style.left = (w * 0.01977) + "px";
//                document.getElementByClassName("span6").style.top = (h * 0.11374) + "px";
                
                var spans = document.getElementsByClassName("span6");
 		for(var i = 0; i < spans.length; i++){
 			spans[i].style.right = (w * 0.03148) + "px";
                        spans[i].style.top = (h * 0.13493) + "px";
 		}
                
                var buttons = document.getElementsByClassName("offset2");
 		for(var i = 0; i < buttons.length; i++){
 			buttons[i].style.right = (w * 0.21962) + "px";
 		}
                
 		
 		document.getElementById("footer").style.width = w + "px";
 		document.getElementById("footer").style.height = (h*0.04) + "px";
 		document.getElementById("footer").style.backgroundSize = w +"px" + " " + (h*0.04) + "px";
 		document.getElementById("footer").style.top = h - (h*0.04) + "px";
 		
 		document.getElementById("header").style.display = "block";
 		document.getElementById("container").style.display = "block";
 		document.getElementById("footer").style.display = "block";
                
                document.getElementById("connect_create_heading").style.fontSize = w * 0.01025 + "px";
//                document.getElementById("connect_create_heading").style.right = w * 0.03148 + "px";
                document.getElementById("connect_create_username").style.width = w * 0.21962 + "px";
                document.getElementById("connect_create_email").style.width = w * 0.21962 + "px";
                document.getElementById("connect_create_birthday").style.lineHeight = h * 0.02699 + "px";
    }	
</script>
</head>
<body onload = "page_width();"  style = "overflow: hidden;">
<div id = "header">
    <a href="<?=base_url();?>"> <img src = "<?=base_url();?>images/hitseven_logo.png" id = "hit_seven_logo" /> </a>
    <img src = "<?=base_url();?>resources/img/logo.png" id = "logo"/>
</div>
	
<div id = "container">
    <div id = "form-info" style="direction: rtl">  
        <!--style="width: 372px; height: 350px; top: 277.8055px; background-size: 370px 347px;"-->
            <div class="row">
<!--                <div class="span12">
                    <h2><?php echo anchor(current_url(), lang('connect_create_account')); ?></h2>
                </div>-->
                <div class="clearfix"></div>
                <div class="span6" style="position: absolute;">
                                <?php echo form_open(uri_string()); ?>
                                <?php echo form_fieldset(); ?>
                    <h3 id="connect_create_heading" style="position: relative;"><?php echo lang('connect_create_heading'); ?></h3>
                                <?php if (isset($connect_create_error)) : ?>
                    <div class="span6">
                        <div class="form_error"><?php echo $connect_create_error; ?></div>
                    </div>
                    <div class="clearfix"></div>
                                <?php endif; ?>
                    <div class="span2">
                                        <?php echo form_label(lang('connect_create_username'), 'connect_create_username'); ?>
                    </div>
                    <div class="span4">
                        <?php $connect_create[0]['username'] = $username;  ?>
                                        <?php echo form_input(array('name' => 'connect_create_username', 'id' => 'connect_create_username', 'value' => set_value('connect_create_username') ? set_value('connect_create_username') : (isset($connect_create[0]['username']) ? $connect_create[0]['username'] : ''), 'width' => '300')); ?>
                                        <?php echo form_error('connect_create_username'); ?>
                                        <?php if (isset($connect_create_username_error)) : ?>
                        <span class="field_error"><?php echo $connect_create_username_error; ?></span>
                                        <?php endif; ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="span2">
                                        <?php echo form_label(lang('connect_create_email'), 'connect_create_email'); ?>
                    </div>
                    <div class="span4">
                        <?php $connect_create[0]['email'] = $email;  ?>
                                        <?php echo form_input(array('name' => 'connect_create_email', 'id' => 'connect_create_email', 'value' => set_value('connect_create_email') ? set_value('connect_create_email') : (isset($connect_create[0]['email']) ? $connect_create[0]['email'] : ''), 'width' => '300')); ?>
                                        <?php echo form_error('connect_create_email'); ?>
                                        <?php if (isset($connect_create_email_error)) : ?>
                        <span class="field_error"><?php echo $connect_create_email_error; ?></span>
                                        <?php endif; ?>
                    </div>
                        <div class="clearfix"></div>
                        <div class="span2">
                                <label> <?=$this->lang->line('connect_create_birthday');?> </label>
                        </div>
                        <div class="span4">
                                <?php
                                        log_message('error','connect_create view $birthday= '.  print_r($birthday,1));
                                        $year = substr($birthday,6,10);
                                        $day = substr($birthday,0,2);
                                        $month = substr($birthday,3,2);
                                        $BD = $year ."-".$month."-".$day;
                                ?>
                                        <input type="date" value="<?=$BD;?>" name = "connect_create_birthday" id = "connect_create_birthday" >
                                        <input type="hidden" value="<?=$this->session->userdata('provider');?>" name = "provider" id = "provider" >
                                <?php echo form_error('connect_create_birthday'); ?>
                                        <?php if (isset($connect_create_birthday_error)) : ?>
                        <span class="field_error"><?php echo $connect_create_birthday_error; ?></span>
                                        <?php endif; ?>
                        </div>
                    <div class="clearfix"></div>
                    <div class="offset2 span4" style="position: relative">
                                        <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-danger', 'content' => lang('connect_create_button'))); ?>
                    </div>
                    <div class="clear"></div>
                                <?php echo form_fieldset_close(); ?>
                                <?php echo form_close(); ?>
                </div>
                <div class="clearfix"></div>
            </div>
	</div>
</div>

<div id = "footer"></div>
</body>
</html>