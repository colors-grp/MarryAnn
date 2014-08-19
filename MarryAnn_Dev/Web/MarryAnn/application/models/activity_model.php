<?php
class Activity_model extends CI_Model {
	//Insert user Activity in log
	function insert_log($user_id , $act_id) {
		$data = array(
					'user_id' => $user_id,
					'activity_id' => $act_id,
					'time' => gmdate("F jS,Y h:i:s a", time())
				);
		$this->db->insert('user_activity' , $data);
	}
	//Get all user activities
	function get_log($user_id) {
		$this->db->where('user_id' , $user_id);
		$this->db->from('user_activity');
		$this->db->join('activity_type', 'activity_type.id = user_activity.activity_id');
		$this->db->order_by("user_activity.id", "desc");
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
} 
