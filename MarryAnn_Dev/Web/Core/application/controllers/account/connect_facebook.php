<?php
/*
 * Connect_facebook Controller
 */
class Connect_facebook extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model(array('account/account_model', 'account/account_facebook_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/account_linked', 'account/connect_third_party'));
	}

	function index()
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));

		// Load facebook redirect view
		redirect('account/redirect_fb');
// 		$this->load->view("account/redirect_fb");
		
	}

}

/* End of file connect_facebook.php */
/* Location: ./application/account/controllers/connect_facebook.php */
