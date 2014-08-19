<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication {

	var $CI;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// Obtain a reference to the ci super object
		$this->CI =& get_instance();

		$this->CI->load->library('session');
	}

	// --------------------------------------------------------------------

	/**
	 * Check user signin status
	 *
	 * @access public
	 * @return bool
	 */
	function is_signed_in()
	{
		return $this->CI->session->userdata('account_id') ? TRUE : FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Sign user in
	 *
	 * @access public
	 * @param int  $account_id
	 * @param bool $remember
	 * @return void
	 */
	function sign_in($account_id, $remember = FALSE)
	{
		log_message('error', 'Started Sign In ... account id = '.$account_id);
		$remember ? $this->CI->session->cookie_monster(TRUE) : $this->CI->session->cookie_monster(FALSE);

		$this->CI->session->set_userdata('account_id', $account_id);

		//$this->CI->load->model('account/account_model');

		//$this->CI->core_call->update_last_signed_in_datetime($account_id);

		
		// Redirect signed in user with session redirect
		if ($redirect = $this->CI->session->userdata('sign_in_redirect'))
		{
			$this->CI->session->unset_userdata('sign_in_redirect');
			
			log_message('error', 'redirect 1 == ' .$redirect);
			redirect($redirect);
		}
		// Redirect signed in user with GET continue
		elseif ($this->CI->input->get('continue'))
		{
			log_message('error', 'redirect  2 == ' .$this->CI->input->get('continue'));
			redirect($this->CI->input->get('continue'));
		}

		log_message('error', 'redirect 3 == 3adah ');
		redirect('');
	}

	// --------------------------------------------------------------------

	/**
	 * Sign user out
	 *
	 * @access public
	 * @return void
	 */
	function sign_out()
	{
		$this->CI->session->unset_userdata('account_id');
		$this->CI->session->sess_destroy();
	}

	// --------------------------------------------------------------------

	/**
	 * Check password validity
	 *
	 * @access public
	 * @param object $account
	 * @param string $password
	 * @return bool
	 */
	function check_password($password_hash, $password)
	{
		$this->CI->load->helper('account/phpass');

		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

		return $hasher->CheckPassword($password, $password_hash) ? TRUE : FALSE;
	}
	
	/**
	 * Anchor Link
	 *
	 * Creates an anchor based on the local URL.
	 *
	 * @access	public
	 * @param	string	the URL
	 * @param	string	the link title
	 * @param	mixed	any attributes
	 * @return	string
	 */
	function anchorToCore($uri = '', $title = '', $attributes = '')
	{
		//$core_url = 'http://colors-studios.com/a3m';
		$core_url = $this->CI->config->item('core_url');
		
		$title = (string) $title;
	
		if ( ! is_array($uri))
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? $core_url . 'index.php?'. $uri : $uri;
		}
		else
		{
			$site_url = $core_url . '/index.php?'. $uri;
		}
	
		if ($title == '')
		{
			$title = $site_url;
		}
	
		if ($attributes != '')
		{
			$attributes = _parse_attributes($attributes);
		}
	
		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
	}

}


/* End of file Authentication.php */
/* Location: ./application/account/libraries/Authentication.php */