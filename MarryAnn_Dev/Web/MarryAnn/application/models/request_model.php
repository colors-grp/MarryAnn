<?php
class request_model extends CI_Model {
	
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
	function get_sender_requests($user_id){
		$this->db->select('*');
		$this->db->from('request');		
		$this->db->where('sender_id', $user_id);
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
		/*Inactive 	0
		 *Active 	1
		 *Approved  2
		 *Declined  3
		 *Invalid 	4
		 *Cancelled 5 
		 */
		$this->db->where('request_id' , $req_id);
		$data = array('status' =>  $status, 'message' => $msg);
		$this->db->update('request' , $data);
		return $this->db->affected_rows();
	}
}