<?php

class platform_fbutils extends CI_Model {	// To encrypt a value using the Configured encryption key ...
	function encryptIt( $q ) {
// 		$cryptKey  = $this->config->item('encryption_key'); 
		$qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( 'qJB0rGtIn5UB1xG03efyCp' ), $q, MCRYPT_MODE_CBC, md5( md5( 'qJB0rGtIn5UB1xG03efyCp' ) ) ) );
		return( $qEncoded );
	}
		// To decrypt a value using the Configured encryption key ...
	function decryptIt( $q ) {
// 		$cryptKey  = $this->config->item('encryption_key'); 
		$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( 'qJB0rGtIn5UB1xG03efyCp' ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( 'qJB0rGtIn5UB1xG03efyCp' ) ) ), "\0");
		return( $qDecoded );
	}	// Get the user from facebook + Facebook array data integrity checks ... 
	function get_user() {				// get user ID from facebook ... Ex: 565645764
		$query = $this->facebook->getUser();						// validate output ... and set return array ...		// is_true means that user ID got returned successfully from Facebook ...
		if ($query) {
			$data['is_true'] = TRUE;
			$data['facebook_uid'] = $query;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	// Get access token from facebook ...
	function get_access_token() {
		$query = $this->facebook->getAccessToken();		// Validate ...
		if ($query) {
			$data['is_true'] = TRUE;
			$data['access_token'] = $query;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	// Get API Secret ...
	function get_api_secret() {
		$query = $this->facebook->getApiSecret();		// Validate ...
		if ($query) {
			$data['is_true'] = TRUE;
			$data['api_secret'] = $query;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}	// Weird!
	function get_app_id() {		// To be checked ...
		$query = $this->facebook->getApiSecret();
		if ($query) {
			$data['is_true'] = TRUE;
			$data['app_id'] = $query;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	// Call Facebook to get Logout URL ...	// In case we ever wanted to logout, the URL should be the CORE URL not base_url
	function get_logout_url() {
		$query = $this->facebook->getLogoutUrl(array('next' => base_url()));
		if ($query) {
			$data['is_true'] = TRUE;
			$data['logout_url'] = $query;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	// The code parameter (signed request) ...
	function get_signed_request() {
		$query = $this->facebook->getSignedRequest();
		if ($query) {
			$data['is_true'] = TRUE;
			$data['signed_request'] = $query;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	// Set access token ...
	function set_access_token($access_token) {
		$query = $this->facebook->setAccessToken($access_token);		// Validate ...
		if ($query) {
			$data['is_true'] = TRUE;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	
	function set_api_secret($app_secret) {
		$query = $this->facebook->setApiSecret($app_secret);
		if ($query) {
			$data['is_true'] = TRUE;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	
	function set_app_id($app_id) {
		$query = $this->facebook->setAppId($app_id);
		
		if ($query) {
			$data['is_true'] = TRUE;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}	//function is formatted for the following
	
	//https://graph.facebook.com/ID/CONNECTION_TYPE?access_token=123456
	// Use this method to get data from Facebook ...
	function get_facebook_object($object, $facebook_uid, $access_token) {
	
		$fb_connect = curl_init();
	
		curl_setopt($fb_connect, CURLOPT_URL, 'https://graph.facebook.com/'.$facebook_uid.'/'.$object.'?access_token='.$access_token);
	
		curl_setopt($fb_connect, CURLOPT_RETURNTRANSFER, 1);
	
		$output = curl_exec($fb_connect);
	
		curl_close($fb_connect);
	
		$result = json_decode($output);
	
		if (isset($result->error)) {
	
			$data['is_true'] = FALSE;
	
			$data['message'] = $result->error->message;
	
			$data['type'] = $result->error->type;
	
			$data['code'] = $result->error->code;
	
	
	
			return $data;
	
		} else {
	
			$data['is_true'] = TRUE;
	
			$data['data'] = $result->data;
	
				
	
			return $data;
	
		}
	
	}	
	//function is formatted for the following
	//https://graph.facebook.com/ID/CONNECTION_TYPE?access_token=123456
	// http://graph.facebook.com/AmrHussein.Official?fields=cover
	// Use this method to get data from Facebook ...
	function get_facebook_field($object, $facebook_uid, $access_token) {
		$fb_connect = curl_init();
		curl_setopt($fb_connect, CURLOPT_URL, 'https://graph.facebook.com/'.$facebook_uid.'?fields='.$object.'&access_token='.$access_token);
		curl_setopt($fb_connect, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($fb_connect);
		curl_close($fb_connect);
		$result = json_decode($output);
		if (isset($result->error)) {
			$data['is_true'] = FALSE;
			$data['message'] = $result->error->message;
			$data['type'] = $result->error->type;
			$data['code'] = $result->error->code;
			return $data;
		} else {
			$data['is_true'] = TRUE;
			$data['data'] = $result;
			return $data;
		}
	
	}
}