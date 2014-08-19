<?php
class User_model extends CI_Model {
	function add_user($user_id){
		//get the current date from server
		$cur_date = date('Y-m-d H:i:s');
		
		$data = array(
				'user_id' => $user_id,
				'lastsignedin' => $cur_date,
				'days' => 1 //day 1 as it is the first time to signin
		);
		$this->db->insert('user_day', $data);
		return $this->db->affected_rows();
	}
	
	function get_user_info($user_id){
		$this->db->select('*');
		$this->db->from('user_day');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	function update_user_info($user_id, $days){
		//get the current date from server
		$cur_date = date('Y-m-d');
	
		$this->db->where('user_id', $user_id);
		$data = array('lastsignedin' =>  $cur_date, 'days' => $days);
		$this->db->update('user_day' , $data);
		return $this->db->affected_rows();
	}
	
	/*function get_user_id($user_id) {
		$this->db->select('*');
		$this->db->where('id', $user_id);
		$query = $this->db->get('a3m_account');
		if ($query->num_rows() > 0)
			return $query->row();
		return FALSE;
	}
	function get_card_parameters($card_id) {
		$this->db->select('*');
		$this->db->where('id', $card_id);
		$query = $this->db->get('card');
		return (($query != FALSE && $query->num_rows() > 0)?$query: FALSE);
	}
        function get_all_fullname_id(){
            $sql = "SELECT id, fullname FROM a3m_account;";
            $query = $this->db->query($sql);
            return (($query->num_rows() > 0)?$query: FALSE);
        }
        function get_user_details($user_id){
            $sql = "SELECT * FROM a3m_account_details WHERE account_id = " . $user_id;
            $query = $this->db->query($sql);
            return (($query->num_rows() > 0)?$query: FALSE);
        }
        function get_all_details(){
            $sql = "SELECT * FROM a3m_account_details";
            $query = $this->db->query($sql);
            return (($query->num_rows() > 0)?$query: FALSE);
        }
        */
        
        // Get user information from user_day table
        // Inputs: user id
        // Output: User information (Array)
        function get_user_day($user_id){
            $this->db->select('*');
            $this->db->from('user_day');
            $this->db->where('user_id', $user_id);
            $query = $this->db->get()->result_array();
            return $query;
        }
}