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
	
	function getcredit_get() {
		log_message('error', 'bteeg fi get credit ?');
		// Get user facebook id
		$user_id = $this->get('user_id');
		// Load the credit model and get user credit from database
		$this->load->model('credit_model');
		$rValue['data'] = $this->credit_model->get_credit($user_id);
		
		if($rValue['data'])
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
                //log_message('error', 'mo7eb h7fb getFacebookID $user_id='.$user_id);
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
		
		if($this->credit_model->buy_credit($user_id, $credit))
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
		$this->load->model(array('account/account_facebook_model'));
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
	
}