<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class fan_page_upload extends CI_Controller {
	public function index()
	{
		// Remove the headers (data:,) part.
		$filteredData=substr($GLOBALS['HTTP_RAW_POST_DATA'], strpos($GLOBALS['HTTP_RAW_POST_DATA'], ",")+1);
		
		// Need to decode before saving since the data we received is already base64 encoded
		$decodedData=base64_decode($filteredData);
		
		$fp = fopen( '/home/hitsevey/public_html/SS/h7-assets/resources/img/uploads/test.png', 'wb' );
		fwrite( $fp, $decodedData);
		fclose( $fp );
	}
	
	function post_to_FB(){
		$this->load->helper('url');
		
		$app_id = "170161316509571";
		$app_secret = "92fcf6d4ac1dc115b01755afaacd4f9f";
		$post_login_url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		$album_name = 'Super Fanos';
		$album_description = 'Fanousize your picture with SuperSayem';
		
		
	//Obtain the access_token with publish_stream permission
	if(isset($_REQUEST["code"]))
		$code = $_REQUEST["code"];

    //Obtain the access_token with publish_stream permission 
    if(empty($code)) {
        $dialog_url= "http://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($post_login_url) . "&scope=publish_stream";
        echo("<script>top.location.href='" . $dialog_url . "'</script>");
        exit;
    }

    // Make sure you have read & write access to this folder
    $tmpfile = "/home/hitsevey/public_html/SS/h7-assets/resources/img/uploads/test.png";

    $token_url= "https://graph.facebook.com/oauth/access_token?client_id=" .  $app_id . "&redirect_uri=" . urlencode($post_login_url) . "&client_secret=" . $app_secret . "&code=" . $code;
    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);
    $access_token = $params['access_token'];

    $flag = false;
    
    for ($i = 0; $i < count($_SESSION['albums_names']); $i++) {
    	if($_SESSION['albums_names'][$i] == 'Super Fanos'){
    		$flag = true;
    		$id = $i;
    	}
    }
    
    if($flag == false){
    	// Create a new album
    	$graph_url = "https://graph.facebook.com/me/albums?access_token=". $access_token;
	
	    $postdata = http_build_query(array('name'=>$album_name,'message'=>$album_description));
	    $opts = array('http'=>array('method'=>'POST','header'=>'Content-type: application/x-www-form-urlencoded','content' => $postdata));
	    $context  = stream_context_create($opts);
	    $result = json_decode(file_get_contents($graph_url, false, $context));
	
	    // Get the new album ID
	    $album_id = $result->id;
    }else{
    	$album_id = $_SESSION['albums_ids'][$id];
    }
    
    //upload photo
    $args = array('message'=>'دوس وخد سيلفي مع الفانوس '."\n".'www.supersayem.com'."\n".'#سوبرصايم');
    $args[basename($tmpfile)] = '@' . realpath($tmpfile);

    $ch = curl_init();
    $url = 'https://graph.facebook.com/' . $album_id . '/photos?access_token=' . $access_token;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    $data = curl_exec($ch);

    unlink($tmpfile);

    
/*    $response = $this->facebook->api(
    		'me/hitsevenapp:took_a_selfie',
    		'POST',
    		array(
    				'fanous' => "www.supersayem.com"
    		)
    );
    
    print_r($response);
  */  
    redirect('uploaded_successfully');

	}
}