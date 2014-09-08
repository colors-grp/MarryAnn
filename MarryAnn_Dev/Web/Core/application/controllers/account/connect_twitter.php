<?php
/*
 * Connect_twitter Controller
 */
class Connect_twitter extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
		$this->load->library(array('account/authentication', 'account/authorization', 'account/twitter_lib'));
		$this->load->model(array('account/account_model', 'account/account_twitter_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}

	function index()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
                

		if ($this->input->get('oauth_token'))
		{
			try
			{
                            log_message('error','inside try');
				// Perform token exchange
				$this->twitter_lib->etw->setToken($this->input->get('oauth_token'));
                            log_message('error','after $this->twitter_lib->etw->setToken');
				$twitter_token = $this->twitter_lib->etw->getAccessToken();
                            log_message('error','after $twitter_token = '.  print_r($twitter_token,1));
				$this->twitter_lib->etw->setToken($twitter_token->oauth_token, $twitter_token->oauth_token_secret);
                            log_message('error','after $this->twitter_lib->etw->setToken');
				// Get account credentials
				$twitter_info = $this->twitter_lib->etw->get_accountVerify_credentials()->response;
                            log_message('error','after $twitter_info = '.  print_r($twitter_info,1));
			} catch (Exception $e)
                        {
                                log_message('error','inside catch');
				//$this->authentication->is_signed_in() ? redirect('account/account_linked') : redirect('account/sign_up');
                                if($this->authentication->is_signed_in()){
                                    $redirect_url =  $this->authentication->getSiteUrl($this->session->userdata('sitecode'));
                                    //redirect($redirect_url);
                                }
			}
                        log_message('error','before $user from DB= '.  print_r($this->account_twitter_model->get_by_twitter_id($twitter_info['id']),1));
			// Check if user has connect twitter to a3m
			if ($user = $this->account_twitter_model->get_by_twitter_id($twitter_info['id']))
			{
				// Check if user is not signed in on a3m
				if ( ! $this->authentication->is_signed_in())
				{
					// Run sign in routine
					$this->authentication->sign_in($user->account_id);
				}
				$user->account_id === $this->session->userdata('account_id') ? $this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_this_account'), lang('connect_twitter'))) : $this->session->set_flashdata('linked_error', sprintf(lang('linked_linked_with_another_account'), lang('connect_twitter')));
				$redirect_url =  $this->authentication->getSiteUrl($this->session->userdata('sitecode')). '?accountid='.$user->account_id.'&mode=2';
                                //redirect('account/account_linked');
			}
			// The user has not connect twitter to a3m
			else
			{
                            log_message('error','inside user has no twitter account');
                            log_message('error','before is user signed in = '.  print_r($this->authentication->is_signed_in(),1));
				// Check if user is signed in on a3m
				if ( ! $this->authentication->is_signed_in())
				{
					// Store user's twitter data in session
					$this->session->set_userdata('connect_create', array(array('provider' => 'twitter', 'provider_id' => $twitter_info['id'], 'username' => $twitter_info['screen_name'], 'token' => $twitter_token->oauth_token, 'secret' => $twitter_token->oauth_token_secret), array('fullname' => $twitter_info['name'], 'picture' => $twitter_info['profile_image_url'])));
                                        log_message('error','after set user data into session='.  print_r($this->session->userdata('connect_create'),1));
					// Create a3m account
					redirect('account/connect_create');
				}
				else
				{
					// Connect twitter to a3m
					$this->account_twitter_model->insert($this->session->userdata('account_id'), $twitter_info['id'], $twitter_token->oauth_token, $twitter_token->oauth_token_secret);
					$this->session->set_flashdata('linked_info', sprintf(lang('linked_linked_with_your_account'), lang('connect_twitter')));
					$redirect_url =  $this->authentication->getSiteUrl($this->session->userdata('sitecode')). '?accountid='.$user->account_id.'&mode=2';
                                        //redirect('account/account_linked');
				}
			}
                        log_message('error','user twitter account connected to a3m $redirect_url='.print_r($redirect_url,1));
                        redirect($redirect_url);
		}

		// Redirect to authorize url
		header("Location: ".$this->twitter_lib->etw->getAuthenticateUrl());
	}

}


/* End of file connect_twitter.php */
/* Location: ./application/controllers/account/connect_twitter.php */
