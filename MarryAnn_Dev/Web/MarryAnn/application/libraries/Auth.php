<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Auth {

	protected $CI;
	
	function __construct () {
		$this->CI =& get_instance();
	}
	
	function is_logged_in() {
		$is_logged_in = $this->CI->session->userdata('is_logged_in');
		if (!isset($is_logged_in) || $is_logged_in != TRUE ) {
			$this->CI->session->set_flashdata('message', '<div class="error_message">Try logging in first.</div>');
			redirect(base_url(), 'location');
		}
	}
	function getLoginURL()
	{
		$this->rest->initialize(array(
				'server' => 'http://colors-studios.com/core/index.php?/api/h7fb/',
				'http_user' => '',
				'http_pass' => '',
				'http_auth' => 'basic' // or 'digest'
		));
	
	
		//$platform_url = $this->platform_fbutils->encryptIt(base_url());
		return $this->rest->get('loginurl', array('platform_url' => $platform_url), 'json');
		//return $this->config->item('facebook_login_parameters');
		//return $this->facebook->getLoginURL($this->config->item('facebook_login_parameters'));
	}
	function logout() { 
		$this->CI->session->sess_destroy();
		$this->CI->facebook->destroySession();
		session_destroy();
		
		$this->CI->load->model('platform_fbutils');
		$result = $this->CI->platform_fbutils->get_logout_url();
		echo $result['logout_url'];
		if ($result['is_true']) {
			redirect($result['logout_url'], 'location');
		} else {
			redirect(base_url(), 'location');
		}
	}
}