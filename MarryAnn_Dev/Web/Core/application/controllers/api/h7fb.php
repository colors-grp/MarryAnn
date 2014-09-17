<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class H7FB extends REST_Controller
{
	// Call facebook to get the login URL and pass it back to the platform ...
	function loginurl_get()
	{
		// Load core_fbutils ... 
		$this->load->model('core_fbutils');
		 
		// Set the redirect URL which facebook will return to after logging in ...
		// base_url (is the URL of the CORE -> send you to Core.php.index())
		// Add Sitecode parameter to send the platform URL to Core
		// ex: "http://www.colors-studios.com/core" . '?' . "&sitecode=" . encrypted ("http://www.colors-grp.com/test1") ...
// 		$redirect_uri = base_url() . '?'. '&sitecode=' . $this->get('platform_url');
		$redirect_uri = base_url() . '?'. 'sitecode=' . $this->get('platform_url');

// 		$redirect_uri = base_url();

		// get the login url from facebook with the configured return uri
		$loginurl = $this->facebook->getLoginUrl(array('redirect_uri' => "$redirect_uri", 'scope' => 'email,read_friendlists')); // , 'sitecode' => $this->get('platform_url') 
		
		if($loginurl)
		{
			$this->response($loginurl, 200); // 200 being the HTTP response code
		}

		else
		{
			$this->response(array('error' => 'Couldn\'t find any users!'), 404);
		}
	}
	
//    mobile functions
    // Insert new user into database
    // http://hitseven.net/index.php?/api/h7fb/mobileAddMe/username//firstname//lastname//email//credit//birthday/dd-mm-yyyy/fb_id//token//format/json
	function mobileAddMe_get() {
            log_message('error', 'bteeg fi get mobileAddMe ?');
            $username = $this->get('username');
            $data['firstname'] = $firstname = $this->get('firstname');
            $data['lastname'] = $lastname = $this->get('lastname');
            $data['fullname'] = $fullname = $firstname. ' ' .$lastname;
            $email = $this->get('email');
            if(strpos($email, ':')){
                $email = substr($email, 0 ,strrpos( $email , ':')). '@' . substr($email, strrpos( $email , ':') + 1);
            } else {
                $email = substr($email, 0 ,strrpos( $email , '%')). '@' . substr($email, strrpos( $email , '%') + 1);
            }
            $data['dateofbirth'] = $birthday = $this->get('birthday');
            $credit = (is_numeric($this->get('credit')))?$this->get('credit'):0;
            $fb_id = $this->get('fb_id');
            $token = $this->get('token');
        // -----------------
        // Load Needed models
            $this->load->model(array('account/account_model','account/account_details_model','account/account_facebook_model'));
        // Get user's data from facebook table then insert if not exists
            $result = $this->account_facebook_model->get_by_facebook_id($fb_id);
            if(!$result){
                // insert in a3m_account
                    $user_id = $this->account_model->create($username, $email, $birthday,$credit);//, $competition->start_credit);
                // Add user details
                    $this->account_details_model->update($user_id, $data);
                // Add user facebook data
                    $this->account_facebook_model->insert($user_id, $fb_id, $token);
            } else {
                $user_id = $result->account_id;
            }
             // --------------
        // response acts as "return" for the function
            if(!$user_id){
                $user_id = -1;
            }
            log_message('error', 'mobileAddMe user_id='.$user_id.' $result='.print_r($result,TRUE));
            $ret['accountId'] = $user_id;
            $this->response($ret , 200);
//            $this->response($user_id , 200);
	}
    // Get Facebook IDs of given user IDs
    // http://hitseven.net/index.php?/api/h7fb/mobileAddMe/users_ids/$users_ids_encrypted_with_json_then_base64/format/json
        function mobileGetFacebookIDs_get() {
		log_message('error', 'bteeg fi get mobileGetFacebookIDs ?');
            // Get user facebook id
		$users_ids_encrypted = $this->get('users_ids');
                $users_ids = json_decode(base64_decode($users_ids_encrypted));
                log_message('error','mo7eb h7fb mobileGetFacebookIDs $user_ids='.  print_r($users_ids,TRUE));
            // Load the credit model and get user credit from database
		$this->load->model('account/account_facebook_model');
		$rValue['data'] = $this->account_facebook_model->get_by_array_facebook_ids($users_ids);
            // order returned fb_ids to be the same order of $users_ids
                $temp = array();
                foreach($users_ids as $account_id){
                    foreach($rValue['data'] as $recored){
                        if($account_id == $recored['account_id']){
                            array_push($temp, array( 'user_id' => $account_id, 'fb_id' => $recored['facebook_id']));
                        }
                    }
                }
                $rValue['data'] = $temp;
                log_message('error','mo7eb h7fb mobileGetFacebookIDs $rValue[data]='.print_r($rValue['data'],TRUE));
                $ret['fb_ids'] = $temp;
            // response acts as "return" for the function
		$this->response($ret, 200);
	}
    // Get user's Facebook friends
    // if wrong fb_id it returns -1, 
    // http://hitseven.net/index.php?/api/h7fb/mobileAddMe/fb_id//format/json
        function mobileGetCommonFacebookFriends_get() {
		log_message('error', 'h7fb mobileGetCommonFacebookFriends_get FBBBBB Entered method = ');
            // Get parameters sent from platform
		$fb_id = $this->get('fb_id');
                //echo $accountid;
		log_message('error', 'h7fb mobileGetCommonFacebookFriends_get $accountid === '. $fb_id);
            // Load needed models
		$this->load->model('account/account_model');
		$this->load->model('account/account_facebook_model');
            // Get fb and access token id from a3m_account table
		$fb = $this->account_facebook_model->get_by_facebook_id($fb_id);
//                echo print_r($fb,TRUE);
                log_message('error','mo7eb htfb mobileGetCommonFacebookFriends_get $fb='.  print_r($fb,TRUE));
            // Get fb friends from facebook using fb_id and fb_token
                if(count($fb) > 0){
                    $fb_friends = $this->account_facebook_model->getFriends($fb->facebook_id, $fb->token);
                    log_message('error', 'h7fb mobileGetCommonFacebookFriends_get $fb_friends=' . print_r($fb_friends,TRUE));
                // Filter facebook_ids column in a side array so can be used with selection from database
                    $fb_ids = array();
                    $i = 0;
                    foreach($fb_friends['data'] as $recored){
                        $fb_ids[$i] = $recored['id'];
                        $i++;
                    }
                    log_message('error','mo7eb h7fb mobileGetCommonFacebookFriends_get $fb_ids='.  print_r($fb_ids,TRUE));
                // Get account_id, fb_id, fullname from database tables using $fb_firends->fb_id
                    $rValue['data'] = json_encode($this->account_facebook_model->get_details_by_array_facebook_ids($fb_ids));
                    log_message('error','mo7eb h7fb mobileGetCommonFacebookFriends_get $rValue[data]='.$rValue['data']);
                    if(!$rValue['data'])
                    {
                            $rValue['data'] = -1;
                    }
                } else {
                    $rValue['data'] = -1;
                }
                $ret['friends_fb_ids'] = $rValue['data'];
            // response acts as "return" for the function
		$this->response($ret, 200);
	}
//    end of mobile functions
	function getcredit_get() {
		log_message('error', 'bteeg fi get credit ?');
		// Get user facebook id
		$user_id = $this->get('user_id');
		// Load the credit model and get user credit from database
		$this->load->model('credit_model');
		$rValue['data'] = $this->credit_model->get_credit($user_id);
		if($rValue['data'] == 0 && is_numeric($rValue['data'])){
                    $rValue['invoke'] = TRUE;
                }
		elseif($rValue['data'])
		{
			$rValue['invoke'] = TRUE;
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get User Credit';
		}
		log_message('error', ' rvalueeeee==== ' . print_r($rValue, TRUE));
		// response acts as "return" for the function
		$this->response($rValue);
	}
        
        function getFacebookID_get() {
		log_message('error', 'bteeg fi get getFacebookID ?');
                // Get user facebook id
		$user_id = $this->get('user_id');
                log_message('error', 'mo7eb h7fb getFacebookID $user_id='.$user_id);
		// Load the credit model and get user credit from database
		$this->load->model('account/account_facebook_model');
		$rValue['data'] = $this->account_facebook_model->get_by_account_id($user_id);
		
		if($rValue['data'])
		{
			$rValue['invoke'] = TRUE;
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get User Facebook ID';
		}
		
		log_message('error', 'h7fb getFacebookID rvalueeeee==== ' . print_r($rValue, TRUE));
		// response acts as "return" for the function
		$this->response($rValue);
	}
        
        function getFacebookIDs_get() {
		log_message('error', 'bteeg fi get getFacebookIDs ?');
                // Get user facebook id
		$users_ids_encrypted = $this->get('users_ids');
                $users_ids = json_decode(base64_decode($users_ids_encrypted));
                
                log_message('error','mo7eb h7fb getFacebookIDs_get $user_ids='.  print_r($users_ids,TRUE));
                //log_message('error', 'mo7eb h7fb getFacebookID $user_id='.$user_id);
		// Load the credit model and get user credit from database
		$this->load->model('account/account_facebook_model');
		$rValue['data'] = $this->account_facebook_model->get_by_array_facebook_ids($users_ids);
		// order returned fb_ids to be the same order of $users_ids
                $temp = array();
                foreach($users_ids as $account_id){
                    foreach($rValue['data'] as $recored){
                        if($account_id == $recored['account_id']){
                            array_push($temp, $recored['facebook_id']);
                        }
                    }
                }
                $rValue['data'] = $temp;
                log_message('error','mo7eb h7fb getFacebookIDs_get $rValue[data]='.print_r($rValue['data'],TRUE));
                
		if($rValue['data'])
		{
			$rValue['invoke'] = TRUE;
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get User Facebook ID';
		}
		
		log_message('error', 'h7fb getFacebookID rvalueeeee==== ' . print_r($rValue, TRUE));
		// response acts as "return" for the function
		$this->response($rValue);
	}
	
	function buycredit_get() {
		$user_id = $this->get('user_id');
		$credit = $this->get('credit');
		// Load the credit model and buy credit for user sending the facebook ID
		// and desired credit to be bought
		$this->load->model('credit_model');
		//log_message('error','mo7eb h7fb buy_credit $user_id='.$user_id.'   $credit='.$credit);
		$result = $this->credit_model->buy_credit($user_id, $credit);
                //log_message('error','mo7eb h7fb buy_credit $result='.$result);
                if($result)
		{
			$rValue['invoke'] = TRUE;
			$rValue['data']	= TRUE;
                        
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to Buy User Credit';
		}
		
		// response acts as "return" for the function
		$this->response($rValue);
	}
	
	function getMe_get() {
		$account_id = $this->get('account_id');
		// Load the credit model and buy credit for user sending the facebook ID
		// and desired credit to be bought
		log_message('error', ' get meeeeeeeeee meeee  ' . $account_id);
		$this->load->model('account/account_facebook_model');
		$query = $this->account_facebook_model->get_facebook_me($account_id);
		if($query)
		{
			$rValue['invoke'] = TRUE;
			$rValue['data']	= $query->row();
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get Facebook Me data';
		}
		
		// response acts as "return" for the function
		$this->response($rValue);
	}
    // Get user's data from a3m_account table
	function get_by_id_get() {
		$account_id = $this->get('account_id');
		// Load the credit model and buy credit for user sending the facebook ID
		// and desired credit to be bought
		log_message('error', 'get_by_id  ' . $account_id);
		$this->load->model('account/account_model');
		$query = $this->account_model->get_by_id($account_id);
                //log_message('error','mo7eb h7fb get_by_id_get() $query='.  print_r($query,TRUE));
		if($query)
		{
			$rValue['invoke'] = TRUE;
			$rValue['data']	= json_encode($query);
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get user data from a3m_account';
		}
		
		// response acts as "return" for the function
		$this->response($rValue);
	}
    // Get user's data from a3m_account table
	function get_by_account_id_get() {
		$account_id = $this->get('account_id');
		// Load the credit model and buy credit for user sending the facebook ID
		// and desired credit to be bought
		log_message('error', 'get_by_account_id  ' . $account_id);
		$this->load->model('account/account_details_model');
		$query = $this->account_details_model->get_by_account_id($account_id);
                //log_message('error','mo7eb h7fb get_by_account_id_get() $query='.  print_r($query,TRUE));
		if($query)
		{
			$rValue['invoke'] = TRUE;
			$rValue['data']	= json_encode($query);
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get user details from a3m_account_details';
		}
		
		// response acts as "return" for the function
		$this->response($rValue);
	}
    // Get user's data from a3m_account table
	function fb_get_by_account_id_get() {
		$account_id = $this->get('account_id');
		// Load the credit model and buy credit for user sending the facebook ID
		// and desired credit to be bought
		//log_message('error', 'fb_get_by_account_id  ' . $account_id);
		$this->load->model('account/account_facebook_model');
		$query = $this->account_facebook_model->get_by_account_id($account_id);
                log_message('error','mo7eb h7fb fb_get_by_account_id_get() $query='.  print_r($query,TRUE));
                //$rValue = array();
                
                //log_message('error', 'fb_get_by_account_id gettype($query)='.gettype($query).'  $query' . print_r($query,TRUE)); 
                //log_message('error', 'fb_get_by_account_id count($query)='.count($query));
		if(count($query))
		{
                    //log_message('error', 'fb_get_by_account_id inside');
			$rValue['invoke'] = TRUE;
			$rValue['data']	= json_encode($query);
                      //  log_message('error', 'fb_get_by_account_id json_encode($query->row())='.json_encode($query->row()));
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get user facebook data from a3m_facebook';
                        //log_message('error', 'fb_get_by_account_id $rValue='.print_r($rValue,TRUE));
		}
                log_message('error', 'fb_get_by_account_id  $account_id=' . $account_id . '$rValue='.print_r($rValue,TRUE));
		// response acts as "return" for the function
		$this->response($rValue);
	}
    // Get user's twitter data from a3m_account table
	function tw_get_by_account_id_get() {
		$account_id = $this->get('account_id');
		// Load the credit model and buy credit for user sending the facebook ID
		// and desired credit to be bought
		//log_message('error', 'fb_get_by_account_id  ' . $account_id);
		$this->load->model('account/account_twitter_model');
		$query = $this->account_twitter_model->get_by_account_id($account_id);
                log_message('error','mo7eb h7fb tw_get_by_account_id_get() $query='.  print_r($query,TRUE));
                //$rValue = array();
                
                //log_message('error', 'fb_get_by_account_id gettype($query)='.gettype($query).'  $query' . print_r($query,TRUE)); 
                //log_message('error', 'fb_get_by_account_id count($query)='.count($query));
		if(count($query))
		{
                    //log_message('error', 'fb_get_by_account_id inside');
			$rValue['invoke'] = TRUE;
			$rValue['data']	= json_encode($query);
                      //  log_message('error', 'fb_get_by_account_id json_encode($query->row())='.json_encode($query->row()));
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get user twitter data from a3m_facebook';
                        //log_message('error', 'fb_get_by_account_id $rValue='.print_r($rValue,TRUE));
		}
                log_message('error', 'tw_get_by_account_id  $account_id=' . $account_id . '$rValue='.print_r($rValue,TRUE));
		// response acts as "return" for the function
		$this->response($rValue);
	}
	
	function friends_get() {
		
		log_message('error', 'FBBBBB Entered the friends method = ');
		// Get parameters sent that are in json format
		$accountid = $this->get('accountid');
		//log_message('error', 'the params before JSON' .$this->get('accountid'));
		log_message('error', '$$accountid === '. $accountid);
		
		// Decode parameters
		//$params = json_decode($jsn_params);
		//$accountid = $params->accountid;
		log_message('error', 'FBBBBB account id = '. $accountid);
		// Load the credit model and buy credit for user sending the facebook ID
		// and desired credit to be bought
		$this->load->model(array('account/account_model'));
		$this->load->model(array('account/account_facebook_model'));
		
		$fb = $this->account_facebook_model->get_by_account_id($accountid);
		
		log_message('error', '$FB variable ==== '.json_encode($fb[0]));
		$rValue['data'] = json_encode($this->account_facebook_model->getFriends($fb[0]->facebook_id, $fb[0]->token));
	
		log_message('error', 'h7fb friends_get $rValue[data]=' . print_r($rValue['data'],TRUE));
		//log_message('error', 'FBBBBB data = '. $rValue['data']);
		
		
		if($rValue['data'])
		{
			$rValue['invoke'] = TRUE;
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to Get Users Facebook Friends';
		}
	
		// response acts as "return" for the function
		$this->response($rValue);
	}
        
        //Gets Common Friends between Users facebook friends and users in a3m_account table
        function getCommonFriends_get(){
		log_message('error', 'h7fb getCommonFriends FBBBBB Entered method = ');
		// Get parameters sent from platform
		$accountid = $this->get('accountid');
		log_message('error', 'h7fb getCommonFriends $accountid === '. $accountid);
		// Load needed models
		$this->load->model('account/account_model');
		$this->load->model('account/account_facebook_model');
		// Get fb and access token id from a3m_account table
		$fb = $this->account_facebook_model->get_by_facebook_id($accountid);
                log_message('error','mo7eb htfb getCommonFriends $fb='.  print_r($fb,TRUE));
		// Get fb friends from facebook using fb_id and fb_token
		$fb_friends = $this->account_facebook_model->getFriends($fb->facebook_id, $fb->token);
		log_message('error', 'h7fb getCommonFriends $fb_friends=' . print_r($fb_friends,TRUE));
		// Filter facebook_ids column in a side array so can be used with selection from database
                $fb_ids = array();
                $i = 0;
                foreach($fb_friends['data'] as $recored){
                    $fb_ids[$i] = $recored['id'];
                    $i++;
                }
                log_message('error','mo7eb h7fb getCommonFriends $fb_ids='.  print_r($fb_ids,TRUE));
                // Get account_id, fb_id, fullname from database tables using $fb_firends->fb_id
                $rValue['data'] = json_encode($this->account_facebook_model->get_details_by_array_facebook_ids($fb_ids));
		log_message('error','mo7eb h7fb getCommonFriends $rValue[data]='.$rValue['data']);
		
                if($rValue['data'])
		{
			$rValue['invoke'] = TRUE;
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to Get Users Facebook Friends';
		}
	
		// response acts as "return" for the function
		$this->response($rValue);
	}
	
	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
        
        function signOut_get() {
		log_message('error', 'bteeg fi get signOut ?');
                // Get user facebook id
		$user_id = $this->get('user_id');
//                log_message('error', 'mo7eb h7fb signOut $user_id='.$user_id);
		// Load the credit model and get user credit from database
		$this->load->model('account/account_facebook_model');
                log_message('error','h7fb signOut $user_id='.$user_id);
		$rValue['data'] = $this->account_facebook_model->sign_out($user_id);
		
		if($rValue['data'])
		{
			$rValue['invoke'] = TRUE;
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get User Facebook ID';
		}
		
//		log_message('error', 'h7fb getFacebookID rvalueeeee==== ' . print_r($rValue, TRUE));
		// response acts as "return" for the function
		$this->response($rValue);
	}
	
        function get_user_access_token_get() {
		log_message('error', 'bteeg fi get get_user_access_token ?');
                // Get user facebook id
		$user_id = $this->get('user_id');
//                log_message('error', 'mo7eb h7fb signOut $user_id='.$user_id);
		// Load the credit model and get user credit from database
		$this->load->model('account/account_facebook_model');
                log_message('error','posting user_iddddddddddddd ='.$user_id);
		$rValue['data'] = $this->account_facebook_model->get_user_access_token($user_id);
                $rValue['data'] = $rValue['data'][0]['token'];
		log_message('error','posting tokennnnnnnnn='.$rValue['data']);
		if($rValue['data']) 
		{
			$rValue['invoke'] = TRUE;
		}
		else
		{
			$rValue['invoke'] = FALSE;
			$rValue['error'] = 'Unable to get User Facebook ID';
		}
		
//		log_message('error', 'h7fb getFacebookID rvalueeeee==== ' . print_r($rValue, TRUE));
		// response acts as "return" for the function
		$this->response($rValue);
	}
		
		function post_story_get($category_id, $user_id) {
		$category_id = $this -> get('category_id');
		$user_id = $this -> get('user_id');
		
		$this -> load -> model('account/account_facebook_model');
		log_message('error', 'posting user_iddddddddddddd =' . $user_id);
		//$rValue['data'] = $this -> account_facebook_model -> get_user_access_token($user_id);
		$stuff = $this -> account_facebook_model -> get_user_access_token($user_id);
		//echo $stuff[0]['token'];
		//log_message('error', '$rValue[data] ' . print_r( $stuff,TRUE));
		
		
		$access_token =  $stuff[0]['token'];
		
		$this->load->library(array('account/facebook_lib'));

		$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
		));
		
		//echo $category_id  . '    ' . $access_token;
		if ($category_id != -1) {
			
			$this -> load -> helper('url');
			if ($category_id == 1) {
				log_message('error', 'NOUR, gwa el if cat id = ' . $category_id);
				try {
							$this->load->library(array('account/facebook_lib'));

		$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
		));
					$facebook -> setAccessToken($access_token);
					$response = $facebook -> api('me/hitsevenapp:play', 'POST', array('sally_syamak_game' => array('og:url' => 'https://apps.facebook.com/hitsevenapp/', 'og:title' => 'سوبر صايم - سلي صيامك', 'og:image' => base_url() . 'h7-assets/resources/img/categories/sally.png', 'og:description' => 'كل يوم لعبة جديدة تجمع فيها الكلمات وتختبر تركيزك'
					//'og:access_token' => 'CAACawsTTN4MBAGaAHHYaXDsnXaG3bc1zcHtlND6YjRR6SO1yxPKhVhAvJ8kNkvM1duZAjZAior426ft6fG9rztaoxkPVs7LesHPAMnhsIY2x4hsk4cHeBH6WTDUxeqEmjMN5XJbKvMhIHHKfoZCmZCnLfcvkuV8NRoZBtrYnF90UZAIem6sHyu'
					)));
				} catch(FacebookApiException $e) {
					log_message('error', 'NOUR, gwa el catch ' . $e);
				}

			} elseif ($category_id == 2) {
				log_message('error', 'NOUR, gwa el if cat id = ' . $category_id);
				try {
							$this->load->library(array('account/facebook_lib'));

		$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
		));
					$facebook -> setAccessToken($access_token);
					$response = $facebook -> api('me/hitsevenapp:solve', 'POST', array('moslsalat_quiz' => array('og:url' => 'https://apps.facebook.com/hitsevenapp/', 'og:title' => 'سوبر صايم - مسلسلات', 'og:image' => base_url() . 'h7-assets/resources/img/categories/mosalsalat.png', 'og:description' => 'كل يوم اسئلة عن مسلسل جديد وشوف إنت فاكر قد إيه منه'
					//	'og:access_token' => 'CAACawsTTN4MBAGaAHHYaXDsnXaG3bc1zcHtlND6YjRR6SO1yxPKhVhAvJ8kNkvM1duZAjZAior426ft6fG9rztaoxkPVs7LesHPAMnhsIY2x4hsk4cHeBH6WTDUxeqEmjMN5XJbKvMhIHHKfoZCmZCnLfcvkuV8NRoZBtrYnF90UZAIem6sHyu'
					)));
				} catch(FacebookApiException $e) {
					log_message('error', 'NOUR, gwa el catch ' . $e);
				}

			} elseif ($category_id == 3) {
				log_message('error', 'NOUR, gwa el if cat id = ' . $category_id);
				try {
							$this->load->library(array('account/facebook_lib'));

		$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
		));
					$facebook -> setAccessToken($access_token);
					$response = $facebook -> api('me/hitsevenapp:find', 'POST', array('new_weapon' => array('og:url' => 'https://apps.facebook.com/hitsevenapp/', 'og:title' => 'سوبر صايم - فين السلاح؟', 'og:image' => base_url() . 'h7-assets/resources/img/categories/qatel.png', 'og:description' => 'كل يوم جريمة جديدة تساعد فيها المقدم نور الدين يقفش المجرم لما تطلع السلاح من مكان الجريمة'
					//'og:access_token' => 'CAACawsTTN4MBAGaAHHYaXDsnXaG3bc1zcHtlND6YjRR6SO1yxPKhVhAvJ8kNkvM1duZAjZAior426ft6fG9rztaoxkPVs7LesHPAMnhsIY2x4hsk4cHeBH6WTDUxeqEmjMN5XJbKvMhIHHKfoZCmZCnLfcvkuV8NRoZBtrYnF90UZAIem6sHyu'
					)));
				} catch(FacebookApiException $e) {
					log_message('error', 'NOUR, gwa el catch ' . $e);
				}

			} elseif ($category_id == 4) {
				log_message('error', 'NOUR, gwa el if cat id = ' . $category_id);
				try {
							$this->load->library(array('account/facebook_lib'));

		$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
		));
		
					$facebook -> setAccessToken($access_token);
					$response = $facebook -> api('me/hitsevenapp:enjoy', 'POST', array('shahryar_comic' => array('og:url' => 'https://apps.facebook.com/hitsevenapp/', 'og:title' => 'سوبر صايم - ألف ليلة وليلة (٣٠ زوجة لشهريار)', 'og:image' => base_url() . 'h7-assets/resources/img/categories/alfleila.png', 'og:description' => 'كل يوم حلقة كومكس جديدة نشوف فيها الزوجة هتعمل اه وندور مع شهريار على عصير الخروب'
					//'og:access_token' => 'CAACawsTTN4MBAGaAHHYaXDsnXaG3bc1zcHtlND6YjRR6SO1yxPKhVhAvJ8kNkvM1duZAjZAior426ft6fG9rztaoxkPVs7LesHPAMnhsIY2x4hsk4cHeBH6WTDUxeqEmjMN5XJbKvMhIHHKfoZCmZCnLfcvkuV8NRoZBtrYnF90UZAIem6sHyu'
					)));
				} catch(FacebookApiException $e) {
					log_message('error', 'NOUR, gwa el catch ' . $e);
				}

			}
		} else {
			log_message('error', 'NOUR cat id = -1');
		}
	}

        function post4me_get($user_id, $message) {

            $user_id = $this -> get('user_id');
            $message = base64_decode(urldecode($this -> get('message')));

            $this -> load -> model('account/account_facebook_model');
            log_message('error', 'posting user_iddddddddddddd =' . $user_id);
            log_message('error', 'posting $message =' . $message);
            //$rValue['data'] = $this -> account_facebook_model -> get_user_access_token($user_id);
            $stuff = $this -> account_facebook_model -> get_user_access_token($user_id);
            //echo $stuff[0]['token'];
            //log_message('error', '$rValue[data] ' . print_r( $stuff,TRUE));


            $access_token =  $stuff[0]['token'];

            $this->load->library(array('account/facebook_lib'));

            $facebook = new Facebook(array(
                            'appId' => '170161316509571',
                            'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
                            'cookie' =>true
            ));


            $this -> load -> helper('url');


            try {

            $this->load->library(array('account/facebook_lib'));

            $facebook = new Facebook(array(
                            'appId' => '170161316509571',
                            'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
                            'cookie' =>true
            ));
                    $facebook -> setAccessToken($access_token);
                    $response = $facebook -> api('/me/feed', 'POST', array('message' => $message
                    //'og:access_token' => 'CAACawsTTN4MBAGaAHHYaXDsnXaG3bc1zcHtlND6YjRR6SO1yxPKhVhAvJ8kNkvM1duZAjZAior426ft6fG9rztaoxkPVs7LesHPAMnhsIY2x4hsk4cHeBH6WTDUxeqEmjMN5XJbKvMhIHHKfoZCmZCnLfcvkuV8NRoZBtrYnF90UZAIem6sHyu'
                    ));
            } catch(FacebookApiException $e) {
                    log_message('error', 'NOUR, gwa el catch ' . $e);
            }
        }
        
        // Create new record for the given parameters into competition table
        // Input: site url, platform name and platform type.
        // Output: site code.
        function getNewSiteCode_get(){
            $data_input = json_decode(urldecode($this->get('data')), true);
            // Load the credit model and buy credit for user sending the facebook ID
            // and desired credit to be bought
            $this->load->model('competition_model');
            log_message('error', 'getNewSiteCode  $data_input=' . print_r($data_input,1));
            $temp = $this->competition_model->get_competition_by_url($data_input['url']);
            log_message('error', 'getNewSiteCode  $data=' . print_r($temp,1));
            if( !count($temp) ){
                $id = $this->competition_model->create($data_input);
            } else {
                $id = $temp[0]['id'];
            }
            $data = $this->competition_model->get_competition_by_url($data_input['url']);
            if($id)
            {
                    $rValue['invoke'] = TRUE;
                    $rValue['data']	= urlencode(json_encode($data));
            }
            else
            {
                    $rValue['invoke'] = FALSE;
                    $rValue['error'] = 'Error while accessing database';
            }
            log_message('error', 'getNewSiteCode_get response $rValue=' . print_r($rValue,1));
            // response acts as "return" for the function
            $this->response($rValue);
        }
        
        function updatePlatformName_get(){
            $data_input = json_decode(urldecode($this->get('data')), true);
            // Load the credit model and buy credit for user sending the facebook ID
            // and desired credit to be bought
            $this->load->model('competition_model');
            log_message('error', 'updatePlatformName  $data_input=' . print_r($data_input,1));
            $data = array( 'name' => $data_input['name'] );
            $result = $this->competition_model->update_competition_name($data_input['id'], $data);
            if($result)
            {
                    $rValue['invoke'] = TRUE;
                    $rValue['data']	= $result;
            }
            else
            {
                    $rValue['invoke'] = FALSE;
                    $rValue['error'] = 'Error while accessing database';
            }
            log_message('error', 'updatePlatformName response $rValue=' . print_r($rValue,1));
            // response acts as "return" for the function
            $this->response($rValue);
        }
}