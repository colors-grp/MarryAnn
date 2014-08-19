<?php

class core_fbutils extends CI_Model {
	function encryptIt( $q ) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';// 		$cryptKey  = $this->config->item('encryption_key');
		$qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
		return( $qEncoded );
	}
	
	function decryptIt( $q ) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';// 		$cryptKey  = $this->config->item('encryption_key');
		$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		return( $qDecoded );
	}
	function get_user() {
		$query = $this->facebook->getUser();
		if ($query) {
			$data['is_true'] = TRUE;
			$data['facebook_uid'] = $query;			
			return $data;
		} else {			echo ' no query variable' . $query;
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	
	function get_access_token() {
		$query = $this->facebook->getAccessToken();
		
		if ($query) {
			$data['is_true'] = TRUE;
			$data['access_token'] = $query;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}
	
	function get_api_secret() {
		$query = $this->facebook->getApiSecret();
		
		if ($query) {
			$data['is_true'] = TRUE;
			$data['api_secret'] = $query;
			return $data;
		} else {
			$data['is_true'] = FALSE;
			return $data;
		}
	}

	function get_app_id() {
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
	
	function set_access_token($access_token) {
		$query = $this->facebook->setAccessToken($access_token);
		
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
	}
	//function is formatted for the following
	
	//https://graph.facebook.com/ID/CONNECTION_TYPE?access_token=123456
	
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
	function get_facebook_object1($graph_url) {
		$fb_connect = curl_init();				$real_url = $this->core_fbutils->decryptIt($graph_url);
		curl_setopt($fb_connect, CURLOPT_URL, $real_url);  
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
}