<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_facebook_model extends CI_Model {
	
	//function is formatted for the following
	
	//https://graph.facebook.com/ID/CONNECTION_TYPE?access_token=123456
	// Use this method to get data from Facebook ...
	function get_facebook_object($object, $facebook_uid, $access_token) {

		$fb_connect = curl_init();

		log_message('error','mo7eb get_fb_object success string='.  'https://graph.facebook.com/'.$facebook_uid.'/'.$object.'?access_token='.$access_token);

		curl_setopt($fb_connect, CURLOPT_URL, 'https://graph.facebook.com/'.$facebook_uid.'/'.$object.'?access_token='.$access_token);

		curl_setopt($fb_connect, CURLOPT_RETURNTRANSFER, 1);

		log_message('error','mo7eb get_fb_object success $fb_connect='.  print_r($fb_connect,TRUE));

		$output = curl_exec($fb_connect);
		log_message('error','mo7eb get_fb_object success $output='.  print_r($output,TRUE));

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

			log_message('error','mo7eb get_fb_object success $result='.  print_r($result,TRUE));
			log_message('error','mo7eb get_fb_object success $result->data='.  print_r($result->data,TRUE));

			return $data;
		}
	}
	
	//example function
	
	function email($facebook_id, $token) {
	
		$result = $this->get_facebook_object('email', $facebook_id, $token);
                
                //log_message('error','mo7eb account_fb_model email $result='.  print_r($result,TRUE));
		if ($result['is_true']) {
	
			$data['email'] = $result['data'];
                        
                        
		} else {
	
			$data['error_message'] = $result['message'];
			$data['error_code'] = $result['code'];
			$data['error_type'] = $result['type'];
	
			$data['email'] = array();
	
		}
	
		return $data;
	
	}
	
	function get_facebook_me($account_id) {
		$this->db->where('account_id' , $account_id);
		$query = $this->db->get('a3m_account_details');
		log_message('error', 'nun roooows  ' . $query->num_rows());
		if ($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	
	//example function
	
	function friends($facebook_id, $token) {
                //$this->email($facebook_id, $token);
		$result = $this->getFriends($facebook_id, $token);
	
		log_message('error', 'account__FB__Model: going to get friends of ID: '.$facebook_id . '   with token: '.$token);
		
		if ($result['is_true']) {
                        log_message('error','account_fb_model Success Message friends: '.  print_r($result,TRUE));
			$data['friends'] = $result['data'];
	
		} else {
                    log_message('error','account_fb_model Error Message');
			$data['error_message'] = $result['message'];
			$data['error_code'] = $result['code'];
			$data['error_type'] = $result['type'];
	
			$data['friends'] = array();
	
		}
	
		return $data;
	
	}

	/**
	 * Get account facebook
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account facebook
	 */
	function get_by_account_id($account_id)
	{
            //log_message('error','mo7eb account_fb_model get_by_account_id $account_id='.$account_id);
            $result =  $this->db->get_where('a3m_account_facebook', array('account_id' => $account_id))->result();
            //log_message('error','mo7eb account_fb_model get_by_account_id $result='.  print_r($result,TRUE));
            return $result;
	}

        // --------------------------------------------------------------------
	
	function notify_facebook($fb_id, $message, $href)
	{
		log_message('error', 'account_fb_model notify_facebook called');
		$this->load->library(array('account/facebook_lib'));

		$rValue['data'] = $this->get_by_account_id($fb_id);
		log_message('error','facebook data -> '.print_r($rValue['data'][0], TRUE));
		 
		$token = $rValue['data'][0]->token;
		
		$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
		));

		// Try to get a logged in facebook user ID ...
		//$session = $facebook->getUser();

		$facebook->setAccessToken($token);
		
		$user = $rValue['data'][0]->facebook_id;

$params = array(
        'href' => $href,
        'template' => $message,
        'access_token' => '170161316509571|sKck_w5wqQCc5I2tFuFke4gosVM',
    );
		log_message('error',' Facebook ID: '. $user .'   ---- token == '.$token);
		
		if($fb_id){
			
			try {
				//$friends = $this->get_facebook_object('friends', $fb_id, $token);
				 
				$send = $facebook->api('/' . $user . '/notifications/', 'post', $params);
				
				return $send;
			} catch (FacebookApiException $e) {
				log_message('error', 'account_fb_model getFriends catch: '.$e->getMessage());
				//echo $e->getMessage();
			}
		}
		else
			log_message('error','Could not Get Facebook ID: ');
	}
	
	function getFriends($fb_id, $token)
	{
		log_message('error', 'account_fb_model getFriends called');
		$this->load->library(array('account/facebook_lib'));

		log_message('error','mo7eb account_fb_model getFriends yarab2');
		 
		$facebook = new Facebook(array(
				'appId' => '170161316509571',
				'secret' =>'92fcf6d4ac1dc115b01755afaacd4f9f',
				'cookie' =>true
		));

		// Try to get a logged in facebook user ID ...
		//$session = $facebook->getUser();

		$facebook->setAccessToken($token);
		
		if($fb_id){
			$friends = NULL;
			log_message('error','Got Facebook ID: '. $fb_id);
			try {
				//$friends = $this->get_facebook_object('friends', $fb_id, $token);
				 
				$friends = $facebook->api('/me/friends');
				log_message('error', 'account_fb_model getFriends $friends======' . print_r($friends,TRUE));
				return $friends;
			} catch (FacebookApiException $e) {
				log_message('error', 'account_fb_model getFriends catch: '.$e->getMessage());
				//echo $e->getMessage();
			}
		}
		else
			log_message('error','Could not Get Facebook ID: ');
	}
        
        
        /// --------------------------------------------------------------------
        
        /**
	 * Get array of facebook accounts
	 * @access public
	 * @param string $users_ids
	 * @return object account facebook
         * 
         * gets facebook ids from database given list of users_ids
	 */
        function get_details_by_array_facebook_ids($fb_ids)
	{
            log_message('error','mo7eb account_fb_model get_details_by_array_facebook_ids Entered Method. ...' .print_r($fb_ids,TRUE));
            //log_message('error','mo7eb account_fb_model get_by_array_facebook_ids $fb_ids='.print_r($fb_ids,TRUE));
            $this->db->select('facebook_id AS fb_id, aaf.account_id, fullname');
            $this->db->from('a3m_account_facebook AS aaf');
            $this->db->join('a3m_account_details AS aad', 'aaf.account_id = aad.account_id');
            $this->db->where_in('aaf.facebook_id', $fb_ids);
            $this->db->order_by("aaf.account_id", "asc"); 
            $result = $this->db->get()->result_array();
            log_message('error','mo7eb account_fb_model get_by_array_facebook_ids count($result)='.count($result));
            return $result;
	}
        
        /// --------------------------------------------------------------------
        
        /**
	 * Get array of fb_id, account_id and fullname
	 * @access public
	 * @param string $fb_ids
	 * @return object details
         * 
         * gets fb_id, account_id and fullname from database given list of fb_ids
	 */
        function get_by_array_facebook_ids($users_ids)
	{
            log_message('error','mo7eb da5al account_fb_model get_by_array_facebook_ids');
            $this->db->select('facebook_id, account_id');
            $this->db->where_in('account_id', $users_ids);
            $result = $this->db->get('a3m_account_facebook')->result_array();
            //log_message('error','mo7eb account_fb_model get_by_array_facebook_ids $users_ids='.  print_r($users_ids,TRUE));
            log_message('error','mo7eb account_fb_model get_by_array_facebook_ids $result='.print_r($result,TRUE));
            return $result;
	}
        
        // --------------------------------------------------------------------
	/**
	 * Get account facebook
	 *
	 * @access public
	 * @param string $facebook_id
	 * @return object account facebook
	 */
	function get_by_facebook_id($facebook_id)
	{
		return $this->db->get_where('a3m_account_facebook', array('facebook_id' => $facebook_id))->row();
	}

	// --------------------------------------------------------------------

	/**
	 * Insert account facebook
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $facebook_id
	 * @return void
	 */
	function insert($account_id, $facebook_id, $token)
	{
		$this->load->helper('date');

		if ( ! $this->get_by_facebook_id($facebook_id)) // ignore insert
		{
			$this->db->insert('a3m_account_facebook', array('account_id' => $account_id, 'facebook_id' => $facebook_id, 'linkedon' => mdate('%Y-%m-%d %H:%i:%s', now()), 'token' => $token));
			return TRUE;
		}
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete account facebook
	 *
	 * @access public
	 * @param int $facebook_id
	 * @return void
	 */
	function delete($facebook_id)
	{
		$this->db->delete('a3m_account_facebook', array('facebook_id' => $facebook_id));
	}
        
        function get_user_access_token($user_id){
            $this->db->where('account_id',$user_id);
            return $this->db->get('a3m_account_facebook')->result_array();
        }
        
        //Update user facebook token given facebook id
        function update_user_token($fb_id, $token){
            $this->db->where('facebook_id',$fb_id);
            $data['token'] = $token;
            $this->db->update('a3m_account_facebook', $data);
        }
        
        // Returns fb_id(s) of all users
        function get_all_ids(){
            $this->db->select('facebook_id');
            return $this->db->get('a3m_account_facebook')->result_array();
        }
}


/* End of file account_facebook_model.php */
/* Location: ./application/account/models/account_facebook_model.php */