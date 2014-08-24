<?php
class Request_model extends CI_Model {
	
	//insert a new request when a user send a trade request
	function add_request($sender_id, $receiver_id, $demand, $offer, $msg, $demand_value, $offer_value) {
		//get the current date from server
		$cur_date = date('Y-m-d H:i:s');
		
		$data = array(
			'sender_id' => $sender_id,
			'receiver_id' => $receiver_id,
			'request_demand' => $demand,
			'request_offer' => $offer,
			'message' => $msg,
			'status' => 1, // should be the value of the active state
			'request_date' => $cur_date,
			'demand_value' => $demand_value,
			'offer_value' => $offer_value
		);
		$this->db->insert('request', $data);
		return $this->db->affected_rows();
	}
	
	//return all requests that the user has sent
	function get_requests($user_id,$user_type){
		$this->db->select('*');
		$this->db->from('request');
                if($user_type){//receiver
                    $this->db->where('receiver_id', $user_id);
                } else {
                    $this->db->where('sender_id', $user_id);
                }
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	//return all requests that the user has received
	function get_receiver_requests($user_id){
		$this->db->select('*');
		$this->db->from('request');		
		$this->db->where('receiver_id', $user_id);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	//update the msg and the status fields
	function update_status_msgs($status, $msg, $req_id){
		/* Inactive         0
		 * Active           1
		 * Approved         2
		 * Declined         3
		 * Invalid          4
		 * Cancelled        5 
                 * Auto Declined    6
		 */
		$this->db->where('request_id' , $req_id);
		$data = array('status' =>  $status, 'message' => $msg);
		$this->db->update('request' , $data);
		return $this->db->affected_rows();
	}
        // Auto decline any request other than current request given card serial.
        // Input: request id, list of cards serials.
        // Output: non.
        function auto_decline($request_id, $card_serial){
            for($i=0;$i<count($card_serial);$i++){
                $this->db->where('status','1');
                $this->db->where('request_id !=', $request_id);
                
                $this->db->like('request_demand', '['.$card_serial[$i],'after');
                $this->db->or_like('request_demand', ','.$card_serial[$i].',');
                $this->db->or_like('request_demand', $card_serial[$i].']','before');
                
                $this->db->or_like('request_offer', '['.$card_serial[$i],'after');
                $this->db->or_like('request_offer', ','.$card_serial[$i].',');
                $this->db->or_like('request_offer', $card_serial[$i].']','before');
                
                $data = array(
                    'status' => 6
                );
                $this->db->update('request',$data);
            }
        }
        // Get request information given its id
        // Inputs: request id.
        // Output: request.
        function get_request_by_id($request_id){
            $this->db->select('*');
            $this->db->from('request');
            $this->db->where('request_id',$request_id);
            $query = $this->db->get()->result_array();
            return $query;
        }
        // Lock / Unlock user's request lock
        // Inputs: user id, unlock flag (0 unlocked, 1 locked).
        // Output: success flag.
        function lock_user_request($user_id, $lock){
            $this->db->where('user_id', $user_id);
            $this->db->where('lock', ($lock)?0:1);
            $data = array(
                'lock' => $lock
            );
            $this->db->update('user_request_locks', $data);
            return $this->db->affected_rows();
        }
}