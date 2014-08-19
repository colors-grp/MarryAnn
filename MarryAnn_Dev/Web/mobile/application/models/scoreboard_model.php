<?php
class Scoreboard_model extends CI_Model{
	function get_scoreboard ($cat_id , $cat_name , $start , $size) {
		$this->db->from($cat_name.'_scoreboard');
		$this->db->join('a3m_account_facebook', $cat_name.'_scoreboard.user_id = a3m_account_facebook.account_id');
		$this->db->order_by('rank' , "asc");
		$this->db->limit($size , $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	function get_friends_scoreboard($cat_id,$cat_name,$friends_ids, $start , $size) {
		$this->db->select('*');
		$this->db->from($cat_name.'_scoreboard');
		$this->db->join('a3m_account_facebook', $cat_name.'_scoreboard.user_id = a3m_account_facebook.account_id');
		$this->db->where_in('user_id' , $friends_ids);
		$this->db->order_by('rank' , "asc");
		$this->db->limit($size , $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	
	function get_active_table($cat_id){
		$this->db->select('*');
		$this->db->from('active_scoreboard');
		$this->db->where('category_id',$cat_id);
		return $this->db->get()->row(0)->active_table;
	}
	
	// New scoreboard
	function get_all_friends_active($cat_name, $active_table, $limit, $offset ,$accounts_ids = FALSE){
		$this->db->select('*');
		$this->db->from($cat_name.'_scoreboard_'.$active_table);
		if($accounts_ids != FALSE) 
			$this->db->where_in('user_id',$accounts_ids);
		$this->db->order_by('rank','ASC');
		$this->db->limit($limit , $offset);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}
	
	function get_user_score_in_category($cat_name , $user_id) {
		$active = $this->get_active_table(1);
		$this->db->from($cat_name.'_scoreboard_'.$active);
		$this->db->where('user_id' , $user_id);
		$query = $this->db->get();
		if($query -> num_rows() > 0)
			return $query->row()->score;
		return FALSE;
	}
        
        function get_user_category_score($cat_id,$user_id){
            $this->db->where('user_id' , $user_id);
            $this->db->where('category_id' , $cat_id);
            $query = $this->db->get('user_category');
            return ($query -> num_rows()>0)?$query->row()->score:0;
        }
}
