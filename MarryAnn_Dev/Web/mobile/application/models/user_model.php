<?php
class User_model extends CI_Model {
	
	function check_user_scores($user_id) {
		$this->db->where('user_id' ,$user_id );
		$query = $this->db->get('shahryar_scoreboard_1');
		if($query->num_rows() > 0)
			return true;
		return false;
	} 
	
	function is_already_registered_user($fb_id) {
		$this->db->where('facebook_id' , $fb_id);
		$query = $this->db->get('a3m_account_facebook');
		if($query->num_rows() > 0)
			return true;
		return false;
	}
	
	function get_hitseven_ids($friends_facebook_ids) {
		$this->db->where_in('facebook_id' , $friends_facebook_ids);
		$query = $this->db->get('a3m_account_facebook');
		$account_ids = array();
		if($query->num_rows() > 0) {
		 	foreach ($query->result() as $row) {
		 		array_push($account_ids, $row->account_id);
		 	}
		 	return  $account_ids;
		}
		return FALSE;
	}
	
	function get_user_id($fb_id) {
		$this->db->where('facebook_id' , $fb_id);
		$query = $this->db->get('a3m_account_facebook');
		if($query->num_rows() > 0) {
			$ret = $query->row();
			return $ret->account_id;
		}
		return false;
	}
	
	function get_user_fb_id($user_id) {
		$this->db->where('account_id' , $user_id);
		$query = $this->db->get('a3m_account_facebook');
		if($query->num_rows() > 0) {
			$ret = $query->row();
			return $ret->facebook_id;
		}
		return false;
	}
	
	function get_user_credit($user_id) {
		$this->db->where('id' , $user_id);
		$query = $this->db->get('a3m_account');
		$row = $query->row();
		return $row->credit;
	}
	
	function update_user_credit($user_id , $new_credit) {
		$data = array( 'credit' => $new_credit );
		$this->db->where('id', $user_id);
		$this->db->update('a3m_account', $data);
	}
	
	function is_dirty($user_id) {
		$this->db->where('id' , $user_id);
		$query = $this->db->get('a3m_account');
		$row = $query->row();
		if($row->dirty == 1)
			return true;
		return false;
	}
	
	function update_dirty($user_id) {
		$data = array( 'dirty' => 0 );
		$this->db->where('id', $user_id);
		$this->db->update('a3m_account', $data);	
	}
	
	function insert_user_category($cat_id , $user_id) {
		$data = array(
				'user_id' => $user_id ,
				'category_id' => $cat_id
		);
		$query = $this->db->insert('user_category', $data);

// 		delete from a3m_account where id = 98;
// 		delete from a3m_account_details where account_id = 98;
// 		delete from a3m_account_facebook where account_id = 98;
		
	}
	
	function insert_new_user_in_scoreboards($user_id, $user_name, $cat_name){
		$data = array(
				'user_id' => $user_id ,
				'user_name' => $user_name,
				'score' => '0',
				'change' => 'n'
		);
		$this->db->insert($cat_name ."_scoreboard_1", $data);
		$this->db->insert($cat_name ."_scoreboard_2", $data);
	}
}