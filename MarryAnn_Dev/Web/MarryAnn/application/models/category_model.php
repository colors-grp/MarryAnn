<?php
class Category_model extends CI_Model{

	//Get categories user intersted in
	function get_category_interst_by_userID($user_id) {
		$this->db->select('*');
		$this->db->from('category');
		$this->db->join('user_category' ,'user_category.category_id = category.id');
		$this->db->where('user_id' , $user_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query;
		return FALSE;
	}

	//Returns all categories in competition
	function get_all_category() {
            $this->db->select('*');
            $this->db->order_by('id', 'asc');
            $query = $this->db->get('category');
            if($query->num_rows())
                    return $query;
            return FALSE;
	}

	//Given a category id, returns the category name
	function get_category_name_by_id($cat_id) {
		$this->db->where('id' , $cat_id);
		$query = $this->db->get('category');
		if($query -> num_rows() > 0)
			return $query->row()->name;
		return  FALSE;
	}
        
        //Given a category id, returns the category color
	function get_category_color_by_id($cat_id) {
		$this->db->where('id' , $cat_id);
		$query = $this->db->get('category');
		if($query -> num_rows() > 0)
			return $query->row()->color;
		return  FALSE;
	}

	//Add new category to certain user
	function insert_user_category($cat_id , $user_id) {
		$data = array(
				'user_id' => $user_id ,
				'category_id' => $cat_id
		);
		$this->db->insert('user_category', $data);
	}

	//1- updates user score in a certain category
	//2- updates card count in a certain catergory
	//ONLY USE WHEN USER BUYS NEW CARD ...
	function update_user_score_category($cat_id , $user_id,$new_score) {
		$this->db->select('score,	num_of_cards');
		$this->db->where('category_id' , $cat_id);
		$this->db->where('user_id' , $user_id);
		$query = $this->db->get('user_category');
		
		$this->db->where('category_id' , $cat_id);
		$this->db->where('user_id' , $user_id);
		$res = $query->row();
		$new_score += $res->score;
		$new_num_of_cards = $res->num_of_cards + 1;
		$data = array('score' =>  $new_score , 'num_of_cards' => $new_num_of_cards);
		$this->db->update('user_category' , $data);
		return $new_score;
	}
	
	function get_rank($user_id, $cat_id) {
		$this->db->select('*');
		$this->db->from('user_category');
		$this->db->where('category_id', $cat_id);
		$this->db->join('a3m_account', 'a3m_account.id = user_category.user_id');
		$this->db->order_by('score', 'desc');
		$query = $this->db->get();
		return $query;
	}
	
}