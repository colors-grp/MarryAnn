<?php
/*
 * Connect_facebook Controller
*/
class redirect_fb extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
		$this->load->library(array('account/authentication', 'account/authorization', 'account/facebook_lib'));
		$this->load->model(array('account/account_model', 'account/account_facebook_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}

	function index()
	{
		
		maintain_ssl(TRUE);
		
		$code = $this->input->get('code');
		if($code)
		{
			log_message('error', 'redirect_fb: WELCOME BACK FROM FACEBOOK: ' . $_SESSION['sitecode']);
		}

		$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
		));

//		log_message('error', 'redirect_fb: Site Code: ' . $_SESSION['sitecode']);

		// Try to get a logged in facebook user ID ...
		$fb_id = $facebook->getUser();

		log_message('error', 'redirect_fb: session of user object: ' . $fb_id);
		
		// Array ( [language] => arabic [sitecode] => 6 [fb_170161316509571_state] => ffe41adad40d8f75ca75260b71fe40a8 )
		log_message('error', 'redirect_fb: Check this Session ->>> : ' . print_r($_SESSION, TRUE));

		// Check if facebook user id is obtained ...
		if($fb_id) {
			$me = NULL;
			try {
				$me = $facebook->api('/me');
				log_message('error', 'redirect_fb: me: ' . print_r($me,TRUE));
			} catch (FacebookApiException $e) {
				echo $e->getMessage();
			}
				
			log_message('error', 'redirect_fb: assigned code=1: ' . $me['name']);
				
			// Check if user has connect facebook to a3m
			if ($user = $this->account_facebook_model->get_by_facebook_id($fb_id))
			{
				//$redirect_url =  $this->config->item('core_url') . 'index.php?accountid='.$user->account_id;

				//log_message('error', 'redirect_fb:  user has connect facebook to a3m::  ' .$redirect_url);
				// Redirect to Platform with account ID parameter ...
				$redirect_url =  $this->authentication->getSiteUrl($_SESSION['sitecode']). '?accountid='.$user->account_id;
                                $this->account_facebook_model->update_user_token($fb_id, $facebook->getAccessToken());
				redirect($redirect_url);
				//redirect('http://colors-studios.com/jlaw/index.php?accountid='.$user->account_id);
			}
			// The user has not connect facebook to a3m
			else
			{
				log_message('error', 'redirect_fb:  user has NOTTT connect facebook to a3m' );
				// Check if user is signed in on a3m
// 				if ( ! $this->authentication->is_signed_in())
// 				{
					// Store user's facebook data in session
                                if(!isset($me['email'])){$me['email'] = 'default@default.default';}
                                if(!isset($me['gender'])){$me['gender'] = 'male';}
					$this->session->set_userdata('connect_create', array(array('provider' => 'facebook', 'provider_id' => $me['id'], 'provider_UN' => $me['name'], 'provider_email' => $me['email'], 'access_token' => $facebook->getAccessToken()), array('fullname' => $me['name'], 'firstname' => $me['first_name'], 'lastname' => $me['last_name'], 'gender' => $me['gender'], 'dateofbirth' => $me['birthday'],	// not a required field, not all users have it set
							'picture' => 'http://graph.facebook.com/'.$facebook->getUser().'/picture'
					)));
						
					log_message('error', 'redirect_fb:  redirecting to connecT_cretate' );
					// Create a3m account
					redirect('account/connect_create');
// 				}
// 				else
// 				{
// 					log_message('error', 'redirect_fb:  user is signed in and i am in redirect_fb' );
// 					// Connect facebook to a3m
// 					$this->account_facebook_model->insert($this->session->userdata('account_id'), $this->facebook_lib->user['id']);
// 					$this->session->set_flashdata('linked_info', sprintf(lang('linked_linked_with_your_account'), lang('connect_facebook')));
						
// 					log_message('error', 'redirect_fb:  redirecting to somewhere !!!!' );
// 					// Redirect to Core home with account ID parameter ...
// 					$redirect_url =  $this->config->item('platform_url') . '?accountid='.$this->session->userdata('account_id');
// 					redirect($redirect_url);
// 				}
			}
				
		}else{
			$params = array('scope' => 'email,user_friends,user_birthday,publish_actions');
			$loginURL = $facebook->getLoginUrl($params);
			log_message('error', 'redirect_fb: not $me: here is $loginURL ' . $loginURL);
			redirect($loginURL);
		}
	}
}