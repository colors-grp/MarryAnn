<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {
	function notify() {
		// Push The notification with parameters
		$this->load->library('PushBots');
		$pb = new PushBots();
		// Application ID
		$appID = '53747f541d0ab1d1048b456f';
		// Application Secret
		$appSecret = '194edd35736f9af60c6261f444590c6d';
		$pb->App($appID, $appSecret);
		// Notification msg
		$name = 'The Colors Concorrenza';
		$msg="Hey, we have got a new msg from $name!";
		$pb->Alert($msg);
		$platforms= array(0);
		$pb->Platform($platforms);
		// Push it !
		$pb->Push();
	}
}