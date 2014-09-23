<?php
class User_model extends CI_Model {
	//insert user data in database
	function set_user($data) {
		$user_name = $data['name'];
		$user_fbid = $data['fb_id'];
		$tmp = array('name' =>  $user_name, 'fb_id' => $user_fbid );
		$this->db->insert('user', $tmp);
	}
	//get user from database by facebook id
	function get_user_by_fbid($fbid=NULL) {
		$this->db->where('fb_id' , $fbid);
		$query = $this->db->get('user');
		if($query -> num_rows() > 0) {
			return $query->row();
		}
		else{
			return FALSE;
		}
	}

	//get user from database by hitseven id
	function get_user_by_id($id=NULL) {
		$this->db->where('id' , $id);
		$query = $this->db->get('user');
		if($query -> num_rows() > 0){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}
        
        // Get user from a3m_account table
//        function get_user_a3m($id){
//            $this->db->where('id' , $id);
//            $query = $this->db->get('a3m_account');
//            return $query->result_array();
//        }
}