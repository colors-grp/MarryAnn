<?php 

/**
 * H7 Core Class
 *
 * Make REST requests to Core services with simple syntax.
 *
 */

class core_call extends CI_Model
{

	protected $CI;

	function __construct($config = array())
	{
		$this->CI =& get_instance();

		log_message('debug', 'REST Class Initialized');

		//log_message('error', 'The Core URL -> '.$this->CI->config->item('core_api_url'));

		$this->CI->load->library('rest');
		$this->CI->rest->initialize(array(
				'server' => $this->CI->config->item('core_api_url'),
				'http_user' => '',
				'http_pass' => '',
				'http_auth' => 'basic' // or 'digest'
		));
	}

	// call ( <Method Name>, Parameter Array) ...
	private function callCore($method, $params)
	{
		log_message('error', 'The method Name -> '.$method);
		// log_message('error', 'The params -> '.json_encode($params));
		// 		$value=8;
		// 		return $this->CI->rest->get($method, array('accountid', $params['accountid']), 'json');
		//log_message('error', 'core call ->>>>>>', count($params));
        log_message('error', 'core call ->>>>>>', print_r($params,TRUE));
		return $this->CI->rest->get($method, $params, 'json');
	}
	
	function mobileGetFacebookIDs($USER_IDs)
	{
		$method = 'mobileGetFacebookIDs';
		log_message('error', ' $fbid==== ' .$USER_IDs);
		$rValue = $this->CI->rest->get($method, array('users_ids' => $USER_IDs), 'json');// $this->callCore($method, array('fb_id' => $fb_id));
		
		
		log_message('error', ' rvalueeeee==== ' . print_r($rValue, TRUE));
		return $rValue;
	}
	// call ( <Method Name>, Parameter Array) ...
	function mobileGetCommonFacebookFriends($fb_id)
	{
		$method = 'mobileGetCommonFacebookFriends';
		log_message('error', ' $fbid==== ' .$fb_id);
		$rValue = $this->CI->rest->get($method, array('fb_id' => $fb_id), 'json');// $this->callCore($method, array('fb_id' => $fb_id));
	
	
		log_message('error', ' rvalueeeee==== ' . print_r($rValue, TRUE));
		return $rValue;
		//log_message('error', ' the data : ' . $rValue->friends_fb_ids);
		/* If the method was executed successfully ...
		if ($rValue) {
			if($rValue->friends_fb_ids) {
				log_message('error', ' the data : ' . $rValue->friends_fb_ids);
				// return required data ...
				return $rValue->friends_fb_ids;
			} else {
				log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
				return $rValue->error;
			}
		}
		else
			return "No Credit Recieved";*/
	}
	// call ( <Method Name>, Parameter Array) ...
	function getUserCredit($user_id)
	{
		$method = 'getcredit';
		log_message('error', ' $fbid==== ' .$user_id);
		$rValue = $this->callCore($method, array('user_id' => $user_id));

		//log_message('error', 'rValue from user credit ====== '.rValue);

		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		log_message('error', ' rvalueeeee==== ' . print_r($rValue, TRUE));
		// If the method was executed successfully ...
		if ($rValue) {
			if($rValue->invoke != FALSE) {
				log_message('error', ' the data : ' . $rValue->data);
				// return required data ...
				return $rValue->data;
			} else {
				log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
				return $rValue->error;

			}
		}
		else
			return "No Credit Recieved";
	}

        function getFacebookID($user_id)
	{
		$method = 'getFacebookID';
		log_message('error','core_call getFacebookID $userid==== ' .$user_id);
		$rValue = $this->callCore($method, array('user_id' => $user_id));

		//log_message('error', 'rValue from user credit ====== '.rValue);

		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		log_message('error', 'core_call getFacebookID rvalueeeee==== ' . print_r($rValue, TRUE));
		// If the method was executed successfully ...
		if ($rValue) {
			if($rValue->invoke != FALSE) {
				log_message('error', ' the data : ' . $rValue->data);
				// return required data ...
				return $rValue->data;
			} else {
				log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
				return $rValue->error;

			}
		}
		else
			return "No Facebook ID";
	}
        
	function getFacebookIDs($users_ids)
	{
		$method = 'getFacebookIDs';
                $users_id_send = urlencode(base64_encode(json_encode($users_ids)));
		//log_message('error','core_call getFacebookIDs $usersids==== ' .  print_r($users_id_send,TRUE));
		$rValue = $this->callCore($method, array('users_ids' => $users_id_send));
		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		//log_message('error', 'core_call getFacebookIDs rvalueeeee==== ' . print_r($rValue, TRUE));
		// If the method was executed successfully ...
		if ($rValue) {
			if($rValue->invoke != FALSE) {
				log_message('error', 'core_call getFacebookIDs the data : ' . print_r($rValue->data,TRUE));
				// return required data ...
				return $rValue->data;
			} else {
				log_message('error', 'core_call getFacebookIDs Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
				return $rValue->error;

			}
		}
		else
			return "No Facebook IDs";
	}
        
        
        
        // call ( <Method Name>, Parameter Array) ...
	function getFacebookFriends($accountid)
	{
		log_message('error', 'core_call getFacebookFriends $accountid= '.$accountid);
		$method = 'friends';
		// 		$params = ;
                $temp = array('accountid' => $accountid);
                log_message('error', 'mo7eb getFacebookFriends temp[acciuntid] = '.$temp['accountid']);
		$rValue = $this->callCore($method, $temp);

		log_message('error', 'rValue ====== '.print_r($rValue->data,TRUE));
		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		// If the method was executed successfully ...
		if($rValue->invoke) {
			log_message('error', ' the data : ' . $rValue->data);
			// return required data ...
			return $rValue->data;
		} else {
			log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
			return $rValue->error;

		}
	}
	// call ( <Method Name>, Parameter Array) ...
	function buy_credit($user_id, $credit)
	{
		$method = 'buycredit';
		log_message('error', 'buy credit ->>>>>>'. $user_id . ' , ' . $credit);
		$rValue = $this->callCore($method, array('user_id' => $user_id, 'credit' => $credit));

		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		// If the method was executed successfully ...
		if ($rValue) {
			if($rValue->invoke) {
				log_message('error', ' the data : ' . $rValue->data);
				// return required data ...
				return $rValue->data;
			} else {
				log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
				return $rValue->error;

			}
		}
		else
			return "You can't Buy Credit";
	}
        // call ( <Method Name>, Parameter Array) ...
	function getCommonFriends($accountid)
	{
		$method = 'getCommonFriends';
		log_message('error', 'core_call getCommonFriends $accountid='. $accountid);
		$rValue = $this->callCore($method, array('accountid' => $accountid));
                log_message('error','core_call  getCommonFriends $rValue:'.  print_r($rValue,TRUE));
		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		// If the method was executed successfully ...
		if ($rValue) {
			if($rValue->invoke) {
				log_message('error', 'core_call getCommonFriends $rValue->data:' . print_r($rValue->data,TRUE));
				// return required data ...
				return $rValue->data;
			} else {
				log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
				return $rValue->error;

			}
		}
		else
			return "Dont have facebook friends";
	}
	function getMe($account_id) {
		$method = 'getMe';
		$rValue = $this->callCore($method, array('account_id' => $account_id));
                log_message('error','mo7eb core_call getMe $rValue'.  print_r($rValue,TRUE));
		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		// If the method was executed successfully ...
		if($rValue->invoke) {
			// 			log_message('error', ' the data : ' . $rValue->data);
			// return required data ...
			return $rValue->data;
		} else {
			// 			log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
			return $rValue->error;

		}
	}
    // Get user data from a3m_account table given user's id
        function get_by_id($account_id) {
		$method = 'get_by_id';
		$rValue = $this->callCore($method, array('account_id' => $account_id));
                //log_message('error','mo7eb core_call get_by_account_id $rValue='.  print_r($rValue,TRUE));
		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		// If the method was executed successfully ...
		if($rValue->invoke) {
			// 			log_message('error', ' the data : ' . $rValue->data);
			// return required data ...
			return $rValue->data;
		} else {
			// 			log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
			return $rValue->error;
		}
	}
    // Get user's details from a3m_account_details table
        function get_by_account_id($account_id) {
		$method = 'get_by_account_id';
		$rValue = $this->callCore($method, array('account_id' => $account_id));
		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		// If the method was executed successfully ...
		if($rValue->invoke) {
			// 			log_message('error', ' the data : ' . $rValue->data);
			// return required data ...
			return $rValue->data;
		} else {
			// 			log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
			return $rValue->error;
		}
	}
    // Get user's facebook data from a3m_facebook table
        function fb_get_by_account_id($account_id) {
		$method = 'fb_get_by_account_id';
		$rValue = $this->callCore($method, array('account_id' => $account_id));
                log_message('error','core_call fb_get_by_account_id $account_id='.$account_id.' $rValue='.print_r($rValue,TRUE));
		// Validation for return values ...
		// The API call will return an array with 2 parameters:
		// invoke: a boolean that indicates correct processing at API side
		// data: The returned value itself
		// If invoke was false, a 3rd parameter is returned containing error message "named: error" ...

		// If the method was executed successfully ...
		if($rValue->invoke) {
			// 			log_message('error', ' the data : ' . $rValue->data);
			// return required data ...
			return $rValue->data;
		} else {
			// 			log_message('error', 'Error calling H7 API, Method: '. $method . ', error message: ' . $rValue->error);
			return $rValue->error;
		}
	}
}

/* End of file CoreCall.php */
/* Location: ./application/libraries/CoreCall.php */