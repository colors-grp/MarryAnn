<?php



$facebook = new Facebook(array(
		'appId' => '170161316509571',
		'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
		'cookie' =>true
));

if(isset($_GET['logout'])=='1'){
	$facebook->destroySession();

	header("location:http://colors-studios.com/fb-test/login.php");
}

$session = $facebook->getUser();
$me = NULL;
if($session) {
	try {
		$me = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		echo $e->getMessage();
	}
}
//this can be put in the html code
if($me) {
	echo 'back';
}else{
	$params = array('scope' => 'read_stream,publish_stream,publish_actions,manage_pages,email,user_checkins,user_birthday');
	$loginURL = $facebook->getLoginUrl($params);
	echo "<a href='$loginURL'>
	<button>LOGIN</button>
	</a>";
}
?>