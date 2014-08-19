<?php
class event_model extends CI_Model {

	function get_event($event_id){
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where('event_id', $event_id);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	function add_user_event($user_id, $event_id){
		//get the current date from server
		$cur_date = date('Y-m-d');
		
		$data = array(
				'user_id' => $user_id,
				'event_id' => $event_id,
				'date' => $cur_date,
				'credit_won' => 0
		);
		$this->db->insert('user_events', $data);
		return $this->db->affected_rows();
	}
	
	//get user's credit which he has won from specific event
	function get_credit_won($user_id, $event_id){
		//get the current date from server
		$cur_date = date('Y-m-d');
		
		$this->db->select('credit_won');
		$this->db->from('user_events');
		$this->db->where('user_id', $user_id);
		$this->db->where('event_id', $event_id);
		$this->db->where('date', $cur_date);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	//update the user's event_id and credit_won
	function update_user_event($user_id, $event_id, $credit){
		//get the current date from server
		$cur_date = date('Y-m-d');
		
		$this->db->where('user_id', $user_id);
		$this->db->where('event_id', $event_id);
		$data = array('date' =>  $cur_date, 'credit_won' => $credit);
		$this->db->update('user_events' , $data);
		return $this->db->affected_rows();
	}
}