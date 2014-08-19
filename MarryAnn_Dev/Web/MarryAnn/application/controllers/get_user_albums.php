<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class get_user_albums extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('facebook');
	}
	
	public function index()
	{
		// Get User ID
		$user = $this->facebook->getUser();
		
		if ($user) {
			try {
				// Get the user profile data you have permission to view
				$user_profile = $this->facebook->api('/me');
				 
				$albums = $this->facebook->api('/me/albums');
		
				for($i = 0; $i < count($albums['data']); $i++){
					$_SESSION['albums_names'][$i] = $albums['data'][$i]['name'];
					$_SESSION['albums_ids'][$i] = $albums['data'][$i]['id'];
				}
				 
			} catch (FacebookApiException $e) {
				$user = null;
			}
		} else {
			die('<script>top.location.href="'.$this->facebook->getLoginUrl(array('scope' => 'user_photos', 'redirect_uri' => 'http://dev.hitseven.net/SS/index.php?/get_user_albums')).'";</script>');
		}
		
		$_SESSION['fb_id'] = $user_profile['id'];
		$this->load->view('your_fanos_view');
	}
}