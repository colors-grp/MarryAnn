<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// $config['appId']  = 'APP_ID'; 
// $config['secret'] = 'APP_SECRET';// Colors studios App
$config['appId']   = '170161316509571';
$config['secret']  = '92fcf6d4ac1dc115b01755afaacd4f9f';//https://developers.facebook.com/docs/reference/php/facebook-getLoginUrl/
$config['facebook_login_parameters'] = array(		// Here we put the permissioms H7 needs from Facebook ...
		'scope' => 'user_actions:music, user_likes, friends_likes',		// Know what display is ?? ...
		'display' => 'page'
);