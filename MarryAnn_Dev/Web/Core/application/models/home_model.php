<?php
class Home_model extends CI_Model{

	function get_competitions(){ //Get all sites info table(site_id , site_name , site_url)
		$query = $this->db->get('competition');
		if($query -> num_rows() > 0)
		return $query;
		return FALSE;
	}

	function insert_user($user_fb_data) {
		//Facebook informartion to be inserted in database
		$user_name = $user_fb_data['name'];
		$user_id = $user_fb_data['id'];
		$user_gender = $user_fb_data['gender'];
		$data = array('name' =>  $user_name, 'fb_id' => $user_id ,'gender' => $user_gender);
		$this->db->insert('users', $data);
	}

	function get_users_by_fbid($facebook_id = NULL){
		$this->db->where('fb_id' , $facebook_id);
		$query = $this->db->get('users');
		if($query -> num_rows() > 0)
		return $query;
		return FALSE;
	}
        
        function insert_message($data){
            $this->db->insert('messages', $data);
            return $this->db->affected_rows();
        }
}
