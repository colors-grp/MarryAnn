<?php
class session_model extends CI_Model {
	function get_sessiondata($sessionid) {
		// Select user with facebook ID and put the record in 'query'
		log_message('error', 'session_model.php: '.$sessionid);
		$this->db->where('session_id', $sessionid);
		$this->db->select('user_data');
		$query = $this->db->get('ci_sessions');
		//log_message('error', 'session_model.php: '.$query);
		// Get and return user credit using the ID
		//foreach ($query->result() as $row)
		if($query->num_rows()>0)	
			$user_data = $query->$row->user_data;
		return $user_data;
	}
}