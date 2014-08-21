<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//https://developers.facebook.com/docs/reference/php/facebook-getLoginUrl/
$config['facebook_login_parameters'] = array(
											'scope' => 'user_actions:music, user_likes, friends_likes',
											'display' => 'page'
											);$config['encryption_key'] = 'qJB0rGtIn5UB1xG03efyCp';