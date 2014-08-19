<?php
/*
 * Sign_out Controller
 */
class Sign_out extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
	}

	/**
	 * Account sign out
	 *
	 * @access public
	 * @return void
	 */
	function index()
	{
            $this->load->library(array('account/authentication', 'account/authorization'));
//            unset($_SESSION['fb_id']);
            $this->authentication->sign_out();
            redirect(base_url());
//		// Redirect signed out users to homepage
//		if ( ! $this->authentication->is_signed_in()) redirect('');
//
//		// Run sign out routine
//		$this->authentication->sign_out();
//
//		// Redirect to homepage
//		if ( ! $this->config->item("sign_out_view_enabled")) redirect('');
//
//		// Load sign out view
//		$this->load->view('sign_out');
	}

}


/* End of file sign_out.php */
/* Location: ./application/account/controllers/sign_out.php */