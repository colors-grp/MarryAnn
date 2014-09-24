<!DOCTYPE HTML>
<!--
Miniport 2.5 by HTML5 UP
html5up.net | @n33co
Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>HitSeven - Social Competitions</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,600,700" rel="stylesheet" />
		<script src="js/jquery.min.js"></script>
		<script src="js/config.js"></script>
		<script src="js/skel.min.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>
                <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css" /><![endif]-->
	</head>
	<body>

		<!-- Nav -->
		<nav id="nav">
			<ul class="container">
				<li>
                                        <a href="<?=site_url('admin/go_home');?>">Home</a>
				</li>
				<li>
					<a href="#work">How it works?</a>
				</li>
				<li>
					<a href="#portfolio">Competitions</a>
				</li>
				<li>
					<a href="#contact">Contact</a>
				</li>
                                <li>
					<a href="<?=site_url('admin/sign_out');?>">Sign out</a>
				</li>
			</ul>
		</nav>

		<!-- Portfolio -->
		<div class="wrapper wrapper-style3">
			<article id="portfolio">
				<header>
					<h2>Competitions powered by HitSeven</h2>
				</header>
				<div class="container">
					<div class="row">
						<div class="12u"></div>
					</div>
					<div class="row">
						<?php
                                                log_message('error','admin home_view $site_info='.print_r($site_info,1));
                                                foreach ($site_info as $row){
//                                                    log_message('error','admin home_view $row='.print_r($row->result_array(),1));
//                                                    echo print_r($row,1).'<br />';
//                                                    if($row->url == 'https://hitseven.net/SuperSayem/' && $row->name == 'SuperSayem')
//                                                    {
                                                        echo "<div class=\"4u\">";
                                                        echo "<article class=\"box box-style2\">";
                                                        $img = "images\\" . $row->name. ".jpg";
//                                                        $url = ($row->url == 'https://hitseven.net/SuperSayem/')?'http://www.supersayem.com':$row->url;
                                                        $url = $row->url;
                                                        echo "<a href=$url class=\"image image-full\"><img src=$img alt=\"\" /></a>";
                                                        echo "<h3><a href=$url >$row->name</a></h3>";
                                                        echo "</article>";
                                                        echo "</div>";
                                                        break;
//                                                    }
						}
                                                echo "<div class=\"4u\">";
                                                echo "<article class=\"box box-style2\">";
                                                $img = "images\add_competition.jpg";
//                                                        $url = ($row->url == 'https://hitseven.net/SuperSayem/')?'http://www.supersayem.com':$row->url;
                                                $url = '#';
                                                echo "<a href=$url class=\"image image-full\"><img src=$img alt=\"\" /></a>";
                                                echo "<h3><a href=$url >Add new competition</a></h3>";
                                                echo "</article>";
                                                echo "</div>";

                                                
						?>
						</div>
					</div>
					<footer>
						<p>
							Platform status: SuperSayem is the first demo competition, HitSeven is going live for B2B services in October 2014.
						</p>
						<a href="#contact" class="button button-big">Get in touch with us</a>
					</footer>
			</article>
		</div>
		
		<!-- Contact -->
		<div class="wrapper wrapper-style4">
			<article id="contact" class="container small">
				<header>
					<h2>Get in touch with HitSeven team!</h2>
					<span>We'd love to hear from you :)) ...</span>
				</header>
				<div>
					<div class="row">
						<div class="12u">
                                                        <form>
								<div>
                                                                        <h5 class="message_field" id="error_field" style="color: red; display: none;">PLEASE FILL ALL FIELDS.</h5>
                                                                        <h5 class="message_field" id="invalid_email_field" style="color: red; display: none;">PLEASE ENTER VALID E-MAIL.</h5>
                                                                        <h5 class="message_field" id="sending_field" style="color: green; display: none;">SENDING YOUR MESSAGE, PLEASE WAIT...</h5>
                                                                        <h5 class="message_field" id="success_field" style="color: green; display: none;">WE GOT YOUR MESSAGE.</h5>
                                                                        <h5 class="message_field" id="failed_field" style="color: red; display: none;">WE DID NOT GET YOUR MESSAGE, PLEASE TRY AGAIN.</h5>
									<div class="row half">
										<div class="6u">
											<input type="text" name="name" id="name" placeholder="Name" />
										</div>
										<div class="6u">
											<input type="text" name="email" id="email" placeholder="Email" />
										</div>
									</div>
									<div class="row half">
										<div class="12u">
											<input type="text" name="subject" id="subject" placeholder="Subject" />
										</div>
									</div>
									<div class="row half">
										<div class="12u">
											<textarea name="message" id="message" placeholder="Message"></textarea>
										</div>
									</div>
									<div class="row">
										<div class="12u">
                                                                                    <button type="submit" class="button form-button-submit">Send Message</button>
                                                                                    <button type="reset" class="button button-alt form-button-reset">Clear Form</button>
                                                                                    <h5 style="color: red;">ALL FIELDS ARE REQUIRED</h5>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="12u">
							<hr />
							<h3>Find us on ...</h3>
							<ul class="social">
								<li class="facebook">
									<a href="http://www.facebook.com/HitSeven.Official" class="fa fa-facebook"><span>Facebook</span></a>
								</li>
								<!--
								<li class="rss"><a href="#" class="fa fa-rss"><span>RSS</span></a></li>
								<li class="instagram"><a href="#" class="fa fa-instagram"><span>Instagram</span></a></li>
								<li class="foursquare"><a href="#" class="fa fa-foursquare"><span>Foursquare</span></a></li>
								<li class="skype"><a href="#" class="fa fa-skype"><span>Skype</span></a></li>
								<li class="soundcloud"><a href="#" class="fa fa-soundcloud"><span>Soundcloud</span></a></li>
								<li class="youtube"><a href="#" class="fa fa-youtube"><span>YouTube</span></a></li>
								<li class="blogger"><a href="#" class="fa fa-blogger"><span>Blogger</span></a></li>
								<li class="flickr"><a href="#" class="fa fa-flickr"><span>Flickr</span></a></li>
								<li class="vimeo"><a href="#" class="fa fa-vimeo"><span>Vimeo</span></a></li>
								-->
							</ul>
							<hr />
						</div>
					</div>
				</div>
				<footer>
					<ul id="copyright">
						<li>
							&copy; 2014 HitSeven.com
						</li>
					</ul>
				</footer>
			</article>
		</div>
                <script type="text/javascript">
                    $("form").bind("submit", validate);
                    function validate(){
                        var fields = document.getElementsByClassName('message_field');
                        for(var i=0; i<fields.length; i++){fields[i].style.display = 'none';}
                        fields = new Array(
                                    document.getElementById('name').value,
                                    document.getElementById('email').value,
                                    document.getElementById('subject').value,
                                    document.getElementById('message').value
                                );
                        var error = false;
                        for(var i=0; i<fields.length; i++){
                            if(fields[i] == ''){
                                error = true;
                                document.getElementById('error_field').style.display = 'block';
                                break;
                            }
                        }
                        if(!validateEmail(fields[1])){
                            error = true;
                            document.getElementById('invalid_email_field').style.display = 'block';
                        }
                        if(!error){
                            document.getElementById('sending_field').style.display = 'block';
                            var ajaxpage = "<?=base_url();?>index.php?/core/submit_message";
                            $.post(ajaxpage , {name: fields[0], email: fields[1], subject: fields[2], message: fields[3]})
                                    .done(function( data ) {
                                        if(data == -1){
                                            failed_message();
                                        } else {
                                            document.getElementById('sending_field').style.display = 'none';
                                            document.getElementById('success_field').style.display = 'block';
                                        }
                                    })
                                    .fail(function() {
                                        failed_message();
                                    });
                        }
                        return false;
                    }
                    function failed_message(){
                        document.getElementById('sending_field').style.display = 'none';
                        document.getElementById('failed_field').style.display = 'block';
                    }
                    function validateEmail(email) {
                        // http://stackoverflow.com/a/46181/11236
                        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        return re.test(email);
                    }
                    function clear(){
                        document.getElementById('name').innerHTML = '';
                        document.getElementById('email').innerHTML = '';
                        document.getElementById('subject').innerHTML = '';
                        document.getElementById('message').innerHTML = '';
                    }
                </script>
	</body>
</html>